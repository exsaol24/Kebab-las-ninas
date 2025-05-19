<?php

namespace App\Controller;

use App\Repository\PlatosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InicioController extends AbstractController
{
    #[Route('/inicio', name: 'app_inicio')]
    public function index(PlatosRepository $platosRepository, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        // Obtener los platos desde la base de datos
        $platos = $platosRepository->findAll();

        $carrito = $request->getSession()->get('carrito', []);
        $totalCarrito = 0;
        foreach ($carrito as $item) {
            $cantidad = isset($item['cantidad']) && !is_array($item['cantidad']) ? (int)$item['cantidad'] : 1;
            $totalCarrito += $cantidad;
        }

        // Renderizar la plantilla y pasar la variable 'platos' y el total del carrito
        return $this->render('inicio/index.html.twig', [
            'platos' => $platos,
            'totalCarrito' => $totalCarrito,
        ]);
    }
}
