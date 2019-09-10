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
    public function testExtendBaseEntityJoinWithExtendedEntity(): void
    {
        /** @var \Shopsys\FrameworkBundle\Component\Doctrine\QueryBuilderExtender $queryBuilderExtender */
        $queryBuilderExtender = $this->getContainer()->get(QueryBuilderExtender::class);
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->from(Category::class, 'c');
        $queryBuilder->join(BaseProduct::class, 'p');
        $queryBuilderExtender->addOrExtendJoin($queryBuilder, Product::class, 'p', '0 = 0');

        $joinDqlPart = $queryBuilder->getDQLPart('join');
        $this->assertCount(1, reset($joinDqlPart));
    }

    public function testExtendExtendedEntityJoinWithBaseEntity(): void
    {
        /** @var \Shopsys\FrameworkBundle\Component\Doctrine\QueryBuilderExtender $queryBuilderExtender */
        $queryBuilderExtender = $this->getContainer()->get(QueryBuilderExtender::class);
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->from(Category::class, 'c');
        $queryBuilder->join(Product::class, 'p');
        $queryBuilderExtender->addOrExtendJoin($queryBuilder, BaseProduct::class, 'p', '0 = 0');

        $joinDqlPart = $queryBuilder->getDQLPart('join');
        $this->assertCount(1, reset($joinDqlPart));
    }
}
