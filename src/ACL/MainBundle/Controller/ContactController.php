<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/5/2014
 * Time: 7:28 PM
 */

namespace ACL\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactController
 * @package ACL\MainBundle\Controller
 *
 *
 *
 */
class ContactController extends Controller {

    /**
     * @Route(path="/contato", name="acl_contact" )
     */
    public function indexAction(Request $request){

    }

    /**
     * @Route(path="/contato/send", name="acl_contact_send" )
     */
    public function contactAction(){

    }

    /**
     * @Route(path="/contato/trainning", name="acl_contact_trainning" )
     */
    public function trainningAction(){

    }

} 