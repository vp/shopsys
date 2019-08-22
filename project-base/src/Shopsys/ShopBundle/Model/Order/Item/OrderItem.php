<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Model\Order\Item;

use Doctrine\ORM\Mapping as ORM;
use Shopsys\FrameworkBundle\Model\Order\Item\OrderItem as BaseOrderItem;
use Shopsys\FrameworkBundle\Model\Order\Item\OrderItemData as BaseOrderItemData;
use Shopsys\FrameworkBundle\Model\Order\Order as BaseOrder;
use Shopsys\FrameworkBundle\Model\Pricing\Price;

/**
 * @ORM\Table(name="order_items")
 * @ORM\Entity
 */
class OrderItem extends BaseOrderItem
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $randomColumn;

    /**
     * @param \Shopsys\ShopBundle\Model\Order\Order $order
     * @param string $name
     * @param \Shopsys\FrameworkBundle\Model\Pricing\Price $price
     * @param string $vatPercent
     * @param int $quantity
     * @param string $type
     * @param null|string $unitName
     * @param null|string $catnum
     * @param null|string $randomColumn
     */
    public function __construct(
        BaseOrder $order,
        string $name,
        Price $price,
        string $vatPercent,
        int $quantity,
        string $type,
        ?string $unitName,
        ?string $catnum,
        ?string $randomColumn = null
    ) {
        parent::__construct(
            $order,
            $name,
            $price,
            $vatPercent,
            $quantity,
            $type,
            $unitName,
            $catnum
        );

        $this->randomColumn = $randomColumn;
    }

    /**
     * @param OrderItemData $orderItemData
     */
    public function edit(BaseOrderItemData $orderItemData)
    {
        parent::edit($orderItemData);
        $this->randomColumn = (string) $orderItemData->randomColumn;
    }

    /**
     * @return null|string
     */
    public function getRandomColumn(): ?string
    {
        return $this->randomColumn;
    }

    /**
     * @param string|null $randomColumn
     */
    public function setRandomColumn(?string $randomColumn): void
    {
        $this->randomColumn = $randomColumn;
    }
}
