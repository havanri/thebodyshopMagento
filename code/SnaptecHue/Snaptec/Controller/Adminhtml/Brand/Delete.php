<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SnaptecHue\Snaptec\Controller\Adminhtml\Brand;

use Magento\Framework\App\Action\HttpPostActionInterface;
use SnaptecHue\Snaptec\Model\BrandFactory;
use SnaptecHue\Snaptec\Api\BrandRepositoryInterface;
use Magento\Backend\App\Action\Context;
/**
 * Delete CMS page action.
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'SnaptecHue_Snaptec::page_delete';

    protected $brandFactory;
    protected $brandRepo;
    protected $context;
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function __construct(Context $context, BrandFactory $brandFactory, BrandRepositoryInterface $brandRepo)
    {
        $this->brandFactory = $brandFactory;
        $this->brandRepo = $brandRepo;
        parent::__construct($context);
    }
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->brandFactory->create();
                $model = $this->brandRepo->getById($id);
                
                $title = $model->getTitle();
                $this->brandRepo->delete($model);
                // var_dump($model);die;
                
                // display success message
                $this->messageManager->addSuccessMessage(__('The brand has been deleted.'));
                
                // go to grid
                // $this->_eventManager->dispatch('adminhtml_cmspage_on_delete', [
                //     'title' => $title,
                //     'status' => 'success'
                // ]);
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // $this->_eventManager->dispatch(
                //     'adminhtml_cmspage_on_delete',
                //     ['title' => $title, 'status' => 'fail']
                // );
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['brand_id' => $id]);
            }
        }
        
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a brand to delete.'));
        
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
