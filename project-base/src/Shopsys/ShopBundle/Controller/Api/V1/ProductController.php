<?php

namespace Shopsys\ShopBundle\Controller\Api\V1;

use FOS\RestBundle\Controller\AbstractFOSRestController;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;

/**
 * @experimental
 */
class ProductController extends AbstractFOSRestController
{

    public function getProductAction(Request $request, int $productId): Response
    {

        $product = [
            'uuid' => 'abcdef-56df4a65df4',
            'name' => 'test',
            'description' => 'Lorem ipsum',
        ];

        $data = [$product];
        $view = $this->view($data, 200)
            ->setTemplate('@ShopsysShop/Front/Api/Product/product.html.twig');

        return $this->handleView($view);

        //return new JsonResponse($product);
    }
}
