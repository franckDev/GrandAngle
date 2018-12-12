<?php

namespace ModuleDiffusionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AccueilControllerTest extends WebTestCase
{
	/** @test */
    public function AfficheIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $dateJour = new \Datetime();
        $date = $dateJour->format('Y-m-d');
        $langue = "fr";
        
	    //Connection à la base de données
	    $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $connection = $em->getConnection();

        // récupérer la liste complète des oeuvres
        $query = "select e.nomExposition as nomEx, oe.nom as nomOe, oe.image as img, oe.nom_image as nomImg, texe.description as des from Exposition as e
        		  inner join Emplacement as em on e.id=em.exposition_id
        		  inner join Oeuvre as oe on oe.id=em.oeuvre_id
                  inner join Text_exposition as texe on e.id=texe.exposition_id
        		  where DATE_FORMAT(e.dateHeureDebutExposition,'%Y-%m-%d') <= '".$date."'and DATE_FORMAT(e.dateHeureFinExposition,'%Y-%m-%d') >= '".$date."' and texe.langue='".$langue."'";

                // On stocke le résultat
                $oeuvres = $connection->fetchAll($query);

       	// On parcourt les oeuvres
		for ($i=0; $i < count($oeuvres); $i++) { 
			// On vérifie si l'oeuvre est présente
			$this->assertContains($oeuvres[$i]["nomEx"],$crawler->text());
		}

    }

    /** @test */
    public function ChargeAgenda()
    {
    	$client = static::createClient();

        $crawler = $client->request('GET', '/agenda');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /** @test */
    public function ChargeOeuvre()
    {

    	$client = static::createClient();

    	$crawler = $client->request('GET', '/oeuvre');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());

		$em = $client->getContainer()->get('doctrine.orm.entity_manager');
		$expositions = $em->getRepository('ModuleGestionBundle:Exposition')->findAll();
		$connection = $em->getConnection();
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

		// On parcourt les oeuvres
		for ($i=0; $i < count($oeuvres); $i++) { 
			// On vérifie si l'oeuvre est présente
			$this->assertContains($oeuvres[$i]["nom"],$crawler->text());
		}

		// On parcourt les expositions
		for ($i=0; $i < count($expositions); $i++) { 
			// On vérifie si l'exposition est présente
			$this->assertContains($expositions[$i]->getNomExposition(),$crawler->text());
		}

    }

    /** @test */
  //   public function ChargeListeExpo()
  //   {

  //   	$client = static::createClient();

  //   	$crawler = $client->request('GET', '/list', array(), array(), array(
		//     'HTTP_X-Requested-With' => 'XMLHttpRequest',
		// ));

		// $this->assertEquals(200, $client->getResponse()->getStatusCode());

		// var_dump($crawler->text());

  //   }

}