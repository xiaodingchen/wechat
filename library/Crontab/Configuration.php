<?php 
namespace Skinny\Crontab;

use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Skinny\Crontab\Logger;

class Configuration
{
    public function setLogger(PsrLoggerInterface $logger)
    {
        $this->logger = new Logger($logger);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function getOptions()
    {
        return $this->options;
    }
}