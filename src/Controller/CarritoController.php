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


    // Acción para añadir un plato al carrito
    #[Route('/agregar/{id}', name: 'agregar')]
    public function agregar(int $id, SessionInterface $session, PlatosRepository $platosRepository): Response
    {
        // --- VERIFICAR SI EL USUARIO ESTÁ LOGEADO ---
        // app.session.get('user_name') verifica si la clave 'user_name' existe en la sesión
        // que es donde guardas el nombre del usuario al logearse.
        if (null === $session->get('user_name')) {
            // Si el usuario NO está logeado
            $this->addFlash('warning', 'Debes iniciar sesión para añadir productos al carrito.');

            // Redirigir a la página de login
            return $this->redirectToRoute('app_login');
        }
        // --- FIN VERIFICACIÓN ---


        // Si el usuario SÍ está logeado, procedemos con la lógica para añadir al carrito

        // Verificar si el plato existe antes de añadirlo
        $plato = $platosRepository->find($id);
        if (!$plato) {
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

        $this->addFlash('success', 'Plato añadido al carrito.');

        // Redirigir de vuelta a la página de inicio (o a donde prefieras después de añadir)
        return $this->redirectToRoute('app_inicio');
        // O para redirigir al carrito:
        // return $this->redirectToRoute('app_carrito_index');
    }

    // ... (Tus acciones eliminar, actualizar y vaciar permanecen igual) ...
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
