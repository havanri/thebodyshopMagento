<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SnaptecHue\Snaptec\Controller\Adminhtml\Brand;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use SnaptecHue\Snaptec\Model\BrandFactory;
use SnaptecHue\Snaptec\Api\BrandRepositoryInterface;

/**
 * Edit CMS page action.
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'SnaptecHue_Snaptec::save';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    protected $brandFactory;

    protected $brandRepo;

    const BRAND_NO_EXISTS_MESSAGE = 'This brand no longer exists.';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        BrandFactory $brandFactory,
        BrandRepositoryInterface $brandRepo
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->brandFactory = $brandFactory;
        $this->brandRepo = $brandRepo;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('SnaptecHue_Snaptec::brand');
        return $resultPage;
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        // $model = $this->_objectManager->create(\SnaptecHue\Snaptec\Model\Brand::class);
        $model = $this->brandFactory->create();
        // 2. Initial checking
        if ($id) {
            $model = $this->brandRepo->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__(BRAND_NO_EXISTS_MESSAGE));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('snaptechue_snaptec_brand', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Brands'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Brand'));

        return $resultPage;
    }
}
