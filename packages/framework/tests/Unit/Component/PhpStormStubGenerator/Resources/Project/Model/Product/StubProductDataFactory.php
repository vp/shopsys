<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product;

use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct as BaseStubProduct;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData as BaseStubProductData;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductDataFactory as BaseStubProductDataFactory;

class StubProductDataFactory extends BaseStubProductDataFactory
{
    /**
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData
     */
    public function create(): BaseStubProductData
    {
        return parent::create();
    }

    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProduct $stubProduct
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData
     */
    public function createFromStubProduct(BaseStubProduct $stubProduct): BaseStubProductData
    {
        return parent::createFromStubProduct($stubProduct);
    }
}
