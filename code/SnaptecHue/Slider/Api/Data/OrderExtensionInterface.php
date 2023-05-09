<?php
namespace SnaptecHue\Slider\Api\Data;

interface OrderExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * Get custom attribute.
     *
     * @return CustomAttributeInterface|null
     */
    public function getCustomAttribute(): ? CustomAttributeInterface;

    /**
     * Set custom attribute.
     *
     * @param CustomAttributeInterface $customAttribute
     * @return $this
     */
    public function setCustomAttribute(CustomAttributeInterface $customAttribute);
}