<?php

declare(strict_types=1);

namespace Tests\GraphBundle\Functional\Product;

use Tests\GraphBundle\GraphQlTestCase;

class ProductQueryTest extends GraphQlTestCase
{
    public function testBasicQueries(): void
    {
        $query = <<<'EOF'
query {
  product(id:72) {
    ean
    id
    partno
    name
  }
}
EOF;
        $jsonExpected = <<<EOF
{
  "data": {
    "product": {
      "ean": "8845781243207",
      "id": "72",
      "partno": "TIC100",
      "name": "100 Czech crowns ticket"
    }
  }
}
EOF;
        $this->assertQuery($query, $jsonExpected);
    }
}
