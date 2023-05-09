<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnaptecHue\Snaptec\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use SnaptecHue\Snaptec\Model\Brand;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use SnaptecHue\Snaptec\Model\BrandFactory;
use SnaptecHue\Snaptec\Api\BrandRepositoryInterface;

/**
 * Save CMS page action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'SnaptecHue_Snaptec::save';
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

     /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepo;
    const SAVE_BRAND_SUCCESSFUL_MEASSAGE = 'You saved the brand.';
    const ERROR_SAVE_BRAND_MESSAGE = 'Something went wrong while saving the brand.';
    const DUPLICATED_SUCCESSFUL_MESSAGE = 'You duplicated the page.';
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        BrandFactory $brandFactory,
        BrandRepositoryInterface $brandRepo
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->brandFactory = $brandFactory;
        $this->brandRepo = $brandRepo;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Brand::STATUS_ENABLED;
            }
            if (empty($data['brand_id'])) {
                $data['brand_id'] = null;
            }
            if (empty($data['image'])) {
                $data['image'] = null;
            }

            /** @var Brand $model */
            $model = $this->brandFactory->create();

            $id = $this->getRequest()->getParam('brand_id');
            if ($id) {
                try {
                    $model = $this->brandRepo->getById($id);                   
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__());
                    return $resultRedirect->setPath('*/*/');
                }
            }
            // echo '<pre>';var_dump($data['images']); echo '</pre>'; die;
            if(!empty($data['images'][0]['name']) && $data != null){
                $data['image'] = $data['images'][0]['name'];
            }
            $model->setData($data);
            try {
                $this->brandRepo->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the brand.'));
                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the brand.'));
            }

            $this->dataPersistor->set('snaptechue_snaptec_brand', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('brand_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * Process result redirect
     *
     * @param PageInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $dupBrand =  $this->brandFactory->create();
            $dupBrand->setData($data);
            $dupBrand->setId(null);
            $dupBrand->setIsActive(0);
            $this->brandRepo->save($dupBrand);
            $this->messageManager->addSuccessMessage(__('You duplicated the page.'));
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $dupBrand->getId(),
                    '_current' => true,
                ]
            );
        }
        $this->dataPersistor->clear('snaptechue_snaptec_brand');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
