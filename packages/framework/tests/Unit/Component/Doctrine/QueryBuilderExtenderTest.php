<?php

declare(strict_types=1);

namespace Tests\FrameworkBundle\Component\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Shopsys\FrameworkBundle\Component\Doctrine\QueryBuilderExtender;
use Shopsys\FrameworkBundle\Model\Category\Category;
use Shopsys\FrameworkBundle\Model\Product\Product as BaseProduct;

class QueryBuilderExtenderTest extends TestCase
{
    public function testAddFirstJoinToQueryBuilder()
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $queryBuilder = new QueryBuilder($entityManager);

        $queryBuilderExtender = new QueryBuilderExtender();
        $queryBuilder->from(Category::class, 'c');
        $queryBuilderExtender->addOrExtendJoin($queryBuilder, BaseProduct::class, 'p', '1 = 1');

        $joins = $queryBuilder->getDQLPart('join');
        $this->assertCount(1, $joins);
    }
}
