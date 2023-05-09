<?php

namespace SnaptecHue\Snaptec\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutFactory;

class InlineEdit extends Action
{
    protected $layoutFactory;
    protected $registry;

    public function __construct(
        Action\Context $context,
        LayoutFactory $layoutFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->layoutFactory = $layoutFactory;
        $this->registry = $registry;
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach ($postItems as $itemId => $itemData) {
            try {
                //key là id 'id' => ['data1':'value1', 'data2':'value2']
                $model = $this->_objectManager->create(\SnaptecHue\Snaptec\Model\Brand::class)->load($itemId);
                $model->setData(array_merge($model->getData(), $itemData));
                $model->save();
            } catch (LocalizedException $e) {
                $messages[] = $this->getErrorWithItemId($itemId, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithItemId($itemId, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithItemId(
                    $itemId,
                    __('Something went wrong while saving the item.')
                );
                $error = true;
            }
        }

        if (isset($error)) {
            return $resultJson->setData([
                'messages' => $messages,
                'error' => true,
            ]);
        }

        return $resultJson->setData([
            'messages' => [__('Items updated')],
            'error' => false,
        ]);
    }

    protected function getErrorWithItemId($itemId, $errorText)
    {
        return '[Item ID: ' . $itemId . '] ' . $errorText;
    }
}