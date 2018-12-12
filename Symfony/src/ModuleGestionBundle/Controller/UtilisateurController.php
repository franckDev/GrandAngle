<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

use ModuleGestionBundle\Entity\Utilisateur;
use ModuleGestionBundle\Entity\Telephone;

use ModuleGestionBundle\Form\UtilisateurType;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all Utilisateur entities.
     *
     */
    public function indexAction()
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        // Si l'utilisateur n'est pas ADMIN 
        if($role == "USER"){
            return $this->redirectToRoute('module_gestion_index');
        }   

        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('ModuleGestionBundle:Utilisateur')->findAll();

        return $this->render('utilisateur/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
            'role' => $role,
        ));
    }

    /**
     * Creates a new Utilisateur entity.
     *
     */
    public function newAction(Request $request)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        // Si l'utilisateur n'est pas ADMIN 
        if($role == "USER"){
            return $this->redirectToRoute('module_gestion_index');
        }   

        $utilisateur = new Utilisateur();

        $form = $this->createForm('ModuleGestionBundle\Form\UtilisateurType', $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($utilisateur);

            $em->flush();

            return $this->redirectToRoute('utilisateur_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('utilisateur/new.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'role' => $role,
        ));
    }

    /**
     * Finds and displays a Utilisateur entity.
     *
     */
    public function showAction(Utilisateur $utilisateur)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        // Si l'utilisateur n'est pas ADMIN 
        if($role == "USER"){
            return $this->redirectToRoute('module_gestion_index');
        }   

        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('utilisateur/show.html.twig', array(
            'utilisateur' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
            'role'        => $role,
        ));
    }

    /**
     * Displays a form to edit an existing Utilisateur entity.
     *
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        // Si l'utilisateur n'est pas ADMIN 
        if($role == "USER"){
            return $this->redirectToRoute('module_gestion_index');
        }   

        // On stocke son id
        $id = $utilisateur->getId();

        // On appelle l'entity manager
        $em = $this->getDoctrine()->getManager();

        // On fait une requête pour récupérer les infos de l'utilisateur
        $utilisateur = $em->getRepository('ModuleGestionBundle:Utilisateur')->find($id);

        // Si il n'existe pas on déclenche une erreur
        if(!$utilisateur) {
            throw $this->createNotFoundException('Aucun utilisateur avec l\'id '.$id);
        }

        // On créé un tableau 
        $originalTelephones = new ArrayCollection();

        // On boucle sur l'utilisateur pour récupérer ses numéros existants
        foreach ($utilisateur->getTelephones() as $telephone) {
            $originalTelephones->add($telephone);
        }

        // On prépare le formulaire
        $editForm = $this->createForm('ModuleGestionBundle\Form\UtilisateurType', $utilisateur);

        // On récupère la requête
        $editForm->handleRequest($request);

        // Si le formulaire a été soumi et qu'il est valide
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // On parcourt chacun des numéros existants 
            foreach ($originalTelephones as $telephone) {

                // Si le numéro existant n'est pas contenu dans le formulaire on l'efface
                if(false === $utilisateur->getTelephones()->contains($telephone)) {

                    $em->remove($telephone);
                }    
            }

            // On persist le changement
            $em->persist($utilisateur);
            // On exécute
            $em->flush();

            return $this->redirectToRoute('utilisateur_edit', array(
                'id'   => $id,
                'role' => $role,
            ));
        }
        return $this->render('utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView(),
            'role'        => $role,
        ));
    }
    /**
     * Deletes a Utilisateur entity.
     *
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * Creates a form to delete a Utilisateur entity.
     *
     * @param Utilisateur $utilisateur The Utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateur_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
