<?php
namespace DigitekNg\ShoppingCartMgt\Controller\Adminhtml\Carts;;

use DigitekNg\ShoppingCartMgt\Controller\Adminhtml\Carts;


class Index extends Carts {

    public function execute()
    {

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('digitek_cart::digitekng_cart');
        $resultPage->getConfig()->getTitle()->prepend(__('Cart List'));
        $resultPage->addBreadcrumb(__('Carts'), __('Carts'));
        $resultPage->addBreadcrumb(__('Cart List'), __('Cart List'));
        return $resultPage;
    }
}