<?php

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability {
    class StubAvailability
    {
        /**
         * @return bool
         */
        public function isAvailable(): bool
        {
        }
    }
}

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability {
    class StubAvailabilityChecker
    {
        /**
         * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability $stubAvailability
         * @return bool
         */
        public function check(\Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability $stubAvailability): bool
        {
        }
    }
}

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product {
    class StubProduct
    {
        /**
         * @var string
         */
        protected $uuid;

        /**
         * @var \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability
         */
        protected $stubAvailability;

        /**
         * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability
         */
        public function getStubAvailability(): \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability
        {
        }

        /**
         * @param Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\\Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability $stubAvailability
         * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability
         */
        public function setStubAvailability(\Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Availability\StubAvailability $stubAvailability): void
        {
        }

        /**
         * @return string
         */
        public function getUuid(): string
        {
        }
    }
}

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product {
    class StubProductData
    {
        /**
         * string
         */
        public $uuid;

        /**
         * @var \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Availability\StubAvailability|null
         */
        public $stubAvailability;
    }
}

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product {
    class StubProductDataFactory implements StubProductDataFactoryInterface
    {
        /**
         * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData
         */
        public function create(): \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData
        {
        }

        /**
         * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData $stubProduct
         * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData
         */
        public function createFromStubProduct(\Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct $stubProduct): \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData
        {
        }
    }
}

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product {
    interface StubProductDataFactoryInterface
    {
        /**
         * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData
         */
        public function create(): \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData;

        /**
         * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProduct $stubProduct
         * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData
         */
        public function createFromStubProduct(\Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct $stubProduct): \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProductData;
    }

}

namespace Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product {
    class StubProductFacade
    {
        /**
         * @param \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProductData $stubProductData
         * @return \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Project\Model\Product\StubProduct
         */
        public function create(\Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct $stubProductData): \Tests\FrameworkBundle\Unit\Component\PhpStormStubGenerator\Resources\Framework\Model\Product\StubProduct
        {
        }
    }
}
