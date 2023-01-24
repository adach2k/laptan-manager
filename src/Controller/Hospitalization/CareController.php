<?php

namespace App\Controller\Hospitalization;

use App\Entity\Hospitalization\Care;
use App\Form\Hospitalization\CareType;
use App\Repository\Hospitalization\CareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("gestion-hospitalization/soin")
 */
class CareController extends AbstractController
{

    /**
     * @Route("/", name="care.index")
     */
    public function index(CareRepository $repository)
    {
        return $this->render('hospitalization/care/index.html.twig', [
            'cares' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="care.new")
     */
    public function new(Request $request)
    {
        $care = new Care();
        $form = $this->createForm(CareType::class, $care);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($care);
            $manager->flush();

            return $this->redirectToRoute('care.index');
        }
        
        return $this->render('hospitalization/care/new.html.twig', [
            'care' => $care,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="care.edit", methods="GET|POST")
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $care = $manager->getRepository(Care::class)->find($id);
        $form = $this->createForm(CareType::class, $care);
        $form->handleRequest($request);

        if (!$care) {
            throw $this->createNotFoundException('Y a pas un care avec cet identifiant' . $id);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('care.index');
        }

        return $this->render('hospitalization/care/edit.html.twig', [
            'form'  =>  $form->createView(),
            'care'  =>  $care,
        ]);
    }

    /**
     * @Route("/{id}", name="care.show", methods={"GET"})
     */
    public function show(Care $care)
    {
        return $this->render('hospitalization/care/show.html.twig', [
            'care' => $care,
        ]);
    }

    /**
     * @Route("/{id}", name="care.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $care = $manager->getRepository(Care::class)->find($id);

        if ($this->isCsrfTokenValid('delete' . $care->getId(), $request->get('_token'))) {
            $manager->remove($care);
            $manager->flush();
        }
        return $this->redirectToRoute('care.index');
    }
}
