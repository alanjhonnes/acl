<?php

namespace ACL\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TrainningSessionAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('content')
            ->add('details')
            ->add('category')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('content')
            ->add('category')
            ->add('date')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with( 'Geral', array( 'class' => 'col-md-8' ) )
                ->add('name', 'text', array('label' => 'Nome'))
                ->add('content', 'ckeditor', array('label' => 'Conteúdo'))
                ->add('details', 'ckeditor', array('label' => 'Detalhes'))
                ->add('requirements', 'ckeditor', array('label' => 'Requisitos'))
                ->add('subscription', 'ckeditor', array('label' => 'Inscrições'))
                ->add('review', 'ckeditor', array('label' => 'Avaliação do treinamento'))
                ->add('equipment', 'ckeditor', array('label' => 'Material do participante'))
                ->add('transport', 'ckeditor', array('label' => 'Transporte'))
                ->add('rules', 'ckeditor', array('label' => 'Regras de Conduta'))
            ->end()
            ->with( 'Detalhes', array( 'class' => 'col-md-4' ) )
                ->add('date', 'sonata_type_date_picker', array('label' => 'Data'))
                ->add( 'category', 'sonata_type_model_list', array('label' => 'Categoria', 'required' => true) )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => 'Id'))
            ->add('name', null, array('label' => 'Nome'))
            ->add('content', null, array('label' => 'Conteúdo'))
            ->add('category', null, array('label' => 'Categoria'))
            ->add('date', null, array('label' => 'Data'))
            ->add('details', null, array('label' => 'Detalhes'))
            ->add('requirements', null, array('label' => 'Requisitos'))
            ->add('subscription', null, array('label' => 'Inscrições'))
            ->add('review', null, array('label' => 'Avaliações'))
            ->add('equipment', null, array('label' => 'Material do participante'))
            ->add('transport', null, array('label' => 'Transporte'))
            ->add('rules', null, array('label' => 'Regras de Conduta'))
        ;
    }
}
