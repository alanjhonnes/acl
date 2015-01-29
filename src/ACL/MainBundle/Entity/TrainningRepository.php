<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 1/22/2015
 * Time: 1:02 PM
 */

namespace ACL\MainBundle\Entity;


use Doctrine\ORM\EntityRepository;

class TrainningRepository extends EntityRepository {


    public function getQueryBuilderForQuestion($question){
        return $this->createQueryBuilder('t')
            ->where('t.question LIKE :question')
            ->setParameter('question', '%'.$question.'%');

    }
}
