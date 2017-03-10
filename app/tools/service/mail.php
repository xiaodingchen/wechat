<?php 
namespace App\tools\service;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;
use Skinny\Component\Config as config;

class mail
{
    public static function sedmail(array $to, $subject, $body, $bodyType = 'text/html', $file = null)
    {
        $server = config::get('mail.server');
        $transport = Swift_SmtpTransport::newInstance($server['host'], $server['port'])
        ->setUsername($server['username'])
        ->setPassword($server['password']);

        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($subject)
        ->setFrom(config::get('mail.from'))
        ->setTo($to)
        ->setBody($body, $bodyType);

        if($file)
        {
            $message->attach(Swift_Attachment::fromPath($file));
        }

        $numSent = $mailer->send($message);

        return $numSent;
    }
}
