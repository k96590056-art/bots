<?php
/**
 * 检查 TelegramBotService.php 文件语法
 * 在服务器上运行: php check_telegram_service.php
 */

$filePath = __DIR__ . '/admin/app/Services/TelegramBotService.php';

if (!file_exists($filePath)) {
    echo "错误: 文件不存在: $filePath\n";
    exit(1);
}

// 读取文件内容
$content = file_get_contents($filePath);

// 检查第850-860行
$lines = explode("\n", $content);
$startLine = 849; // 0-based index
$endLine = 860;

echo "检查第 850-860 行内容:\n";
echo str_repeat("=", 80) . "\n";
for ($i = $startLine; $i <= $endLine && $i < count($lines); $i++) {
    $lineNum = $i + 1;
    printf("%4d: %s\n", $lineNum, $lines[$i]);
}
echo str_repeat("=", 80) . "\n\n";

// 检查是否有残留的代码片段
$patterns = [
    "/\s+['\"]response['\"]\s*=>\s*\$result\s*\n\s*\]\);\s*$/m" => "发现残留的 Log::info 代码片段",
    "/\s+['\"]response['\"]\s*=>\s*\$result\s*\n\s*\]\);\s*$/m" => "发现未闭合的数组",
];

$foundIssues = false;
foreach ($patterns as $pattern => $message) {
    if (preg_match($pattern, $content)) {
        echo "警告: $message\n";
        $foundIssues = true;
    }
}

// 使用 PHP 语法检查
$output = [];
$returnVar = 0;
exec("php -l \"$filePath\" 2>&1", $output, $returnVar);

echo "\nPHP 语法检查结果:\n";
echo str_repeat("=", 80) . "\n";
echo implode("\n", $output) . "\n";
echo str_repeat("=", 80) . "\n";

if ($returnVar === 0) {
    echo "\n✓ 语法检查通过\n";
} else {
    echo "\n✗ 发现语法错误\n";
    exit(1);
}

// 检查第854行具体内容
if (isset($lines[853])) {
    $line854 = trim($lines[853]);
    echo "\n第854行内容: \"$line854\"\n";
    
    if (strpos($line854, 'catch') !== false) {
        echo "✓ 第854行是正确的 catch 语句\n";
    } else if (strpos($line854, '=>') !== false && strpos($line854, 'response') !== false) {
        echo "✗ 警告: 第854行可能包含残留的数组代码\n";
    }
}
