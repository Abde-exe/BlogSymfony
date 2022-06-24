<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index(ManagerRegistry $doctrine): Response
    {
        $dernierArticle = $doctrine->getRepository(Article::class)->findOneBy(
            [],
            ["dateDeCreation" => "DESC"]
        );
        return $this->render('home/index.html.twig', [
            "dernierArticle" => $dernierArticle
        ]);
    }
}
