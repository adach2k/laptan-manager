<?php

namespace App\Controller\Place;

use App\Entity\Place\Bed;
use App\Form\Place\BedType;
use App\Repository\Place\BedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/place/bed")
 */
class BedController extends AbstractController
{
    /**
     * @Route("/", name="place_bed_index", methods={"GET"})
     */
    public function index(BedRepository $bedRepository): Response
    {
        return $this->render('place/bed/index.html.twig', [
            'beds' => $bedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="place_bed_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bed = new Bed();
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $bed->setDisponible(true);
            $entityManager->persist($bed);
            $entityManager->flush();

            return $this->redirectToRoute('place_bed_index');
        }

        return $this->render('place/bed/new.html.twig', [
            'bed' => $bed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="place_bed_show", methods={"GET"})
     */
    public function show(Bed $bed): Response
    {
        return $this->render('place/bed/show.html.twig', [
            'bed' => $bed,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="place_bed_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bed $bed): Response
    {
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('place_bed_index');
        }

        return $this->render('place/bed/edit.html.twig', [
            'bed' => $bed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="place_bed_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bed $bed): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bed->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('place_bed_index');
    }
}
