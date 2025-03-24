<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DireccionesController extends AbstractController
{
    #[Route('/direcciones', name: 'app_direcciones')]
    public function index(): Response
    {
        return $this->render('direcciones/index.html.twig', [
            'controller_name' => 'DireccionesController',
        ]);
    }
}
