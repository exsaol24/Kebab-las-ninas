<?php

namespace App\Controller;

use App\Entity\Reserva;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservaController extends AbstractController
{
    #[Route('/reserva-mesa', name: 'reserva_mesa', methods: ['POST'])]
    public function reservar(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $nombre = $request->request->get('nombre');
        $telefono = $request->request->get('telefono');
        $personas = $request->request->get('personas');
        $fecha = $request->request->get('fecha');
        $hora = $request->request->get('hora');

        // Validación básica de hora (19:00 a 02:00)
        $horaObj = \DateTime::createFromFormat('H:i', $hora);
        $horaInt = (int)$horaObj->format('H');
        $minutos = (int)$horaObj->format('i');

        // Validar rango y múltiplo de 15 minutos
        $isValidHour = (
            (($horaInt >= 19 && $horaInt <= 23) || ($horaInt >= 0 && $horaInt < 2))
            && ($minutos % 15 === 0)
        );

        if (!$isValidHour) {
            return new JsonResponse([
                'success' => false,
                'message' => 'La hora debe estar entre las 19:00 y las 02:00 y en intervalos de 15 minutos.'
            ]);
        }

        $reserva = new Reserva();
        $reserva->setNombre($nombre);
        $reserva->setTelefono($telefono);
        $reserva->setPersonas($personas);
        $reserva->setFecha(new \DateTime($fecha));
        $reserva->setHora($horaObj);

        $em->persist($reserva);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}