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
	 * {@inheritdoc}
	 */
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('name')
			->add('subname')
			->add('description')
			->add('position')
		;
	}

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters( DatagridMapper $datagridMapper )
    {
        $datagridMapper
            ->add( 'name' )
            ->add( 'description' )
            ->add( 'position' );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields( ListMapper $listMapper )
    {
        $listMapper
            ->addIdentifier( 'name' )
            ->add( 'subname' )
            ->add( 'description', 'raw' )
            ->add( 'position' )
            ->add( 'category', null, array('associated_property' => 'name', 'label' => 'Categoria') )
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
            ->add( 'name', null, array('label' => 'Nome do Produto') )
            ->add( 'subname', null, array('label' => 'Subtítulo do Produto') )
            ->add( 'description', 'ckeditor', array( 'required' => true, 'label' => 'Descrição' ) )
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
                    'target_field'         => 'content',
                    'label' => 'Específicações Técnicas'
                )
            )
            ->end()
            ->with( 'Opções', array( 'class' => 'col-md-4' ) )
            ->add( 'position', 'integer', array( 'required' => false, 'data' => 0, 'label' => 'Posição' ) )
	        ->add('enabled', null, array('required' => false, 'label' => 'Ativo'))
	        ->add( 'brand', 'sonata_type_model_list', array('label' => 'Marca') )
            ->add( 'category', 'sonata_type_model_list', array('label' => 'Categoria') )
            ->add(
                'image',
                'sonata_type_model_list',
                array( 'required' => false, 'label' => 'Imagem principal' ),
                array(
                    'link_parameters' => array(
                        'context' => 'Produtos'
                    )
                )
            )
            ->add(
                'gallery',
                'sonata_type_model_list',
                array( 'required' => false, 'label' => 'Galeria de Fotos' ),
                array(
                    'link_parameters' => array(
                        'context' => 'Produtos'
                    )
                )
            )
            ->add(
                'downloads',
                'sonata_type_model_list',
                array( 'required' => false, 'label' => 'Galeria de Downloads' ),
                array(
                    'link_parameters' => array(
                        'context' => 'Downloads'
                    )
                )
            )
	        ->add(
		        'softwares',
		        'sonata_type_model_list',
		        array( 'required' => false, 'label' => 'Galeria de Softwares' ),
		        array(
			        'link_parameters' => array(
				        'context' => 'Softwares'
			        )
		        )
	        )
            ->add(
                'videos',
                'sonata_type_model_list',
                array( 'required' => false, 'label' => 'Galeria de Vídeos' ),
                array(
                    'link_parameters' => array(
	                    'context' => 'Videos'
                    )
                )
            )
            ->end();
    }


}
