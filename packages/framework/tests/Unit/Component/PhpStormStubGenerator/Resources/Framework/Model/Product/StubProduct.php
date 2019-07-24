<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product;

use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability;

class StubProduct
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability
     */
    protected $stubAvailability;

    /**
     * @param string $uuid
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability $stubAvailability
     */
    public function __construct(string $uuid, StubAvailability $stubAvailability)
    {
        $this->uuid = $uuid;
        $this->stubAvailability = $stubAvailability;
    }

    /**
     * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability
     */
    public function getStubAvailability(): StubAvailability
    {
        return $this->stubAvailability;
    }

    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability $stubAvailability
     */
    public function setStubAvailability(StubAvailability $stubAvailability): void
    {
        $this->stubAvailability = $stubAvailability;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
