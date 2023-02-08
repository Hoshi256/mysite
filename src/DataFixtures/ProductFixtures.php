<?php

namespace App\DataFixtures;
use App\Entity\Category;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
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


        $product1 = new Product();
        $product1->setName('Paris');
        $product1->setDescription('le voyage a paris');
        $product1->setPrice(123);
        $product1->setImage('gdsdqsjdjdjgdjgdsjgds');
        
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Rome');
        $product2->setDescription('le voyage a Rome');
        $product2->setPrice(23);
        $product2->setImage('gdsdqsjdjdjgdjgdsjgds');
        
        $manager->persist($product2);// $manager->persist($product);
      

        $manager->flush();


    }
}
