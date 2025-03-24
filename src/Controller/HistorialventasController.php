<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HistorialventasController extends AbstractController
{
    #[Route('/historialventas', name: 'app_historialventas')]
    public function index(): Response
    {
        return $this->render('historialventas/index.html.twig', [
            'controller_name' => 'HistorialventasController',
        ]);
    }
}
