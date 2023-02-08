<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    

    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName('voyage');
        $category1->setDescription('la description de mon voyage');
        $category1->setDate(new \DateTime());
        $category1->setImage('gdsdqsjdjdjgdjgdsjgds');
        
        
        $manager->persist($category1);
        // $product = new Product();
        // $manager->persist($product);
        $category2 = new Category();
        $category2->setName('vetement');
        $category2->setDescription('la description de mon vetement');
        $category2->setDate(new \DateTime());
        $category2->setImage('gdsdqsjdjdjgdjgdsjgds');

        $manager->persist($category2);

        $manager->flush();
    }
}
