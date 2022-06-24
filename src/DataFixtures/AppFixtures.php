<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitre("mon titre $i")
                ->setContenu("mon contenu $i")
                ->setDateDeCreation(new DateTime("now"));

            $manager->persist($article);
        }
        for ($i = 1; $i <= 10; $i++) {
            $auteur = new Auteur();
            $auteur->setNom("mon auteur $i")
                ->setPrenom("mon prenom")
                ->setBiographie("ma bio $i")
                ->setDateDeNaissance(new DateTime());

            $manager->persist($auteur);
        }
        $manager->flush();
    }
}
