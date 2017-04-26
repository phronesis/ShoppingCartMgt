<?php


namespace DigitekNg\ShoppingCartMgt\Block\Adminhtml\Carts;
use \Magento\Backend\Block\Widget\Grid\Extended;
use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Helper\Data;

use Magento\Quote\Model\Quote;
use Magento\Customer\Model\ResourceModel\CustomerRepository;


class Grid extends Extended
{
    private $quote;
    private $customerRepository;
    public function __construct
    (
        Context $context,
        Data $backendHelper,
        Quote $quote,
        CustomerRepository $customerRepository,
        array $data
    )
    {
       $this->quote = $quote;
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
                'quote_id' => $row->getQuoteId()
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

        $this->addColumn('customer_id', array(
            'header' => __('Customer'),
            'type' => 'number',
            'index' => 'customer_id'
            //'frame_callback'=>[$this,"getCustomerName"]
        ));
        $this->addColumn('base_grand_total', array(
            'header' => __('Base Grand Total'),
            'type' => 'text',
            'index' => 'base_grand_total',
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
                'getter' => 'getQuoteId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => [
                            'base' => '*/*/view',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
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

    public function yesNo($value){
        $yesNo = ["No","Yes"];
        return $yesNo[$value];
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

}