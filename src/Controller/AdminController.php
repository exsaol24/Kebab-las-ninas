<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Entity\Platos;
use App\Entity\Pedidos;
use App\Entity\Historialventas;
use App\Entity\Estadospedidos;
use App\Entity\Detallespedidos;
use App\Entity\Categorias;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EstadospedidosType;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_panel')]
    public function index(EntityManagerInterface $em): Response
    {
        $usuarios = $em->getRepository(Usuarios::class)->findAll();
        $platos = $em->getRepository(Platos::class)->findAll();
        $pedidos = $em->getRepository(Pedidos::class)->findAll();
        $historialventas = $em->getRepository(Historialventas::class)->findAll();
        $estadospedidos = $em->getRepository(Estadospedidos::class)->findAll();
        $detallespedidos = $em->getRepository(Detallespedidos::class)->findAll();
        $categorias = $em->getRepository(Categorias::class)->findAll();

        return $this->render('admin/panel.html.twig', [
            'usuarios' => $usuarios,
            'platos' => $platos,
            'pedidos' => $pedidos,
            'historialventas' => $historialventas,
            'estadospedidos' => $estadospedidos,
            'detallespedidos' => $detallespedidos,
            'categorias' => $categorias,
        ]);
    }

    #[Route('/admin/usuario/editar/{id}', name: 'admin_usuario_editar')]
    public function editar(Request $request, EntityManagerInterface $em, $id): Response
    {
        $session = $request->getSession();
        if (!$session->get('es_admin')) {
            throw $this->createAccessDeniedException('Acceso solo para administradores.');
        }

        $usuario = $em->getRepository(Usuarios::class)->find($id);
        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        if ($request->isMethod('POST')) {
            $usuario->setNombre($request->request->get('nombre'));
            $usuario->setEmail($request->request->get('email'));
            $usuario->setDireccion($request->request->get('direccion'));
            $usuario->setTelefono($request->request->get('telefono'));
            $usuario->setAdministrador($request->request->get('administrador', 0));
            $em->flush();

            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('admin/editar_usuario.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    #[Route('/admin/usuario/eliminar/{id}', name: 'admin_usuario_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, EntityManagerInterface $em, $id): Response
    {
        $session = $request->getSession();
        if (!$session->get('es_admin')) {
            throw $this->createAccessDeniedException('Acceso solo para administradores.');
        }

        $usuario = $em->getRepository(Usuarios::class)->find($id);
        if ($usuario) {
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('admin_panel');
    }

    #[Route('/admin/estado-pedido/editar/{id}', name: 'admin_estado_pedido_editar')]
    public function editarEstadoPedido(Request $request, EntityManagerInterface $em, $id): Response
    {
        $session = $request->getSession();
        if (!$session->get('es_admin')) {
            throw $this->createAccessDeniedException('Acceso solo para administradores.');
        }

        $estadoPedido = $em->getRepository(Estadospedidos::class)->find($id);
        if (!$estadoPedido) {
            throw $this->createNotFoundException('Estado de pedido no encontrado');
        }

        $form = $this->createForm(EstadospedidosType::class, $estadoPedido);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('estadospedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => true,
        ]);
    }

    #[Route('/admin/estado-pedido/nuevo', name: 'admin_estado_pedido_nuevo')]
    public function nuevoEstadoPedido(Request $request, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        if (!$session->get('es_admin')) {
            throw $this->createAccessDeniedException('Acceso solo para administradores.');
        }

        $estadoPedido = new Estadospedidos();

        $form = $this->createForm(EstadospedidosType::class, $estadoPedido);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($estadoPedido);
            $em->flush();

            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('estadospedidos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => false,
        ]);
    }
}
