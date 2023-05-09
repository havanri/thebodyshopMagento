<?php

namespace SnaptecHue\Practice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class  LogCustomerEmail implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(Observer $observer)
    {
        //$password = $observer->getEvent()->getPassword();
        $customer = $observer->getEvent()->getModel();
        $this->logger->info('SnaptecHue\Practice: ' . $customer->getEmail());
        return $this;
    }
}
