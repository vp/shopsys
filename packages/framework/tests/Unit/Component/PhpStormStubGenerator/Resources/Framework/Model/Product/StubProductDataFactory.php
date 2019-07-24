<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product;

class StubProductDataFactory implements StubProductDataFactoryInterface
{
    /**
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData
     */
    public function create(): StubProductData
    {
        return new StubProductData();
    }

    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct $stubProduct
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData
     */
    public function createFromStubProduct(StubProduct $stubProduct): StubProductData
    {
        $data = $this->create();
        $data->uuid = $stubProduct->getUuid();
        $data->stubAvailability = $stubProduct->getStubAvailability();
        return $data;
    }
}
