<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ModuleGestionBundle\Entity\Theme;
use ModuleGestionBundle\Form\ThemeType;

/**
 * Theme controller.
 *
 */
class ThemeController extends Controller
{
    /**
     * Lists all Theme entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $themes = $em->getRepository('ModuleGestionBundle:Theme')->findAll();

        return $this->render('theme/index.html.twig', array(
            'themes' => $themes,
        ));
    }

    /**
     * Creates a new Theme entity.
     *
     */
    public function newAction(Request $request)
    {
        $theme = new Theme();
        $form = $this->createForm('ModuleGestionBundle\Form\ThemeType', $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('exposition_new', array('idT' => $theme->getId()));
        }

        return $this->render('theme/new.html.twig', array(
            'theme' => $theme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Theme entity.
     *
     */
    public function showAction(Theme $theme)
    {
        $deleteForm = $this->createDeleteForm($theme);

        return $this->render('theme/show.html.twig', array(
            'theme' => $theme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Theme entity.
     *
     */
    public function editAction(Request $request, Theme $theme)
    {
        $deleteForm = $this->createDeleteForm($theme);
        $editForm = $this->createForm('ModuleGestionBundle\Form\ThemeType', $theme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('theme_edit', array('id' => $theme->getId()));
        }

        return $this->render('theme/edit.html.twig', array(
            'theme' => $theme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Theme entity.
     *
     */
    public function deleteAction(Request $request, Theme $theme)
    {
        $form = $this->createDeleteForm($theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($theme);
            $em->flush();
        }

        return $this->redirectToRoute('theme_index');
    }

    /**
     * Creates a form to delete a Theme entity.
     *
     * @param Theme $theme The Theme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Theme $theme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('theme_delete', array('id' => $theme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
