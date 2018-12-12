<?php
// src/ModuleGestionBundle/DataFixtures/ORM/LoadExpositionData.php

namespace ModuleGestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
// use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModuleGestionBundle\Entity\Exposition;
use ModuleGestionBundle\Entity\Organisateur;
use ModuleGestionBundle\Entity\Auteur;
use ModuleGestionBundle\Entity\Collectif;
use ModuleGestionBundle\Entity\TextExposition;

class LoadExpositionData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
    	// Je créé d'abord toutes mes expositions
        $exposition = new Exposition();
        $exposition1 = new Exposition();
        $exposition2 = new Exposition();
        $exposition3 = new Exposition();

        $exposition->setNomExposition('Chevaliers et bombardes.');
        $exposition->setEvenement('teaser');
        $exposition->setDateHeureDebutExposition(\DateTime::createFromFormat('d/m/Y', '07/10/2015'));
        $exposition->setDateHeureFinExposition(\DateTime::createFromFormat('d/m/Y', '24/01/2016'));
        $exposition->setStockage('');
        $exposition->setFichier('');

        $exposition1->setNomExposition('Fosses et donjon médiévaux.');
        $exposition1->setEvenement('deploie');
        $exposition1->setDateHeureDebutExposition(\DateTime::createFromFormat('d/m/Y', '25/10/2015'));
        $exposition1->setDateHeureFinExposition(\DateTime::createFromFormat('d/m/Y', '25/01/2016'));
        $exposition1->setStockage('');
        $exposition1->setFichier('');

        $exposition2->setNomExposition('Beauté congo.');
        $exposition2->setEvenement('inaugurer');
        $exposition2->setDateHeureDebutExposition(\DateTime::createFromFormat('d/m/Y', '11/07/2015'));
        $exposition2->setDateHeureFinExposition(\DateTime::createFromFormat('d/m/Y', '10/01/2016'));
        $exposition2->setStockage('');
        $exposition2->setFichier('');

        $exposition3->setNomExposition('Villa flora. Les Temps enchantés.');
        $exposition3->setEvenement('teaser');
        $exposition3->setDateHeureDebutExposition(\DateTime::createFromFormat('d/m/Y', '10/09/2015'));
        $exposition3->setDateHeureFinExposition(\DateTime::createFromFormat('d/m/Y', '07/02/2016'));
        $exposition3->setStockage('');
        $exposition3->setFichier('');

   		// Puis les organisateurs (Auteur et Collectif)
        $auteur  = new Auteur();
        $auteur1  = new Auteur();
        $collectif  = new Collectif();
        $collectif1  = new Collectif();
        // Auteur
        $auteur->setNom('Pierre-Luc Baron-Moreau');
        $auteur->setNationalite('Français');
        $auteur->setDatenaissance(\DateTime::createFromFormat('d/m/Y', '25/12/1968'));
        $auteur1->setNom('Claude Levêque');
        $auteur1->setNationalite('Français');
        $auteur1->setDatenaissance(\DateTime::createFromFormat('d/m/Y', '04/01/1978'));
        // Collectif
        $collectif->setNom('Fondation Cartier pour l\'Art contemporain');
        $collectif->setDatecreation(\DateTime::createFromFormat('d/m/Y', '19/04/1998'));
        $collectif1->setNom('Bonnard, Cézanne, Manet...');
        $collectif1->setDatecreation(\DateTime::createFromFormat('d/m/Y', '25/06/2014'));

        // Puis les textes des expositions
        $textExpo = new TextExposition();
        $textExpo1 = new TextExposition();
        $textExpo2 = new TextExposition();
        $textExpo3 = new TextExposition();

        $textExpo->setDescription('D’Azincourt à Marignan, 1415-1515, au musée de l’Armée - Hôtel des Invalides.
À l’occasion de l’année François Ier, 100 ans d’histoire,
explorés de la défaite d’Azincourt jusqu’au début de la Renaissance pour retracer les évolutions de l’art de la guerre,
à travers le développement de l’artillerie qui progressivement embrasera les champs de bataille.');
        $textExpo->setLangue('fr');
        $textExpo1->setDescription('Claude Lévêque, artiste majeur de la scène contemporaine internationale,
pose une création spécifique dans les espaces du Louvre médiéval,
pensés comme univers et base de récit. Son œuvre y active évocations et sensations.
Du dessous de la pyramide à la partie médiévale du Louvre,
une création d’émotions sensorielles "entre coercition et ravissement" par l’utilisation de la lumière, du son, d’objets et de matériaux.');
        $textExpo1->setLangue('fr');
        $textExpo2->setDescription('Congo Kitoko, à la Fondation Cartier pour l’Art contemporain.
La production artistique congolaise, dans sa diversité et sa vivacité, de la naissance de la peinture moderne au Congo dans les années 1920 à aujourd’hui, 
mais avec ses musique, sculpture, photographie et bande dessinée.');
        $textExpo2->setLangue('fr');
        $textExpo3->setDescription('
Découvrir pour la première fois en France des chefs-d’œuvre d’une des plus prestigieuses collections particulières,
ceux que choisirent les époux Hahnloser-Bühler pour orner leur Villa Flora (Winterthour, Suisse).
Près de 80 merveilles de Bonnard, Cézanne, Manet, Manguin, Matisse, Marquet, Renoir, Vallotton, Vuillard et Van Gogh...');
        $textExpo3->setLangue('fr');
        
		// Je persiste les expositions puis les organisateurs(Auteurs et Collectifs) ainsi que les Texte des expositions.

		// Persist Expos
        $manager->persist($exposition);
        $manager->persist($exposition1);
        $manager->persist($exposition2);
        $manager->persist($exposition3);

        // Persist Auteurs
        $manager->persist($auteur);
        $manager->persist($auteur1);

        // // Persist Collectifs
        $manager->persist($collectif);
        $manager->persist($collectif1);

        // Persist Textes des expositions
        $manager->persist($textExpo);
        $manager->persist($textExpo1);
        $manager->persist($textExpo2);
        $manager->persist($textExpo3);

        // Et j'enregistre en base de données
		$manager->flush();

		// On ajoute aux expositions les textes expos
        $exposition->addTextexposition($textExpo);
        $exposition1->addTextexposition($textExpo1);
        $exposition2->addTextexposition($textExpo2);
        $exposition3->addTextexposition($textExpo3);

        // On ajoute les organisateurs
        $exposition->setOrganisateur($auteur);
        $exposition1->setOrganisateur($auteur1);
        $exposition2->setOrganisateur($collectif);
        $exposition3->setOrganisateur($collectif1);

        // Persist Expos
        $manager->persist($exposition);
        $manager->persist($exposition1);
        $manager->persist($exposition2);
        $manager->persist($exposition3);

        // Et j'enregistre en base de données
        $manager->flush();

        $this->addReference('expo', $exposition);
        $this->addReference('expo1', $exposition1);
        $this->addReference('expo2', $exposition2);
        $this->addReference('expo3', $exposition3);
    }

    public function getOrder()
    {
        return 2; // L'ordre dans lequel les fichiers sont chargés
    }
}