<?php

namespace SnaptecHue\Sale\Observer;

use Magento\Framework\Event\Observer;
use Exception;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class SetValueCustomAttributeOrder implements ObserverInterface
{
    private $_logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->_logger  = $logger;
    }
    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();
            $customAttributeValue = $order->getGrandTotal() > 200 ? 'Yes' : 'No';
            $order->setData('status_grand_total_custom', $customAttributeValue);
            $order->save();
        } catch (Exception $ex) {
            $this->_logger->critical($ex);
        }
    }
}
