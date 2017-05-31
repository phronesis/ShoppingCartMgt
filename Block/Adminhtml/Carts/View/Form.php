<?php

namespace DigitekNg\ShoppingCartMgt\Block\Adminhtml\Carts\View;

use Gloo\ConsumablesMgtSystem\Helper\Data;
use Gloo\ConsumablesMgtSystem\Model\CustomerFactory;
use Magento\Backend\Block\Template;
use Magento\Framework\Registry;


class Form extends Template {

    protected $_template = 'carts/form.phtml';
    protected $registry =null;
    protected $customerFactory;
    protected $helper;


    public function __construct
    (
        Template\Context $context,
        Registry $registry,
        CustomerFactory $customerFactory,
        Data $helper,
        array $data
    )
    {
        $this->registry = $registry;
        $this->helper = $helper;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $data);
    }

    public function getShoppingSession(){
        return $this->registry->registry('shoppingSessionData');
    }

    public function getQuoteDetails(){
        return $this->registry->registry('quoteData');
    }

    public function getCustomerName($value){
        if($value){
            $customer = $this->customerFactory->create()->getMagentoCustomer()->load($value);
            return $customer->getName();
        }
        return;
    }

    public function formatAmount($amount){
        return $this->helper->formatPrice($amount);
    }



}