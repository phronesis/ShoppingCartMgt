<?php

namespace Gloo\ConsumablesMgtSystem\Controller\Adminhtml\ShoppingSessions;

use Gloo\ConsumablesMgtSystem\Controller\Adminhtml\ShoppingSessions;
use Magento\Framework\Exception\NotFoundException;

use Magento\Framework\Controller\ResultFactory;

class View extends ShoppingSessions {

    public function execute()
    {
        try{
            $quoteId = $this->getRequest()->getParam('quote_id');
            $this->registry->register('shoppingSessionData',$this->getShoppingSessionData($quoteId));
            $this->registry->register('quoteData',$this->getQuote($quoteId));
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->pageFactory->create();
            $resultPage->setActiveMenu('gloo_cms::shopping_sessions');
            $resultPage->getConfig()->getTitle()->prepend(__('Cart Details'));
            $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
            $resultPage->addBreadcrumb(__('Shopping Sessions'), __('Shopping Sessions'));
            $resultPage->addBreadcrumb(__('Shopping Details'), __('Shopping Details'));

            return $resultPage;
        }catch (\Exception $e){
            $this->messageManager->addError($e->getMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

    }


}