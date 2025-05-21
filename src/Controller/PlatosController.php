<?php

namespace App\Controller;

use App\Entity\Platos;
use App\Entity\Usuarios;
use App\Form\PlatosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class PlatosController extends AbstractController
{
    #[Route('/platos', name: 'app_platos')]
    public function index(): Response
    {
        return $this->render('platos/index.html.twig', [
            'controller_name' => 'PlatosController',
        ]);
    }

    #[Route('/admin/platos', name: 'admin_platos')]
    public function adminIndex(EntityManagerInterface $em): Response
    {
        $platos = $em->getRepository(Platos::class)->findAll();
        $usuarios = $em->getRepository(Usuarios::class)->findAll();
        $pedidos = $em->getRepository(\App\Entity\Pedidos::class)->findAll();
        return $this->render('admin/panel.html.twig', [
            'platos' => $platos,
            'usuarios' => $usuarios,
            'pedidos' => $pedidos,
        ]);
    }

    #[Route('/admin/plato/nuevo', name: 'admin_plato_nuevo')]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        $plato = new Platos();
        $form = $this->createForm(PlatosType::class, $plato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagen = $form->get('imagen')->getData();
            if ($imagen) {
                $nuevoNombre = uniqid().'.'.$imagen->guessExtension();
                try {
                    $imagen->move(
                        $this->getParameter('platos_images_directory'),
                        $nuevoNombre
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error al subir la imagen');
                }
                $plato->setImagen($nuevoNombre);
            }
            $em->persist($plato);
            $em->flush();
            return $this->redirectToRoute('admin_platos');
        }

        return $this->render('platos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => false,
        ]);
    }

    #[Route('/admin/plato/editar/{id}', name: 'admin_plato_editar')]
    public function editar(Request $request, Platos $plato, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PlatosType::class, $plato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagen = $form->get('imagen')->getData();
            if ($imagen) {
                $nuevoNombre = uniqid().'.'.$imagen->guessExtension();
                try {
                    $imagen->move(
                        $this->getParameter('platos_images_directory'),
                        $nuevoNombre
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error al subir la imagen');
                }
                $plato->setImagen($nuevoNombre);
            }
            $em->flush();
            return $this->redirectToRoute('admin_platos');
        }

        return $this->render('platos/form.html.twig', [
            'form' => $form->createView(),
            'editar' => true,
        ]);
    }

    #[Route('/admin/plato/eliminar/{id}', name: 'admin_plato_eliminar', methods: ['POST'])]
    public function eliminar(Request $request, Platos $plato, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plato->getId(), $request->request->get('_token'))) {
            $em->remove($plato);
            $em->flush();
        }
        return $this->redirectToRoute('admin_platos');
    }
}
