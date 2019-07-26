<?php
declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\PHPStan;

use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductDataFactoryInterface;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductDataFactory;

class StubProductDataFactoryExtension extends ReplacedClassExtension
{
    public function getClass(): string
    {
        return StubProductDataFactoryInterface::class;
    }

    protected function getReplacer(): string
    {
        return StubProductDataFactory::class;
    }
}
