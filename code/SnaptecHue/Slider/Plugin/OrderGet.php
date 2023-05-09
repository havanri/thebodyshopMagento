<?php

namespace SnaptecHue\Slider\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderSearchResultInterface;

class OrderGet
{
    /**
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    public function __construct(
        OrderExtensionFactory $extensionFactory,
    ) {
        $this->extensionFactory = $extensionFactory;
    }
    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $result
    ) {
        $orders = $result->getItems();
        foreach ($orders as $order) {
            //get extension attribute by order
            $extensionAttributes = $order->getExtensionAttributes();
            if (!$extensionAttributes) {
                $extensionAttributes = $this->extensionFactory->create();
            }
            // add custom attribute under lying extension_attributes
            $customAttributeValue = $order->getData('status_grand_total_custom');
            if ($customAttributeValue !== null) {
                $extensionAttributes->setStatusGrandToTalCustom($customAttributeValue);
            }
            //set order with new extension_attributes
            $order->setExtensionAttributes($extensionAttributes);
        }
        return $result;
    }
    // public function afterGet(
    //     OrderRepositoryInterface $subject,
    //     OrderInterface $order,
    // ) {
    //     $extensionAttributes = $order->getExtensionAttributes();
    //     $orderExtension = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();

    //     $customAttribute = $order->getData('status_grand_total_custom');
    //     $orderExtension->setStatusGrandToTalCustom($customAttribute);

    //     $order->setExtensionAttributes($orderExtension);

    //     return $order;
    // }
}
