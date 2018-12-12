<?php

namespace ModuleDiffusionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ModuleGestionBundle\Entity\Exposition;
use ModuleGestionBundle\Entity\Oeuvre;
use ModuleGestionBundle\Entity\Emplacement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Accueil controller.
 *
 */
class AccueilController extends Controller
{
	public function indexAction()
  {
        $dateJour = new \Datetime();
        $date = $dateJour->format('Y-m-d');
        $langue = "fr";
        
	       //Connection à la base de données
        $connection = $this->get('database_connection');

        // récupérer la liste complète des oeuvres
        $query = "select e.nomExposition as nomEx, oe.nom as nomOe, oe.image as img, oe.nom_image as nomImg, texe.description as des from Exposition as e
        		  inner join Emplacement as em on e.id=em.exposition_id
        		  inner join Oeuvre as oe on oe.id=em.oeuvre_id
                  inner join Text_exposition as texe on e.id=texe.exposition_id
        		  where DATE_FORMAT(e.dateHeureDebutExposition,'%Y-%m-%d') <= '".$date."'and DATE_FORMAT(e.dateHeureFinExposition,'%Y-%m-%d') >= '".$date."' and texe.langue='".$langue."'";

                // On stocke le résultat
                $rows = $connection->fetchAll($query);

        return $this->render('ModuleDiffusion/accueil/index.html.twig', array(
        	'rows' => $rows));
	}

  public function agendaAction()
  {
          return $this->render('ModuleDiffusion/accueil/agenda.html.twig');

  }

  public function oeuvreAction(Request $req)
  {
      if($req->isXMLHttpRequest()){
          //Connection à la base de données
          $connection = $this->get('database_connection');
          $date = new \DateTime();
          $date = $date->format('Y-m-d H:i:s');
          $query = "SELECT o.nom as nom, o.id as id, e.id as idEx, o.image as fichier
                    FROM Exposition as e
                    INNER JOIN Emplacement em
                    ON em.exposition_id = e.id
                    INNER JOIN Oeuvre o
                    ON em.oeuvre_id = o.id
                    WHERE DATE_FORMAT(e.dateHeureDebutExposition,'%Y-%m-%d') <= '".$date."'
                    AND DATE_FORMAT(e.dateHeureFinExposition,'%Y-%m-%d') >= '".$date."'";
          $rows = $connection->fetchAll($query);
                  
          // Puis on le renvoie dans un tableau en Json
          return new JsonResponse(array('data' => json_encode($rows)));
      // Sinon on charge normalement
      }else{
          $em = $this->getDoctrine()->getManager();
          $expositions = $em->getRepository('ModuleGestionBundle:Exposition')->findAll();
          $connection = $this->get('database_connection');
          $date = new \DateTime();
          $date = $date->format('Y-m-d H:i:s');
          $query = "SELECT o.nom as nom, o.id as id, e.id as idEx, o.image as fichier
                    FROM Exposition as e
                    INNER JOIN Emplacement em
                    ON em.exposition_id = e.id
                    INNER JOIN Oeuvre o
                    ON em.oeuvre_id = o.id
                    WHERE DATE_FORMAT(e.dateHeureDebutExposition,'%Y-%m-%d') <= '".$date."'
                    AND DATE_FORMAT(e.dateHeureFinExposition,'%Y-%m-%d') >= '".$date."'";
          $oeuvres = $connection->fetchAll($query);

          if(!empty($oeuvres))
          {
            $idExposition = $oeuvres[0]['idEx'];
          }
          return $this->render('ModuleDiffusion/accueil/oeuvre.html.twig', array(
              'expositions' => $expositions,
              'oeuvres' => $oeuvres,
              'idExposition' => $idExposition
              ));
      }
  }
  public function listexpoAction(Request $request)
  {
      if($request->isXMLHttpRequest()) 
      {
          $connection = $this->get('database_connection');
          $id = $request->get("id");
          $query = "SELECT e.id as idEx, o.nom as nomO, o.id as idO, o.image as fichier
                    FROM Exposition e
                    INNER JOIN Emplacement em
                    ON em.exposition_id = e.id
                    INNER JOIN Oeuvre o
                    ON em.oeuvre_id = o.id
                    WHERE e.id =".$id;
          $data = $connection->fetchAll($query);
          return new JsonResponse(array('data' => json_encode($data)));
      }else{
        return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
      }
      
  }

  public function detailAction(Oeuvre $oeuvre, $idE)
  {
      $connection = $this->get('database_connection');
      $id = $oeuvre->getId();
      $query = "SELECT t.description as descrpt
                FROM Texte_Oeuvre as t
                WHERE t.langue = 'fr' 
                AND t.oeuvre_id =".$id;
      $trad = $connection->fetchAll($query);
      $query = "SELECT m.nom as nom, m.lien as lien
                FROM multimedia as m
                INNER JOIN oeuvre o
                ON o.id = m.oeuvre_id
                WHERE o.id =".$id;
      $multis = $connection->fetchAll($query);
      return $this->render('ModuleDiffusion/accueil/detail_oeuvre.html.twig', array(
          'oeuvre' => $oeuvre,
          'trad' => $trad,
          'multis' => $multis,
          'idE' => $idE
      ));
  }

  public function majvuoAction(Request $request)
  {
      if($request->isXMLHttpRequest()) 
      {
          // $connection = $this->get('database_connection');
          // $id = $request->get('id');
          // $idE = $request->get('idE');
          // $query = "UPDATE Emplacement as em 
          //           SET em.nombreVisiteOeuvre =3
          //           WHERE em.exposition_id =7 
          //           AND em.oeuvre_id =6";
          // $new = $connection->fetchAll($query);
          // var_dump($new);
          $id = $request->get('id');
          $idE = $request->get('idE');
          $emplacement = new Emplacement();
          $em = $this->getDoctrine()->getEntityManager();
          $repo = $em->getRepository('ModuleGestionBundle:Emplacement');
          $repo->updateVisite($id,$idE,$em);
          $message = true;
          return new JsonResponse(array('data' => json_encode($message)));
      }
      return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
  }
}