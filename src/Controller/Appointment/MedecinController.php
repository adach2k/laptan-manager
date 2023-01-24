<?php

namespace App\Controller\Appointment;

use App\Entity\Appointment\Medecin;
use App\Form\Appointment\MedecinType;
use App\Repository\Appointment\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("manage/doctor")
 */
class MedecinController extends AbstractController
{

    /**
     * @Route("/", name="doctor.index")
     */
    public function index(MedecinRepository $repository)
    {
        return $this->render('appointment/medecin/index.html.twig', [
            'doctors'  => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="doctor.new")
     */
    public function new(Request $request)
    {
        $doctor = new Medecin();
        $form = $this->createForm(MedecinType::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($doctor);
            $manager->flush();

            return $this->redirectToRoute('appointment.new');
        }
        return $this->render('appointment/medecin/new.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="doctor.show", methods={"GET"})
     */
    public function show(Medecin $doctor)
    {
        return $this->render('appointment/medecin/show.html.twig', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="doctor.edit", methods="GET|POST")
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $doctor = $manager->getRepository(Medecin::class)->find($id);
        $form = $this->createForm(MedecinType::class, $doctor);
        $form->handleRequest($request);

        if (!$doctor) {
            throw $this->createNotFoundException('Y a pas un medecin avec cet identifiant' . $id);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('doctor.index');
        }

        return $this->render('appointment/medecin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="doctor.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $doctor = $manager->getRepository(Medecin::class)->find($id);

        if ($this->isCsrfTokenValid('delete' . $doctor->getId(), $request->get('_token'))) {
            $manager->remove($doctor);
            $manager->flush();
        }
        return $this->redirectToRoute('doctor.index');
    }
}
