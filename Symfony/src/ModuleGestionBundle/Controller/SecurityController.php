<?php

namespace ModuleGestionBundle\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
    	$mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
    	$jours = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
    	
		$response = parent::loginAction($request);
		// On récupère le role de la personne connectée
    	$role = $this->getUser()->getRole();

    	return $this->render('ModuleGestionBundle:Default:index.html.twig', array('role' => $role));
   	}
}

