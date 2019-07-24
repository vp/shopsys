<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability;

use Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailabilityChecker as BaseStubAvailabilityChecker;

class StubAvailabilityChecker extends BaseStubAvailabilityChecker
{
    /**
     * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability $stubAvailability
     * @return bool
     */
    public function test(StubAvailability $stubAvailability): bool
    {
        return $stubAvailability->isAvailable();
    }
}
