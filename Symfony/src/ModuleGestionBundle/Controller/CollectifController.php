<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ModuleGestionBundle\Entity\Collectif;
use ModuleGestionBundle\Form\CollectifType;

/**
 * Collectif controller.
 *
 */
class CollectifController extends Controller
{
    /**
     * Lists all Collectif entities.
     *
     */
    public function indexAction()
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $em = $this->getDoctrine()->getManager();

        $collectifs = $em->getRepository('ModuleGestionBundle:Collectif')->findAll();

        return $this->render('collectif/index.html.twig', array(
            'collectifs' => $collectifs,
            'role' => $role,
        ));
    }

    /**
     * Creates a new Collectif entity.
     *
     */
    public function newAction(Request $request)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $collectif = new Collectif();
        $form = $this->createForm('ModuleGestionBundle\Form\CollectifType', $collectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($collectif);
            $em->flush();

            return $this->redirectToRoute('exposition_new', array('idC' => $collectif->getId()));
        }

        return $this->render('collectif/new.html.twig', array(
            'collectif' => $collectif,
            'form' => $form->createView(),
            'role' => $role,
        ));
    }

    /**
     * Finds and displays a Collectif entity.
     *
     */
    public function showAction(Collectif $collectif)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $deleteForm = $this->createDeleteForm($collectif);

        return $this->render('collectif/show.html.twig', array(
            'collectif' => $collectif,
            'delete_form' => $deleteForm->createView(),
            'role' => $role,
        ));
    }

    /**
     * Displays a form to edit an existing Collectif entity.
     *
     */
    public function editAction(Request $request, Collectif $collectif)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $deleteForm = $this->createDeleteForm($collectif);
        $editForm = $this->createForm('ModuleGestionBundle\Form\CollectifType', $collectif);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($collectif);
            $em->flush();

            return $this->redirectToRoute('collectif_edit', array('id' => $collectif->getId()));
        }

        return $this->render('collectif/edit.html.twig', array(
            'collectif' => $collectif,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'role' => $role,
        ));
    }

    /**
     * Deletes a Collectif entity.
     *
     */
    public function deleteAction(Request $request, Collectif $collectif)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $form = $this->createDeleteForm($collectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($collectif);
            $em->flush();
        }

        return $this->redirectToRoute('collectif_index');
    }

    /**
     * Creates a form to delete a Collectif entity.
     *
     * @param Collectif $collectif The Collectif entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Collectif $collectif)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('collectif_delete', array('id' => $collectif->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
