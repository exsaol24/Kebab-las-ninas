<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SobrenosotrosController extends AbstractController
{
    #[Route('/sobrenosotros', name: 'app_sobrenosotros')]
    public function index(): Response
    {
        return $this->render('sobrenosotros/index.html.twig', [
            'controller_name' => 'SobrenosotrosController',
        ]);
    }
}
