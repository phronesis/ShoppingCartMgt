<?php

namespace Digitek\ShoppingCartMgt\Block\Adminhtml;
use \Magento\Backend\Block\Widget\Grid\Container;

class Carts extends Container{
    protected function _construct()
    {
        $this->_blockGroup = 'Digitek_ShoppingCartMgt';
        $this->_controller = 'adminhtml_digitekCarts';
        $this->_headerText = __('Carts');
        parent::_construct();
    }
}