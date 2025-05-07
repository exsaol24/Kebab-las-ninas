<?php

namespace App\Controller;

use App\Repository\PlatosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InicioController extends AbstractController
{
    #[Route('/inicio', name: 'app_inicio')]
    public function index(PlatosRepository $platosRepository): Response
    {
        // Obtener los platos desde la base de datos
        $platos = $platosRepository->findAll();

        // Renderizar la plantilla y pasar la variable 'platos'
        return $this->render('inicio/index.html.twig', [
            'platos' => $platos,
        ]);
    }
}
