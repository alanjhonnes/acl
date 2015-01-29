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
     * @Route(path="/contato", name="acl.main.contact.index" )
     */
    public function indexAction(Request $request){
        return $this->render('ACLMainBundle:Contact:index.html.twig');
    }

    /**
     * @Route(path="/contato/general", name="acl.main.contact.general" )
     */
    public function contactAction(){

        $this->redirectToRoute('acl.main.contact.index');
    }

    /**
     * @Route(path="/contato/tecnical", name="acl.main.contact.tecnical" )
     */
    public function tecnicalAction(){
        $this->redirectToRoute('acl.main.contact.index');
    }

} 
