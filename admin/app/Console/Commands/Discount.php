在z<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DiscountService;
use ReflectionClass;
use ReflectionMethod;

class Discount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount {method? : 要调用的方法名}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '优惠活动相关命令';

    protected $discountService;

    /**
     * 方法描述映射
     *
     * @var array
     */
    protected $methodDescriptions = [
        'grantVipBonus' => '发放VIP升级奖金。参数：用户ID、VIP等级ID、奖金金额',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->discountService = new DiscountService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $methodName = $this->argument('method');

        if (empty($methodName)) {
            // 如果没有指定方法，显示所有可用方法
            $this->showAvailableMethods();
            return 0;
        }

        // 检查方法是否存在
        if (!method_exists($this->discountService, $methodName)) {
            $this->error("方法不存在：{$methodName}");
            $this->showAvailableMethods();
            return 1;
        }

        // 显示方法描述
        $description = $this->getMethodDescription($methodName);
        $this->info("方法：{$methodName}");
        $this->info("功能：{$description}");

        // 获取方法参数信息
        $reflection = new ReflectionClass($this->discountService);
        $method = $reflection->getMethod($methodName);
        $parameters = $method->getParameters();

        if (empty($parameters)) {
            // 如果没有参数，直接调用
            $this->info("\n正在调用方法...");
            $result = call_user_func([$this->discountService, $methodName]);
            $this->displayResult($result);
        } else {
            // 如果有参数，提示用户输入
            $this->info("\n该方法需要以下参数：");
            $args = [];
            foreach ($parameters as $param) {
                $paramName = $param->getName();
                $paramType = $param->getType() ? $param->getType()->getName() : 'mixed';
                $defaultValue = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                
                $prompt = "请输入 {$paramName}";
                if ($paramType !== 'mixed') {
                    $prompt .= " ({$paramType})";
                }
                if ($defaultValue !== null) {
                    $prompt .= " [默认: {$defaultValue}]";
                }
                $prompt .= ": ";

                $value = $this->ask($prompt, $defaultValue);
                
                // 类型转换
                if ($paramType === 'int' || $paramType === 'integer') {
                    $value = (int)$value;
                } elseif ($paramType === 'float' || $paramType === 'double') {
                    $value = (float)$value;
                } elseif ($paramType === 'bool' || $paramType === 'boolean') {
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
                
                $args[] = $value;
            }

            $this->info("\n正在调用方法...");
            $result = call_user_func_array([$this->discountService, $methodName], $args);
            $this->displayResult($result);
        }

        return 0;
    }

    /**
     * 显示所有可用方法
     */
    protected function showAvailableMethods()
    {
        $this->info('可用方法：');
        $reflection = new ReflectionClass($this->discountService);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        
        foreach ($methods as $method) {
            if ($method->getName() === '__construct') {
                continue;
            }
            $methodName = $method->getName();
            $description = $this->getMethodDescription($methodName);
            $this->line("  - {$methodName}: {$description}");
        }
    }

    /**
     * 获取方法描述
     *
     * @param string $methodName
     * @return string
     */
    protected function getMethodDescription($methodName)
    {
        if (isset($this->methodDescriptions[$methodName])) {
            return $this->methodDescriptions[$methodName];
        }

        // 尝试从方法的注释中获取描述
        $reflection = new ReflectionClass($this->discountService);
        $method = $reflection->getMethod($methodName);
        $docComment = $method->getDocComment();
        
        if ($docComment) {
            // 提取第一行注释作为描述
            $lines = explode("\n", $docComment);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, '*') === 0) {
                    $line = trim(substr($line, 1));
                    if (!empty($line) && strpos($line, '@') !== 0 && strpos($line, '/') !== 0) {
                        return $line;
                    }
                }
            }
        }

        return '无描述';
    }

    /**
     * 显示方法执行结果
     *
     * @param mixed $result
     */
    protected function displayResult($result)
    {
        if (is_array($result)) {
            if (isset($result['code'])) {
                if ($result['code'] == 200) {
                    $this->info("执行成功：{$result['message']}");
                    if (isset($result['data'])) {
                        $this->table(['字段', '值'], $this->formatData($result['data']));
                    }
                } else {
                    $this->error("执行失败：{$result['message']}");
                }
            } else {
                $this->info('执行结果：');
                $this->line(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        } else {
            $this->info('执行结果：' . var_export($result, true));
        }
    }

    /**
     * 格式化数据为表格格式
     *
     * @param array $data
     * @return array
     */
    protected function formatData($data)
    {
        $rows = [];
        foreach ($data as $key => $value) {
            $rows[] = [$key, is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value];
        }
        return $rows;
    }
}
