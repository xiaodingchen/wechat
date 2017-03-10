<?php 
use Skinny\Exceptions\HandleExceptions;
class Kernel
{
    private static $__running_in_console = null;
    private static $__exception_instance = null;
    /**
     * 判断PHP运行模式
     * */
    public static function runningInConsole()
    {
        return php_sapi_name() == 'cli';
    }

    /**
     * 错误处理
     */
    public static function startExceptionHandling()
    {
        if (! isset(static::$__exception_instance))
        {
            static::$__exception_instance = new HandleExceptions();
        }
        
        static::$__exception_instance->bootstrap();
    }
}
