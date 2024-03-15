<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{   
    private $cartServices;
    private $session;

    public function __construct(CartServices $cartServices, SessionInterface $session)
    {
        $this->cartServices = $cartServices;
        $this->session = $session;
    }

    #[Route('/checkout', name: 'checkout')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();    

        if (!$user) {
            // Gérer le cas où l'utilisateur n'est pas connecté
            // Redirection vers la page de connexion par exemple
            return $this->redirectToRoute("app_login");
        }
        
        $cart = $this->cartServices->getFullCart();

        if(!isset($cart['products'])){
            return $this->redirectToRoute("app_home");
        }

        $addresses = $user->getAddresses();
        if($addresses->isEmpty()){
            $this->addFlash('checkout_message', 'Merci de renseigner une adresse de livraison avant de continuer !');
            return $this->redirectToRoute("app_address_new");
        }
        if($this->session->get('checkout_data')){
            return $this->redirectToRoute('checkoutConfirm');
        }

        $form = $this->createForm(CheckoutType::class, null, ['user'=>$user]);
        //$form->handleRequest($request);
        //traitement du formulaire

        return $this->render('checkout/index.html.twig', [
            'cart'=>$cart,
            'checkout'=>$form->createView()
        ]);


    }

    // #[route('/checkout/confirm' , name:'checkoutConfirm')]
    // public function confirm(Request $request, OrderServices $orderServices):Response{
    //     $user = $this->getUser();
    //     $cart = $this->cartServices->getFullCart(); //deux fois utiliser donc faire un contructeur
     
    //     if(!isset($cart['products'])){
    //         return $this->redirectToRoute("accueil");
    //     }
    //     if(!$user->getAddresses()->getValues()){
    //         $this->addFlash('checkout_message', 'Merci de renseigner une adresse de livraison avant de continuer !');
    //         return $this->redirectToRoute("address_new");
    //     }
    //     //dd($cart['products'][0]);
    //     $form = $this->createForm(CheckoutType::class, null, ['user'=>$user]);
    //     $form->handleRequest($request);
        
    //     if($form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data')){
    //         if($this->session->get('checkout_data')){
    //             $data = $this->session->get('checkout_data');
    //         }else{
            
    //             $data = $form->getData();
    //             $this->session->set('checkout_data',$data);
    //         }
           
    //         $address = $data['address'];
    //         $transport = $data['transport'];
    //         $informations = $data['informations'];
    //         //dd($data);
    //         //save panier
    //         $cart['checkout'] = $data;
    //         //dd($cart);
           
    //         $reference = $orderServices->saveCart($cart,$user);
    //         //dd($reference);
    //         return $this->render('checkout/confirm.html.twig', [
    //             'cart'=>$cart,
    //             'address' =>$address,
    //             'transport' =>$transport,
    //             'informations' =>$informations,
    //             'reference' =>$reference,
    //             'apiKeyPublic' => $_ENV['key_test_stripe_public'],
    //             'checkout'=>$form->createView()
    //         ]);
    //     } else {
    //         return $this->redirectToRoute('checkout');
    //     }    
    // }


    #[Route('/checkout/edit', name:'checkout_edit')]
    public function checkoutEdit():Response{
        $this->session->set('checkout_data',[]);
        return $this->redirectToRoute("checkout");
    }
}
