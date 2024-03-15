<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $repoProduct, ): Response
    {
        $produits = $repoProduct->findAll();
        $produitIsBest = $repoProduct->findByIsBest(1);
        $produitIsNew = $repoProduct->findByIsNew(6);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits' => $produits,
            'produitIsBest' => $produitIsBest,
            'produitIsNew' => $produitIsNew,
        ]);
    }

    // Afficher les détails d'un produit
    #[Route('/product/{id}', name: 'single_product')]
    public function show(?Product $produit): Response{
        
        if(!$produit){
            return $this->redirectToRoute("app_accueil");
        }

        return $this->render("accueil/single_product.html.twig",[
            'produit' => $produit,
        ]);
    }

}
