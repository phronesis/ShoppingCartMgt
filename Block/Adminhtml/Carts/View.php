<?php
namespace DigitekNg\ShoppingCartMgt\Block\Adminhtml\Carts;
use Magento\Backend\Block\Widget\Form\Container;
use \Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class View extends Container{

    /**
     * Block group
     *
     * @var string
     */
    protected $_blockGroup = 'DigitekNg_ShoppingCartMgt';

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;
    protected $registry;
    public function __construct
    (
        Context $context,
        Registry $registry,
        array $data

    )
    {
        $this->registry = $registry;
        //var_dump($this->registry); exit;

        parent::__construct($context, $data);

    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_carts';
        $this->_mode = 'view';
        $this->authorization = $this->getAuthorization();

        parent::_construct();

        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('save');
        $this->setId('digitek_cart_grid');
        //$order = $this->getOrder();
        if(
            $this->isAllowedAction('Magento_Sales::create') &&
            $this->isAllowedAction('DigitekNg_ShoppingCartMgt::cart_convert')
        ){

        $this->buttonList->add(
            'convert_quote',
            [
                'label' => __('Convert to Order'),
                'class' => __('action-primary'),
                'id' => 'convert-to-order',
                'onclick'=> 'setLocation(\''.$this->getOrderUrl().'\')',
                'data_attribute' => [
                    'url' => $this->getOrderUrl()
                ]
            ]
        );

        }

    }

    public function getUrl($params = '', $params2 = [])
    {
        $params2['quote_id'] = $this->getQuoteId();
        return parent::getUrl($params, $params2);
    }

    /**
     * Edit URL getter
     *
     * @return string
     */
    public function getOrderUrl()
    {
        return $this->getUrl('*/*/order');
    }

    protected function isAllowedAction($resourceId){
        return $this->authorization->isAllowed($resourceId);
    }

    protected function getQuoteId()
    {
        return $this->registry->registry("quoteData")->getId();
    }

    public function getQuoteData(){
        return $this->registry->registry("quoteData");
    }
}