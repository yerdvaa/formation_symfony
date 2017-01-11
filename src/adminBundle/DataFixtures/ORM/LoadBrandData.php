<?php

namespace adminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Brand;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i++)
        {
            $brand = new Brand();
            $brand->setTitle('un nouveau titre'.$i);


            $manager->persist($brand);
            $manager->flush();
            $this->addreference('nouvelle-marque-'.$i, $brand);
        }
    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 2;
    }


}