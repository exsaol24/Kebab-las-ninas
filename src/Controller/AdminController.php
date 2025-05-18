<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Entity\Platos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_panel')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        if (!$session->get('es_admin')) {
            throw $this->createAccessDeniedException('Acceso solo para administradores.');
        }

        $usuarios = $em->getRepository(Usuarios::class)->findAll();
        $platos = $em->getRepository(Platos::class)->findAll();

        return $this->render('admin/panel.html.twig', [
            'usuarios' => $usuarios,
            'platos' => $platos,
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
}
