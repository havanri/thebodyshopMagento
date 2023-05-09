<?php

namespace SnaptecHue\Practice\Controller\Test;

use Psr\Log\LoggerInterface;

class Logger extends \SnaptecHue\Practice\Controller\Test
{

    protected $logger;
    protected $cache;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        LoggerInterface $logger,
        \SnaptecHue\Practice\Model\Cache $cache
    ) {
        $this->logger = $logger;
        $this->cache = $cache;
        return parent::__construct($context);
    }
    public function execute()
    {
        //simple
        $this->logger->log(\Monolog\Logger::DEBUG, 'debug message');
        $this->logger->log(\Monolog\Logger::INFO, 'info message', ['user' => 'Ri']);
        $this->logger->log(\Monolog\Logger::NOTICE, 'notice message');
        $this->logger->log(\Monolog\Logger::WARNING, 'warning message');
        $this->logger->log(\Monolog\Logger::ERROR, 'error message');
        $this->logger->log(\Monolog\Logger::CRITICAL, 'critical message');
        $this->logger->log(\Monolog\Logger::ALERT, 'alert message');
        $this->logger->log(\Monolog\Logger::EMERGENCY, 'emergency message');

        // preferred shorter version
        $this->logger->debug('debug msg');
        $this->logger->info('info msg', ['user' => 'Ri']);
        $this->logger->notice('notice msg');
        $this->logger->warning('warning msg');
        $this->logger->error('error msg');
        $this->logger->critical('critical msg');
        $this->logger->alert('alert msg');
        $this->logger->emergency('emergency msg');

        /* The debug.log file contains only the debug level type of the log */

        //
        $cacheId = 'Ripro';
        $objInfo = null;
        $_objInfo = $this->cache->load($cacheId);
        if ($_objInfo) {
            $objInfo = unserialize($_objInfo);
        } else {
            $objInfo = [
                'var1' => 'val1',
                'var2' => 'val2',
                'var3' => 'val3'
            ];
            $this->cache->save(serialize($objInfo), $cacheId);
        }
    }
}
