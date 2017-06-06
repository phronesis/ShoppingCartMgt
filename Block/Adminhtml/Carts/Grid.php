<?php


namespace DigitekNg\ShoppingCartMgt\Block\Adminhtml\Carts;
use \Magento\Backend\Block\Widget\Grid\Extended;
use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Helper\Data;
use DigitekNg\ShoppingCartMgt\Helper\Data as Helper;

use Magento\Quote\Model\Quote;
use Magento\Customer\Model\ResourceModel\CustomerRepository;


class Grid extends Extended
{
    private $quote;
    private $customerRepository;
    private $helper;

    public function __construct
    (
        Context $context,
        Data $backendHelper,
        Quote $quote,
        CustomerRepository $customerRepository,
        Helper $helper,
        array $data
    )
    {
       $this->quote = $quote;
       $this->helper = $helper;
       $this->customerRepository = $customerRepository;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('digitek_carts');
        $this->setUseAjax(false);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }


    protected function _prepareCollection()
    {
        $collection = $this->quote->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/view',
            array(
                'quote_id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => __('ID'),
            'type' => 'number',
            'index' => 'entity_id',
        ));

        $this->addColumn('customer_firstname', array(
            'header' => __('First Name'),
            'type' => 'text',
            'index' => 'customer_firstname',
            'frame_callback'=>[$this,'appendUserLink']
        ));
        $this->addColumn('customer_lastname', array(
            'header' => __('Last Name'),
            'type' => 'text',
            'index' => 'customer_lastname',
            'frame_callback'=>[$this,'appendUserLink']
        ));

        $this->addColumn('is_active', array(
            'header' => __('Is Active'),
            'type' => 'options',
            'options'=>['No','Yes'],
            'index' => 'is_active'
        ));

        $this->addColumn('customer_is_guest', array(
            'header' => __('Guest?'),
            'type' => 'options',
            'options'=>['No','Yes'],
            'index' => 'customer_is_guest'
        ));

        $this->addColumn('items_count', array(
            'header' => __('Items Count'),
            'type' => 'number',
            'index' => 'items_count'
        ));
        $this->addColumn('subtotal', array(
            'header' => __('Sub Total'),
            'type' => 'number',
            'index' => 'subtotal',
            'frame_callback'=>[$this,'formatAmount']
        ));
        $this->addColumn('grand_total', array(
            'header' => __('Grand Total'),
            'type' => 'number',
            'index' => 'grand_total',
            'frame_callback'=>[$this,'formatAmount']
        ));

        $this->addColumn('store_id', array(
            'header' => __('Store'),
            'type' => 'options',
            'options'=>$this->getStores(),
            'index' => 'store_id',
           // 'frame_callback'=>[$this,'getStoreById']
        ));

        $this->addColumn('created_at', array(
            'header' => __('Created At'),
            'type' => 'datetime',
            'index' => 'created_at',
        ));
        $this->addColumn('updated_at', array(
            'header' => __('Updated At'),
            'type' => 'datetime',
            'index' => 'updated_at'
        ));

        $this->addColumn(
            'edit',
            [
                'header' => __('View'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => [
                            'base' => '*/*/view'
                        ],
                        'field' => 'quote_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    public function appendUserLink($value,$row){
        if(empty($value)) return;
        return '<a href="'.$this->getUrl('customer/index/edit/',['id'=>$row['customer_id']]) .'">'.$value.' </a>';
    }


    public function getStores(){
       $stores = $this->_storeManager->getStores();
       $storeNames = [];
       foreach($stores as $storeId=>$store){
           $storeNames[$storeId] = $store->getName();
       }

       return $storeNames;
    }



    public function getCustomerName($value){
        /**
         * @var \Magento\Customer\Model\Customer $customer;
         */

        if($value){
            $customer = $this->customerFactory->create()->getMagentoCustomer()->load($value);

            return $customer->getName();
        }
        return;
    }

    public function formatAmount($amount){
        return $this->helper->formatAmount($amount);
    }

}