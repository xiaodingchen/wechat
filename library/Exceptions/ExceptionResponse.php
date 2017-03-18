<?php 
namespace Skinny\Exceptions;

use Exception;
use Skinny\Log\Logger as logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ExceptionResponse
{
    public function renderForConsole(Exception $e)
    {
        throw $e;
    }

    /**
     * 使用whoops错误处理组件
     */
    public function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        
        return new SymfonyResponse($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
    }

    /**
     * Report or log an exception.
     *
     * @param \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        logger::error($e);
    }

    public function renderExceptionWithJson(Exception $e)
    {
        $trace = $e->getTrace();
        if (config::get('app.debug', false) === false)
        {
            $e = new \RuntimeException(503, 'unknown error');
            $trace = [];
        }

        $errcode = $e->getCode();
        $errmsg = $e->getMessage();

        $json = [
            'errcode' => $errcode,
            'errmsg' => $errmsg,
            'trace' => $trace
        ];

        return new JsonResponse($json);
    }
}

