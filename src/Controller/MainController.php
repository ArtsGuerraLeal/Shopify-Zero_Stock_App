<?php

namespace App\Controller;

use App\Services\ShopifyService;
use Slince\Shopify\Model\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\InstallService;


/**
 * @Route("/api", name="api.")
 */
class MainController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/home", name="home")
     * @return Response
     */
    public function index()
    {

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController'
        ]);
    }

    /**
     * @Route("/install", name="install")
     * @param InstallService $installService
     * @return Response
     */
    public function installAccess(InstallService $installService)
    {
        $route = $installService->install();
        return $this->redirect($route);


        return $this->render('main/new.html.twig', [
            'controller_name' => 'New controller',
            'url'=> $this->session->get('shop')
        ]);

    }

    /**
     * @Route("/generate", name="generate")
     * @param InstallService $installService
     * @return Response
     */
    public function generateAccess(InstallService $installService)
    {

        $installService->generateToken();
        $token = $this->session->get('token');
        return $this->render('main/generate.html.twig', [
            'controller_name' => 'New controller',
            'token'=> $token
        ]);

    }

    /**
     * @Route("/clear", name="clear")
     */
    public function clearAccess()
    {
        $this->session->clear();
    return $this->redirectToRoute('home.landing');

    }

    public function hideProducts(ShopifyService $shopifyService)
    {

    }


}

//http://zero.com/api/generate?code=bb6d12ffc70254c5d0df84693f17f5a5&hmac=69e9340336bf4ec5a9fa529366652d211ce1b129d6da43da3370c16c21b60720&shop=artsaucetesting.myshopify.com&timestamp=1585432110

//https://zero.com/?hmac=85f2e91eac04080887f4db26b246d60db831e7549740cdba4691ac525ab3f2a9&locale=en&session=3e818b1fc18b6d247b8ce9d1bfc4cf27a727c0d8c5ad11ce1aad95fa36cf7deb&shop=artsaucetesting.myshopify.com&timestamp=1585433022
//http://zero.com/?hmac=85f2e91eac04080887f4db26b246d60db831e7549740cdba4691ac525ab3f2a9&locale=en&session=3e818b1fc18b6d247b8ce9d1bfc4cf27a727c0d8c5ad11ce1aad95fa36cf7deb&shop=artsaucetesting.myshopify.com&timestamp=1585433022

//http://zero.com/?hmac=53a608e6f5cd6e0f341aeb83209ceac4aa516ba55dab100a986fa26268c964bc&shop=artsaucetesting.myshopify.com&timestamp=1585431651
//https://artsaucetesting.myshopify.com/admin/oauth/request_grant?client_id=983f08a8fbf88a9a5098a1d941307e18&redirect_uri=https%3A%2F%2Fshopify.artsauce.moe%2Fgenerate_token.php&scope=read_products%2Cwrite_products%2Cread_inventory%2Cwrite_inventory
//https://shopify.artsauce.moe/generate_token.php?code=65026e0d6ed95919007faac0be06c600&hmac=c0bdb60254fbcdacd20583f3a2edd13f47c5dc9717f0166b3f201880639a676f&shop=artsaucetesting.myshopify.com&timestamp=1585428630