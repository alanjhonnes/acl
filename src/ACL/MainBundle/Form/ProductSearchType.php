<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 12/26/2014
 * Time: 8:29 PM
 */

namespace ACL\MainBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductSearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'search', array('horizontal_input_wrapper_class' => 'catalog-search-form'))
        ->setMethod('GET')
        ->setAttribute('class', 'catalog-search-form');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    public function getName(){
        return '';
    }


}