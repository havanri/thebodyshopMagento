<?php

namespace SnaptecHue\ReCaptcha\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\View\LayoutInterface;

class AddRecaptchaToLoginObserver implements ObserverInterface
{
    /**
     * @var LayoutInterface
     */
    protected $_layout;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $_encryptor;

    /**
     * AddRecaptchaToLoginObserver constructor.
     * @param LayoutInterface $layout
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     */
    public function __construct(
        LayoutInterface $layout,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
    ) {
        $this->_layout = $layout;
        $this->_scopeConfig = $scopeConfig;
        $this->_encryptor = $encryptor;
    }

    /**
     * Add Recaptcha to Login page
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->_scopeConfig->getValue('customer/recaptcha/enabled')) {
            return;
        }

        $block = $observer->getLayout()->getBlock('customer.login');
        if ($block) {
            $transportObject = $observer->getData('transport');
            $html = $transportObject->getHtml();
            $html .= $this->_layout->createBlock(
                'Magento\ReCaptcha\Block\ReCaptcha',
                '',
                ['data' => ['jsLayout' => 'customer-login']]
            )->toHtml();
            $transportObject->setHtml($html);
        }
    }
}