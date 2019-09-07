<?php

declare(strict_types=1);

namespace Tests\GraphBundle;

use Tests\ShopBundle\Test\FunctionalTestCase;

abstract class GraphQlTestCase extends FunctionalTestCase
{
    /**
     * @param string $query
     * @param string $jsonExpected
     * @param string $jsonVariables
     */
    protected function assertQuery(string $query, string $jsonExpected, $jsonVariables = '{}'): void
    {
        $client = $this->getClient();
        $path = $this->getContainer()->get('router')->generate('overblog_graphql_endpoint');

        $client->request(
            'GET',
            $path,
            ['query' => $query, 'variables' => $jsonVariables],
            [],
            ['CONTENT_TYPE' => 'application/graphql']
        );

        $code = $client->getResponse()->getStatusCode();
        $result = $client->getResponse()->getContent();

        $this->assertSame(200, $code);
        $this->assertEquals(json_decode($jsonExpected, true), json_decode($result, true), $result);
    }
}
