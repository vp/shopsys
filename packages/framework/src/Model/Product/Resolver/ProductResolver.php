<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\Model\Product\Resolver;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Shopsys\FrameworkBundle\Model\Product\Exception\ProductNotFoundException;
use Shopsys\FrameworkBundle\Model\Product\Filter\ProductFilterData;
use Shopsys\FrameworkBundle\Model\Product\Listing\ProductListOrderingConfig;
use Shopsys\FrameworkBundle\Model\Product\Product;
use Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainFacadeInterface;

class ProductResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainFacadeInterface
     */
    protected $productOnCurrentDomainFacade;

    /**
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainFacadeInterface $productOnCurrentDomainFacade
     */
    public function __construct(ProductOnCurrentDomainFacadeInterface $productOnCurrentDomainFacade)
    {
        $this->productOnCurrentDomainFacade = $productOnCurrentDomainFacade;
    }

    /**
     * @param int $id
     * @return \Shopsys\FrameworkBundle\Model\Product\Product|null
     */
    public function resolve(int $id): ?Product
    {
        try {
            return $this->productOnCurrentDomainFacade->getVisibleProductById($id);
        } catch (ProductNotFoundException $e) {
            return null;
        }
    }

    /**
     * @param int $categoryId
     * @return \Shopsys\FrameworkBundle\Model\Product\Product[]
     */
    public function resolveByCategoryId(int $categoryId): array
    {
        // startup style
        $filterData = new ProductFilterData();
        $orderingModeId = ProductListOrderingConfig::ORDER_BY_NAME_ASC;
        $page = 1;
        $limit = 20;

        $paginationResult = $this->productOnCurrentDomainFacade->getPaginatedProductsInCategory($filterData, $orderingModeId, $page, $limit, $categoryId);

        return $paginationResult->getResults();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Product',
        ];
    }
}
