<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Controller1Controller extends AbstractController
{
    #[Route('/test', name: 'app_controller1')]
    public function test()
    {
        $identite = ['personne1' => ['prenom' => 'Nassima', 'nom' => 'Bekkari'], 'personne2' => ['prenom' => 'Cyril', 'nom' => 'Belin']];

        // foreach ($identite as $key => $value) {
        //     foreach ($value as $key2 => $value2) {
        //         echo "$value2 $key2";
        //     }
        // }
        // dd();
        return $this->render("test.html.twig", [

            "identite" => $identite
        ]);
    }
}
