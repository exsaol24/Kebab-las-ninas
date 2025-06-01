<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PerfilType;
use App\Entity\Usuarios;

final class UsuariosController extends AbstractController
{
    #[Route('/usuarios', name: 'app_usuarios')]
    public function index(): Response
    {
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }

    #[Route('/perfil/editar/{id}', name: 'perfil_editar')]
    public function editarPerfil(
        int $id,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // Busca el usuario por ID
        $usuario = $em->getRepository(Usuarios::class)->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $form = $this->createForm(PerfilType::class, $usuario);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $usuario->setContrasena($plainPassword); // Cambia esto según tu setter real
            }
            $em->flush();
            $this->addFlash('success', '¡Perfil actualizado correctamente!');
            return $this->redirectToRoute('app_inicio'); // Redirige al inicio
        }

        return $this->render('usuarios/editar_perfil.html.twig', [
            'form' => $form->createView(),
            'usuario' => $usuario,
        ]);
    }
}
