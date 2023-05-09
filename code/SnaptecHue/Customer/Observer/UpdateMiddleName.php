<?php

namespace SnaptecHue\Customer\Observer;

use Exception;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\CustomerRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class UpdateMiddleName implements ObserverInterface
{
    const CUSTOM_MIDDLE_NAME = "Mid";

    /** @var \Magento\Customer\Model\Session */
    protected $customerSession;

    /** @var \Magento\Customer\Api\CustomerRepositoryInterface */
    protected $customerRepository;

    public function __construct(Session $customerSession, CustomerRepositoryInterface $customerRepository)
    {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    public function execute(Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            if ($customer && $this->customerSession->isLoggedIn()) {
                $customerId = $customer->getId();
                $customer = $this->customerRepository->getById($customerId);
                $middleName = $customer->getMiddleName();
                if ($middleName !== self::CUSTOM_MIDDLE_NAME) {
                    $customer->setMiddleName(self::CUSTOM_MIDDLE_NAME);
                    $this->customerRepository->save($customer);
                    // $customer->save();
                    // dd($customer);
                }
            }
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
}
