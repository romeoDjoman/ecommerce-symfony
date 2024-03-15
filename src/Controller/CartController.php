<?php

namespace App\Controller;

use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $cartServices;

    public function __construct(CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->cartServices->getFullCart();
        if (empty($cart['products'])) {
            return $this->render('cart/empty_cart.html.twig');
        }

        $cartItemCount = $this->cartServices->getCartItemCount() ?? 0;

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'cartItemCount' => $cartItemCount,
        ]);
    }

    #[Route("/cart/add/{id}", name: "cartAdd")]
    public function addToCart($id): Response
    {
        $this->cartServices->addToCart($id);
        return $this->redirectToRoute("app_cart");
    }

    #[Route("/cart/delete/{id}", name: "cartDelete")]
    public function deleteFromCart($id): Response
    {
        $this->cartServices->deleteFromCart($id);
        return $this->redirectToRoute("app_cart");
    }

    #[Route("/cart/deleteAll", name: "cartDeleteAll")]
    public function deleteAllToCart(): Response
    {
        $this->cartServices->deleteCart();

        // Redirige vers la page du panier après la suppression
        return $this->redirectToRoute("app_cart");
    }

}
