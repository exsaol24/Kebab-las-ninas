<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Detallespedidos;
use App\Entity\Platos;
use App\Entity\Historialventas;
use App\Repository\PlatosRepository;
use App\Repository\PedidosRepository;
use App\Repository\EstadospedidosRepository;
use App\Repository\UsuariosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class CarritoController extends AbstractController
{
    #[Route('/carrito', name: 'app_carrito')]
    public function index(Request $request, PlatosRepository $platosRepository): Response
    {
        $carrito = $request->getSession()->get('carrito', []);
        $carritoData = [];
        $total = 0;

        foreach ($carrito as $key => $item) {
            $plato = $platosRepository->find($item['id']);
            if ($plato) {
                $cantidad = isset($item['cantidad']) && !is_array($item['cantidad']) ? (int)$item['cantidad'] : 1;
                $personalizacion = $item['personalizacion'] ?? [];
                $carritoData[] = [
                    'key' => $key,
                    'plato' => $plato,
                    'cantidad' => $cantidad,
                    'personalizacion' => $personalizacion,
                ];
                $total += $plato->getPrecio() * $cantidad;
            }
        }

        return $this->render('carrito/index.html.twig', [
            'carritoData' => $carritoData,
            'total' => $total,
        ]);
    }

    #[Route('/carrito/agregar/{id}', name: 'app_carrito_agregar', methods: ['GET', 'POST'])]
    public function agregar($id, Request $request, PlatosRepository $platosRepository): Response
    {
        $session = $request->getSession();
        $carrito = $session->get('carrito', []);
        $carrito[] = [
            'id' => $id,
            'cantidad' => 1,
            'personalizacion' => [],
        ];
        $session->set('carrito', $carrito);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'success' => true,
                'total_productos_carrito' => count($carrito),
            ]);
        }

        $this->addFlash('success', 'Producto añadido al carrito.');
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/agregar-personalizado/{id}', name: 'app_carrito_agregar_personalizado', methods: ['POST'])]
    public function agregarPersonalizado($id, Request $request, PlatosRepository $platosRepository): Response
    {
        $session = $request->getSession();
        $carrito = $session->get('carrito', []);

        $cantidad = max(1, (int)$request->request->get('cantidad', 1));
        $personalizacion = $request->request->all('personalizacion');

        $carrito[] = [
            'id' => $id,
            'cantidad' => $cantidad,
            'personalizacion' => $personalizacion,
        ];

        $session->set('carrito', $carrito);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'success' => true,
                'total_productos_carrito' => count($carrito),
            ]);
        }

        $this->addFlash('success', 'Producto añadido al carrito con personalización.');
        return $this->redirectToRoute('app_inicio');
    }

    #[Route('/carrito/actualizar/{key}', name: 'app_carrito_actualizar', methods: ['POST'])]
    public function actualizar($key, Request $request): Response
    {
        $cantidad = max(1, (int)$request->request->get('cantidad', 1));
        $personalizacion = $request->request->all('personalizacion');
        $session = $request->getSession();
        $carrito = $session->get('carrito', []);
        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] = $cantidad;
            $carrito[$key]['personalizacion'] = $personalizacion;
            $session->set('carrito', $carrito);
            $this->addFlash('success', 'Cantidad y personalización actualizadas.');
        }
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/eliminar/{key}', name: 'app_carrito_eliminar')]
    public function eliminar($key, Request $request): Response
    {
        $session = $request->getSession();
        $carrito = $session->get('carrito', []);
        if (isset($carrito[$key])) {
            unset($carrito[$key]);
            // Reindexar el array para evitar huecos en los índices
            $carrito = array_values($carrito);
            $session->set('carrito', $carrito);
            $this->addFlash('success', 'Producto eliminado del carrito.');
        }
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/vaciar', name: 'app_carrito_vaciar')]
    public function vaciar(Request $request): Response
    {
        $request->getSession()->remove('carrito');
        $this->addFlash('success', 'Carrito vaciado.');
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/finalizar', name: 'app_carrito_finalizar', methods: ['POST'])]
    public function finalizar(
        Request $request,
        PlatosRepository $platosRepository,
        EntityManagerInterface $em,
        EstadospedidosRepository $estadospedidosRepository,
        UsuariosRepository $usuariosRepository,
        MailerInterface $mailer,
        Environment $twig
    ): Response {
        $session = $request->getSession();
        $carrito = $session->get('carrito', []);
        $personalizaciones = $request->request->all('personalizacion');
        if (empty($carrito)) {
            $this->addFlash('error', 'El carrito está vacío.');
            return $this->redirectToRoute('app_carrito');
        }

        // Obtener usuario desde la sesión
        $usuarioId = $session->get('user_id');
        if (!$usuarioId) {
            $this->addFlash('error', 'Debes iniciar sesión para finalizar el pedido.');
            return $this->redirectToRoute('app_login');
        }

        $usuario = $usuariosRepository->find($usuarioId);
        if (!$usuario || !$usuario->getDireccion()) {
            $this->addFlash('error', 'Debes tener una dirección registrada para finalizar el pedido.');
            return $this->redirectToRoute('app_carrito');
        }

        // Crear pedido
        $pedido = new Pedidos();
        $pedido->setUsuarios($usuario);
        // Obtener el estado del pedido
        $estado = $estadospedidosRepository->findOneBy(['nombre' => 'Pendiente']);
        if (!$estado) {
            $estado = $estadospedidosRepository->findOneBy([]);
        }
        if (!$estado) {
            $this->addFlash('error', 'No se ha encontrado un estado válido para el pedido. Contacta con el administrador.');
            return $this->redirectToRoute('app_carrito');
        }
        $pedido->setEstado($estado);
        $pedido->setDireccionentrega($usuario->getDireccion());
        // Recoge el método de pago del formulario
        $metodoPago = $request->request->get('metodo_pago', 'Efectivo');
        $pedido->setMetodopago($metodoPago);
        $pedido->setFechapedido(new \DateTime());

        $total = 0;
        foreach ($carrito as $key => $item) {
            $plato = $platosRepository->find($item['id']);
            if ($plato) {
                $cantidad = isset($item['cantidad']) && !is_array($item['cantidad']) ? (int)$item['cantidad'] : 1;
                $total += $plato->getPrecio() * $cantidad;
            }
        }
        $pedido->setTotal($total);

        $em->persist($pedido);

        // Guardar detalles del pedido
        $detallesPedidos = [];
        foreach ($carrito as $key => $item) {
            $plato = $platosRepository->find($item['id']);
            if ($plato) {
                $detalle = new Detallespedidos();
                $detalle->setPedido($pedido);
                $detalle->setPlatos($plato);
                $cantidad = isset($item['cantidad']) && !is_array($item['cantidad']) ? (int)$item['cantidad'] : 1;
                $detalle->setCantidad($cantidad);
                $detalle->setPreciounitario($plato->getPrecio());

                // Personalización legible
                $pers = isset($item['personalizacion']) ? $item['personalizacion'] : [];
                $nombres = [
                    'salsa_blanca' => 'Salsa blanca',
                    'salsa_yogurt' => 'Salsa yogurt',
                    'lechuga' => 'Lechuga',
                    'tomate' => 'Tomate',
                    'cebolla' => 'Cebolla',
                    'maiz' => 'Maíz',
                    'queso_feta' => 'Queso feta',
                    'lombarda' => 'Lombarda',
                    'salsa_picante' => 'Salsa picante',
                ];
                $persLegible = [];
                foreach ($pers as $clave => $valor) {
                    if (!empty($valor) && isset($nombres[$clave])) {
                        $persLegible[] = $nombres[$clave];
                    }
                }
                $persString = count($persLegible) ? implode(', ', $persLegible) : 'Sin personalización';
                $detalle->setPersonalizacion($persString);

                $em->persist($detalle);
                $detallesPedidos[] = [
                    'plato' => $plato,
                    'cantidad' => $cantidad,
                    'personalizacion' => $persLegible,
                    'precio_unitario' => $plato->getPrecio(),
                ];
            }
        }

        $em->flush();
        $session->remove('carrito');

        // Registrar en historialventas
        $historial = new Historialventas();
        $historial->setPedido($pedido);
        $historial->setFechaventa(new \DateTime());
        $historial->setTotal($pedido->getTotal());
        $em->persist($historial);
        $em->flush();

        try {
            $emailContent = $twig->render('emails/pedido_confirmacion.html.twig', [
                'pedido' => $pedido,
                'usuario' => $usuario,
                'detallesPedidos' => $detallesPedidos,
            ]);

            $email = (new Email())
                ->from('your_email@example.com')
                ->to($usuario->getEmail())
                ->subject('Confirmación de tu pedido en Kebab Las Niñas')
                ->html($emailContent);

            $mailer->send($email);
            $this->addFlash('success', 'Pedido realizado correctamente y confirmación enviada a tu correo.');
        } catch (\Exception $e) {
            $this->addFlash('warning', 'Pedido realizado, pero no se pudo enviar el correo de confirmación. Error: ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_inicio');
    }
}