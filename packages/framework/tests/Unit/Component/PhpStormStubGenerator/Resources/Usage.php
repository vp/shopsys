<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources;

class Usage
{
    /**
     * @var \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductFacade
     */
    private $facade;

    /**
     * @var \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailabilityChecker
     */
    private $checker;

    /**
     * @var \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductDataFactoryInterface
     */
    private $factory;

    public function test()
    {
        $data = $this->factory->create();
        $data->stubAvailability->isAvailable();
        $data->name;
        $product = $this->facade->create($data);
        $product->getName();
        $product->getUuid();
        $this->checker->check($product->getStubAvailability());
    }
}
