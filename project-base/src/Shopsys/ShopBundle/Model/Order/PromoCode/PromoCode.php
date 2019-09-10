<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Model\Order\PromoCode;

use Doctrine\ORM\Mapping as ORM;
use Shopsys\FrameworkBundle\Component\Money\Money;
use Shopsys\FrameworkBundle\Model\Customer\User;
use Shopsys\FrameworkBundle\Model\Order\PromoCode\PromoCode as BasePromoCode;
use Shopsys\FrameworkBundle\Model\Order\PromoCode\PromoCodeData as BasePromoCodeData;
use Shopsys\FrameworkBundle\Model\Pricing\Currency\Currency;

/**
 * @ORM\Table(name="promo_codes")
 * @ORM\Entity
 */
class PromoCode extends BasePromoCode
{
    /**
     * @var \Shopsys\FrameworkBundle\Component\Money\Money
     *
     * @ORM\Column(type="money", nullable=true, precision=20, scale=6)
     */
    protected $price;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Currency\Currency
     *
     * @ORM\ManyToOne(targetEntity="Shopsys\FrameworkBundle\Model\Pricing\Currency\Currency")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $currency;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Customer\User|null
     *
     * @ORM\ManyToOne(targetEntity="Shopsys\FrameworkBundle\Model\Customer\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $customer;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isTransport;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $repeatsLeft;

    public function __construct(PromoCodeData $promoCodeData)
    {
        parent::__construct($promoCodeData);
        $this->price = $promoCodeData->price;
        $this->currency = $promoCodeData->currency;
        $this->domain = $promoCodeData->domain;
        $this->customer = $promoCodeData->customer;
        $this->isTransport = $promoCodeData->isTransport;
        $this->repeatsLeft = $promoCodeData->repeatsLeft;
    }

    /**
     * @param PromoCodeData $promoCodeData
     */
    public function edit(BasePromoCodeData $promoCodeData): void
    {
        parent::edit($promoCodeData);
        $this->price = $promoCodeData->price;
        $this->currency = $promoCodeData->currency;
        $this->domain = $promoCodeData->domain;
        $this->customer = $promoCodeData->customer;
        $this->isTransport = $promoCodeData->isTransport;
        $this->repeatsLeft = $promoCodeData->repeatsLeft;
    }


    /**
     * @return \Shopsys\FrameworkBundle\Component\Money\Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @param \Shopsys\FrameworkBundle\Component\Money\Money $price
     */
    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    /**
     * @return \Shopsys\FrameworkBundle\Model\Pricing\Currency\Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Currency\Currency $currency
     */
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int|null
     */
    public function getDomain(): ?int
    {
        return $this->domain;
    }

    /**
     * @param int|null $domain
     */
    public function setDomain(?int $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return null|\Shopsys\FrameworkBundle\Model\Customer\User
     */
    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    /**
     * @param null|\Shopsys\FrameworkBundle\Model\Customer\User $customer
     */
    public function setCustomer(?User $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return bool
     */
    public function isTransport(): bool
    {
        return $this->isTransport;
    }

    /**
     * @param bool $isTransport
     */
    public function setIsTransport(bool $isTransport): void
    {
        $this->isTransport = $isTransport;
    }

    /**
     * @return int
     */
    public function getRepeatsLeft(): ?int
    {
        return $this->repeatsLeft;
    }

    /**
     * @param int $repeatsLeft
     */
    public function setRepeatsLeft(?int $repeatsLeft): void
    {
        $this->repeatsLeft = $repeatsLeft;
    }
}
