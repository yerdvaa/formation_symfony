<?php

namespace adminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Categorie;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCategorieData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i++)
        {
            $cat = new Categorie();
            $cat->setTitle('un nouveau titre'.$i)
                ->setDescription('lorem ipsum'.$i)
                ->setPosition($i)
                ->setActive(rand(0,1))
                ;

            $manager->persist($cat);
            $manager->flush();
            $this->addReference('nouvelle-categorie-'.$i, $cat);
        }

    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 1;
    }



}