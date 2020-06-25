<?php

namespace App\Services;

use Slince\Shopify\PublicAppCredential;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Slince\Shopify\Client;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Slince\Shopify\CursorBasedPagination;

/**
 * @IgnoreAnnotation("PropertyAccess")
 */
class ShopifyService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function hideAll()
    {
        $token = $this->session->get('token');

        $shop = $this->session->get('shop');


        $credential = new PublicAppCredential($token);

        $client = new Client($credential, $shop, [
            'metaCacheDir' => './tmp' // Metadata cache dir, required
        ]);
        $productManager = $client->getProductManager();


        $pagination = $productManager->paginate([
            // filter your product
            'limit' => 250,
            'published_status' => 'published'
        ]);

        $zeroID = array();

        $currentProducts = $pagination->current(); //current page

        foreach ($currentProducts as $curProd){
            $variant = $curProd->getVariants();

            foreach ($variant as $var){
                $quantity = $var->getInventoryQuantity();
                if($quantity < 1){
                    array_push($zeroID,$curProd->getId());

                }

            }
        }

        while ($pagination->hasNext()) {
            $nextProducts = $pagination->next();

            foreach ($nextProducts as $nxtProd){
                $variant = $nxtProd->getVariants();
                foreach ($variant as $var){
                    $quantity = $var->getInventoryQuantity();
                    if($quantity < 1){
                        array_push($zeroID,$nxtProd->getId());
                    }

                }
            }
        }

        foreach ($zeroID as $id) {

            $productManager->update($id,["published_at"=>null]);
        }


    }

    public function showAll()
    {
        $token = $_SESSION["token"];

        $shop = $_SESSION["shop"];


        $credential = new PublicAppCredential($token);

        $client = new Client($credential, $shop, [
            'metaCacheDir' => './tmp' // Metadata cache dir, required
        ]);
        $productManager = $client->getProductManager();


        $pagination = $productManager->paginate([
            // filter your product
            'limit' => 250,
            'published_status' => 'published'
        ]);

        $zeroID = array();

        $currentProducts = $pagination->current(); //current page

        foreach ($currentProducts as $curProd){
            $variant = $curProd->getVariants();

            foreach ($variant as $var){
                $quantity = $var->getInventoryQuantity();
                if($quantity < 1){
                    array_push($zeroID,$curProd->getId());

                }

            }
        }

        while ($pagination->hasNext()) {
            $nextProducts = $pagination->next();

            foreach ($nextProducts as $nxtProd){
                $variant = $nxtProd->getVariants();
                foreach ($variant as $var){
                    $quantity = $var->getInventoryQuantity();
                    if($quantity < 1){
                        array_push($zeroID,$nxtProd->getId());
                    }

                }
            }
        }


        foreach ($zeroID as $id) {

            $productManager->update($id,["published_at"=>date("c")]);
        }


    }
}

