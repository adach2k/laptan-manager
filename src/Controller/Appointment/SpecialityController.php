<?php

namespace App\Controller\Appointment;

use App\Entity\Appointment\Speciality;
use App\Form\Appointment\SpecialityType;
use App\Repository\Appointment\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("manage/specialty")
 */
class SpecialityController extends AbstractController
{
    /**
     * @Route("/", name="specialty.index")
     */
    public function index(Request $request, SpecialityRepository $repository)
    {
        $specialty = new Speciality();
        $form = $this->createForm(SpecialityType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($specialty);
            $manager->flush();

            return $this->redirectToRoute('specialty.index');
        }
        
        return $this->render('appointment/speciality/index.html.twig', [
            'specialties' => $repository->findAll(),
            'specialty' => $specialty,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specialty.edit", methods={"GET|POST"})
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $specialty = $manager->getRepository(Speciality::class)->find($id);
        $form = $this->createForm(SpecialityType::class, $specialty);
        $form->handleRequest($request);

        if (!$specialty) {
            throw $this->createNotFoundException('Y a pas une specialité avec cet identifiant' . $id);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('specialty.index');
        }

        return $this->render('appointment/speciality/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specialty.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $specialty = $manager->getRepository(Speciality::class)->find($id);

        if ($this->isCsrfTokenValid('delete' . $specialty->getId(), $request->get('_token'))) {
            $manager->remove($specialty);
            $manager->flush();
        }
        return $this->redirectToRoute('specialty.index');
    }
}
