<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstadospedidosController extends AbstractController
{
    #[Route('/estadospedidos', name: 'app_estadospedidos')]
    public function index(): Response
    {
        return $this->render('estadospedidos/index.html.twig', [
            'controller_name' => 'EstadospedidosController',
        ]);
    }
}
