<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product;

use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData as BaseStubProductData;

class StubProductData extends BaseStubProductData
{
    /**
     * @var string|null
     */
    public $name;
}
