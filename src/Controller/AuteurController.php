<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    public function lire(ManagerRegistry $doctrine, $id)
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);
        return $this->render("auteur/lireAuteur.html.twig", [
            'auteur' => $auteur,

        ]);
    }

    public function allAuteurs(ManagerRegistry $doctrine): Response
    {
        $auteurs = $doctrine->getRepository(Auteur::class)->findAll();

        return $this->render('auteur/allAuteurs.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    public function ajout(ManagerRegistry $doctrine, Request $request): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //recupere le manager de doctrine
            $manager = $doctrine->getManager();
            //persiste l'objet
            $manager->persist($auteur);
            //envoie en bdd
            $manager->flush();

            return $this->redirectToRoute("auteurs");
        }
        return $this->render("auteur/formulaire.html.twig", [
            'formAuteur' => $form->createView()
        ]);
    }

    public function update(ManagerRegistry $doctrine, Request $request, $id)
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($auteur);
            $manager->flush();
            return $this->redirectToRoute("auteurs");
        }
        return $this->render("auteur/formulaire.html.twig", [
            'formAuteur' => $form->createView()
        ]);
    }

    public function delete(ManagerRegistry $doctrine, $id)
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);
        $manager = $doctrine->getManager();
        $manager->remove($auteur);
        $manager->flush();

        return $this->redirectToRoute("auteurs");
    }
}
