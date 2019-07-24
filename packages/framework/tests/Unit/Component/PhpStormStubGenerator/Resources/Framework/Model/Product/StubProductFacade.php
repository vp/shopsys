<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product;

class StubProductFacade
{
    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData $stubProductData
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct
     */
    public function create(StubProductData $stubProductData): StubProduct
    {
        return new StubProduct($stubProductData->uuid, $stubProductData->stubAvailability);
    }
}
