<?php

namespace SnaptecHue\Slider\Model;

use SnaptecHue\Slider\Api\CustomerOrderInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

class CustomerOrder implements CustomerOrderInterface
{

    /**
     * @var OrderCollectionFactory
     */
    protected $_orderCollectionFactory;

    /**
     * @param OrderCollectionFactory $orderCollectionFactory
     */
    public function __construct(
        OrderCollectionFactory $orderCollectionFactory
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * Get customer order list by date range
     *
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getCustomerOrderList($fromDate, $toDate)
    {
        $collection = $this->_orderCollectionFactory->create()
        ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate));

        var_dump($fromDate);
        var_dump($toDate);
        $customerList = array();
        foreach ($collection as $order) {
            $customerList[] = [
                'order_id' => $order->getId(),
                'email' => $order->getData('customer_email'),
                'firstname' => $order->getData('customer_firstname'),
                'middlename' => $order->getData('customer_middlename'),
                'lastname' => $order->getData('customer_lastname'),
                'created_at'=>$order->getData('created_at'),
            ];
        }

        return $customerList;
    }
}
