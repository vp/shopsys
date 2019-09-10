<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Model\Order\PromoCode;

use Shopsys\FrameworkBundle\Model\Order\PromoCode\PromoCodeData as BasePromoCodeData;

class PromoCodeData extends BasePromoCodeData
{
    /**
     * @var \Shopsys\FrameworkBundle\Component\Money\Money
     */
    public $price;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Currency\Currency
     */
    public $currency;

    /**
     * @var int|null
     */
    public $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Customer\User|null
     */
    public $customer;

    /**
     * @var bool
     */
    public $isTransport;

    /**
     * @var int|null
     */
    public $repeatsLeft;
}
