<?php
// src/ModuleGestionBundle/DataFixtures/ORM/LoadEmplacementData.php

namespace ModuleGestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
// use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModuleGestionBundle\Entity\Emplacement;

class LoadEmplacementData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	// Je créé d'abord toutes mes emplacements
        $emplacement = new Emplacement();
        $emplacement1 = new Emplacement();
        $emplacement2 = new Emplacement();
        $emplacement3 = new Emplacement();

        $emplacement->setExposition($this->getReference('expo'));
        $emplacement->setOeuvre($this->getReference('oeuv'));
        $emplacement->setPosition('1');

        $emplacement1->setExposition($this->getReference('expo1'));
        $emplacement1->setOeuvre($this->getReference('oeuv1'));
        $emplacement1->setPosition('2');

        $emplacement2->setExposition($this->getReference('expo2'));
        $emplacement2->setOeuvre($this->getReference('oeuv2'));
        $emplacement2->setPosition('3');

        $emplacement3->setExposition($this->getReference('expo3'));
        $emplacement3->setOeuvre($this->getReference('oeuv3'));
        $emplacement3->setPosition('4');

        $manager->persist($emplacement);
        $manager->persist($emplacement1);
        $manager->persist($emplacement2);
        $manager->persist($emplacement3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // L'ordre dans lequel les fichiers sont chargés
    }
}