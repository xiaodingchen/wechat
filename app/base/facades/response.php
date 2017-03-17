<?php 
namespace App\base\facades;

use App\base\service\response as HttpResponse;
use Skinny\support\traits\macro as MacroableTrait;
use Skinny\Facades\Facade;
use Skinny\Kernel;
use Symfony\Component\HttpFoundation\JsonResponse;

class response extends Facade
{
    use MacroableTrait;

    private static $__response;
    
    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\Response
     */
    public static function make($content = '', $status = 200, array $headers = array())
    {
        return new HttpResponse($content, $status, $headers);
    }
    
    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int    $status
     * @param  array  $headers
     * @param  int    $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function json($data = array(), $status = 200, array $headers = array(), $options = 0)
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

}
