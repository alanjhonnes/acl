<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 1/26/2015
 * Time: 6:35 PM
 */

namespace ACL\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class TrainningController
 * @package ACL\MainBundle\Controller
 */
class TrainningController extends Controller {

    /**
     * @Route("/treinamento", name="acl.main.trainning.index")
     */
    public function indexAction(Request $request){

        $this->get('sonata.seo.page')->setTitle('Treinamento');

        $pager = $this->get('knp_paginator');
        $page  = $request->get('page', 1);

        $pagination = $pager->paginate($this->getRepository()->createQueryBuilder('t'), $page, 30);


        return $this->render('ACLMainBundle:Trainning:index.html.twig', array(
            'pager'        => $pagination,
            'search' => null,
        ));
    }

    /**
     * @Route("/treinamento/busca", name="acl.main.trainning.search")
     */
    public function searchAction(Request $request){
        $this->get('sonata.seo.page')->setTitle('Treinamento');

        $pager = $this->get('knp_paginator');
        $page  = $request->get('page', 1);

        $question = $request->get('question', '');

        $qb = $this->getRepository()->createQueryBuilder('t')
            ->where('t.question LIKE :question')
            ->setParameter('question', '%'.$question.'%');

        $pagination = $pager->paginate($qb, $page, 10);


        return $this->render('ACLMainBundle:Trainning:index.html.twig', array(
            'pager'        => $pagination,
            'search' => $question,
        ));
    }


    /**
     * @return \ACL\MainBundle\Entity\TrainningRepository
     */
    protected function getRepository(){
        return $this->getDoctrine()->getRepository('ACLMainBundle:Trainning');
    }


}
