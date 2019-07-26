<?php
declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\PHPStan;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

abstract class ReplacedReturnExtension implements DynamicMethodReturnTypeExtension
{
    protected abstract function getReplacementMap();

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        foreach ($methodReflection->getVariants() as $variant) {
            $returnType = $variant->getReturnType();
            if ($returnType instanceof ObjectType) {
                if (in_array($returnType->getClassName(), array_keys($this->getReplacementMap()))) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        foreach ($methodReflection->getVariants() as $variant) {
            $returnType = $variant->getReturnType();
            if ($returnType instanceof ObjectType) {
                if (in_array($returnType->getClassName(), array_keys($this->getReplacementMap()))) {
                    $returnClassName = $this->getReplacementMap()[$returnType->getClassName()];
                    return new ObjectType($returnClassName);
                }
            }
        }
    }
}