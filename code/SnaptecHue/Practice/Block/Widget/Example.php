<?php

namespace SnaptecHue\Practice\Block\Widget;

class Example extends \Magento\Framework\View\Element\AbstractBlock implements \Magento\Widget\Block\BlockInterface
{
    protected function _beforeToHtml()
    {
        $this->setText(sprintf(
            'example widget: var1=%s, var2=%s',
            $this->getData('var1'),
            $this->getData('var2')
        ));
        return parent::_beforeToHtml();
    }
}
