<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/5/2014
 * Time: 8:30 PM
 */

namespace ACL\MainBundle\Entity;

use Application\Sonata\NewsBundle\Entity\Post;

class PostManager extends \Sonata\NewsBundle\Entity\PostManager {

    //TODO
    public function findLatestPosts($limit){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->from("ApplicationSonataNewsBundle:Post", 'post')
            ->andWhere('post.');

        $this->findBy(array('enabled' => true), array(), 4);
    }

} 