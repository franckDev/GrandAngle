<?php
// src/ModuleGestionBundle/DataFixtures/ORM/LoadThemeData.php

namespace ModuleGestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModuleGestionBundle\Entity\Theme;

class LoadThemeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Je créé les thèmes
        $theme = new theme();
        $theme1 = new theme();
        $theme2 = new theme();
        $theme3 = new theme();
        $theme4 = new theme();
        $theme5 = new theme();
        $theme6 = new theme();
        $theme7 = new theme();
        $theme8 = new theme();
        $theme9 = new theme();
        $theme10 = new theme();

        // Je les définis
        $theme->setLibelle("Abandon");
        $theme1->setLibelle("Abécédaire");
        $theme2->setLibelle("Berceuses");
        $theme3->setLibelle("Danse");
        $theme4->setLibelle("Dragon");
        $theme5->setLibelle("Littérature Jeunesse");
        $theme6->setLibelle("Moyen-Age");
        $theme7->setLibelle("Photographie");
        $theme8->setLibelle("Sexualité");
        $theme9->setLibelle("Tableau");
        $theme10->setLibelle("Voyage");

        // Je les persist
        $manager->persist($theme);
        $manager->persist($theme1);
        $manager->persist($theme2);
        $manager->persist($theme3);
        $manager->persist($theme4);
        $manager->persist($theme5);
        $manager->persist($theme6);
        $manager->persist($theme7);
        $manager->persist($theme8);
        $manager->persist($theme9);
        $manager->persist($theme10);

        // Et j'enregistre en base de données
        $manager->flush();
    }
}