<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\FrontendModel;

class AppGlobalId
{
    /**
     * @param string $globalId
     * @return int
     */
    public static function getIdFromGlobalId(string $globalId): int
    {
        return (int)$globalId;
    }
}
