<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Model\Order\PromoCode;

use Shopsys\FrameworkBundle\Model\Order\PromoCode\PromoCode as BasePromoCode;
use Shopsys\FrameworkBundle\Model\Order\PromoCode\PromoCodeData as BasePromoCodeData;
use Shopsys\FrameworkBundle\Model\Order\PromoCode\PromoCodeDataFactory as BasePromoCodeDataFactory;

class PromoCodeDataFactory extends BasePromoCodeDataFactory
{
    /**
     * @return PromoCodeData
     */
    public function create(): BasePromoCodeData
    {
        return new PromoCodeData;
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Order\PromoCode\PromoCode $promoCode
     *
     * @return PromoCodeData
     */
    public function createFromPromoCode(BasePromoCode $promoCode): BasePromoCodeData
    {
        $promoCodeData = new PromoCodeData();
        $this->fillFromPromoCode($promoCodeData, $promoCode);

        return $promoCodeData;
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Order\PromoCode\PromoCodeData $promoCodeData
     * @param \Shopsys\ShopBundle\Model\Order\PromoCode\PromoCode $promoCode
     */
    protected function fillFromPromoCode(BasePromoCodeData $promoCodeData, BasePromoCode $promoCode): void
    {
        d($promoCodeData); exit;
        parent::fillFromPromoCode($promoCodeData, $promoCode);
        $promoCodeData->price = $promoCode->getPrice();
        $promoCodeData->currency = $promoCode->getCurrency();
        $promoCodeData->domain = $promoCode->getDomain();
        $promoCodeData->customer = $promoCode->getCustomer();
        $promoCodeData->isTransport = $promoCode->isTransport();
        $promoCodeData->repeatsLeft = $promoCode->getRepeatsLeft();
    }
}
