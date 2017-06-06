<?php
namespace DigitekNg\ShoppingCartMgt\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper{

    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    protected $timezone;
    public function __construct
    (
        Context $context,
        TimezoneInterface $timezone,
        PriceHelper $priceHelper
    )
    {
        parent::__construct($context);
        $this->priceHelper = $priceHelper;
        $this->timezone = $timezone;
    }

    public function formatAmount($amount,$container = true){
        return $this->priceHelper->currency($amount,true,$container);
    }

    public function getFormattedTime($time = null,$format = "Y-m-d H:i:s"){
        if(!is_null($time)){
            $time = strtotime($time);
        }
        return $this->timezone->date($time)->format($format);
    }

}