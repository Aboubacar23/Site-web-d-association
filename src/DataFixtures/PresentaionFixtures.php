<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Faker\Factory;
use App\Entity\Historique;
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

        $manager->flush();
       
    }
}
