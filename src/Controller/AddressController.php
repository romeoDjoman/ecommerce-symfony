<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/address')]
class AddressController extends AbstractController
{
    #[Route('/', name: 'app_address_index', methods: ['GET'])]
    public function index(AddressRepository $addressRepository): Response
    {
        return $this->render('address/index.html.twig', [
            'addresses' => $addressRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_address_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $address = new Address(); // Créez une nouvelle instance d'Address

    $form = $this->createForm(AddressType::class, $address);
    $form->handleRequest($request);
    $user = $this->getUser();

    if ($form->isSubmitted() && $form->isValid()) {
        $address->setUser($user);
        $entityManager->persist($address);
        $entityManager->flush();
        $this->addFlash('success', 'Vous venez d\'ajouter une nouvelle adresse.');
        return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('address/new.html.twig', [
        'address' => $address,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_address_show', methods: ['GET'])]
    public function show(Address $address): Response
    {
        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_address_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Adresse mise à jour avec succès.');
            return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
        }else{
            $title = "Créer une nouvelle adresse";
        }

        return $this->renderForm('address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
            'title' => $title,
        ]);
    }

    #[Route('/{id}', name: 'app_address_delete', methods: ['POST'])]
    public function delete(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $entityManager->remove($address);
            $entityManager->flush();
            $this->addFlash('success', 'Adresse supprimée avec succès.');
        }

        return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
    }
}
