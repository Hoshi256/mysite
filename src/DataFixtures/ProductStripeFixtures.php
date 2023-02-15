<?php

namespace App\DataFixtures;

use App\Entity\ProductStripe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductStripeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $productStripe = new ProductStripe();
            $productStripe
                ->setName('ProductStripe ' . $i)
                ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                ->setPrice(mt_rand(10, 600));

            $manager->persist($productStripe);
        }

        $manager->flush();
    }
}
