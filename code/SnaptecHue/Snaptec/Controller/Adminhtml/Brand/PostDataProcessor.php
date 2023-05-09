<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SnaptecHue\Snaptec\Controller\Adminhtml\Brand;

use Magento\Cms\Model\Page\DomValidationState;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Config\Dom\ValidationSchemaException;
use Magento\Cms\Model\Page\CustomLayout\CustomLayoutValidator;
use Magento\Framework\Filter\FilterInput;

/**
 * Controller helper for user input.
 */
class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * @var \Magento\Framework\View\Model\Layout\Update\ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var DomValidationState
     */
    private $validationState;

    /**
     * @var CustomLayoutValidator
     */
    private $customLayoutValidator;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param DomValidationState|null $validationState
     * @param CustomLayoutValidator|null $customLayoutValidator
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        DomValidationState $validationState = null,
        CustomLayoutValidator $customLayoutValidator = null
    ) {
        $this->messageManager = $messageManager;
        $this->validationState = $validationState
            ?: ObjectManager::getInstance()->get(DomValidationState::class);
        $this->customLayoutValidator = $customLayoutValidator
            ?: ObjectManager::getInstance()->get(CustomLayoutValidator::class);
    }
    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'title' => __('Page Title'),
            'is_active' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
    public function filter($data)
    {
        $filterRules = [];

        foreach (['custom_theme_from', 'custom_theme_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $this->dateFilter;
            }
        }

        return (new FilterInput($filterRules, [], $data))->getUnescaped();
    }
    /**
     * Validate data, avoid cyclomatic complexity
     *
     * @param array $data
     * @param \Magento\Framework\View\Model\Layout\Update\Validator $layoutXmlValidator
     * @return bool
     */
    private function validateData($data, $layoutXmlValidator)
    {
        try {
            if (!empty($data['layout_update_xml']) && !$layoutXmlValidator->isValid($data['layout_update_xml'])) {
                return false;
            }

            if (!empty($data['custom_layout_update_xml']) &&
                !$layoutXmlValidator->isValid($data['custom_layout_update_xml'])
            ) {
                return false;
            }
            if (!$this->customLayoutValidator->validate($data)) {
                return false;
            }
        } catch (ValidationException | ValidationSchemaException $e) {
            return false;
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e);
            return false;
        }

        return true;
    }
}
