<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/5/2014
 * Time: 7:28 PM
 */

namespace ACL\MainBundle\Controller;

use ACL\MainBundle\Form\ContactType;
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

        $message = null;

        $form = $this->createForm(new ContactType());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $emailMessage = $this->createEmail()
                ->setSubject('Contato - Site ACL Security')
                ->setFrom('site@aclsecurity.com.br')
                ->setTo($data->getType() . '@aclsecurity.com.br')
                ->setBody(
                    $this->renderView('ACLMainBundle:Contact:email.html.twig',
                        array('email' => $data->getEmail(),
                            'message' => $data->getMessage(),
                            'subject' => $data->getSubject(),
                            'type' => $data->getType()
                        )),
                    'text/html'
                );
            if($this->getMailer()->send($emailMessage)){
               $message = 'Mensagem enviada com sucesso!';
            }
        }

        return $this->render('ACLMainBundle:Contact:index.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message
            )
        );
    }

    /**
     * @return \Swift_Message
     */
    protected function createEmail(){
        return \Swift_Message::newInstance();
    }

    /**
     * @return \Swift_Mailer
     */
    protected function getMailer(){
        return $this->get('mailer');
    }

} 
