<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class ArticleController extends AbstractController
{

    public function allArticles(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Article::class)->findAll();

        return $this->render('article/allArticles.html.twig', [
            'articles' => $articles,
        ]);
    }

    public function lire(ManagerRegistry $doctrine, $id)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);
        return $this->render("article/lireArticle.html.twig", [
            'article' => $article,

        ]);
    }
    public function ajout(ManagerRegistry $doctrine, Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDateDeCreation(new DateTime("now"));
            //recupere le manager de doctrine
            $manager = $doctrine->getManager();
            //persiste l'objet
            $manager->persist($article);
            //envoie en bdd
            $manager->flush();

            return $this->redirectToRoute("articles");
        }
        return $this->render("article/formulaire.html.twig", [
            'formArticle' => $form->createView()
        ]);
    }

    public function update(ManagerRegistry $doctrine, Request $request, $id)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDateDeModification(new DateTime("now"));
            //recupere le manager de doctrine
            $manager = $doctrine->getManager();
            //persiste l'objet
            $manager->persist($article);
            //envoie en bdd
            $manager->flush();

            return $this->redirectToRoute("articles");
        }
        return $this->render("article/formulaire.html.twig", [
            'formArticle' => $form->createView()
        ]);
    }
    public function delete(ManagerRegistry $doctrine, $id)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);
        $manager = $doctrine->getManager();
        //persiste l'objet
        $manager->remove($article);
        //envoie en bdd
        $manager->flush();

        return $this->redirectToRoute("articles");
    }
}
