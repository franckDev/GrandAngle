<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ModuleGestionBundle\Entity\Emplacement;
use ModuleGestionBundle\Form\EmplacementType;

/**
 * Emplacement controller.
 *
 */
class EmplacementController extends Controller
{
    /**
     * Lists all Emplacement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $emplacements = $em->getRepository('ModuleGestionBundle:Emplacement')->findAll();

        return $this->render('emplacement/index.html.twig', array(
            'emplacements' => $emplacements,
        ));
    }

    /**
     * Creates a new Emplacement entity.
     *
     */
    public function newAction(Request $request)
    {
        $emplacement = new Emplacement();
        $form = $this->createForm('ModuleGestionBundle\Form\EmplacementType', $emplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emplacement);
            $em->flush();

            return $this->redirectToRoute('emplacement_show', array('id' => $emplacement->getId()));
        }

        return $this->render('emplacement/new.html.twig', array(
            'emplacement' => $emplacement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Emplacement entity.
     *
     */
    public function showAction(Emplacement $emplacement)
    {
        $deleteForm = $this->createDeleteForm($emplacement);

        return $this->render('emplacement/show.html.twig', array(
            'emplacement' => $emplacement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Emplacement entity.
     *
     */
    public function editAction(Request $request, Emplacement $emplacement)
    {
        $deleteForm = $this->createDeleteForm($emplacement);
        $editForm = $this->createForm('ModuleGestionBundle\Form\EmplacementType', $emplacement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emplacement);
            $em->flush();

            return $this->redirectToRoute('emplacement_edit', array('id' => $emplacement->getId()));
        }

        return $this->render('emplacement/edit.html.twig', array(
            'emplacement' => $emplacement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Emplacement entity.
     *
     */
    public function deleteAction(Request $request, Emplacement $emplacement)
    {
        $form = $this->createDeleteForm($emplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emplacement);
            $em->flush();
        }

        return $this->redirectToRoute('emplacement_index');
    }

    /**
     * Creates a form to delete a Emplacement entity.
     *
     * @param Emplacement $emplacement The Emplacement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Emplacement $emplacement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emplacement_delete', array('id' => $emplacement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
