<?php

namespace App\Controller;

use App\Entity\Usuarios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
public function index(Request $request): Response
{
    $error = null;

    if ($request->isMethod('POST')) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // Buscar el usuario en la base de datos
        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $email]);

        // Verificar si el usuario existe, está verificado y la contraseña coincide
        if ($usuario && $usuario->getContrasena() === $password && $usuario->isVerificado() == 1) {
            // Guardar el nombre del usuario en la sesión
            $session = $request->getSession();
            $session->set('user_name', $usuario->getNombre());

            return $this->redirectToRoute('app_inicio');
        }

        $error = 'Credenciales inválidas.';
    }

    return $this->render('login/index.html.twig', [
        'error' => $error,
    ]);
    
}
#[Route('/logout', name: 'app_logout', methods: ['GET'])]
public function logout(Request $request): Response
{
    // Obtener la sesión y limpiarla
    $session = $request->getSession();
    $session->clear();

    return $this->redirectToRoute('app_login');
}
}
