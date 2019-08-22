<?php

declare(strict_types=1);

namespace Shopsys\ShopBundle\Model\Order\Item;

use Shopsys\FrameworkBundle\Model\Order\Item\OrderItem as BaseOrderItem;
use Shopsys\FrameworkBundle\Model\Order\Item\OrderItemData as BaseOrderItemData;
use Shopsys\FrameworkBundle\Model\Order\Item\OrderItemFactory as BaseOrderItemFactory;
use Shopsys\FrameworkBundle\Model\Order\Order;

class OrderItemFactory extends BaseOrderItemFactory
{
    /**
     * @param Order $order
     * @param OrderItemData $orderItemData
     *
     * @return OrderItem
     */
    public function createProductFromOrderItemData(Order $order, BaseOrderItemData $orderItemData): BaseOrderItem
    {
        /** @var OrderItem $orderItem */
        $orderItem = parent::createProductFromOrderItemData($order, $orderItemData);
        $orderItem->setRandomColumn($orderItemData->randomColumn);
        return $orderItem;
    }
}
