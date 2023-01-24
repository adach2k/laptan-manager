<?php

namespace App\Controller\Appointment;

use App\Entity\Appointment\Patient;
use App\Form\Appointment\PatientType;
use App\Repository\Appointment\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("manage/patient")
 */
class PatientController extends AbstractController
{

    /**
     * @Route("/", name="patient.index")
     */
    public function index(PatientRepository $repository)
    {
        return $this->render('appointment/patient/index.html.twig', [
            'patients' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="patient.new")
     */
    public function new(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $code = substr(uniqid(), -7, -1);
            $patient->setCode(strtoupper($code));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($patient);
            $manager->flush();

            return $this->redirectToRoute('appointment.new');
        }

        return $this->render('appointment/patient/new.html.twig', [
            'patient' => $patient,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient.show", methods={"GET"})
     */
    public function show(Patient $patient)
    {
        return $this->render('appointment/patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patient.edit", methods="GET|POST")
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $patient = $manager->getRepository(Patient::class)->find($id);
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if (!$patient) {
            throw $this->createNotFoundException('Y a pas un patient avec cet identifiant' . $id);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('patient.index');
        }

        return $this->render('appointment/patient/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{id}", name="patient.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $patient = $manager->getRepository(Patient::class)->find($id);

        if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->get('_token'))) {
            $manager->remove($patient);
            $manager->flush();
        }
        return $this->redirectToRoute('patient.index');
    }
}
