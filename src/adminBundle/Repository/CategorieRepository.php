<?php

namespace adminBundle\Repository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository
{
    public function CategoryCount()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                        SELECT COUNT(cat)
                        FROM adminBundle:Categorie cat
                        
                    ');
        //die(dump($query->getResult()));
    }

    public function CategoryActive()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                        SELECT COUNT(cat)
                        FROM adminBundle:Categorie cat
                        WHERE cat.active = true
                        
                    ');
        //die(dump($query->getResult()));
    }

    public function CategoryActiveAndNotActive()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                        SELECT COUNT(cat)
                        FROM adminBundle:Categorie cat
                        GROUP BY cat.active 
                         ');

        //die(dump($query->getResult()));
    }


}
