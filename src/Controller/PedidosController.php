<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Usuarios;
use App\Entity\Detallespedidos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\PedidosType;

final class PedidosController extends AbstractController
{
    #[Route('/pedidos', name: 'app_pedidos')]
    public function index(): Response
    {
        return $this->render('pedidos/index.html.twig', [
            'controller_name' => 'PedidosController',
        ]);
    }

    #[Route('/admin/pedidos', name: 'admin_pedidos')]
    public function adminIndex(EntityManagerInterface $em): Response
    {
        $platos = $em->getRepository(\App\Entity\Platos::class)->findAll();
        $usuarios = $em->getRepository(\App\Entity\Usuarios::class)->findAll();
        $pedidos = $em->getRepository(\App\Entity\Pedidos::class)->findAll();
        $historialventas = $em->getRepository(\App\Entity\Historialventas::class)->findAll();
        $categorias = $em->getRepository(\App\Entity\Categorias::class)->findAll();
        $estadospedidos = $em->getRepository(\App\Entity\Estadospedidos::class)->findAll();
        $detallespedidos = $em->getRepository(\App\Entity\Detallespedidos::class)->findAll();

        return $this->render('admin/panel.html.twig', [
            'platos' => $platos,
            'usuarios' => $usuarios,
            'pedidos' => $pedidos,
            'historialventas' => $historialventas,
            'estadospedidos' => $estadospedidos,
            'detallespedidos' => $detallespedidos,
            'categorias' => $categorias,
        ]);
    }

    #[Route('/admin/pedido/editar/{id}', name: 'admin_pedido_editar')]
    public function editar(Request $request, Pedidos $pedido, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PedidosType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_pedidos');
        }

        return $this->render('pedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => true,
        ]);
    }

    #[Route('/admin/pedido/eliminar/{id}', name: 'admin_pedido_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, Pedidos $pedido, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pedido->getId(), $request->request->get('_token'))) {
            // Eliminar detalles asociados primero
            $detalles = $em->getRepository(Detallespedidos::class)->findBy(['pedido' => $pedido]);
            foreach ($detalles as $detalle) {
                $em->remove($detalle);
            }
            try {
                $em->remove($pedido);
                $em->flush();
            } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', 'No se puede eliminar el pedido porque tiene historial de ventas asociado.');
                return $this->redirectToRoute('admin_pedidos');
            } catch (\Doctrine\DBAL\Exception $e) {
                $this->addFlash('error', 'Error al eliminar el pedido.');
                return $this->redirectToRoute('admin_pedidos');
            }
        }
        return $this->redirectToRoute('admin_pedidos');
    }
}
