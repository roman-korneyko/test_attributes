<?php

namespace Test\Attributes\Model;

use Magento\Framework\Data\Collection;
use Test\Attributes\Model\ResourceModel\Product\Sold\CollectionFactory;
use Test\Attributes\Api\Data\SalesInformationInterface;

class SalesInformation implements SalesInformationInterface
{
    protected $orderStatuses;
    protected $product_id;
    /**
     * @var Test\Attributes\Model\ResourceModel\Product\Sold\CollectionFactory
     */
    private $reportCollectionFactory;

    /**
     * SalesInformation constructor.
     * @param CollectionFactory $reportCollectionFactory
     * @param array $orderStatuses
     * @param $product_id
     */
    public function __construct(
        CollectionFactory $reportCollectionFactory,
        array $orderStatuses,
        $product_id
    ) {
        $this->product_id = $product_id;
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->orderStatuses = $orderStatuses;
    }

    /**
     * Get Sold Qty
     * @return int
     */
    public function getQty()
    {
        $SoldProducts = $this->reportCollectionFactory->create();
        $SoldProductQty = $SoldProducts->addOrderedQty($this->orderStatuses, true)
            ->addAttributeToFilter('product_id', $this->product_id);

        if (!$SoldProductQty->count()) {
            return 0;
        }

        $product = $SoldProductQty->getFirstItem();

        return (int)$product->getData('ordered_qty');
    }

    /**
     * Get Lasf ordered
     * @return string
     */
    public function getLastOrder()
    {
        $SoldProducts = $this->reportCollectionFactory->create();
        $SoldProductDate = $SoldProducts
            ->addOrderedQty($this->orderStatuses, false)
            ->addAttributeToFilter('product_id', $this->product_id)
            ->setOrder('order.created_at', Collection::SORT_ORDER_DESC);

        $SoldProductDate->getSelect()->limit(1);

        if (!$SoldProductDate->count()) {
            return "";
        }

        $product = $SoldProductDate->getFirstItem();

        return $product->getData('created_at');
    }

    /**
     * Set product ID
     * @param $product_id
     * @return $this|object
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }
}
