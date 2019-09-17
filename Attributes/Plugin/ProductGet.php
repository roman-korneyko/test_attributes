<?php

namespace Test\Attributes\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Test\Attributes\Model\SalesInformationFactory;

class ProductGet
{
    /**
     * @var ProductExtensionFactory
     */
    private $extensionFactory;
    /**
     * @var SalesInformationFactory
     */
    private $salesInformationFactory;

    /**
     * @param ProductExtensionFactory $extensionFactory
     * @param SalesInformationFactory $salesInformation
     */
    public function __construct(
        ProductExtensionFactory $extensionFactory,
        SalesInformationFactory $salesInformation
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->salesInformationFactory = $salesInformation;
    }
    /**
     * @param Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param Magento\Catalog\Api\Data\ProductInterface $entity
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $extensionAttributes = $entity->getExtensionAttributes()?:$this->extensionFactory->create();
        $extensionAttributes->setSalesInformation(
            $this->salesInformationFactory->create(['product_id' => $entity->getId()])
        );
        return $entity;
    }
}
