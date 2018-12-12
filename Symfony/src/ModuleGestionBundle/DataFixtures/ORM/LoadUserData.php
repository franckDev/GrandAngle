<?php
// src/ModuleGestionBundle/DataFixtures/ORM/LoadUserData.php

namespace ModuleGestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModuleGestionBundle\Entity\Utilisateur;
use ModuleGestionBundle\Entity\Telephone;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Je créé les téléphones de mes utilisateurs
        $telephone1User1 = new Telephone();
        $telephone2User1 = new Telephone();

        $telephone1User2 = new Telephone();
        $telephone2User2 = new Telephone();

        $telephone1User1->setNumero('0620209392');
        $telephone1User1->setLibelle('Portable');

        $telephone2User1->setNumero('0549020052');
        $telephone2User1->setLibelle('Fixe');

        $telephone1User2->setNumero('0612354789');
        $telephone1User2->setLibelle('Portable');

        $telephone2User2->setNumero('0542369874');
        $telephone2User2->setLibelle('Fixe');

        //Je créé mes utilisateurs
        $Utilisateur = new Utilisateur();
        $Utilisateur->setFirstname('Courtois');
        $Utilisateur->setLastname('Franck');
        $Utilisateur->setRole('ADMIN');
        $Utilisateur->setUsername('fcourtois');
        $Utilisateur->setEmail('developpeur16700@gmail.com');
        $Utilisateur->setEnabled('1');
        $Utilisateur->setPassword('$2y$13$4KuNv2iBV0LCxZ5an8kuO.RGw6wVI0WQXn5hngwEwLJPZwOCUSqEi');
        // J'ajoute autant de téléphone qu'il faut
        $Utilisateur->addTelephone($telephone1User1);
        $Utilisateur->addTelephone($telephone2User1);

        $Utilisateur1 = new Utilisateur();
        $Utilisateur1->setFirstname('Dupond');
        $Utilisateur1->setLastname('Maurice');
        $Utilisateur1->setRole('USER');
        $Utilisateur1->setUsername('dmaurice');
        $Utilisateur1->setEmail('flac16700@gmail.com');
        $Utilisateur1->setEnabled('1');
        $Utilisateur1->setPassword('$2y$13$jNQEgc3MEHnrQ3hyUKLteOOYGZT/hCVHICr.DI276fjBvbftUoXIi');
        // J'ajoute autant de téléphone qu'il faut
        $Utilisateur1->addTelephone($telephone1User2);
        $Utilisateur1->addTelephone($telephone2User2);

        //Je créé mes utilisateurs
        $Utilisateur2 = new Utilisateur();
        $Utilisateur2->setFirstname('admin');
        $Utilisateur2->setLastname('admin');
        $Utilisateur2->setRole('ADMIN');
        $Utilisateur2->setUsername('admin');
        $Utilisateur2->setEmail('jonathan.pouvreau@hotmail.fr');
        $Utilisateur2->setEnabled('1');
        $Utilisateur2->setPassword('$2y$13$FwffagLdrI52mA1K5VXvSeejGYuoMmjnDY6yLWa6xkgkO4EaS7V.O');
        // J'ajoute autant de téléphone qu'il faut
        $Utilisateur2->addTelephone($telephone1User1);
        $Utilisateur2->addTelephone($telephone2User1);

        // Je persiste tout ça 
        $manager->persist($telephone1User1);
        $manager->persist($telephone2User1);
        $manager->persist($telephone1User2);
        $manager->persist($telephone2User2);
        $manager->persist($Utilisateur);
        $manager->persist($Utilisateur1);
        $manager->persist($Utilisateur2);

        // Et j'enregistre en base de données
        $manager->flush();
    }
}