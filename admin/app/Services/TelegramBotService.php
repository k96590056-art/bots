<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\SystemConfig;

class TelegramBotService
{
    protected $botToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = SystemConfig::getValue('telegram_bot_token') ?? env('TELEGRAM_BOT_TOKEN');
        
        if (empty($this->botToken)) {
            Log::error('Telegram Bot Token未配置', [
                'config_value' => SystemConfig::getValue('telegram_bot_token'),
                'env_value' => env('TELEGRAM_BOT_TOKEN')
            ]);
        }
        
        $this->apiUrl = 'https://api.telegram.org/bot' . $this->botToken . '/';
    }

    /**
     * 发送消息
     *
     * @param int $chatId
     * @param string $text
     * @param array $options
     * @return array
     */
    public function sendMessage($chatId, $text, $options = [])
    {
        $data = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $options);

        // 如果options中有reply_markup，需要将其转换为JSON字符串
        if (isset($data['reply_markup']) && is_array($data['reply_markup'])) {
            $data['reply_markup'] = json_encode($data['reply_markup']);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'sendMessage');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram发送消息CURL错误', [
                    'chat_id' => $chatId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram发送消息失败', [
                    'chat_id' => $chatId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '发送消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram发送消息异常', [
                'chat_id' => $chatId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 发送图片
     *
     * @param int $chatId
     * @param string $photo 图片URL或文件路径
     * @param string $caption 图片说明
     * @param array $options
     * @return array
     */
    public function sendPhoto($chatId, $photo, $caption = '', $options = [])
    {
        $data = [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ];

        $data = array_merge($data, $options);

        // 如果options中有reply_markup，需要将其转换为JSON字符串
        if (isset($data['reply_markup']) && is_array($data['reply_markup'])) {
            $data['reply_markup'] = json_encode($data['reply_markup']);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'sendPhoto');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram发送图片CURL错误', [
                    'chat_id' => $chatId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram发送图片失败', [
                    'chat_id' => $chatId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '发送图片失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram发送图片异常', [
                'chat_id' => $chatId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 发送带内联键盘的图片
     *
     * @param int $chatId
     * @param string $photo 图片URL或文件路径
     * @param string $caption 图片说明
     * @param array $inlineKeyboard 内联键盘数组
     * @param array $options
     * @return array
     */
    public function sendPhotoWithInlineKeyboard($chatId, $photo, $caption = '', $inlineKeyboard = [], $options = [])
    {
        $replyMarkup = [
            'inline_keyboard' => $inlineKeyboard
        ];

        $data = [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($replyMarkup),
        ];

        $data = array_merge($data, $options);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'sendPhoto');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram发送带键盘图片CURL错误', [
                    'chat_id' => $chatId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram发送带键盘图片失败', [
                    'chat_id' => $chatId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '发送图片失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram发送带键盘图片异常', [
                'chat_id' => $chatId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 编辑消息
     *
     * @param int $chatId
     * @param int $messageId
     * @param string $text
     * @param array $options
     * @return array
     */
    public function editMessageText($chatId, $messageId, $text, $options = [])
    {
        $data = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $options);

        // 如果options中有reply_markup，需要将其转换为JSON字符串
        if (isset($data['reply_markup']) && is_array($data['reply_markup'])) {
            $data['reply_markup'] = json_encode($data['reply_markup']);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'editMessageText');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram编辑消息CURL错误', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram编辑消息失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '编辑消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram编辑消息异常', [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 删除消息
     *
     * @param int $chatId
     * @param int $messageId
     * @return array
     */
    public function deleteMessage($chatId, $messageId)
    {
        $data = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'deleteMessage');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram删除消息CURL错误', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram删除消息失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '删除消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram删除消息异常', [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 发送带内联键盘的消息
     *
     * @param int $chatId
     * @param string $text
     * @param array $inlineKeyboard 内联键盘数组
     * @param array $options
     * @return array
     */
    public function sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard = [], $options = [])
    {
        $replyMarkup = [
            'inline_keyboard' => $inlineKeyboard
        ];

        $data = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $options);

        // 将reply_markup单独处理，确保正确编码
        $data['reply_markup'] = json_encode($replyMarkup);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'sendMessage');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram发送带键盘消息CURL错误', [
                    'chat_id' => $chatId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram发送带键盘消息失败', [
                    'chat_id' => $chatId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '发送消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram发送带键盘消息异常', [
                'chat_id' => $chatId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 编辑图片消息的caption（带内联键盘）
     *
     * @param int $chatId
     * @param int $messageId
     * @param string $caption
     * @param array $inlineKeyboard
     * @param array $options
     * @return array
     */
    public function editMessageCaptionWithInlineKeyboard($chatId, $messageId, $caption, $inlineKeyboard = [], $options = [])
    {
        $replyMarkup = [
            'inline_keyboard' => $inlineKeyboard
        ];

        $data = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'caption' => $caption,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($replyMarkup),
        ], $options);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'editMessageCaption');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram编辑图片消息caption CURL错误', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram编辑图片消息caption失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '编辑消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram编辑图片消息caption异常', [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 编辑消息的媒体内容（替换图片）
     *
     * @param int $chatId
     * @param int $messageId
     * @param string $photoUrl
     * @param string $caption
     * @param array $inlineKeyboard
     * @return array
     */
    public function editMessageMedia($chatId, $messageId, $photoUrl, $caption = "", $inlineKeyboard = [])
    {
        $media = [
            "type" => "photo",
            "media" => $photoUrl,
            "caption" => $caption,
            "parse_mode" => "HTML"
        ];

        $data = [
            "chat_id" => $chatId,
            "message_id" => $messageId,
            "media" => json_encode($media)
        ];

        if (!empty($inlineKeyboard)) {
            $data["reply_markup"] = json_encode(["inline_keyboard" => $inlineKeyboard]);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . "editMessageMedia");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error("Telegram editMessageMedia CURL错误", [
                    "chat_id" => $chatId,
                    "message_id" => $messageId,
                    "curl_error" => $curlError
                ]);
                return ["code" => 500, "message" => "请求失败：" . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result["ok"]) || !$result["ok"]) {
                Log::error("Telegram editMessageMedia失败", [
                    "chat_id" => $chatId,
                    "message_id" => $messageId,
                    "http_code" => $httpCode,
                    "response" => $result
                ]);
                return ["code" => 500, "message" => "编辑消息媒体失败", "data" => $result];
            }

            return ["code" => 200, "message" => "成功", "data" => $result];
        } catch (\Exception $e) {
            Log::error("Telegram editMessageMedia异常", [
                "chat_id" => $chatId,
                "message_id" => $messageId,
                "error" => $e->getMessage()
            ]);
            return ["code" => 500, "message" => $e->getMessage()];
        }
    }


    /**
     * 编辑带内联键盘的消息
     *
     * @param int $chatId
     * @param int $messageId
     * @param string $text
     * @param array $inlineKeyboard
     * @param array $options
     * @return array
     */
    public function editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard = [], $options = [])
    {
        $replyMarkup = [
            'inline_keyboard' => $inlineKeyboard
        ];

        $data = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($replyMarkup),
        ], $options);

        // 如果options中也有reply_markup，需要合并处理
        if (isset($options['reply_markup']) && is_array($options['reply_markup'])) {
            $data['reply_markup'] = json_encode($options['reply_markup']);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'editMessageText');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram编辑带键盘消息CURL错误', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram编辑带键盘消息失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '编辑消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram编辑带键盘消息异常', [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 编辑消息的回复键盘（只编辑按钮，不修改消息内容）
     *
     * @param int $chatId
     * @param int $messageId
     * @param array $inlineKeyboard
     * @return array
     */
    public function editMessageReplyMarkup($chatId, $messageId, $inlineKeyboard = [])
    {
        $replyMarkup = [
            'inline_keyboard' => $inlineKeyboard
        ];

        $data = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'reply_markup' => json_encode($replyMarkup),
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'editMessageReplyMarkup');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram编辑消息回复键盘CURL错误', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram编辑消息回复键盘失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '编辑消息回复键盘失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram编辑消息回复键盘异常', [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 设置Webhook
     *
     * @param string $url
     * @return array
     */
    public function setWebhook($url)
    {
        $data = [
            'url' => $url,
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'setWebhook');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram设置Webhook CURL错误', [
                    'url' => $url,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram设置Webhook失败', [
                    'url' => $url,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '设置Webhook失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram设置Webhook异常', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 设置Bot命令菜单（让命令在输入框左侧常驻显示）
     * 
     * @param array $commands 命令数组，格式：[['command' => 'start', 'description' => '开始使用'], ...]
     * @param string $scope 命令作用域，默认为空表示所有私聊。可选值：
     *                      - 'default' - 默认作用域（所有私聊）
     *                      - ['type' => 'chat', 'chat_id' => 123] - 指定聊天
     *                      - ['type' => 'chat_administrators', 'chat_id' => 123] - 聊天管理员
     *                      - ['type' => 'chat_member', 'chat_id' => 123, 'user_id' => 456] - 指定用户
     * @param string $languageCode 语言代码，默认为空（所有语言）
     * @return array
     */
    public function setMyCommands($commands = null, $scope = null, $languageCode = null)
    {
        // 如果没有提供命令，默认设置/start命令
        if ($commands === null) {
            $commands = [
                [
                    'command' => 'start',
                    'description' => '开始使用机器人'
                ]
            ];
        }

        $data = [
            'commands' => json_encode($commands)
        ];

        // 如果提供了scope，添加到请求中
        if ($scope !== null) {
            if (is_string($scope) && $scope === 'default') {
                // default scope不需要额外参数
            } else if (is_array($scope)) {
                $data['scope'] = json_encode($scope);
            }
        }

        // 如果提供了语言代码，添加到请求中
        if ($languageCode !== null) {
            $data['language_code'] = $languageCode;
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'setMyCommands');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram设置Bot命令菜单CURL错误', [
                    'commands' => $commands,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram设置Bot命令菜单失败', [
                    'commands' => $commands,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '设置Bot命令菜单失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram设置Bot命令菜单异常', [
                'commands' => $commands,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 设置聊天菜单按钮类型
     *
     * @param string $type 菜单类型：'commands'（显示命令列表）, 'default'（默认）, 'web_app'（打开Web App）
     * @param int|null $chatId 聊天ID，为空则设置默认菜单
     * @param string|null $webAppUrl 当type为web_app时，指定Web App的URL
     * @param string|null $webAppText 当type为web_app时，按钮显示的文字
     * @return array
     */
    public function setChatMenuButton($type = 'commands', $chatId = null, $webAppUrl = null, $webAppText = null)
    {
        $data = [];

        if ($chatId !== null) {
            $data['chat_id'] = $chatId;
        }

        // 根据类型构建 menu_button 参数
        switch ($type) {
            case 'commands':
                $data['menu_button'] = json_encode(['type' => 'commands']);
                break;
            case 'web_app':
                if ($webAppUrl) {
                    $data['menu_button'] = json_encode([
                        'type' => 'web_app',
                        'text' => $webAppText ?: '打开',
                        'web_app' => ['url' => $webAppUrl]
                    ]);
                }
                break;
            case 'default':
            default:
                $data['menu_button'] = json_encode(['type' => 'default']);
                break;
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'setChatMenuButton');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram设置菜单按钮CURL错误', [
                    'type' => $type,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);

            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram设置菜单按钮失败', [
                    'type' => $type,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '设置菜单按钮失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram设置菜单按钮异常', [
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 获取用户信息
     *
     * @param int $userId
     * @return array
     */
    public function getUserInfo($userId)
    {
        // Telegram Bot API没有直接获取用户信息的方法
        // 这个方法主要用于从webhook中获取的用户信息进行解析
        return ['code' => 200, 'message' => '成功'];
    }

    /**
     * 回答回调查询
     * 
     * @param string $callbackQueryId 回调查询ID
     * @param bool $showAlert 是否显示alert弹窗（true显示弹窗，false只消除加载状态）
     * @param string $text alert弹窗显示的文本内容（仅在showAlert=true时有效）
     * @param string $url 已废弃，不再使用（保留以兼容旧代码）
     * @return array
     */
    public function answerCallbackQuery($callbackQueryId, $showAlert = false, $text = null, $url = '')
    {
        // 如果需要显示alert，则调用API显示弹窗提示
        if ($showAlert && !empty($text)) {
            $data = [
                'callback_query_id' => $callbackQueryId,
                'text' => $text,
                'show_alert' => true,
            ];

            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'answerCallbackQuery');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);
                curl_close($ch);

                if ($curlError) {
                    Log::error('Telegram answerCallbackQuery CURL错误', [
                        'callback_query_id' => $callbackQueryId,
                        'curl_error' => $curlError
                    ]);
                    return ['code' => 500, 'message' => '请求失败：' . $curlError];
                }

                $result = json_decode($response, true);
                
                if (!$result || !isset($result['ok']) || !$result['ok']) {
                    Log::error('Telegram answerCallbackQuery失败', [
                        'callback_query_id' => $callbackQueryId,
                        'http_code' => $httpCode,
                        'response' => $result
                    ]);
                    return ['code' => 500, 'message' => '显示提示失败', 'data' => $result];
                }

                return ['code' => 200, 'message' => '成功', 'data' => $result];
            } catch (\Exception $e) {
                Log::error('Telegram answerCallbackQuery异常', [
                    'callback_query_id' => $callbackQueryId,
                    'error' => $e->getMessage()
                ]);
                return ['code' => 500, 'message' => $e->getMessage()];
            }
        }
        
        // 如果不显示alert，只消除加载状态（不显示绿色图标）
        $data = [
            'callback_query_id' => $callbackQueryId,
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'answerCallbackQuery');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram answerCallbackQuery CURL错误', [
                    'callback_query_id' => $callbackQueryId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram answerCallbackQuery异常', [
                'callback_query_id' => $callbackQueryId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    /**
     * 发送带回复键盘的消息（常驻键盘菜单）
     *
     * @param int $chatId
     * @param string $text
     * @param array $keyboard 键盘按钮数组，格式：[['按钮1', '按钮2'], ['按钮3', '按钮4']]
     * @param bool $resizeKeyboard 是否自动调整键盘大小
     * @param bool $oneTimeKeyboard 是否一次性键盘（false表示常驻）
     * @param array $options 其他选项
     * @return array
     */
    public function sendMessageWithReplyKeyboard($chatId, $text, $keyboard = [], $resizeKeyboard = true, $oneTimeKeyboard = false, $options = [])
    {
        // 处理键盘按钮，支持web_app类型
        // 如果键盘中的按钮是数组且包含web_app键，则使用对象格式；否则使用字符串格式
        $processedKeyboard = [];
        foreach ($keyboard as $row) {
            $processedRow = [];
            foreach ($row as $button) {
                if (is_array($button) && isset($button['text'])) {
                    // 按钮已经是对象格式（包含text和可能的web_app等）
                    $processedRow[] = $button;
                } else {
                    // 按钮是字符串，转换为简单格式
                    $processedRow[] = ['text' => (string)$button];
                }
            }
            $processedKeyboard[] = $processedRow;
        }
        
        $replyMarkup = [
            'keyboard' => $processedKeyboard,
            'resize_keyboard' => $resizeKeyboard,
            'one_time_keyboard' => $oneTimeKeyboard
        ];

        // 调试日志 - 记录发送给 Telegram 的完整键盘数据
        file_put_contents(storage_path('logs/telegram_webhook.log'),
            date('Y-m-d H:i:s') . " === sendMessageWithReplyKeyboard 调试 ===\n" .
            "chat_id: {$chatId}\n" .
            "reply_markup: " . json_encode($replyMarkup, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n" .
            "---\n", FILE_APPEND);

        $data = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($replyMarkup),
        ], $options);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . 'sendMessage');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Telegram发送带回复键盘消息CURL错误', [
                    'chat_id' => $chatId,
                    'curl_error' => $curlError
                ]);
                return ['code' => 500, 'message' => '请求失败：' . $curlError];
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['ok']) || !$result['ok']) {
                Log::error('Telegram发送带回复键盘消息失败', [
                    'chat_id' => $chatId,
                    'http_code' => $httpCode,
                    'response' => $result
                ]);
                return ['code' => 500, 'message' => '发送消息失败', 'data' => $result];
            }

            return ['code' => 200, 'message' => '成功', 'data' => $result];
        } catch (\Exception $e) {
            Log::error('Telegram发送带回复键盘消息异常', [
                'chat_id' => $chatId,
                'error' => $e->getMessage()
            ]);
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }
}

