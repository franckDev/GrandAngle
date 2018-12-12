<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use ModuleGestionBundle\Entity\Exposition;
use ModuleGestionBundle\Entity\TextExposition;
use ModuleGestionBundle\Form\ExpositionType;
use ModuleGestionBundle\Entity\Emplacement;
use ModuleGestionBundle\Entity\Oeuvre;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Date as Assert;
use Symfony\Component\Filesystem\Filesystem;
/**
 * Exposition controller.
 *
 */
class ExpositionController extends Controller
{
    /**
     * Lists all Exposition entities.
     *
     */
    public function indexAction(Request $request)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $em = $this->getDoctrine()->getManager();

        $expositions = $em->getRepository('ModuleGestionBundle:Exposition')->findAll();

        $paginator  = $this->get('knp_paginator');

        $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $expositions,
                $request->query->get('page', 1)/*page number*/,
                10/*limit per page*/
            );

        return $this->render('exposition/index.html.twig', array(
            'expositions' => $pagination,
            'role'        => $role,
        ));
    }

    /**
     * Creates a new Exposition entity.
     *
     */
    public function newAction(Request $request)
    {
        // On récupère l'id du thème qu'on vien de créer
        $idTheme = $request->query->get('idT');
        // On récupère l'id du collectif qu'on vien de créer
        $idCollectif = $request->query->get('idC');
        // On récupère l'id de l'auteur qu'on vien de créer
        $idAuteur = $request->query->get('idA');
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $exposition = new Exposition();
        $emplacement = new Emplacement();
        $form = $this->createForm('ModuleGestionBundle\Form\ExpositionType', $exposition);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $id = 0;
            //$this->TestDebugExpoAction($request, $id);

            $file = $request->files->get("exposition")["fichier"];
            // On génère un nom unique pour ce fichier 
            $filename = md5(uniqid()).'.'.$file->getClientOriginalExtension();
            // Fonction pour calculer la taille du fichier
            function taille_fichier($octets) {
                $resultat = $octets;
                for ($i=0; $i < 8 && $resultat >= 1024; $i++) {
                    $resultat = $resultat / 1024;
                }
                if ($i > 0) {
                    return preg_replace('/,00$/', '', number_format($resultat, 2, ',', '')) 
            . ' ' . substr('KMGTPEZY',$i-1,1) . 'o';
                } else {
                    return $resultat . ' o';
                }
            }

            // On déplace ensuite le fichier dans le dossier prévu à cette effet
            $file->move(
                $this->container->getParameter('multimedias_directory'),
                $filename
            );

            $stockage = taille_fichier($file->getClientSize());
            $exposition->setStockage($stockage);
            $exposition->setFichier($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($exposition);
            $em->flush();

            return $this->redirectToRoute('exposition_show', array(
                'id' => $exposition->getId()
            ));
        }

        $em = $this->getDoctrine()->getManager();
        $oeuvres = $em->getRepository('ModuleGestionBundle:Oeuvre')->findAll();

        return $this->render('exposition/new.html.twig', array(
            'exposition' => $exposition,
            'form' => $form->createView(),
            'role' => $role,
            'oeuvres' => $oeuvres,
            'idtheme' => $idTheme,
            'idauteur' => $idAuteur,
            'idcollectif' => $idCollectif,
        ));
    }

    /**
     * Finds and displays a Exposition entity.
     *
     */
    public function showAction(Exposition $exposition)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $deleteForm = $this->createDeleteForm($exposition);
        
        return $this->render('exposition/show.html.twig', array(
            'exposition' => $exposition,
            'delete_form' => $deleteForm->createView(),
            'role'        => $role,
        ));
    }

    /**
     * Displays a form to edit an existing Exposition entity.
     *
     */
    public function editAction(Request $request, Exposition $exposition)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        // On stock son id
        $id = $exposition->getId();
        // On appelle l'entity manager
        $em = $this->getDoctrine()->getManager();
        // On fait une requête pour récupérer les info de l'expo
        $exposition = $em->getRepository('ModuleGestionBundle:Exposition')->find($id);
        // Si il n'existe pas on déclenche une erreur
        if(!$exposition) {
            throw $this->createNotFoundException('Aucune Exposition avec l\'id '.$id);
        }
        // On créé un tableau 
        $originalTextExpositions = new ArrayCollection();
        // On boucle sur l'exposition pour récupérer ses traduction existante
        foreach ($exposition->getTextExpositions() as $textexposition) {
            $originalTextExpositions->add($textexposition);
        }

        // On créé un tableau 
        $originalEmplacements = new ArrayCollection();
        // On boucle sur l'exposition pour récupérer ses traduction existante
        foreach ($exposition->getEmplacements() as $emplacement) {
            $originalEmplacements->add($emplacement);
        }

        $editForm = $this->createForm('ModuleGestionBundle\Form\ExpositionType', $exposition);
        $editForm->remove("fichier");
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // On parcourt chacun des traduction existants 
            foreach ($originalTextExpositions as $textexposition) {

                // Si la traduction existant n'est pas contenu dans le formulaire on l'efface
                if(false === $exposition->getTextExpositions()->contains($textexposition)) {

                    $em->remove($textexposition);
                }    
            }
            foreach ($originalEmplacements as $emplacement) {

                // Si la traduction existant n'est pas contenu dans le formulaire on l'efface
                if(false === $exposition->getEmplacements()->contains($emplacement)) {

                    $em->remove($emplacement);
                }    
            }

            $em->persist($exposition);
            $em->flush();

            return $this->redirectToRoute('exposition_index', array(
                'id' => $id,
            ));
        }

        return $this->render('exposition/edit.html.twig', array(
            'exposition' => $exposition,
            'edit_form' => $editForm->createView(),
            'role'        => $role,
        ));
    }

    /**
     * Deletes a Exposition entity.
     *
     */
    public function deleteAction(Request $request)
    {
        // On récupère le role de la personne connectée
        //$role = $this->getUser()->getRole();
        // Si on reçoit une requête Ajax
        if($request->isXMLHttpRequest())
        {
            // On récupère l'id de l'oeuvre a supprimée
            $id = $request->get('id');
            if($id != "")
            {
                $em = $this->getDoctrine()->getManager();
                // On fait une requête pour récupérer les infos de l'oeuvre
                $expo = $em->getRepository('ModuleGestionBundle:Exposition')->find($id);
                // On instancie un objet fichier system
                $fs = new Filesystem();
                // On récupère le nom exact du fichier à supprimer
                $symlink = $expo->getFichier();
                // On définit le chemin de la suppression du fichier
                $path = $this->container->getParameter('multimedias_directory')."/".$symlink;
                // On supprime
                $fs->remove($path);
            }

            $em->remove($expo);
            $em->flush();

        //return $this->redirectToRoute('exposition_index');
            $message = "Suppression effectuée avec succès !";
        }else{
            $message = "Erreur de suppression !";
        }

        // Puis on le renvoie dans un tableau en Json
        return new JsonResponse(array('msg' => json_encode($message, JSON_UNESCAPED_UNICODE)));
    }

    /**
     * Creates a form to delete a Exposition entity.
     *
     * @param Exposition $exposition The Exposition entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Exposition $exposition)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exposition_delete', array('id' => $exposition->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function testNomAction(Request $request)
    {
        if($request->isXMLHttpRequest()) {
            $idExpo = $request->get('idExpo');
            $nomExpo = $request->get('nomExpo');
            $connection = $this->get('database_connection');
            $query = "SELECT e.nomExposition as nom
                      FROM Exposition as e
                      WHERE e.id <> ".$idExpo."
                      AND e.nomExposition ='".$nomExpo."'";
            $nomExpoTrouve = $connection->fetchAll($query);
            if(empty($nomExpoTrouve))
            {
                $message = false;
            }
            else
            {
                $message = true;
            }

            return new JsonResponse(array('data' => json_encode($message)));
        }
        return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
    }

    public function testDateDiffAction(Request $request)
    {
        if($request->isXMLHttpRequest()) {
            $dateDebut = $request->get('dateDebut');
            $dateDebut = str_replace("/", "-", $dateDebut);
            $dateDebut = date("Y-m-d H:i", strtotime($dateDebut));
            $dateD = new \DateTime($dateDebut);
            $dateFin = $request->get('dateFin');
            $dateFin = str_replace("/", "-", $dateFin);
            $dateFin = date("Y-m-d H:i", strtotime($dateFin));
            $dateF = new \DateTime($dateFin);
            //Test si date de début inférieur à la date de fin 
            if ($dateD > $dateF)
            {
                $message = true;
            }
            else
            {
                $dd = date("Y-m-d H:i", strtotime($dateDebut." +7 days"));
                $dateD = new \DateTime($dd);
                if($dateD > $dateF)
                {
                    $message = true;
                }
                else
                {
                    $dd = date("Y-m-d H:i", strtotime($dateDebut." +28 days"));
                    $dateD = new \DateTime($dd);
                    if($dateD < $dateF)
                    {
                        $message = true;
                    }
                    else
                    {
                        $message = false;
                    }
                }
            }
            return new JsonResponse(array('data' => json_encode($message)));
        }
        return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
    }

    public function testDateExpoAction(Request $request)
    {
        if($request->isXMLHttpRequest()) {
            $idExpo = $request->get('idExpo');
            $connection = $this->get('database_connection');
            $query = "SELECT e.dateHeureFinExposition as datefin, e.dateHeureDebutExposition as datedeb
                      FROM Exposition as e
                      WHERE e.id <> ".$idExpo;
            $ExpoTrouve = $connection->fetchAll($query);
            $verif = true;
            foreach ($ExpoTrouve as $Expo)
            {
                if($Expo['datefin'] != "" && $Expo['datedeb'] != "")
                {
                    $dateFinReq = date("Y-m-d H:i", strtotime($Expo['datefin']." +2 days"));
                    $date = new \DateTime($dateFinReq);

                    $dateDebutTrouve = $request->get('dateDebut');
                    $dateDebutTrouve = str_replace("/", "-", $dateDebutTrouve);
                    $dateDebut = new \DateTime($dateDebutTrouve);

                    $dateDebReq = $Expo['datedeb'];
                    $date = new \DateTime($dateDebReq);

                    $dateFinTrouve = $request->get('dateFin');
                    $dateFinTrouve = str_replace("/", "-", $dateFinTrouve);
                    $dateFin = new \DateTime($dateFinTrouve);

                    if($date > $dateDebut)
                    {
                        if($date > $dateFin)
                        {
                            $verif = true;
                        } else {
                            $verif = false;
                        }
                    }
                    if($date < $dateFin)
                    {
                        if($date < $dateDebut)
                        {
                            $verif = true;
                        } else {
                            $verif = false;
                        }
                    }
                }
                if($verif == false)
                {
                    break;
                }
            }
            if ($verif == false)
            {
                $message = true;
            }
            else
            {
                $message = false;
            }
            return new JsonResponse(array('data' => json_encode($message)));
        }
        return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
    }

    public function AccueilAction()
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        $connection = $this->get('database_connection');
        $query = "SELECT e.nomExposition as Nom, e.dateHeureDebutExposition as DateHeure, e.evenement as Evenement,
                    e.fichier as Fichier, e.id as Id
                  FROM Exposition e
                  ORDER BY e.dateHeureDebutExposition
                  LIMIT 4";
        $exposition = $connection->fetchAll($query);
        $i = 0;
        foreach ($exposition as $key) {
            $Date = date("Y-m-d", strtotime($key['DateHeure']));
            $exposition[$i]['DateHeure'] = $this->DateFrancais($Date);
            $i++;
        }

         // On appelle l'entity manager
        $em = $this->getDoctrine()->getManager();
        // Alerte Oeuvre non livrée
        $oeuvresNonLivre = $em->getRepository('ModuleGestionBundle:Exposition')->findAllCurrent();
        return $this->render('accueil/index.html.twig', array(
            'expositions' => $exposition,
            'role' => $role,
            'oeuvNonLivre' => $oeuvresNonLivre
        ));

    }

    public function DateFrancais($datefr)
    {

        $Jour = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi","Dimanche");
        $Mois = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre");
        $tabDate = explode("-", $datefr);
        $timestamp = mktime(0, 0, 0, $tabDate[1], $tabDate[2], $tabDate[0]);
        $jour = date('w', $timestamp);
        $mois = date('n', $timestamp); 
        if($jour != 0){
        $jour = $Jour[$jour-1];
        } else {
            $jour = $Jour[6];
        }
        $mois = $Mois[$mois-1];
        $datefr = $jour." ".$tabDate[2]." ".$mois." ".$tabDate[0];
        return $datefr;
    }

    /* test unitaire d'impression */
    public function testMailExpoAction(){

        $em = $this->getDoctrine()->getManager();
        // On charge la liste des expositions et oeuvres à alerter
        $expositions = $em->getRepository('ModuleGestionBundle:Exposition')->findAllCurrent();

        return new Response("Hello world !");
    }

    public function printAction(Exposition $exposition)
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $id = $exposition->getId();
        $connection = $this->get('database_connection');
        $query = "SELECT e.nomExposition as nomE, o.nom as nomO, emp.position as pos, emp.nombreVisiteOeuvre as nb
                  FROM Exposition e
                  INNER JOIN Emplacement emp
                  ON emp.exposition_id = e.id
                  INNER JOIN Oeuvre o
                  ON emp.oeuvre_id = o.id
                  WHERE e.id = ".$id;
        $exposition = $connection->fetchAll($query);
        return $this->render('exposition/print.html.twig', array(
            'expositions' => $exposition,
            'role' => $role
        ));
    }

    public function testExpoOeuvAction(Request $request)
    {
        if($request->isXMLHttpRequest()) {

            $idExpo = $request->get('id');
            
            $connection = $this->get('database_connection');

            $query = "SELECT emp.oeuvre_id
                      FROM Emplacement as emp
                      WHERE emp.exposition_id = ".$idExpo."";

            $Trouve = $connection->fetchAll($query);

            if(empty($Trouve))
            {
                $message = true;
            }
            else
            {
                $message = false;
            }

            return new JsonResponse(array('data' => json_encode($message)));
        }
        return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
    }
}
