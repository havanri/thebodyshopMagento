<?php

namespace SnaptecHue\Practice\Controller\Test;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Message\ManagerInterface;

class Message extends \SnaptecHue\Practice\Controller\Test
{

    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;

    /** @var \Magento\Framework\Message\ManagerInterface */
    protected $messageManager;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        PageFactory $resultPageFactory,
        ManagerInterface $messagerManager,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->messageManager = $messagerManager;
        return parent::__construct($context);
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $this->messageManager->addSuccess('Success-1');
        $this->messageManager->addSuccess('Success-2');
        $this->messageManager->addNotice('Notice-1');
        $this->messageManager->addNotice('Notice-2');
        $this->messageManager->addWarning('Warning-1');
        $this->messageManager->addWarning('Warning-2');
        $this->messageManager->addError('Error-1');
        $this->messageManager->addError('Error-2');

        // dd($this->messageManager);
        return $resultPage;
    }
}
