<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Cart
 */
namespace Ceymox\Cart\Observer;
 
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;
 
class GuestCart implements ObserverInterface
{
    protected $customerSession;
    public function __construct(CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
    }
 
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();
 
//To check that customer is logout
        if (!$this->customerSession->isLoggedIn())
        {
            $layout->getUpdate()->addHandle('customer_logged_out');
        }
    }
}
