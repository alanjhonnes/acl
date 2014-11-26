<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACL\MainBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\TextBlockService;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author     Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class RichTextBlockService extends TextBlockService
{

	/**
	 * {@inheritdoc}
	 */
	public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
	{
		$formMapper->add('settings', 'sonata_type_immutable_array', array(
			'keys' => array(
				array('content', 'ckeditor', array()),
			)
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'Texto';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'content'  => 'Insira o texto aqui',
			'template' => 'SonataBlockBundle:Block:block_core_text.html.twig'
		));
	}
}
