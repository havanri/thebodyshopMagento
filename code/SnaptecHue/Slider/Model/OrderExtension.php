<?php
namespace SnaptecHue\Slider\Model;

use SnaptecHue\Slider\Api\Data\CustomAttributeInterface;
use SnaptecHue\Slider\Api\Data\OrderExtensionInterface;
use Magento\Framework\Api\ExtensionAttributes\JoinProcessorInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class OrderExtension extends AbstractExtensibleModel implements OrderExtensionInterface
{
    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param CustomAttributeInterface|null $customAttribute
     */
    public function __construct(
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        CustomAttributeInterface $customAttribute = null
    ) {
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->_setCustomAttribute($customAttribute);
    }

    /**
     * @inheritdoc
     */
    public function getCustomAttributes(): array
    {
        return $this->_getExtensionAttributes()->getCustomAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setCustomAttributes(array $customAttributes): OrderExtensionInterface
    {
        $extensionAttributes = $this->_getExtensionAttributes();
        $extensionAttributes->setCustomAttributes($customAttributes);
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @inheritdoc
     */
    public function getCustomAttribute(): ? CustomAttributeInterface
    {
        return $this->_getExtensionAttributes()->getCustomAttribute();
    }
    /**
     * @inheritdoc
     */
    public function setCustomAttribute(CustomAttributeInterface $customAttribute): OrderExtensionInterface
    {
        $extensionAttributes = $this->_getExtensionAttributes();
        $extensionAttributes->setCustomAttribute($customAttribute);
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}