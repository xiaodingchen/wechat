<?php
/**
 * apc.php
 *
 * */
namespace Skinny\Cache;

class Apc implements CacheInterface
{
    protected $apcu = false;
    
    protected $prefix;
    
    public function __construct($prefix = '')
    {
        $this->apcu = function_exists('apcu_fetch');
        
        $this->setPrefix($prefix);
    }
    
    
    public function get($key)
    {
        $key = $this->prefix.$key;
        return $this->apcu ? apcu_fetch($key) : apc_fetch($key);
    }
    
    public function set($key, $value, $seconds = 0)
    {
        $key = $this->prefix.$key;
        return $this->apcu ? apcu_store($key, $value, $seconds) : apc_store($key, $value, $seconds);
    }
    
    public function delete($key)
    {
        $key = $this->prefix.$key;
        return $this->apcu ? apcu_delete($key) : apc_delete($key);
    }
    
    public function clear()
    {
        $this->apcu ? apcu_clear_cache() : apc_clear_cache('user');
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
}
