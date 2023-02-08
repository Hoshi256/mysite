<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApppFixtures extends Fixture
{
    protected $encoder;
    public function  __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user1 = new User();
        $password = $this->encoder->hashPassword($user, 'lepassdetoto');

        // $user->setPassword($this->encoder->encode($this->password));
        $user->setEmail('toto@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($password);


        $user1->setEmail('tata@gmail.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($password);




        $manager->persist($user);
        $manager->persist($user1);


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
