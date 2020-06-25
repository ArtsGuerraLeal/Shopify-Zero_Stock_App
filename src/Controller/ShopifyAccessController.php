<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopifyAccessController extends AbstractController
{
    /**
     * @Route("/shopify/access", name="shopify_access")
     */
    public function index()
    {
        return $this->render('shopify_access/index.html.twig', [
            'controller_name' => 'ShopifyAccessController',
        ]);
    }
}
