<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="home.")
 */
class HomeController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index()
    {

        if(empty($this->session->get('token'))) {
            $this->session->set('shop', $_GET['shop']);
            $this->session->set('hmac', $_GET['hmac']);

            return $this->redirectToRoute('home.landing');

        }else{
            $this->session->set('shop', $_GET['shop']);
            $this->session->set('hmac', $_GET['hmac']);
            return $this->redirectToRoute('api.generate');

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController'
            ]);

        }



    }

    /**
     * @Route("/landing", name="landing")
     * @return Response
     */
    public function landing()
    {

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',

                'token'=>$this->session->get('token')
            ]);

    }
}
