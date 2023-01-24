<?php

namespace App\Controller\Hospitalization;

use App\Entity\Hospitalization\TypeCare;
use App\Form\Hospitalization\TypeCareType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("gestion-hospitalization/type-soin")
 */
class TypeCareController extends AbstractController
{
    /**
     * @Route("/", name="type.index")
     */
    public function index(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $types = $manager->getRepository(TypeCare::class)->findAll();
        $type = new TypeCare();
        $form = $this->createForm(TypeCareType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($type);
            $manager->flush();

            return $this->redirectToRoute('type.index');
        }

        return $this->render('hospitalization/type_care/index.html.twig', [
            'types' => $types,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type.show", methods={"GET"})
     */
    public function show(TypeCare $type)
    {
        return $this->render('appointment/type_care/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type.edit", methods="GET|POST")
     */
    public function edit(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $type = $manager->getRepository(TypeCare::class)->find($id);
        $form = $this->createForm(TypeCareType::class, $type);
        $form->handleRequest($request);

        if (!$type) {
            throw $this->createNotFoundException('Y a pas un type avec cet identifiant' . $id);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('type.index');
        }

        return $this->render('hospitalization/type_care/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type.delete", methods="DELETE")
     */
    public function delete(Request $request, int $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $type = $manager->getRepository(TypeCare::class)->find($id);

        if ($this->isCsrfTokenValid('delete' . $type->getId(), $request->get('_token'))) {
            $manager->remove($type);
            $manager->flush();
        }
        return $this->redirectToRoute('type.index');
    }
}
