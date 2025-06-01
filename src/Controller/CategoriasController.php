<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Form\CategoriasType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoriasController extends AbstractController
{
    #[Route('/admin/categorias', name: 'admin_categorias')]
    public function index(EntityManagerInterface $em): Response
    {
        $usuarios = $em->getRepository(\App\Entity\Usuarios::class)->findAll();
        $platos = $em->getRepository(\App\Entity\Platos::class)->findAll();
        $pedidos = $em->getRepository(\App\Entity\Pedidos::class)->findAll();
        $historialventas = $em->getRepository(\App\Entity\Historialventas::class)->findAll();
        $estadospedidos = $em->getRepository(\App\Entity\Estadospedidos::class)->findAll();
        $detallespedidos = $em->getRepository(\App\Entity\Detallespedidos::class)->findAll();
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

    #[Route('/admin/categoria/nuevo', name: 'admin_categoria_nuevo')]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        $categoria = new Categorias();
        $form = $this->createForm(CategoriasType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categoria);
            $em->flush();
            return $this->redirectToRoute('admin_categorias');
        }

        return $this->render('categorias/form.html.twig', [
            'form' => $form->createView(),
            'editar' => false,
        ]);
    }

    #[Route('/admin/categoria/editar/{id}', name: 'admin_categoria_editar')]
    public function editar(Request $request, Categorias $categoria, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoriasType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_categorias');
        }

        return $this->render('categorias/form.html.twig', [
            'form' => $form->createView(),
            'editar' => true,
        ]);
    }

    #[Route('/admin/categoria/eliminar/{id}', name: 'admin_categoria_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, Categorias $categoria, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoria->getId(), $request->request->get('_token'))) {
            $em->remove($categoria);
            $em->flush();
        }
        return $this->redirectToRoute('admin_categorias');
    }
}
