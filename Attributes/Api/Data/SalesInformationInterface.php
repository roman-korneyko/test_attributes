<?php

namespace Test\Attributes\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SalesInformationInterface extends ExtensibleDataInterface
{
    /**
     * Retrieve product sold qty
     *
     * @return int
     */
    public function getQty();
    /**
     * Retrieve product last ordered
     *
     * @return string
     */
    public function getLastOrder();

    /**
     * Set product id
     *
     * @param $product_id
     * @return object
     */
    public function setProductId($product_id);
}
