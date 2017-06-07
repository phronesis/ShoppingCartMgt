<?php

namespace Digitek\ShoppingCartMgt\Controller\Adminhtml\Carts;

use Digitek\ShoppingCartMgt\Controller\Adminhtml\Carts;

class Order extends Carts {

    public function execute()
    {
        $quoteId = $this->getRequest()->getParam("quote_id");
        $quote = $this->getQuote($quoteId);

        /**
         * @var \Magento\Backend\Model\Session\Quote $quoteSession
         */
        $quoteSession = $this->_objectManager->get('\Magento\Backend\Model\Session\Quote');
        $quoteSession->setQuoteId($quoteId);
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath("sales/order_create/index",
            ['customer_id'=>$quote->getCustomerId(),'store_id'=>$quote->getStoreId()]);
    }
}