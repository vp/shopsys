<?php
declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\PHPStan;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use ReflectionObject;
use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductDataFactory;

abstract class ReplacedClassExtension implements DynamicMethodReturnTypeExtension
{
    protected abstract function getReplacer(): string;

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return true;
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        // DARK MAGIC!!!!
        $scopeReflection = new ReflectionObject($scope);
        $brokerProperty = $scopeReflection->getProperty('broker');
        $brokerProperty->setAccessible(true);
        $broker = $brokerProperty->getValue($scope);

        $replacer = $broker->getClass($this->getReplacer());
        $replacerMethod = $replacer->getMethod($methodReflection->getName(), $scope);
        foreach ($replacerMethod->getVariants() as $variant) {
            return $variant->getReturnType();
        }
    }
}
