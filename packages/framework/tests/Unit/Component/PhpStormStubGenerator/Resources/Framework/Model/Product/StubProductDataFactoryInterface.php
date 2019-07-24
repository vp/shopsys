<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product;

interface StubProductDataFactoryInterface
{
    /**
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData
     */
    public function create(): StubProductData;

    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct $stubProduct
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData
     */
    public function createFromStubProduct(StubProduct $stubProduct): StubProductData;
}
