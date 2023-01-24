<?php

namespace App\Controller\Appointment;

use App\Entity\Appointment\Appointment;
use App\Form\Appointment\AppointmentType;
use App\Repository\Appointment\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("manage/appointment")
 */
class AppointmentController extends AbstractController
{
    /**
     * @Route("/", name="appointment.index")
     */
    public function index(AppointmentRepository $repository)
    {
        return $this->render('appointment/appointment/index.html.twig', [
            'appointments'  => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="appointment.new")
     */
    public function new(Request $request)
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($appointment);
            $manager->flush();

            return $this->redirectToRoute('appointment.index');
        }
        return $this->render('appointment/Appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appointment.show", methods={"GET"})
     */
    public function show(Appointment $appointment)
    {
        return $this->render('appointment/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="appointment.edit", methods="GET|POST")
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $appointment = $manager->getRepository(Appointment::class)->find($id);
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if (!$appointment) {
            throw $this->createNotFoundException('Y a pas un rendez-vous avec cet identifiant' . $id);
        }

        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('appointment.index');
        }

        return $this->render('appointment/appointment/edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="appointment.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $appointment = $manager->getRepository(Appointment::class)->find($id);

        if($this->isCsrfTokenValid('delete' . $appointment->getId(), $request->get('_token'))) {
            $manager->remove($appointment);
            $manager->flush();
        }
        return $this->redirectToRoute('appointment.index');
    }
}
