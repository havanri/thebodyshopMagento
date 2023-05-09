<?php
namespace SnaptecHue\Snaptec\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('SnaptecHue_Snaptec::brand');

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Brands'));
        // $content = $resultPage->getLayout()->createBlock('SnaptecHue\Snaptec\Block\Adminhtml\Brand\Grid')->toHtml();
        // $resultPage->getLayout()->getBlock('content')->append($content);

        return $resultPage;
    }
}