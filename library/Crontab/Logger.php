<?php 
namespace Skinny\Crontab;

use Exception;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

class Logger
{
    protected $handler = null;
    private static $__crontab_excutions = 0;

    public function __construct(PsrLoggerInterface $log)
    {
        $this->handler = $log;
    }

    public function logging($crontab_name, $result = null)
    {
        if($result instanceof Exception)
        {
            $this->handler->error($result, ['crontab_name' => $crontab_name, 'exception' => $result]);
        }
        else
        {
            $this->handler->debug(sprintf('crontab:%d %s', ++static::$__crontab_excutions, $crontab_name), ['crontab_name' => $crontab_name, 'result' => $result]);
        }
    }
}
