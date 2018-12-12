<?php

namespace ModuleGestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ModuleGestionBundle\Entity\Oeuvre;
use Symfony\Component\HttpFoundation\Response;

/**
 * Scan controller.
 *
 */
class ScanController extends Controller
{
    /**
     * Scan all Oeuvres etat.
     *
     */
    public function TestScanAction()
    {
        $em = $this->getDoctrine()->getManager();
        // On charge la liste des expositions et oeuvres à alerter
        $expositions = $em->getRepository('ModuleGestionBundle:Exposition')->findAllCurrent();
        // On charge la liste des mails des utilisateurs à avertir
        $users = $em->getRepository('ModuleGestionBundle:Utilisateur')->findMailUser();

        $total = count($expositions); // On comptabilise le nombre d'exposition

        $count = 1; // Compteur d'exposition

        // On parcourt la liste des expositions
        foreach ($expositions as $exposition) {

			$listOeuv = $exposition->getEmplacements()->toArray(); // Liste des oeuvres
			$expo = $exposition; // Objet Exposition 

			if($count <= $total){
				// On appelle la fonction d'envoi de mail
				$this->SendMailAction($users,$listOeuv,$expo);
			}

			$count++;
        }

		return new Response('Hello world!'); 
    }

    /**
     * Send a mail to alert.
     *
     */
    private function SendMailAction($listDest,$listOeuv,$expo)
    {
    	// On boucle sur le nombre de destinataire pour envoyer un mail à chacun
    	foreach ($listDest as $destinataire) {
    		
    		// On prepare le mail
	    	$message = \Swift_Message::newInstance()
	    		->setSubject('Alerte Oeuvre')
	    		->setFrom('webmaster@grandangle.fr')
	    		->setTo($destinataire['email'])
	    		->setBody(
	    			$this->renderView(
	    				'email/alert_oeuvre.email.html.twig',
	    				array('user' => $destinataire['lastname'],
	    					  'listOeuv' => $listOeuv,
	    					  'expo' => $expo)
	    			),
	    			'text/html'
	    	);
    		
    		// On envoie le mail
    		$this->get('mailer')->send($message);
    	}
    	
    	// On ressort de la méthode
    	return new Response("true");
    }
}
