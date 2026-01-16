<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Services\DbgmagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * 测试接口：调用 DbgmagService::getGameList 拉取游戏列表
     *
     * 访问路径：/api/test
     * 可选参数（query 或 body 均可）：
     * - providerCode
     * - gameType
     * - gameCode
     * - page
     * - size
     */
    public function test(Request $request)
    {
        $tpl = GameList::query()->find(639);
        if (!$tpl) {
            return response()->json(['code' => 404, 'message' => 'game_lists 未找到 id=639 的数据']);
        }

        $providerCode = (string) $request->input('providerCode', '');
        $gameType = (string) $request->input('gameType', '');
        $gameCode = (string) $request->input('gameCode', '');
        $page = (int) $request->input('page', 1);
        $size = (int) $request->input('size', 100);

        $service = new DbgmagService();
        $res = $service->getGameList($providerCode, $gameType, $gameCode, $page, $size);

        if (!isset($res['code']) || (int)$res['code'] !== 200) {
            return response()->json($res);
        }

        $records = $res['data'] ?? [];
        if (!is_array($records)) {
            return response()->json(['code' => 500, 'message' => 'Dbgmag 返回 records 格式错误', 'data' => $res]);
        }

        // 用 id=639 的“原始字段”做模板（避免 toArray 带上关联/追加字段）
        $tplArr = $tpl->getAttributes();

        // 1) 先把 GMAG records 重组成“待写入数据队列”
        $mappedRows = [];
        foreach ($records as $r) {
            if (!is_array($r)) continue;
            $row = $tplArr;
            // 按要求映射字段：
            // game_code = gameCode
            // category_id = gameType
            // name = cnName
            // name_en = enName
            $row['game_code'] = (string)($r['gameCode'] ?? '');
            $row['category_id'] = (string)($r['gameType'] ?? '');
            $row['name'] = (string)($r['cnName'] ?? '');
            $row['name_en'] = (string)($r['enName'] ?? '');
            $mappedRows[] = $row;
        }

        if (empty($mappedRows)) {
            return response("没有可写入的游戏列表数据\n", 200, ['Content-Type' => 'text/plain; charset=utf-8']);
        }

        // 2) 获取目标 game_lists：id > 639 且 with_api 为空或 dp，按 id 升序
        $targets = GameList::query()
            ->where('id', '>', 639)
            ->where(function ($q) {
                $q->whereNull('with_api')
                    ->orWhere('with_api', '')
                    ->orWhere('with_api', 'dp');
            })
            ->orderBy('id', 'asc')
            ->get();

        if ($targets->isEmpty()) {
            // 满足条件的数据为空，按你的要求：终止写入
            return response("满足条件的 game_lists（id>639 且 with_api 为空或dp）为空，终止写入\n", 200, ['Content-Type' => 'text/plain; charset=utf-8']);
        }

        $lines = [];
        DB::transaction(function () use ($targets, $mappedRows, &$lines) {
            $i = 0;
            // 简单缓存，减少重复 exists 查询
            $existsCache = [];
            foreach ($targets as $t) {
                // 给当前目标行找一条“game_code 不重复”的重组数据
                while (true) {
                    if (!isset($mappedRows[$i])) {
                        // 没有更多重组数据，停止
                        break 2;
                    }

                    $row = $mappedRows[$i];
                    $i++;

                    $gameCodeValue = (string)($row['game_code'] ?? '');
                    if ($gameCodeValue === '') {
                        // 无 game_code 的数据直接跳过
                        continue;
                    }

                    // 若同 game_code 在 game_lists 已存在（排除当前目标行），则不更新也不写入
                    $cacheKey = $t->id . '|' . $gameCodeValue;
                    if (!array_key_exists($cacheKey, $existsCache)) {
                        $existsCache[$cacheKey] = GameList::query()
                            ->where('game_code', $gameCodeValue)
                            ->where('id', '<>', $t->id)
                            ->exists();
                    }
                    if ($existsCache[$cacheKey]) {
                        continue;
                    }

                    // id 使用目标记录的 id
                    $row['id'] = $t->id;

                    // 更新时不能更新主键 id
                    $payload = $row;
                    unset($payload['id']);
                    // 避免把模板行的时间戳覆盖到其它行
                    unset($payload['created_at'], $payload['updated_at'], $payload['deleted_at']);

                    $t->fill($payload);
                    $t->save();

                    $lines[] = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                    break;
                }
            }
        });

        return response(implode("\n", $lines) . "\n", 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}

