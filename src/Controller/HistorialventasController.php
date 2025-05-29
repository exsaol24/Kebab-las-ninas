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
