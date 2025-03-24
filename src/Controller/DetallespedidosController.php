<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetallespedidosController extends AbstractController
{
    #[Route('/detallespedidos', name: 'app_detallespedidos')]
    public function index(): Response
    {
        return $this->render('detallespedidos/index.html.twig', [
            'controller_name' => 'DetallespedidosController',
        ]);
    }
}
