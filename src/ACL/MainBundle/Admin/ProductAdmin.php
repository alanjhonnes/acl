<?php

namespace ACL\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;

class ProductAdmin extends Admin
{

    /**
     * @var Pool
     */
    protected $formatterPool;

    /**
     * @param \Sonata\FormatterBundle\Formatter\Pool $formatterPool
     *
     * @return void
     */
    public function setPoolFormatter( FormatterPool $formatterPool )
    {
        $this->formatterPool = $formatterPool;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters( DatagridMapper $datagridMapper )
    {
        $datagridMapper
            ->add( 'id' )
            ->add( 'title' )
            ->add( 'description' )
            ->add( 'position' );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields( ListMapper $listMapper )
    {
        $listMapper
            ->add( 'id' )
            ->add( 'title' )
            ->add( 'description' )
            ->add( 'position' )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show'   => array(),
                        'edit'   => array(),
                        'delete' => array(),
                    )
                )
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields( FormMapper $formMapper )
    {

        $formMapper
            ->with( 'Geral', array( 'class' => 'col-md-8' ) )
            ->add( 'title' )
            ->add( 'description', 'textarea', array( 'required' => true ) )
            ->add(
                'content',
                'sonata_formatter_type',
                array(
                    'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                    'format_field'         => 'contentFormatter',
                    'source_field'         => 'rawContent',
                    'source_field_options' => array(
                        'attr' => array( 'class' => 'col-md-8', 'rows' => 20 )
                    ),
                    'listener'             => true,
                    'target_field'         => 'content'
                )
            )
            ->end()
            ->with( 'Opções', array( 'class' => 'col-md-4' ) )
            ->add( 'position', 'integer', array( 'required' => false, 'data' => 0 ) )
            ->add( 'category', 'sonata_type_model_list' )
            ->add(
                'mainImage',
                'sonata_type_model_list',
                array( 'required' => false ),
                array(
                    'link_parameters' => array(
                        'context' => 'product'
                    )
                )
            )
            ->add(
                'gallery',
                'sonata_type_model_list',
                array( 'required' => false ),
                array(
                    'link_parameters' => array(
                        //'context' => 'product'
                    )
                )
            )
            ->add(
                'downloads',
                'sonata_type_model_list',
                array( 'required' => false ),
                array(
                    'link_parameters' => array(
                        //'context' => 'product'
                    )
                )
            )
            ->add(
                'videos',
                'sonata_type_model_list',
                array( 'required' => false ),
                array(
                    'link_parameters' => array(
                        //'context' => 'product'
                    )
                )
            )
            ->end();
    }


}
