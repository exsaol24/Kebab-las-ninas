<?php

namespace App\Controller;

use App\Entity\Estadospedidos;
use App\Entity\Historialventas;
use App\Entity\Pedidos;
use App\Entity\Platos;
use App\Entity\Usuarios;
use App\Form\EstadospedidosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstadospedidosController extends AbstractController
{
    #[Route('/admin/estadospedidos', name: 'admin_estadospedidos')]
    public function index(EntityManagerInterface $em): Response
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

    #[Route('/admin/estadopedido/nuevo', name: 'admin_estadopedido_nuevo')]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        $estado = new Estadospedidos();
        $form = $this->createForm(EstadospedidosType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($estado);
            $em->flush();
            return $this->redirectToRoute('admin_estadospedidos');
        }

        return $this->render('estadospedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => false,
        ]);
    }

    #[Route('/admin/estadopedido/editar/{id}', name: 'admin_estadopedido_editar')]
    public function editar(Request $request, Estadospedidos $estado, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EstadospedidosType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_estadospedidos');
        }

        return $this->render('estadospedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => true,
        ]);
    }

    #[Route('/admin/estadopedido/eliminar/{id}', name: 'admin_estadopedido_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, Estadospedidos $estado, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estado->getId(), $request->request->get('_token'))) {
            $em->remove($estado);
            $em->flush();
        }
        return $this->redirectToRoute('admin_estadospedidos');
    }
}
