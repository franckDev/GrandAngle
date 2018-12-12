<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ModuleGestionBundle\Entity\Auteur;
use ModuleGestionBundle\Form\AuteurType;

/**
 * Auteur controller.
 *
 */
class AuteurController extends Controller
{
    /**
     * Lists all Auteur entities.
     *
     */
    public function indexAction()
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        $em = $this->getDoctrine()->getManager();

        $auteurs = $em->getRepository('ModuleGestionBundle:Auteur')->findAll();
        return $this->render('auteur/index.html.twig', array(
            'auteurs' => $auteurs,
            'role' => $role,
        ));
    }

    /**
     * Creates a new Auteur entity.
     *
     */
    public function newAction(Request $request)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        $auteur = new Auteur();
        $form = $this->createForm('ModuleGestionBundle\Form\AuteurType', $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($auteur);
            $em->flush();
            return $this->redirectToRoute('exposition_new', array('idA' => $auteur->getId()));
        }

        return $this->render('auteur/new.html.twig', array(
            'auteur' => $auteur,
            'form' => $form->createView(),
            'role' => $role,
        ));
    }

    /**
     * Finds and displays a Auteur entity.
     *
     */
    public function showAction(Auteur $auteur)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        $deleteForm = $this->createDeleteForm($auteur);

        return $this->render('auteur/show.html.twig', array(
            'auteur' => $auteur,
            'delete_form' => $deleteForm->createView(),
            'role' => $role,
        ));
    }

    /**
     * Displays a form to edit an existing Auteur entity.
     *
     */
    public function editAction(Request $request, Auteur $auteur)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        $deleteForm = $this->createDeleteForm($auteur);
        $editForm = $this->createForm('ModuleGestionBundle\Form\AuteurType', $auteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($auteur);
            $em->flush();

            return $this->redirectToRoute('auteur_edit', array('id' => $auteur->getId()));
        }

        return $this->render('auteur/edit.html.twig', array(
            'auteur' => $auteur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'role' => $role,
        ));
    }

    /**
     * Deletes a Auteur entity.
     *
     */
    public function deleteAction(Request $request, Auteur $auteur)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        $form = $this->createDeleteForm($auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($auteur);
            $em->flush();
        }

        return $this->redirectToRoute('auteur_index');
    }

    /**
     * Creates a form to delete a Auteur entity.
     *
     * @param Auteur $auteur The Auteur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Auteur $auteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('auteur_delete', array('id' => $auteur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
