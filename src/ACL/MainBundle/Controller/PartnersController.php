<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 1/5/2015
 * Time: 6:55 PM
 */

namespace ACL\MainBundle\Controller;

use ACL\MainBundle\Entity\PartnerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PartnersController
 * @package ACL\MainBundle\Controller
 * @Route(path="/parceiros")
 */
class PartnersController extends Controller {

    /**
     * @Route(name="partners_index", path="")
     */
    public function indexAction(){
        $repo = $this->getPartnerRepository();
        $partners = $repo->findAll();

        return $this->render('@ACLMain/Partner/index.html.twig', array('partners' => $partners));
    }

    /**
     * @return PartnerRepository
     */
    private function getPartnerRepository(){
        return $this->getDoctrine()->getRepository('ACLMainBundle:Partner');
    }

}