<?php

namespace App\Controller\Hospitalization;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Hospitalization\Hospitalization;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Hospitalization\HospitalizationType;
use App\Repository\Hospitalization\HospitalizationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("gestion-hospitalization/hospitalization")
 */
class HospitalizationController extends AbstractController
{

    /**
     * @Route("/", name="hospitalization.index")
     */
    public function index(HospitalizationRepository $repository)
    {
        return $this->render('hospitalization/hospitalization/index.html.twig', [
            'hospitalizations'  =>  $repository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new", name="hospitalization.new")
     */
    public function new(Request $request)
    {
        $hospitalization = new Hospitalization();
        $form = $this->createForm(HospitalizationType::class, $hospitalization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hospitalization);
            $manager->flush();

            return $this->redirectToRoute('hospitalization.index');
        }

        return $this->render('hospitalization/hospitalization/new.html.twig', [
            'hospitalization'   => $hospitalization,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hospitalization.edit", methods="GET|POST")
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $hospitalization = $manager->getRepository(Hospitalization::class)->find($id);
        $form = $this->createForm(HospitalizationType::class, $hospitalization);
        $form->handleRequest($request);

        if (!$hospitalization) {
            throw $this->createNotFoundException('Y a pas un hospitalization avec cet identifiant' . $id);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('hospitalization.index');
        }

        return $this->render('hospitalization/hospitalization/edit.html.twig', [
            'form'              =>  $form->createView(),
            'hospitalization'   =>  $hospitalization,
        ]);
    }

    /**
     * @Route("/{id}", name="hospitalization.show", methods={"GET"})
     */
    public function show(Hospitalization $hospitalization)
    {
        return $this->render('hospitalization/hospitalization/show.html.twig', [
            'hospitalization' => $hospitalization,
        ]);
    }

    /**
     * @Route("/{id}", name="hospitalization.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $hospitalization = $manager->getRepository(Hospitalization::class)->find($id);

        if ($this->isCsrfTokenValid('delete' . $hospitalization->getId(), $request->get('_token'))) {
            $manager->remove($hospitalization);
            $manager->flush();
        }
        return $this->redirectToRoute('hospitalization.index');
    }
}
