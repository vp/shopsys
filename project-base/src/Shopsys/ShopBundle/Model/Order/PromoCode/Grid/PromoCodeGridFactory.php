<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Model\Order\PromoCode\Grid;

use Shopsys\FrameworkBundle\Model\Order\PromoCode\Grid\PromoCodeGridFactory as BasePromoCodeGridFactory;

class PromoCodeGridFactory extends BasePromoCodeGridFactory
{
    /**
     * @param bool $withEditButton
     * @return \Shopsys\FrameworkBundle\Component\Grid\Grid
     */
    public function create($withEditButton = false)
    {
        $grid = parent::create($withEditButton);

        $grid->addColumn('price', 'pc.price', t('Price'), true);
        $grid->addColumn('id', 'c.name', t('Currency'), true);
        $grid->addColumn('domain', 'pc.domain', t('Domain'), true);

        return $grid;
    }
}
