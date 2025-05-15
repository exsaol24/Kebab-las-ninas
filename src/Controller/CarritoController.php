<?php

namespace App\Controller;

use App\Repository\PlatosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carrito', name: 'app_carrito_')]
class CarritoController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, PlatosRepository $platosRepository): Response
    {
        $carrito = $session->get('carrito', []);
        $carritoData = [];

        foreach ($carrito as $id => $cantidad) {
            $plato = $platosRepository->find($id);
            if ($plato) {
                $carritoData[] = [
                    'plato' => $plato,
                    'cantidad' => $cantidad,
                ];
            }
        }

        $total = 0;
        foreach ($carritoData as $item) {
            $total += $item['plato']->getPrecio() * $item['cantidad'];
        }

        return $this->render('carrito/index.html.twig', [
            'carritoData' => $carritoData,
            'total' => $total,
        ]);
    }

    #[Route('/agregar/{id}', name: 'agregar')]
    public function agregar(int $id, SessionInterface $session, PlatosRepository $platosRepository, Request $request): Response
    {
        if (null === $session->get('user_name')) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión para añadir productos al carrito.'
                ], 401);
            }
            $this->addFlash('warning', 'Debes iniciar sesión para añadir productos al carrito.');
            return $this->redirectToRoute('app_login');
        }

        $plato = $platosRepository->find($id);
        if (!$plato) {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => false,
                    'message' => 'El plato solicitado no existe.'
                ], 404);
            }
            $this->addFlash('error', 'El plato solicitado no existe.');
            return $this->redirectToRoute('app_inicio');
        }

        $carrito = $session->get('carrito', []);
        if (!empty($carrito[$id])) {
            $carrito[$id]++;
        } else {
            $carrito[$id] = 1;
        }
        $session->set('carrito', $carrito);

        // Calcular total productos en carrito
        $total_productos_carrito = 0;
        foreach ($carrito as $cantidad) {
            $total_productos_carrito += $cantidad;
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'success' => true,
                'total_productos_carrito' => $total_productos_carrito
            ]);
        }

        $this->addFlash('success', 'Plato añadido al carrito.');
        return $this->redirectToRoute('app_inicio');
    }

    #[Route('/eliminar/{id}', name: 'eliminar')]
    public function eliminar(int $id, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);

        if (!empty($carrito[$id])) {
            unset($carrito[$id]);
            $session->set('carrito', $carrito);
            $this->addFlash('success', 'Plato eliminado del carrito.');
        } else {
            $this->addFlash('warning', 'El plato no se encontraba en el carrito.');
        }

        return $this->redirectToRoute('app_carrito_index');
    }

    #[Route('/actualizar/{id}', name: 'actualizar', methods: ['POST'])]
    public function actualizar(int $id, Request $request, SessionInterface $session, PlatosRepository $platosRepository): Response
    {
        $carrito = $session->get('carrito', []);
        $nuevaCantidad = $request->request->get('cantidad');

        $nuevaCantidad = (int) $nuevaCantidad;

        if ($nuevaCantidad > 0 && $platosRepository->find($id)) {
            $carrito[$id] = $nuevaCantidad;
            $session->set('carrito', $carrito);
            $this->addFlash('success', 'Cantidad actualizada.');
        } elseif ($nuevaCantidad === 0 && !empty($carrito[$id])) {
            unset($carrito[$id]);
            $session->set('carrito', $carrito);
            $this->addFlash('success', 'Plato eliminado.');
        } else {
            $this->addFlash('error', 'Cantidad no válida o plato no encontrado.');
        }

        return $this->redirectToRoute('app_carrito_index');
    }

    #[Route('/vaciar', name: 'vaciar')]
    public function vaciar(SessionInterface $session): Response
    {
        $session->remove('carrito');
        $this->addFlash('success', 'El carrito ha sido vaciado.');

        return $this->redirectToRoute('app_carrito_index');
    }
}
