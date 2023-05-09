<?php

namespace SnaptecHue\Slider\Model\ResourceModel\Slide;

/**
 * SnaptecHue slides collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model and model
     *
     * @return void
     */
    protected function _construct()
    {
        /* _init($model, $resourceModel) */
        $this->_init(
            'SnaptecHue\Slider\Model\Slide',
            'SnaptecHue\Slider\Model\ResourceModel\Slide'
        );
    }
}
