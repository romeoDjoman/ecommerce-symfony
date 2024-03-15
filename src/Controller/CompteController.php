<?php

namespace App\Controller;

use App\Entity\Address;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class CompteController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte', name: 'app_compte')]
    public function index(): Response
    {
        $user = $this->getUser();
        $addressRepository = $this->entityManager->getRepository(Address::class);
        $addresses = $addressRepository->findBy(['user' => $user]);

        return $this->render('compte/index.html.twig', [
            'addresses' => $addresses,
        ]);
    }
}
