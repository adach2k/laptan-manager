<?php

namespace App\Controller\Place;

use App\Entity\Place\Bedroom;
use App\Form\Place\BedroomType;
use App\Repository\Place\BedroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/place/bedroom")
 */
class BedroomController extends AbstractController
{
    /**
     * @Route("/", name="place_bedroom_index", methods={"GET"})
     */
    public function index(BedroomRepository $bedroomRepository): Response
    {
        return $this->render('place/bedroom/index.html.twig', [
            'bedrooms' => $bedroomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="place_bedroom_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bedroom = new Bedroom();
        $form = $this->createForm(BedroomType::class, $bedroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bedroom);
            $entityManager->flush();

            return $this->redirectToRoute('place_bedroom_index');
        }

        return $this->render('place/bedroom/new.html.twig', [
            'bedroom' => $bedroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="place_bedroom_show", methods={"GET"})
     */
    public function show(Bedroom $bedroom): Response
    {
        return $this->render('place/bedroom/show.html.twig', [
            'bedroom' => $bedroom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="place_bedroom_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bedroom $bedroom): Response
    {
        $form = $this->createForm(BedroomType::class, $bedroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('place_bedroom_index');
        }

        return $this->render('place/bedroom/edit.html.twig', [
            'bedroom' => $bedroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="place_bedroom_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bedroom $bedroom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bedroom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bedroom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('place_bedroom_index');
    }
}
