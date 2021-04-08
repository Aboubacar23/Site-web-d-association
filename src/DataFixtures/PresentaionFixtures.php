<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Genre;
use App\Entity\Niveau;
use App\Entity\Contact;
use App\Entity\Historique;
use App\Entity\Universite;
use App\Entity\Presentation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PresentaionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

        $presentation = new Presentation();
        $presentation->setLibelle($faker->realText($maxNbChars = 400, $indexSize = 4));
        $manager->persist($presentation);

        $History = new Historique();
        $History->setLibelle($faker->realText($maxNbChars = 400, $indexSize = 4));
        $manager->persist($History);
        $manager->flush();

        for ($i=0; $i < 20; $i++) { 
            $contact = new Contact();

            $contact->setNom($faker->name)
                    ->setObjet($faker->catchPhrase)
                    ->setEmail($faker->email)
                    ->SetMessage($faker->realText($maxNbChars = 400, $indexSize = 4));

            $manager->persist($contact);
            
        }

        for ($i=0; $i < 10; $i++) { 
            $genre = new Genre();
 
            $genre->setNom("Projet".$i);

            $manager->persist($genre);
            
        }

        for ($i=1; $i < 10; $i++) {
            $universite = new Universite();

            $universite->setNom('Universite '.$i);
            $manager->persist($universite);
        }

        for ($i=1; $i < 10; $i++) {
            $niveau = new Niveau();

            $niveau->setLibelle("Niveau d'etude ".$i);
            $manager->persist($niveau);
        }


        $manager->flush();
       
    }
}
