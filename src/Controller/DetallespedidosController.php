<?php

namespace App\Controller;

use App\Entity\Detallespedidos;
use App\Entity\Pedidos;
use App\Entity\Platos;
use App\Entity\Usuarios;
use App\Entity\Historialventas;
use App\Entity\Estadospedidos;
use App\Form\DetallespedidosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetallespedidosController extends AbstractController
{
    #[Route('/admin/detallespedidos', name: 'admin_detallespedidos')]
    public function index(EntityManagerInterface $em): Response
    {
        $detallespedidos = $em->getRepository(Detallespedidos::class)->findAll();
        $usuarios = $em->getRepository(Usuarios::class)->findAll();
        $platos = $em->getRepository(Platos::class)->findAll();
        $pedidos = $em->getRepository(Pedidos::class)->findAll();
        $historialventas = $em->getRepository(Historialventas::class)->findAll();
        $estadospedidos = $em->getRepository(Estadospedidos::class)->findAll();

        return $this->render('admin/panel.html.twig', [
            'detallespedidos' => $detallespedidos,
            'usuarios' => $usuarios,
            'platos' => $platos,
            'pedidos' => $pedidos,
            'historialventas' => $historialventas,
            'estadospedidos' => $estadospedidos,
        ]);
    }

    #[Route('/admin/detallespedido/nuevo', name: 'admin_detallespedido_nuevo')]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        $detalle = new Detallespedidos();
        $form = $this->createForm(DetallespedidosType::class, $detalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($detalle);
            $em->flush();
            return $this->redirectToRoute('admin_detallespedidos');
        }

        return $this->render('detallespedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => false,
        ]);
    }

    #[Route('/admin/detallespedido/editar/{id}', name: 'admin_detallespedido_editar')]
    public function editar(Request $request, Detallespedidos $detalle, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(DetallespedidosType::class, $detalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_detallespedidos');
        }

        return $this->render('detallespedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => true,
        ]);
    }

    #[Route('/admin/detallespedido/eliminar/{id}', name: 'admin_detallespedido_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, Detallespedidos $detalle, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detalle->getId(), $request->request->get('_token'))) {
            $em->remove($detalle);
            $em->flush();
        }
        return $this->redirectToRoute('admin_detallespedidos');
    }
}
