<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ModuleGestionBundle\Entity\Organisateur;
use ModuleGestionBundle\Form\OrganisateurType;

/**
 * Organisateur controller.
 *
 */
class OrganisateurController extends Controller
{
    /**
     * Lists all Organisateur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organisateurs = $em->getRepository('ModuleGestionBundle:Organisateur')->findAll();

        return $this->render('organisateur/index.html.twig', array(
            'organisateurs' => $organisateurs,
        ));
    }

    /**
     * Creates a new Organisateur entity.
     *
     */
    public function newAction(Request $request)
    {
        $organisateur = new Organisateur();
        $form = $this->createForm('ModuleGestionBundle\Form\OrganisateurType', $organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organisateur);
            $em->flush();

            return $this->redirectToRoute('organisateur_show', array('id' => $organisateur->getId()));
        }

        return $this->render('organisateur/new.html.twig', array(
            'organisateur' => $organisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Organisateur entity.
     *
     */
    public function showAction(Organisateur $organisateur)
    {
        $deleteForm = $this->createDeleteForm($organisateur);

        return $this->render('organisateur/show.html.twig', array(
            'organisateur' => $organisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Organisateur entity.
     *
     */
    public function editAction(Request $request, Organisateur $organisateur)
    {
        $deleteForm = $this->createDeleteForm($organisateur);
        $editForm = $this->createForm('ModuleGestionBundle\Form\OrganisateurType', $organisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organisateur);
            $em->flush();

            return $this->redirectToRoute('organisateur_edit', array('id' => $organisateur->getId()));
        }

        return $this->render('organisateur/edit.html.twig', array(
            'organisateur' => $organisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Organisateur entity.
     *
     */
    public function deleteAction(Request $request, Organisateur $organisateur)
    {
        $form = $this->createDeleteForm($organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organisateur);
            $em->flush();
        }

        return $this->redirectToRoute('organisateur_index');
    }

    /**
     * Creates a form to delete a Organisateur entity.
     *
     * @param Organisateur $organisateur The Organisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Organisateur $organisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organisateur_delete', array('id' => $organisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
