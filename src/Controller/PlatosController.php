<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlatosController extends AbstractController
{
    #[Route('/platos', name: 'app_platos')]
    public function index(): Response
    {
        return $this->render('platos/index.html.twig', [
            'controller_name' => 'PlatosController',
        ]);
    }
}
