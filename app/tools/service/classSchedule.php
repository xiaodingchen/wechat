<?php 
namespace App\tools\service;

class classSchedule
{
    protected $start = '20170220';

    protected function getSchedule()
    {
        return 
        [
            1 => ['1-15' => '大学英语(点播or去校区)'],
            2 => ['1-12' => '计算机网络（点播）', '6,10,12,14' => '计算机应用基础（二）上机'],
            3 => ['1-15' => '程序设计C（点播）'],
            4 => ['1-11' => '计算机应用基础（二）(点播or去校区)'],
            5 => ['1-15' => '远程教育导论（点播）', '5,7,10' => '计算机网络上机'],
        ];
    }

    // 获取当天课程安排
    public function getClass()
    {
        $day = date('w', time());
        $week = $this->getWeek();
        $classes = $this->getSchedule();
        $dayClass = $classes[$day];
        $classname = [];
        foreach ($dayClass as $key => $value) 
        {
            if(strpos($key, '-'))
            {
                list($start, $end) = explode('-', $key);
                $weeks = self::array_range($start, $end, 1);
            }
            else
            {
                $weeks = explode(',', $key);
            }

            if(in_array($week, $weeks))
            {
                $classname[] = $value;
            }
        }
        
        return $classname;
    }

    public function getWeek()
    {
        $start = $this->start;
        
        $startTime = strtotime($start);
        $startDay = date('w', $startTime);
        // 获取开始日期所在周的周一
        $startMontime = $this->_getMontime($startDay, $startTime);

        // 获取当前时间所在周的周一
        $currentDay = date('w', time());
        $currentMontime = $this->_getMontime($currentDay, strtotime(date('Y-m-d', time())));
        
        $week = ($currentMontime - $startMontime) / (7 * 86400);
        $week += $week;
        return $week;
    }

    private function _getMontime($startDay, $startTime)
    {
        if($startDay != 1 || $startDay != 0)
        {
            $monTime = $startTime - ($startDay - 1) * 86400;
        }
        elseif ($startDay == 0) 
        {
            $monTime = $startTime - (7 - 1) * 86400;
        }
        else
        {
            $monTime = $startTime;
        }

        return $monTime;
    }

    public static function array_range($from, $to, $step=1)
    {
        $array = array();
        for ($x=$from; $x <= $to; $x += $step)
        {
            $array[] = $x;
        }

        return $array;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }
}
