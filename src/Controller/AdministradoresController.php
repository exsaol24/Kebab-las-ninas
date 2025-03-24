<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdministradoresController extends AbstractController
{
    #[Route('/administradores', name: 'app_administradores')]
    public function index(): Response
    {
        return $this->render('administradores/index.html.twig', [
            'controller_name' => 'AdministradoresController',
        ]);
    }
}
