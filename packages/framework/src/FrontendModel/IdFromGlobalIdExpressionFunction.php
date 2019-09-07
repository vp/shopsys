<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\FrontendModel;

use Overblog\GraphQLBundle\ExpressionLanguage\ExpressionFunction;

class IdFromGlobalIdExpressionFunction extends ExpressionFunction
{
    /**
     * @param string $name
     */
    public function __construct($name = 'idFromGlobalId')
    {
        parent::__construct(
            $name,
            static function ($globalId) {
                return sprintf(
                    '\%s::getIdFromGlobalId(%s)',
                    AppGlobalId::class,
                    $globalId
                );
            }
        );
    }
}
