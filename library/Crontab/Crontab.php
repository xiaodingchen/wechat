<?php 
namespace Skinny\Crontab;

use Skinny\Crontab\Configuration;

class Crontab
{
    public function __construct(Configuration $conf)
    {
        $this->conf = $conf;
    }

    public function run(array $crontab_list)
    {

    }

    // 创建
    private function __createCrotabQueue($crontab_list)
    {
        $timeArr = [];
        foreach ($crontab_list as $key => $value) 
        {
            // 计算任务执行的时间

        }
    }

    private function __formatTime($time_format)
    {

        $timeArr = explode(' ', $time_format);
        if(count(array_unique($timeArr)) == 1 && array_unique($timeArr)[0] == '*')
        {
            return time();
        }
        
        $tmp = '';
        foreach ($timeArr as $val) 
        {
            // 分钟
            if(substr_count($val, needle))
        }
    }
}