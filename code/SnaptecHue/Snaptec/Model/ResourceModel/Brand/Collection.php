<?php

namespace SnaptecHue\Snaptec\Model\ResourceModel\Brand;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'brand_id';
    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('SnaptecHue\Snaptec\Model\Brand', 'SnaptecHue\Snaptec\Model\ResourceModel\Brand');
    }

}