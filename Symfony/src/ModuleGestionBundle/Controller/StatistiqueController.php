<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;
/**
 * Graphique controller.
 *
 */
class StatistiqueController extends Controller
{
    public function chartexpoAction()
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();

        $connection = $this->get('database_connection');
        $query = "SELECT e.nomExposition as nom, e.nombreVisiteExposition as visite
                  FROM Exposition as e";
        $nomExpo = $connection->fetchAll($query);
        $exposition[] = ""; 
        $visite[] = "";
        foreach ($nomExpo as $key => $value) {
            $exposition[$key] = $value['nom'];
            $visite[$key] = intval($value['visite']);
        }

        $sellsHistory = array(
            array(
                 "name" => "Expositions",
                 "data" => $visite
            )
        );

        $ob = new Highchart();
        // ID de l'élement de HTML que utilisé comme conteneur
        $ob->chart->renderTo('linechart');
        // Tittre du graphique
        $ob->title->text('Nombre de vues par exposition');
        // Type du graphique
        $ob->chart->type('column');
        // Axe des ordonnées
        $ob->yAxis->title(array('text' => "Nombre de vue"));
        // Axe des absisses
        $ob->xAxis->title(array('text' => "Nom des expositions"));
        // différente catégorie du graph des absisses
        $ob->xAxis->categories($exposition);
        // Incorporation des données du graphique
        $ob->series($sellsHistory);

        return $this->render('statistique/statistique.html.twig', array(
            'chart' => $ob,
            'role' => $role,
        ));
    }

    public function chartoeuvreAction()
    {
        // On récupère le role de la personne connectée
        $role = $this->getUser()->getRole();
        // On se connecte à la base de données
        $connection = $this->get('database_connection');
        // Récupère les exposition qui posséde au moins 1 oeuvre
        $query = "SELECT distinct e.id as idexpo, e.nomExposition as nomexpo
                  FROM Exposition as e
                  INNER JOIN Emplacement em
                  ON em.exposition_id = e.id
                  WHERE em.exposition_id is not null";
        // On récupère le résultat de la requéte
        $id = $connection->fetchAll($query);
        $exposition[] = "";
        $TotalExpo = array();
        // Ici on boucle afin de trouver toutes les oeuvres de toutes les expositions
        foreach ($id as $key => $value) {
            $exposition[$key] = $value['nomexpo'];
            $connection = $this->get('database_connection');
            $query = "SELECT e.nomExposition as nomexpo, o.nom as nomoeuvre, em.nombreVisiteOeuvre as visite
                      FROM Exposition as e
                      INNER JOIN Emplacement as em
                      ON e.id = em.exposition_id
                      INNER JOIN Oeuvre as o
                      on em.oeuvre_id = o.id
                      WHERE em.exposition_id = ".$value['idexpo'];
            $Expo = $connection->fetchAll($query);
            $TotalExpo = array_merge($TotalExpo, $Expo);
        }
        $nbexpo = count($TotalExpo);

        $tableau = array();
        $y = 0;
        //Ici on cherche les oeuvre unique sans doublon
        while($y != count($TotalExpo))
        {
            if(!empty($tableau))
            {
                if(!in_array($TotalExpo[$y]['nomoeuvre'], $tableau))
                {
                    array_push($tableau, $TotalExpo[$y]['nomoeuvre']);
                }
            }    
            else
            {
                array_push($tableau, $TotalExpo[$y]['nomoeuvre']);
            }
            $y++;
        }
        $tableConstruit = array();
        $trouve = false;
        $precedent = "";
        // On reconstruit le tableau pour l'adapter au type de données lu par le graphique
        foreach ($tableau as $key => $value) 
        {
            $tab = array();
            // nom de l'oeuvre
            $tab['name'] = $value;
            //$precedent = $value;
            $tab['data'] = array();
            //il faut chercher dans chaque $TotalExpo les expo qui on l'oeuvre $value
            $memo = "";
            foreach ($TotalExpo as $key2 => $value2) 
            {
                if($value2['nomexpo'] != $memo)
                {
                    if($value2['nomoeuvre'] == $value)
                    {
                        array_push($tab['data'],intval($value2['visite']));
                        $memo = $value2['nomexpo'];
                    } else {
                        foreach ($TotalExpo as $key3 => $value3) {
                            if($value3['nomexpo'] == $value2['nomexpo'])
                            {
                                if(in_array($value, $TotalExpo[$key3]))
                                {
                                    $trouve = true;
                                }
                            }
                        }
                        if($trouve == false)
                        {
                            array_push($tab['data'],0); 
                            $memo = $value2['nomexpo'];
                        }
                        $trouve = false;
                    }
                }
                //$trouve = false;
            }
            $trouve = false;
            $memo = "";
            array_push($tableConstruit, $tab);
        }
        $ob = new Highchart();
        // ID de l'élement de HTML que utilisé comme conteneur
        $ob->chart->renderTo('linechart');
        // Tittre du graphique
        $ob->title->text('Nombre de vues par oeuvre par exposition');
        // Type du graphique
        $ob->chart->type('column');
        // Axe des ordonnées
        $ob->yAxis->title(array('text' => "Nombre de vue"));
        // Axe des absisses
        $ob->xAxis->title(array('text' => "Nom des expositions"));
        // différente catégorie du graph des absisses
        $ob->xAxis->categories($exposition);
        // Incorporation des données du graphique
        $ob->series($tableConstruit);

        return $this->render('statistique/statistique.html.twig', array(
            'chart' => $ob,
            'role' => $role,
        ));
    }
}