<?php

namespace Digitek\ShoppingCartMgt\Block\Adminhtml\Carts\View;

use Digitek\ShoppingCartMgt\Helper\Data;
use Magento\Customer\Model\CustomerFactory;
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



    public function getQuoteDetails(){
        return $this->registry->registry('quoteData');
    }

    public function getCustomerName($value){
        if($value){
            $customer = $this->customerFactory->create()->load($value);
            return $customer->getName();
        }
        return;
    }

    public function formatAmount($amount){
        return $this->helper->formatAmount($amount);
    }



}