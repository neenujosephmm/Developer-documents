<?php
/**
 * @author 42Functions
 *
 * @package Xlii_Relatedproducts
 */
namespace Xlii\Relatedproducts\Controller\Index;

use \Magento\Framework\App\Action\Action;

class Index extends Action
{
    private $cart;
    private $productFactory;
    private $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Checkout\Model\Cart $cart
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->cart = $cart;
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        try {
            $postedData = $this->getRequest()->getPostValue();
            foreach ($postedData['related_products'] as $key => $productId) {
                $params = [];
                $params['qty'] = 1;
                $product = $this->productFactory->create()->load($productId);
                if ($product) {
                    $this->cart->addProduct($product, $params);
                }
            }
            $this->cart->save();
            $this->messageManager->addSuccess(__('Successfully added to the cart.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addException(
                $e,
                __('%1', $e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('checkout/cart/index');
        return $resultRedirect;
    }
}
