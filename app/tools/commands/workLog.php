<?php 
namespace App\tools\commands;

use Skinny\Console\CommandInterface;
use Skinny\Facades\ConsoleColors as consoleColor;
use App\tools\service\mail;
use Skinny\Component\Config as config;

class workLog implements CommandInterface
{
    public function handle(array $args = [])
    {
        $params = [];
        foreach ($args as $value) 
        {
            list($key, $val) = explode('=', $value);
            $params[$key] = $val;
        }

        $type = $params['type'];

        $numSent = $this->_sendEmail($type);
        
        consoleColor::outputText(sprintf("Sent %d messages", $numSent));
    }

    protected function _sendEmail($type)
    {
        switch ($type) {
            case 'week':
                $subject = 'ITP日志周报提醒';
                $body = '<h2>又过了一周，大家别忘了写ITP日志周报啊！！！！</h2>';
                break;
            case 'month':
                // 处理每个月的最后一天
                if(date('d') != date('t'))
                {
                    return false;
                }
                
                $subject = 'ITP日志月报提醒';
                $body = '<h2>又过了一个月，大家别忘了写ITP日志月报啊！！！！</h2>';

                break;
        }

        if($subject && $body)
        {
            return mail::sedmail(config::get('mail.to.work_log'), $subject, $body);
        }

        return false;
    }

    public function commandExplain()
    {
        return 'php skinny worklog type=week';
    }

    public function commandTitle()
    {
        return '工作日志提醒';
    }
}
