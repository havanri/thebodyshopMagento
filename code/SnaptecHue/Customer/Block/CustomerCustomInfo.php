<?php

namespace SnaptecHue\Customer\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;

class CustomerCustomInfo extends Template
{
    protected $httpContext;

	public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Framework\App\Http\Context $httpContext,
    	array $data = []
	) {
    	$this->httpContext = $httpContext;
    	parent::__construct($context, $data);
	}

	public function getCustomerIsLoggedIn()
	{
    	return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
	}

	public function getCustomerId()
	{
    	return $this->httpContext->getValue('customer_id');
	}

	public function getCustomerName()
	{
    	return $this->httpContext->getValue('customer_name');
	}

	public function getCustomerEmail()
	{
    	return $this->httpContext->getValue('customer_email');
	}
}
