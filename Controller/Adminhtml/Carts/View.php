<?php

namespace DigitekNg\ShoppingCartMgt\Controller\Adminhtml\Carts;

use DigitekNg\ShoppingCartMgt\Controller\Adminhtml\Carts;
use Magento\Framework\Controller\ResultFactory;

class View extends Carts {

    public function execute()
    {
        try{
            $quoteId = $this->getRequest()->getParam('quote_id');
            $this->registry->register('quoteData',$this->getQuote($quoteId));
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->pageFactory->create();
            $resultPage->setActiveMenu('digitek_cart::digitekng_cart_view');
            $resultPage->getConfig()->getTitle()->prepend(__('Cart Details'));
            $resultPage->addBreadcrumb(__('Carts'), __('Carts'));
            $resultPage->addBreadcrumb(__('Cart Details'), __('Cart Details'));

            return $resultPage;
        }catch (\Exception $e){
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

    }


}