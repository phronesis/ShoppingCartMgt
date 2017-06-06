<?php
namespace DigitekNg\ShoppingCartMgt\Block\Adminhtml\Carts;
use Magento\Backend\Block\Widget\Form\Container;
use \Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

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
    /** @var Quote */
    private $quoteDetails = null;
    private $order;
    public function __construct
    (
        Context $context,
        Registry $registry,
        Order $order,
        array $data

    )
    {
        $this->registry = $registry;
        $this->order = $order;
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

        $this->quoteDetails = $this->getQuoteData();
        if(
            $this->isAllowedAction('Magento_Sales::create') &&
            $this->isAllowedAction('DigitekNg_ShoppingCartMgt::cart_convert')
            && $this->canBeConvertedToOrder()
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

        if($this->isConvertedToCart()){
            $this->buttonList->add(
                'view_order_details',
                [
                    'label' => __('View Order Details'),
                    'class' => __('action-primary'),
                    'id' => 'view_order_details',
                    'onclick'=> 'setLocation(\''.$this->getOrderDetailsUrl().'\')',
                    'data_attribute' => [
                        'url' => $this->getOrderDetailsUrl()
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

    public function canBeConvertedToOrder(){
        if(!$this->isConvertedToCart()&& $this->quoteDetails->getIsActive() === '1'){
            return true;
        }
        return false;
    }

    public function isConvertedToCart(){
        return !is_null($this->quoteDetails->getReservedOrderId());
    }

    public function getOrderDetailsUrl(){
        return parent::getUrl('sales/order/view',
            ['order_id'=>$this->getOrderId($this->quoteDetails->getReservedOrderId())]);
    }

    public function getOrderId($incrementId){
        $order = $this->order->loadByIncrementId($incrementId);
        return $order->getId();
    }
}