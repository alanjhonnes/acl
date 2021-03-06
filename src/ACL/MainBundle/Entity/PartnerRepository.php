<?php

namespace ACL\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PartnerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartnerRepository extends EntityRepository
{
    public function findAllWithMedia(){
        return $this->createQueryBuilder('p')
            ->select('p, l')
            ->leftJoin('p.logo', 'l')
            ->getQuery()->execute();
    }
}
