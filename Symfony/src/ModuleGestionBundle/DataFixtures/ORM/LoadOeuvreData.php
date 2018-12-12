<?php
// src/ModuleGestionBundle/DataFixtures/ORM/LoadOeuvreData.php

namespace ModuleGestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
// use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModuleGestionBundle\Entity\Oeuvre;
use ModuleGestionBundle\Entity\TexteOeuvre;
use ModuleGestionBundle\Entity\Artiste;
use ModuleGestionBundle\Entity\Multimedia;
use ModuleGestionBundle\Entity\Tableau;

class LoadOeuvreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	// Je créé d'abord toutes mes oeuvres
        $oeuvre = new Oeuvre();
        $oeuvre1 = new Oeuvre();
        $oeuvre2 = new Oeuvre();
        $oeuvre3 = new Oeuvre();

        $oeuvre->setNom('Garçon à la pipe');
        $oeuvre->setEtat('Pas livré');
        $oeuvre->setNombreVisite('120');

        $oeuvre1->setNom('La joconde - Portrait de Mona Lisa');
        $oeuvre1->setEtat('En cours');
        $oeuvre1->setNombreVisite('174');

        $oeuvre2->setNom('L\'astronome');
        $oeuvre2->setEtat('Pas livré');
        $oeuvre2->setNombreVisite('180');

        $oeuvre3->setNom('White Center');
        $oeuvre3->setEtat('Livré');
        $oeuvre3->setNombreVisite('150');

        // Puis je définis les types des oeuvres
        // Tableau
        $tableau = new Tableau();
        $tableau->setTitre("Garçon à la pipe");
        $tableau->setDateCreation("01/01/1517 00:00");
        $tableau->setLargeur("77 cm");
        $tableau->setHauteur("53 cm");

        $tableau1 = new Tableau();
        $tableau1->setTitre("La Joconde");
        $tableau1->setDateCreation("01/01/1856 00:00");
        $tableau1->setLargeur("195 cm");
        $tableau1->setHauteur("35 cm");

        $tableau2 = new Tableau();
        $tableau2->setTitre("L'astronome");
        $tableau2->setDateCreation("01/01/2011 00:00");
        $tableau2->setLargeur("110 cm");
        $tableau2->setHauteur("85 cm");

        $tableau3 = new Tableau();
        $tableau3->setTitre("White Center");
        $tableau3->setDateCreation("01/01/1998 00:00");
        $tableau3->setLargeur("95 cm");
        $tableau3->setHauteur("120 cm");

        // Statut

        // Multimedia (Son)

        // Multimedia (Video)

        // Je persist mes types d'oeuvre
        $manager->persist($tableau);
        $manager->persist($tableau1);
        $manager->persist($tableau2);
        $manager->persist($tableau3);

        // Puis j'enregistre
        $manager->flush();


        // Puis je met à jour les champs Typeoeuvre dans oeuvre
        $oeuvre->setTypeoeuvre($tableau);
        $oeuvre1->setTypeoeuvre($tableau1);
        $oeuvre2->setTypeoeuvre($tableau2);
        $oeuvre3->setTypeoeuvre($tableau3);

        // Puis je créé les artistes correspondant
        $artiste = new Artiste();
        $artiste1 = new Artiste();
        $artiste2 = new Artiste();
        $artiste3 = new Artiste();

        $artiste->setNom('Picasso');
        $artiste->setPrenom('Pablo');
        $artiste->setNationalite('Espagnol');
        $artiste->setDateNaissance('1881-10-25');
        $artiste->setDateMort('1973-04-08');
        // J'ajoute à l'artiste son oeuvre
        $artiste->addOeuvre($oeuvre);

        $artiste1->setNom('De Vinci');
        $artiste1->setPrenom('Léonard');
        $artiste1->setNationalite('Italien');
        $artiste1->setDateNaissance('1452-04-15');
        $artiste1->setDateMort('1519-05-02');
        // J'ajoute à l'artiste son oeuvre
        $artiste1->addOeuvre($oeuvre1);

        $artiste2->setNom('Vermeer');
        $artiste2->setPrenom('Johannes');
        $artiste2->setNationalite('Néerlandais');
        $artiste2->setDateNaissance('1632-10-31');
        $artiste2->setDateMort('1675-12-15');
        // J'ajoute à l'artiste son oeuvre
        $artiste2->addOeuvre($oeuvre2);

        $artiste3->setNom('Rothko');
        $artiste3->setPrenom('Mark');
        $artiste3->setNationalite('Américain');
        $artiste3->setDateNaissance('1903-09-25');
        $artiste3->setDateMort('1970-02-25');
        // J'ajoute à l'artiste son oeuvre
        $artiste3->addOeuvre($oeuvre3);

		// Je persiste les oeuvres puis les artistes
        $manager->persist($oeuvre);
        $manager->persist($oeuvre1);
        $manager->persist($oeuvre2);
        $manager->persist($oeuvre3);
        $manager->persist($artiste);
        $manager->persist($artiste1);
        $manager->persist($artiste2);
        $manager->persist($artiste3);

        // Et j'enregistre en base de données
		$manager->flush();

        $IP = "localhost"; // Adresse en local par défaut modifiable ex: 92.156.227.65

        // J'enregistre les flashsCode
        $oeuvre->setImgFlashcode('/qrcode/'.$IP.'/GrandAngle/Symfony/web/testoeuvre/'.$oeuvre->getId().'/show');
        $oeuvre->setGenFlashcode('1');
        $oeuvre1->setImgFlashcode('/qrcode/'.$IP.'/GrandAngle/Symfony/web/testoeuvre/'.$oeuvre1->getId().'/show');
        $oeuvre1->setGenFlashcode('1');
        $oeuvre2->setImgFlashcode('/qrcode/'.$IP.'/GrandAngle/Symfony/web/testoeuvre/'.$oeuvre2->getId().'/show');
        $oeuvre2->setGenFlashcode('1');
        $oeuvre3->setImgFlashcode('/qrcode/'.$IP.'/GrandAngle/Symfony/web/testoeuvre/'.$oeuvre3->getId().'/show');
        $oeuvre3->setGenFlashcode('1');

        // Je persiste les oeuvres
        $manager->persist($oeuvre);
        $manager->persist($oeuvre1);
        $manager->persist($oeuvre2);
        $manager->persist($oeuvre3);

         // Et j'enregistre en base de données
        $manager->flush();

        // Je créé mes textes des oeuvres pour les 5 langues
        $texteoeuvreFra = new TexteOeuvre();
        $texteoeuvreAng = new TexteOeuvre();
        $texteoeuvreEsp = new TexteOeuvre();
        $texteoeuvreRus = new TexteOeuvre();
        $texteoeuvreChi = new TexteOeuvre();

        // Oeuvre 
        $texteoeuvreFra->setDescription('Garçon à la pipe est un tableau de Pablo Picasso réalisé en 1905, lors de sa « période rose » lorsqu\'il avait vingt-quatre ans et venait de s\'installer à Montmartre, à Paris. ');
        $texteoeuvreFra->setLangue('fr');
        $texteoeuvreAng->setDescription('Boy with a Pipe is a painting by Pablo Picasso made ​​in 1905, when his " rose period " when he was twenty -four and had just settled in Montmartre, Paris .');
        $texteoeuvreAng->setLangue('en');
        $texteoeuvreEsp->setDescription('Muchacho con pipa es una pintura de Pablo Picasso realizado en 1905 , cuando su " época rosa " cuando tenía veinticuatro años y apenas se había asentado en Montmartre , París .');
        $texteoeuvreEsp->setLangue('es');
        $texteoeuvreRus->setDescription('Мальчик с трубкой является картина Пабло Пикассо сделал в 1905 году, когда его " поднялся период " , когда ему было двадцать четыре года , и только что поселился на Монмартре , Париж .');
        $texteoeuvreRus->setLangue('ru');
        $texteoeuvreChi->setDescription('男孩與一個管道是一幅畢加索在1905年，當他的“玫瑰時期”時，他是24和​​剛剛在蒙馬特高地，巴黎定居的。');
        $texteoeuvreChi->setLangue('ch');

        $texteoeuvreFra1 = new TexteOeuvre();
        $texteoeuvreAng1 = new TexteOeuvre();
        $texteoeuvreEsp1 = new TexteOeuvre();
        $texteoeuvreRus1 = new TexteOeuvre();
        $texteoeuvreChi1 = new TexteOeuvre();

        // Oeuvre 1
        $texteoeuvreFra1->setDescription('La Joconde, ou Portrait de Mona Lisa, est un tableau de l\'artiste italien Léonard de Vinci, réalisé entre 1503 et 1506, qui représente un portrait mi-corps, probablement celui de la florentine Lisa Gherardini, épouse de Francesco del Giocondo.');
        $texteoeuvreFra1->setLangue('fr');
        $texteoeuvreAng1->setDescription('La Joconde , or Portrait of Mona Lisa is a painting by the Italian artist Leonardo da Vinci, realized between 1503 and 1506, which represents a half-length portrait , probably one of the Florentine Lisa Gherardini , wife of Francesco del Giocondo .');
        $texteoeuvreAng1->setLangue('en');
        $texteoeuvreEsp1->setDescription('La Joconde , o retrato de Mona Lisa es una pintura del artista italiano Leonardo da Vinci , realizado entre 1503 y 1506, lo que representa un retrato de medio cuerpo, probablemente uno de los florentina Lisa Gherardini , esposa de Francesco del Giocondo .');
        $texteoeuvreEsp1->setLangue('es');
        $texteoeuvreRus1->setDescription('La Joconde , или Портрет Моны Лизы является картина итальянского художника Леонардо да Винчи, реализованного между 1503 и 1506 , который представляет собой Поясной портрет , вероятно, один из флорентийской Лиза Герардини , жена Франческо дель Джокондо .');
        $texteoeuvreRus1->setLangue('ru');
        $texteoeuvreChi1->setDescription('香格里拉Joconde ，或縱向蒙娜麗莎是意大利藝術家達芬奇， 1503和1506年間實現的，它代表一個半身肖像，可能是佛羅倫薩麗莎·格拉迪尼，弗朗切斯科德爾焦孔多之妻之一一幅畫。');
        $texteoeuvreChi1->setLangue('ch');

        $texteoeuvreFra2 = new TexteOeuvre();
        $texteoeuvreAng2 = new TexteOeuvre();
        $texteoeuvreEsp2 = new TexteOeuvre();
        $texteoeuvreRus2 = new TexteOeuvre();
        $texteoeuvreChi2 = new TexteOeuvre();

        // Oeuvre 2
        $texteoeuvreFra2->setDescription('L\'Astronome, ou L\'Astrologue, est un tableau de Johannes Vermeer, peint vers 1668, et actuellement conservé au musée du Louvre.');
        $texteoeuvreFra2->setLangue('fr');
        $texteoeuvreAng2->setDescription('The Astronomer , or The Astrologer is a painting by Johannes Vermeer, painted around 1668, and now in the Louvre.');
        $texteoeuvreAng2->setLangue('en');
        $texteoeuvreEsp2->setDescription('El astrónomo, o El Astrólogo es una pintura de Juan Vermeer , pintada alrededor de 1668, y ahora en el Louvre .');
        $texteoeuvreEsp2->setLangue('es');
        $texteoeuvreRus2->setDescription('Астроном , или Астролог является картина Яна Вермеера , написана около 1668 года , и в настоящее время в Лувре .');
        $texteoeuvreRus2->setLangue('ru');
        $texteoeuvreChi2->setDescription('天文學家或占星家是約翰內斯·維米爾在盧浮宮繪畫，圍繞1668手繪，現在。');
        $texteoeuvreChi2->setLangue('ch');

        $texteoeuvreFra3 = new TexteOeuvre();
        $texteoeuvreAng3 = new TexteOeuvre();
        $texteoeuvreEsp3 = new TexteOeuvre();
        $texteoeuvreRus3 = new TexteOeuvre();
        $texteoeuvreChi3 = new TexteOeuvre();

        // Oeuvre 3
        $texteoeuvreFra3->setDescription('White Center fait partie du style signature multiforme de Rothko : plusieurs blocs de couleurs complémentaires en couches sur un grand tableau de canvas.The est de haut en bas , un rectangle jaune horizontal, une bande horizontale noire , une bande rectangulaire blanche étroite et la moitié inférieure est lavande. La moitié supérieure du sol de rose est plus profond dans la couleur et la moitié inférieure est pâle .');
        $texteoeuvreFra3->setLangue('fr');
        $texteoeuvreAng3->setDescription('White Center is part of the multifaceted signing style Rothko : several blocks of complementary colors in layers on a large painting of canvas.The is up and down , a horizontal yellow rectangle , a black horizontal stripe , a narrow white rectangular strip and half lavender is lower . The top half of the pink soil is deeper in color and the bottom half is white.');
        $texteoeuvreAng3->setLangue('en');
        $texteoeuvreEsp3->setDescription('White Center es parte del estilo firma multifacética Rothko : varios bloques de colores complementarios en capas sobre una gran pintura de canvas.The es de arriba a abajo , un rectángulo horizontal amarilla , una raya horizontal negro , una franja blanca rectangular estrecha y media lavanda es menor. La mitad superior del suelo es más profundo de color rosa en el color y la mitad inferior es de color blanco .
');
        $texteoeuvreEsp3->setLangue('es');
        $texteoeuvreRus3->setDescription('Белый центр является частью многогранной стиля подписания Ротко : несколько блоков дополнительных цветов в слоях на большой живописи canvas.The вверх и вниз , горизонтальный желтый прямоугольник, черная горизонтальная полоса , узкой белой прямоугольной полосы и половина лаванды ниже . Верхняя половина розовой почвы глубже в цвете , а нижняя половина белая .');
        $texteoeuvreRus3->setLangue('ru');
        $texteoeuvreChi3->setDescription('懷特中心是多方面的簽約風格羅斯科的組成部分：互補色數塊層上的一幅大畫canvas.The的是上下，水平黃色矩形，黑色橫條紋，一個窄的白色矩形條和半薰衣草較低。粉紅色土壤的上半部分是在顏色較深，下半部分是白色。');
        $texteoeuvreChi3->setLangue('ch');

        // Je le lie aux oeuvres
        $oeuvre->addTexteoeuvre($texteoeuvreFra);
        $oeuvre->addTexteoeuvre($texteoeuvreAng);
        $oeuvre->addTexteoeuvre($texteoeuvreEsp);
        $oeuvre->addTexteoeuvre($texteoeuvreRus);
        $oeuvre->addTexteoeuvre($texteoeuvreChi);

        $oeuvre1->addTexteoeuvre($texteoeuvreFra1);
        $oeuvre1->addTexteoeuvre($texteoeuvreAng1);
        $oeuvre1->addTexteoeuvre($texteoeuvreEsp1);
        $oeuvre1->addTexteoeuvre($texteoeuvreRus1);
        $oeuvre1->addTexteoeuvre($texteoeuvreChi1);

        $oeuvre2->addTexteoeuvre($texteoeuvreFra2);
        $oeuvre2->addTexteoeuvre($texteoeuvreAng2);
        $oeuvre2->addTexteoeuvre($texteoeuvreEsp2);
        $oeuvre2->addTexteoeuvre($texteoeuvreRus2);
        $oeuvre2->addTexteoeuvre($texteoeuvreChi2);

        $oeuvre3->addTexteoeuvre($texteoeuvreFra3);
        $oeuvre3->addTexteoeuvre($texteoeuvreAng3);
        $oeuvre3->addTexteoeuvre($texteoeuvreEsp3);
        $oeuvre3->addTexteoeuvre($texteoeuvreRus3);
        $oeuvre3->addTexteoeuvre($texteoeuvreChi3);

        // Je créé mes liens multimedias
        $multimedia = new Multimedia();
        $multimedia1 = new Multimedia();
        $multimedia2 = new Multimedia();
        $multimedia3 = new Multimedia();

        // Lien
        $multimedia->setNom('Youtube vidéo');
        $multimedia->setLien('https://www.youtube.com/watch?v=3473mOlMrqI'); 

        // Lien1
        $multimedia1->setNom('Le figaro');
        $multimedia1->setLien('http://www.lefigaro.fr/arts-expositions/2016/04/29/03015-20160429ARTFIG00015-l-amant-de-leonard-de-vinci-est-il-le-second-visage-de-la-joconde.php'); 

        // Lien2
        $multimedia2->setNom('Musée du louvre');
        $multimedia2->setLien('http://www.louvre.fr/oeuvre-notices/lastronome');

        // Lien3
        $multimedia3->setNom('Blog');
        $multimedia3->setLien('http://whitecenterblog.com/'); 

        // Je lie les multimédias aux oeuvres
        $oeuvre->addMultimedia($multimedia);
        $oeuvre1->addMultimedia($multimedia1);
        $oeuvre2->addMultimedia($multimedia2);
        $oeuvre3->addMultimedia($multimedia3);

        // Je persiste les oeuvres
        $manager->persist($oeuvre);
        $manager->persist($oeuvre1);
        $manager->persist($oeuvre2);
        $manager->persist($oeuvre3);

         // Et j'enregistre en base de données
        $manager->flush();

        $this->addReference('oeuv', $oeuvre);
        $this->addReference('oeuv1', $oeuvre1);
        $this->addReference('oeuv2', $oeuvre2);
        $this->addReference('oeuv3', $oeuvre3);
    }

    public function getOrder()
    {
        return 1; // L'ordre dans lequel les fichiers sont chargés
    }
}