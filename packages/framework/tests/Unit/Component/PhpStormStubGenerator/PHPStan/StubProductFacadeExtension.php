<?php
declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\PHPStan;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductFacade;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability as ProjectStubAvailability;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProduct as ProjectStubProduct;

class StubProductFacadeExtension extends ReplacedReturnExtension
{
    public function getClass(): string
    {
        return StubProductFacade::class;
    }

    protected function getReplacementMap()
    {
        return [
            StubAvailability::class => ProjectStubAvailability::class,
            StubProduct::class => ProjectStubProduct::class,
        ];
    }
}
