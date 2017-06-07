<?php
namespace Digitek\ShoppingCartMgt\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Quote\Model\QuoteRepository;


abstract class Carts extends Action {

    protected $pageFactory;
    protected $quoteRepository;
    protected $registry;
    protected $resultFactory;
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    public function __construct
    (
        Action\Context $context,
        PageFactory $pageFactory,
        QuoteRepository $quoteRepository,
        Registry $registry,
        ResultFactory $resultFactory
    )
    {

        $this->quoteRepository = $quoteRepository;
        $this->registry = $registry;
        $this->resultFactory = $resultFactory;
        $this->pageFactory= $pageFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        parent::__construct($context);
    }

    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Digitek_ShoppingCartMgt::cart_grid');
    }



    protected function getQuote($quoteId){
        $quote = $this->quoteRepository->get($quoteId);
        if(!$quote->getId()){
            throw new NotFoundException(__('Quote does not exists'));
        }
        return $quote;
    }
}