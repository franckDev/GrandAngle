<?php

namespace ModuleGestionBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MgbScanCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mgb:scan')
            ->setDescription('Envoyez un rappel pour les oeuvres non livrées');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
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

        $output->writeln('<comment>Running Cron Tasks...</comment>');
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
                    $this->getContainer()
                         ->get('templating')
                         ->render(
                        'email/alert_oeuvre.email.html.twig',
                        array('user' => $destinataire['lastname'],
                              'listOeuv' => $listOeuv,
                              'expo' => $expo)
                    ),
                    'text/html'
            );
            
            // On envoie le mail
            $this->getContainer()->get('mailer')->send($message);
        }
    }

}
