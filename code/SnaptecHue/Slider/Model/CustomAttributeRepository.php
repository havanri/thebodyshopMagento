<?php

namespace SnaptecHue\Slider\Model;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use SnaptecHue\Slider\Api\CustomAttributeRepositoryInterface;

class CustomAttributeRepository implements CustomAttributeRepositoryInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    protected $_orderCollectionFactory;
    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory )
    {
        $this->orderRepository = $orderRepository;
        $this->_orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * Get custom attribute value by order ID.
     *
     * @param int $orderId
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($orderId)
    {
        $order = $this->orderRepository->get($orderId);
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            throw new NoSuchEntityException(__('No extension attributes found for order with ID %1', $orderId));
        }
        $customAttributes = $extensionAttributes->getStatusGrandTotalCustom();
        if (!isset($customAttributes['attribute_code'])) {
            throw new NoSuchEntityException(__('Custom attribute not found for order with ID %1', $orderId));
        }
        return $customAttributes['attribute_code']->getValue();
    }
    public function getCustomerOrderByDate($fromDate, $toDate)
    {
        // Lấy danh sách các đơn hàng trong khoảng thời gian từ $fromDate đến $toDate
        $orders = $this->_orderCollectionFactory->create()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('create_at')
        ->addAttributeToFilter('created_at', ['from' => $fromDate, 'to' => $toDate]);

        $customers = [];
        foreach ($orders as $order) {
            $customer = [
                'order_id' => $order->getData('entity_id'),
                'email' => $order->getData('customer_email'),
                'firstname' => $order->getData('customer_firstname'),
                'middlename' => $order->getData('customer_middlename'),
                'lastname' => $order->getData('customer_lastname'),
            ];
            $customers[] = $customer;
        }
        return $customers;
    }
}
