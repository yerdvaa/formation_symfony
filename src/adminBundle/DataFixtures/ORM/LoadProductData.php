<?php

namespace adminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i++)
       {
           $product = new Product();
           $product->setTitle('Produit '.$i)
                    ->setDescription("C'est le produit ".$i)
                    ->setPrice(rand(1,1000))
                    ->setQuantity(rand(1,100))
                    ->setMarque($this->getReference('Marque '.$i));
                    //$brand = $this->getReference('Marque');
                    //die(dump($brand));

                for($j = 1; $j < 3; $j++)
                {
                    $product->addCategory($this->getReference('Catégorie '.$j));
                }

               $manager->persist($product);
               $manager->flush();

        }

    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 3;
    }
}