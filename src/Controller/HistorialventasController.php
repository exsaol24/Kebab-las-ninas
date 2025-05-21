<?php

namespace App\Controller;

use App\Entity\Historialventas;
use App\Entity\Usuarios;
use App\Entity\Platos;
use App\Entity\Pedidos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HistorialventasController extends AbstractController
{
    #[Route('/admin/historialventas', name: 'admin_historialventas')]
    public function adminIndex(EntityManagerInterface $em): Response
    {
        $historialventas = $em->getRepository(Historialventas::class)->findAll();
        $usuarios = $em->getRepository(Usuarios::class)->findAll();
        $platos = $em->getRepository(Platos::class)->findAll();
        $pedidos = $em->getRepository(Pedidos::class)->findAll();

        return $this->render('admin/panel.html.twig', [
            'historialventas' => $historialventas,
            'usuarios' => $usuarios,
            'platos' => $platos,
            'pedidos' => $pedidos,
        ]);
    }

    #[Route('/admin/historialventa/editar/{id}', name: 'admin_historialventa_editar')]
    public function editar(Request $request, Historialventas $historialventa, EntityManagerInterface $em): Response
    {
       
        return $this->redirectToRoute('admin_historialventas');
    }

    #[Route('/admin/historialventa/eliminar/{id}', name: 'admin_historialventa_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, Historialventas $historialventa, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historialventa->getId(), $request->request->get('_token'))) {
            $em->remove($historialventa);
            $em->flush();
        }
        return $this->redirectToRoute('admin_historialventas');
    }
}
