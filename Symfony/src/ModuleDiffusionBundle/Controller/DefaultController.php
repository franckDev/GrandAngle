<?php

namespace ModuleDiffusionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Date as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ModuleDiffusionBundle:Default:index.html.twig');
    }

    public function afficheAction(Request $request)
    {

    	if($request->isXMLHttpRequest()) {
			$date = new \DateTime();
			$date = $date->format('Y-m-d H:i:s');
    		$connection = $this->get('database_connection');
    		$query = "SELECT e.dateHeureDebutExposition as dateD, e.dateHeureFinExposition as dateF
    				  FROM Exposition as e
    				  WHERE e.dateHeureDebutExposition <= '".$date."'
    				  AND e.dateHeureFinExposition >= '".$date."'";
    		$expo = $connection->fetchAll($query);
            if(!empty($expo))
            {
        		$dateD = $expo[0]['dateD'];
        		$dateF = $expo[0]['dateF'];
        		$dateD = new \DateTime($dateD);
        		$dateF = new \DateTime($dateF);
        		$diff = date_diff($dateD, $dateF);
        		$diff = $diff->format('%a');
        		$diff = intval($diff);
        		$tab = array();
        		for($i = 0; $i < $diff; $i++)
        		{
                    $date = date("Y-m-d", strtotime($dateD->format('Y-m-d')." +".$i." days"));
        			$tab[$i]['date'] = $date;
                    $tab[$i]['badge'] = true;
                    $tab[$i]['title'] = "exemple".$i;
        		}
            }else{
                $tab = "";
            }
    		return new JsonResponse(array('data' => $tab));
    	}
    	return new Response("Erreur : Ce n'est pas une requête Ajax", 400);
    }
}
