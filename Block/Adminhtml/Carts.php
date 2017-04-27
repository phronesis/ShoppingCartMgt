<?php

namespace DigitekNg\ShoppingCartMgt\Block\Adminhtml;
use \Magento\Backend\Block\Widget\Grid\Container;

class Carts extends Container{
    protected function _construct()
    {
        $this->_blockGroup = 'DigitekNg_ShoppingCartMgt';
        $this->_controller = 'digitekCarts';
        $this->_headerText = __('Carts');
        parent::_construct();
    }
}