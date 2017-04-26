<?php

namespace Gloo\ConsumablesMgtSystem\Controller\Adminhtml\ShoppingSessions;

use Gloo\ConsumablesMgtSystem\Controller\Adminhtml\ShoppingSessions;

class Order extends ShoppingSessions {

    public function execute()
    {
        $quoteId = $this->getRequest()->getParam("quote_id");
        $shoppingSession = $this->getShoppingSessionData($quoteId);
        $quote = $this->getQuote($quoteId);

        /**
         * @var \Magento\Backend\Model\Session\Quote $quoteSession
         */
        $quoteSession = $this->_objectManager->get('\Magento\Backend\Model\Session\Quote');
        $quoteSession->setQuoteId($quoteId);
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath("sales/order_create/index",
            ['customer_id'=>$shoppingSession->getCustomerId(),'store_id'=>$quote->getStoreId()]);
    }
}