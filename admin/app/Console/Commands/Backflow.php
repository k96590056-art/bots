<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackflowService;
use App\Models\SystemConfig;
use App\Models\TransferLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Backflow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backflow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动返水命令：每天12点后自动发放返水';

    protected $backflowService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->backflowService = new BackflowService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 强制使用东八区时间
        date_default_timezone_set('Asia/Shanghai');

        $this->info('开始执行自动返水命令...');

        // 1. 检查并初始化 backflow_date 配置
        $backflowDate = SystemConfig::getValue('backflow_date');
        if (empty($backflowDate)) {
            // 首次执行，添加配置
            $today = date('Y-m-d');
            SystemConfig::updateOrCreate(
                ['key' => 'backflow_date'],
                ['value' => $today]
            );
            $this->info("首次执行，已设置返水日期为：{$today}");
            Log::info('返水命令首次执行，初始化 backflow_date', ['date' => $today]);
            return 0;
        }

        // 2. 检查当前时间是否大于12点
        $currentHour = (int)date('H');
        if ($currentHour < 12) {
            $this->info("当前时间未到12点（当前：{$currentHour}点），不执行自动返水");
            return 0;
        }

        // 3. 检查 backflow_date 是否是今日
        $today = date('Y-m-d');
        if ($backflowDate === $today) {
            $this->info("今日（{$today}）已执行过自动返水，跳过");
            return 0;
        }

        // 4. 执行自动返水
        $this->info("开始执行自动返水，上次执行日期：{$backflowDate}，今日：{$today}");

        // 5. 查询所有未返水的记录，按用户ID分组
        $pendingBackflows = TransferLog::where('transfer_type', 6)
            ->where('state', 0)
            ->select('user_id', DB::raw('SUM(money) as total_amount'), DB::raw('COUNT(*) as count'))
            ->groupBy('user_id')
            ->get();

        if ($pendingBackflows->isEmpty()) {
            $this->info('没有待发放的返水记录');
            // 更新 backflow_date 为今日
            SystemConfig::updateOrCreate(
                ['key' => 'backflow_date'],
                ['value' => $today]
            );
            return 0;
        }

        $this->info("找到 " . $pendingBackflows->count() . " 个用户有待发放的返水");

        $successCount = 0;
        $failCount = 0;
        $totalAmount = 0;
        $totalCount = 0;

        // 6. 按用户分组执行返水
        foreach ($pendingBackflows as $item) {
            $userId = $item->user_id;
            $userTotalAmount = (float)$item->total_amount;
            $userCount = (int)$item->count;

            try {
                $result = $this->backflowService->backflowOut($userId);
                
                if ($result['code'] == 200) {
                    $successCount++;
                    $totalAmount += $userTotalAmount;
                    $totalCount += $userCount;
                    $this->info("用户 ID {$userId} 返水成功：金额 {$userTotalAmount}，记录数 {$userCount}");
                } else {
                    $failCount++;
                    $this->error("用户 ID {$userId} 返水失败：{$result['message']}");
                    Log::error('自动返水失败', [
                        'user_id' => $userId,
                        'result' => $result,
                    ]);
                }
            } catch (\Throwable $e) {
                $failCount++;
                $this->error("用户 ID {$userId} 返水异常：" . $e->getMessage());
                Log::error('自动返水异常', [
                    'user_id' => $userId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        // 7. 更新 backflow_date 为今日
        SystemConfig::updateOrCreate(
            ['key' => 'backflow_date'],
            ['value' => $today]
        );

        // 8. 输出统计信息
        $this->info("\n自动返水执行完成！");
        $this->info("成功用户数：{$successCount}");
        $this->info("失败用户数：{$failCount}");
        $this->info("总返水金额：{$totalAmount}");
        $this->info("总返水记录数：{$totalCount}");

        Log::info('自动返水执行完成', [
            'success_count' => $successCount,
            'fail_count' => $failCount,
            'total_amount' => $totalAmount,
            'total_count' => $totalCount,
            'backflow_date' => $today,
        ]);

        return 0;
    }
}
