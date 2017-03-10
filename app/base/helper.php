<?php 

function url($action, array $params = [])
{
    $arr = explode('_', $action);
    if(count($arr) != 3)
    {
        throw new \RuntimeException('Must be a complete method');
    }

    $urlParmas['m'] = $arr[0];
    $urlParmas['c'] = $arr[1];
    $urlParmas['a'] = $arr[2];

    $urlParmas = array_merge($urlParmas, $params);
    $urlParmas = http_build_query($urlParmas);
    $url = \request::getSchemeAndHttpHost() . \request::getBaseUrl() . '?' . $urlParmas;

    return $url;
}
