<?php 
namespace App\tools\commands;

use Skinny\Console\CommandInterface;
use App\tools\service\classSchedule;
use Skinny\Facades\ConsoleColors as consoleColor;
use App\tools\service\mail;
use Skinny\Component\Config as config;

class lessonRemin implements CommandInterface
{
    public function __construct()
    {
        $this->start = '20170220';
    }

    public function handle(array $args = [])
    {
        $params = [];
        foreach ($args as $value) 
        {
            list($key, $val) = explode('=', $value);
            $params[$key] = $val;
        }

        if($params['start'])
        {
            $this->start = $params['start'];
        }

        $numSent = $this->_sendEmail();
        
        consoleColor::outputText(sprintf("Sent %d messages", $numSent));
        exit(0);
    }

    protected function _sendEmail()
    {
        $subject = '今日上课提醒';
        $serv = new classSchedule();
        $serv->setStart($this->start);
        $classes = $serv->getClass();
        if(count($classes))
        {
            $body = '<p>今日课程有：</p>';
            foreach ($classes as $value) 
            {
                $body .= '<h2 style="color:red">' . $value . '</h2>';
            }

            return mail::sedmail(config::get('mail.to.classes'), $subject, $body);
        }

        return false;
    }

    public function commandExplain()
    {
        return 'php skinny lessonRemin start=20170101';
    }

    public function commandTitle()
    {
        return '今日上课提醒';
    }
}
