<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\Model\Product\Mutation;

use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Shopsys\FrameworkBundle\Component\Domain\Domain;
use Shopsys\FrameworkBundle\Model\Product\Availability\AvailabilityFacade;
use Shopsys\FrameworkBundle\Model\Product\Product;
use Shopsys\FrameworkBundle\Model\Product\ProductDataFactory;
use Shopsys\FrameworkBundle\Model\Product\ProductFacade;

class ProductMutation implements MutationInterface, AliasedInterface
{
    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\Domain
     */
    protected $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductFacade
     */
    protected $productFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductDataFactory
     */
    protected $productDataFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Availability\AvailabilityFacade
     */
    protected $availabilityFacade;

    /**
     * @param \Shopsys\FrameworkBundle\Component\Domain\Domain $domain
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductDataFactory $productDataFactory
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductFacade $productFacade
     * @param \Shopsys\FrameworkBundle\Model\Product\Availability\AvailabilityFacade $availabilityFacade
     */
    public function __construct(Domain $domain, ProductDataFactory $productDataFactory, ProductFacade $productFacade, AvailabilityFacade $availabilityFacade)
    {
        $this->domain = $domain;
        $this->productFacade = $productFacade;
        $this->productDataFactory = $productDataFactory;
        $this->availabilityFacade = $availabilityFacade;
    }

    /**
     * @param \Overblog\GraphQLBundle\Definition\Argument $argument
     * @return \Shopsys\FrameworkBundle\Model\Product\Product
     */
    public function createProduct(Argument $argument): Product
    {
        // todo: Separate object representing input could be nice
        $input = $argument->offsetGet('input');

        $name = $input['name'];
        $ean = $input['ean'];

        // todo: extract someplace else
        $productData = $this->productDataFactory->create();

        // saving name in current domain language
        $productData->name[$this->domain->getLocale()] = $name;
        $productData->ean = $ean;
        $productData->availability = $this->availabilityFacade->getDefaultInStockAvailability();

        //  $input['price_without_vat']); is the instance of Money now
        //  handle saving price not covered as it's not important in terms of graphql

        $product = $this->productFacade->create($productData);

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'createProduct' => 'create_product',
        ];
    }
}
