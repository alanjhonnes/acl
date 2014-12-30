<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Sonata Project <https://github.com/sonata-project/SonataClassificationBundle/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\ClassificationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Geral', array('class' => 'col-md-6'))
                ->add('name', 'text', array('label' => 'Nome'))
                ->add('description', 'textarea', array('required' => false, 'label' => 'Descrição'))
            ->end()
            ->with('Opções', array('class' => 'col-md-6'))
                ->add('position', 'integer', array('required' => false, 'data' => 0, 'label' => 'Posição'))
                ->add('parent', 'sonata_category_selector', array(
                    'category'      => $this->getSubject() ?: null,
                    'model_manager' => $this->getModelManager(),
                    'class'         => $this->getClass(),
                    'required'      => false,
                    'label' => 'Categoria Pai'
                ))
            ->end()
        ;

        if (interface_exists('Sonata\MediaBundle\Model\MediaInterface')) {
            $formMapper
                ->with('Geral')
                    ->add('media', 'sonata_type_model_list',
                        array('required' => false, 'label' => 'Icone'),
                        array(
                            'link_parameters' => array(
                                'provider' => 'sonata.media.provider.image',
                                'context'  => 'Categorias',
                            )
                        )
                    )
                ->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('enabled')
            ->add('parent')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('slug')
            ->add('description')
            ->add('enabled', null, array('editable' => true))
            ->add('position')
            ->add('parent')
        ;
    }
}
