<?php

declare(strict_types=1);

namespace Tests\ShopBundle\Functional\Component\Doctrine;

use Shopsys\FrameworkBundle\Component\Doctrine\QueryBuilderExtender;
use Shopsys\FrameworkBundle\Model\Category\Category;
use Shopsys\FrameworkBundle\Model\Product\Product as BaseProduct;
use Shopsys\ShopBundle\Model\Product\Product;
use Tests\ShopBundle\Test\FunctionalTestCase;

class QueryBuilderExtenderTest extends FunctionalTestCase
{
    /**
     * @dataProvider extendJoinWithExtendedEntityProvider
     * @param string $firstJoinedEntity
     * @param string $secondJoinedEntity
     */
    public function testExtendJoinWithExtendedEntity(string $firstJoinedEntity, string $secondJoinedEntity): void
    {
        /** @var \Shopsys\FrameworkBundle\Component\Doctrine\QueryBuilderExtender $queryBuilderExtender */
        $queryBuilderExtender = $this->getContainer()->get(QueryBuilderExtender::class);
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->from(Category::class, 'c');
        $queryBuilder->join($firstJoinedEntity, 'p');
        $queryBuilderExtender->addOrExtendJoin($queryBuilder, $secondJoinedEntity, 'p', '0 = 0');

        $joinDqlPart = $queryBuilder->getDQLPart('join');
        $this->assertCount(1, reset($joinDqlPart));
    }

    /**
     * @return array
     */
    public function extendJoinWithExtendedEntityProvider(): array
    {
        return [
            'extend base entity join with extended entity' => [
                'firstJoinedEntity' => BaseProduct::class,
                'secondJoinedEntity' => Product::class,
            ],
            'extend extended entity join with base entity' => [
                'firstJoinedEntity' => Product::class,
                'secondJoinedEntity' => BaseProduct::class,
            ],
        ];
    }
}
