<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Admin;
use App\Entity\Genre;
use App\Entity\Projet;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this-> passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $admin = new Admin();
        $admin ->setEmail('aboubacarsidikiconde23@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('Conde');
        $admin->setPrenom('Aboubacar Sidiki Condé');
        $manager->persist($admin);
        $manager->flush();
    }

}
