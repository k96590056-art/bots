<?php

namespace App\Admin\Actions\Grid\User;

use App\Models\TelegramRebindToken;
use App\Models\SystemConfig;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class RebindTelegram extends RowAction
{
    protected $title = '换绑Telegram';

    /**
     * 处理请求
     */
    public function handle(Request $request)
    {
        $userId = $this->getKey();

        // 生成换绑令牌（24小时有效）
        $rebindToken = TelegramRebindToken::generateToken($userId, 24);

        // 通过 bot token 自动获取 bot 用户名
        $botUsername = $this->getBotUsername();

        if (empty($botUsername)) {
            return $this->response()
                ->error('获取 Bot 用户名失败，请检查 telegram_bot_token 配置')
                ->refresh();
        }

        // 生成换绑链接
        $rebindLink = "https://t.me/{$botUsername}?start=rebind_{$rebindToken->token}";

        return $this->response()
            ->success('换绑链接已生成，有效期24小时')
            ->script("
                (function() {
                    var linkText = '{$rebindLink}';
                    Dcat.swal.fire({
                        title: '换绑链接',
                        html: '<div style=\"text-align:left;word-break:break-all;\">' +
                              '<p>请将以下链接发送给用户：</p>' +
                              '<input type=\"text\" id=\"rebind-link\" value=\"' + linkText + '\" style=\"width:100%;padding:8px;margin:10px 0;border:1px solid #ddd;border-radius:4px;\" readonly onclick=\"this.select()\" />' +
                              '<p style=\"color:#666;font-size:12px;\">用户点击链接后，用新的 Telegram 账号打开即可完成换绑</p>' +
                              '</div>',
                        confirmButtonText: '复制链接',
                        showCancelButton: true,
                        cancelButtonText: '关闭',
                        preConfirm: function() {
                            var textArea = document.createElement('textarea');
                            textArea.value = linkText;
                            textArea.style.position = 'fixed';
                            textArea.style.top = '0';
                            textArea.style.left = '0';
                            textArea.style.width = '2em';
                            textArea.style.height = '2em';
                            textArea.style.padding = '0';
                            textArea.style.border = 'none';
                            textArea.style.outline = 'none';
                            textArea.style.boxShadow = 'none';
                            textArea.style.background = 'transparent';
                            document.body.appendChild(textArea);
                            textArea.focus();
                            textArea.select();
                            var success = false;
                            try {
                                success = document.execCommand('copy');
                            } catch (err) {
                                success = false;
                            }
                            document.body.removeChild(textArea);
                            return success;
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            if (result.value) {
                                Dcat.success('链接已复制到剪贴板');
                            } else {
                                Dcat.warning('自动复制失败，请手动复制输入框中的链接');
                            }
                        }
                    });
                })();
            ");
    }

    /**
     * 通过 bot token 获取 bot 用户名
     */
    protected function getBotUsername()
    {
        // 先检查缓存
        $cachedUsername = Cache::get('telegram_bot_username');
        if (!empty($cachedUsername)) {
            return $cachedUsername;
        }

        // 缓存不存在或为空，重新获取
        $botToken = SystemConfig::getValue('telegram_bot_token') ?? env('TELEGRAM_BOT_TOKEN');

        if (empty($botToken)) {
            return null;
        }

        try {
            $client = new Client([
                'timeout' => 10,
                'verify' => false
            ]);

            $response = $client->get("https://api.telegram.org/bot{$botToken}/getMe");

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                if (isset($data['ok']) && $data['ok'] && isset($data['result']['username'])) {
                    $username = $data['result']['username'];
                    // 只缓存成功获取的用户名
                    Cache::put('telegram_bot_username', $username, 3600);
                    return $username;
                }
            }
        } catch (\Exception $e) {
            \Log::error('获取 Telegram Bot 信息失败', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return null;
    }

    /**
     * 确认弹窗
     */
    public function confirm()
    {
        return ['确定要生成换绑链接吗？', '生成后旧的换绑链接将失效'];
    }

    /**
     * 设置请求参数
     */
    protected function parameters()
    {
        return [];
    }
}
