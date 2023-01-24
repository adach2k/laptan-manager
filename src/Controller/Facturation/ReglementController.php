<?php

namespace App\Controller\Facturation;

use App\Entity\Facturation\Reglement;
use App\Form\Facturation\ReglementType;
use App\Repository\Facturation\ReglementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facturation/reglement")
 */
class ReglementController extends AbstractController
{
    /**
     * @Route("/", name="facturation_reglement_index", methods={"GET"})
     */
    public function index(ReglementRepository $reglementRepository): Response
    {
        return $this->render('facturation/reglement/index.html.twig', [
            'reglements' => $reglementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="facturation_reglement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reglement = new Reglement();
        $form = $this->createForm(ReglementType::class, $reglement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $montantRestant = $reglement->getMontantPaye() - $reglement->getFacture()->getMontantTotal();
            $reglement->setCode(substr(uniqid(), 5, 6));
            $reglement->setMontantRestant($montantRestant);
            if($montantRestant >= 0) {
                $reglement->setEtat(true);
            } else {
                $reglement->setEtat(false);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reglement);
            $entityManager->flush();

            return $this->redirectToRoute('facturation_reglement_index');
        }

        return $this->render('facturation/reglement/new.html.twig', [
            'reglement' => $reglement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facturation_reglement_show", methods={"GET"})
     */
    public function show(Reglement $reglement): Response
    {
        return $this->render('facturation/reglement/show.html.twig', [
            'reglement' => $reglement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facturation_reglement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reglement $reglement): Response
    {
        $form = $this->createForm(ReglementType::class, $reglement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $montantRestant = $reglement->getMontantPaye() + $reglement->getMontantRestant();
            if ($montantRestant >= 0) {
                $reglement->setEtat(true);
                $reglement->setMontantPaye($reglement->getFacture()->getMontantTotal());
            } else {
                $reglement->setEtat(false);
            }
            $reglement->setMontantRestant($montantRestant);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facturation_reglement_index');
        }

        return $this->render('facturation/reglement/edit.html.twig', [
            'reglement' => $reglement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facturation_reglement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reglement $reglement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reglement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reglement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facturation_reglement_index');
    }
}
