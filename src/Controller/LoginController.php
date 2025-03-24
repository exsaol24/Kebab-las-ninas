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
        $error = null; // Inicializar la variable de error

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Buscar el usuario en la base de datos
            $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $email]);

            // Verificar si el usuario existe y la contraseña coincide
            if ($usuario && $usuario->getContrasena() === $password) {
                return $this->redirectToRoute('app_inicio'); // Redirige al índice del inicio
            }

            // Asignar el mensaje de error si las credenciales son inválidas
            $error = 'Credenciales inválidas.';
        }

        return $this->render('login/index.html.twig', [
            'error' => $error, // Pasar el error a la plantilla
        ]);
    }
}
