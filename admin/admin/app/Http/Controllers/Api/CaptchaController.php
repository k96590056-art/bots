<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class CaptchaController extends Controller
{
    public function generate(Request $request)
    {
        $pointCount = max(1, (int)$request->input('point_count', 3));
        $target = $this->getRandomChineseChars($pointCount);
        $w = 300;
        $h = 180;
        $sessionId = Str::uuid()->toString();

        // 移除文件目录检查逻辑


        $img = imagecreatetruecolor($w, $h);
        $bg1 = imagecolorallocate($img, rand(200, 255), rand(200, 255), rand(200, 255));
        $bg2 = imagecolorallocate($img, rand(150, 220), rand(150, 220), rand(150, 220));
        for ($y = 0; $y < $h; $y++) {
            $ratio = $y / $h;
            $r = (int)((1 - $ratio) * ($bg1 >> 16) + $ratio * ($bg2 >> 16));
            $g = (int)((1 - $ratio) * (($bg1 >> 8) & 0xFF) + $ratio * (($bg2 >> 8) & 0xFF));
            $b = (int)((1 - $ratio) * ($bg1 & 0xFF) + $ratio * ($bg2 & 0xFF));
            $line = imagecolorallocate($img, $r, $g, $b);
            imageline($img, 0, $y, $w, $y, $line);
        }
        for ($i = 0; $i < 120; $i++) {
            $c = imagecolorallocate($img, rand(120, 220), rand(120, 220), rand(120, 220));
            imagesetpixel($img, rand(0, $w - 1), rand(0, $h - 1), $c);
        }

        $points = [];
        $minDist = 30;
        $padding = 20;
        
        // 确保中文字体支持
        $fontPath = public_path('fonts/simhei.ttf');
        // 如果没有simhei.ttf，尝试使用系统字体或默认字体，这里假设有字体文件
        // 为了演示，如果没有字体文件，可能需要回退或者抛出错误，但通常项目中会有字体文件
        // 作为一个兜底，如果没有simhei.ttf，我们使用一个通用的方法或不渲染文字到图片上（只返回前端渲染）
        // 但根据需求，文字应该是随机生成的，所以最好是在后端生成好传给前端，或者后端画在图上
        // 观察前端逻辑，前端接收 `target_text` 并显示在顶部，同时接收 `points` 并在图片上显示 `hintChars` (ClickCaptcha.vue:161 hintChars 计算属性)
        // 前端 ClickCaptcha.vue 中 hintChars 是根据 targetText 和 points 计算出来的，并在图片上通过绝对定位显示 DOM 元素
        // 所以后端其实不需要把文字画在图片上，只需要生成随机文字并返回即可。
        // 前端代码: v-for="h in hintChars" ... {{ h.char }} ...
        // 所以这里我们只需要生成随机中文字符串赋值给 $target 即可。
        
        for ($i = 1; $i <= $pointCount; $i++) {
            $tries = 0;
            do {
                $x = rand($padding, $w - $padding);
                $y = rand($padding, $h - $padding);
                $ok = true;
                foreach ($points as $p) {
                    $dx = $p['x'] - $x;
                    $dy = $p['y'] - $y;
                    if (sqrt($dx * $dx + $dy * $dy) < $minDist) {
                        $ok = false;
                        break;
                    }
                }
                $tries++;
            } while (!$ok && $tries < 50);
            $points[] = ['id' => $i, 'order' => $i, 'x' => $x, 'y' => $y];
        }

        ob_start();
        imagejpeg($img, null, 85);
        $content = ob_get_clean();
        imagedestroy($img);

        $expected = array_map(function ($p) { return $p['id']; }, $points);
        Cache::put('click_captcha_' . $sessionId, [
            'expected' => $expected,
            'point_count' => $pointCount,
            'created_at' => time(),
        ], now()->addMinutes(5));

        $imageUrl = 'data:image/jpeg;base64,' . base64_encode($content);
        return response()->json([
            'code' => 200,
            'data' => [
                'session_id' => $sessionId,
                'image_url' => $imageUrl,
                'points' => $points,
                'base_width' => $w,
                'base_height' => $h,
                'target_text' => $target,
            ],
        ]);
    }

    private function getRandomChineseChars($count)
    {
        $chars = '';
        for ($i = 0; $i < $count; $i++) {
            // 生成常用汉字的 Unicode 范围: \u4e00-\u9fa5
            // 对应的十进制范围: 19968 - 40869
            $decimal = rand(19968, 40869);
            $chars .= mb_chr($decimal, 'UTF-8');
        }
        return $chars;
    }


    public function verify(Request $request)
    {
        $sessionId = (string)$request->input('session_id', '');
        $cached = Cache::get('click_captcha_' . $sessionId);
        
        Log::info('Captcha Verify:', [
            'session_id' => $sessionId,
            'cached' => $cached,
            'input_id_seq' => $request->input('id_sequence'),
            'input_click_seq' => $request->input('click_sequence')
        ]);

        if (!$cached) {
            return response()->json(['code' => 200, 'valid' => false]);
        }

        $expected = (array)($cached['expected'] ?? []);
        $pointCount = (int)($cached['point_count'] ?? count($expected));

        $idsSeq = array_values(array_map('intval', (array)$request->input('id_sequence', [])));
        $clickSeq = array_values(array_map('intval', (array)$request->input('click_sequence', [])));

        $valid = false;
        if (count($idsSeq) === $pointCount) {
            $valid = ($expected === $idsSeq);
        }
        if (!$valid && count($clickSeq) === $pointCount) {
            $valid = ($expected === $clickSeq);
        }

        Log::info('Captcha Verify Result:', [
            'expected' => $expected,
            'idsSeq' => $idsSeq,
            'valid' => $valid
        ]);

        Cache::forget('click_captcha_' . $sessionId);
        return response()->json(['code' => 200, 'valid' => $valid]);
    }
}
