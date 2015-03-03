<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 3/2/2015
 * Time: 7:06 PM
 */

namespace ACL\MainBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('email', 'text', array('attr' => array('placeholder' => 'Email')))
            ->add('subject', 'text', array('attr' => array('placeholder' => 'Assunto')))
            ->add('message', 'textarea', array('attr' => array('placeholder' => 'Mensagem')))
            ->add('type', 'choice', array(
                    'choices'   => array('comercial' => 'Comercial', 'suporte' => 'Técnico'),
                    'multiple' => false,
                    'expanded' => true,
                'required' => true)
                )
            ->setMethod('POST');
    }

    public function getName(){
        return 'contact_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'ACL\MainBundle\Entity\Contact'
        ));
    }


}
