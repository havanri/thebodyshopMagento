<?php

namespace SnaptecHue\Practice\Controller\Test;

class SessionAndCookie extends \SnaptecHue\Practice\Controller\Test
{

    /** @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory */
    protected $cookieMetadataFactory;

    /** @var \Magento\Framework\Session\Config\ConfigInterface */
    protected $sessionConfig;

    /** @var \Magento\Framework\Stdlib\CookieManagerInterface */
    protected $cookieManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\Session\Config\ConfigInterface $sessionConfig,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
    ) {
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionConfig = $sessionConfig;
        $this->cookieManager = $cookieManager;
        return parent::__construct($context);
    }
    public function execute()
    {
        // $cookieValue = 'Just some value';
        // $cookieMetadata = $this->cookieMetadataFactory
        //     ->createPublicCookieMetadata()
        //     ->setDuration(3600)
        //     ->setPath($this->sessionConfig->getCookiePath())
        //     ->setDomain($this->sessionConfig->getCookieDomain())
        //     ->setSecure($this->sessionConfig->getCookieSecure())
        //     ->setHttpOnly($this->sessionConfig->getCookieHttpOnly());
        // $this->cookieManager
        //     ->setPublicCookie(
        //         'ripro_2_2',
        //         $cookieValue,
        //         $cookieMetadata
        //     );
        $cookieValue = 'Just some value';
        $cookieMetadata = $this->cookieMetadataFactory
            ->createSensitiveCookieMetadata()
            ->setPath($this->sessionConfig->getCookiePath())
            ->setDomain($this->sessionConfig->getCookieDomain());
        $this->cookieManager
            ->setSensitiveCookie(
                'RIPRODAO_NO_2',
                $cookieValue,
                $cookieMetadata
            );

        // Debug information
        // var_dump($this->cookieManager->getCookie('ripro_2_2'));
        // exit;
    }
}
