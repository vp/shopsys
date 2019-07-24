<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability;

class StubAvailabilityChecker
{
    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability $stubAvailability
     * @return bool
     */
    public function check(StubAvailability $stubAvailability): bool
    {
        return $stubAvailability->isAvailable();
    }
}
