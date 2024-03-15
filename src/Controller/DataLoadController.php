<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataLoadController extends AbstractController
{
    #[Route('/data/role', name: 'app_data_load')]
    public function index(UserRepository $repoUser, EntityManagerInterface $entityManager): Response
    {
        $userAdmin = $repoUser->find(2); // Le chiffre correspond à l'ID de l'Admin
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Bienvenue dans le controller de sauvegarde!',
            'path' => 'src/Controller/DataLoaderController.php',
        ]);
    }
}
