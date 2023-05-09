<?php

namespace SnaptecHue\Practice\Model;

use Magento\Cron\Model\ScheduleFactory;

class Cron
{
    protected $logger;
    protected $scheduleFactory;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        ScheduleFactory $scheduleFactory
    ) {
        $this->logger = $logger;
        $this->scheduleFactory = $scheduleFactory;
    }
    public function logHello()
    {
        $this->logger->info('Hello from Cron job!');
        return $this;
    }
}
