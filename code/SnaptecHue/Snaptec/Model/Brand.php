<?php
namespace SnaptecHue\Snaptec\Model;

use Magento\Framework\Model\AbstractModel;
use SnaptecHue\Snaptec\Api\Data\BrandInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Brand extends AbstractModel implements BrandInterface, IdentityInterface
{
    const CACHE_TAG = 'snaptechue_snaptec_brand';
    protected $_cacheTag = 'snaptechue_snaptec_brand';
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $_idFieldName = 'brand_id';
    protected $_eventPrefix = 'snaptechue_snaptec_brand';
    protected $_eventObject = 'brand';
    protected function _construct()
    {
        $this->_init('SnaptecHue\Snaptec\Model\ResourceModel\Brand');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        $values['is_active'] = self::STATUS_ENABLED;

        return $values;
    }
    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }
     /**
     * @param int $Id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID,$id);
    }
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @return int|null
     */
    public function getSortOrder()
    {
        return (int)$this->getData(self::SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }
}