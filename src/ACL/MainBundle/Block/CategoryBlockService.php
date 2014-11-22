<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ACL\MainBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\ClassificationBundle\Entity\CategoryManager;
use Sonata\ClassificationBundle\Model\CategoryManagerInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CategoryBlockService
 *
 * Renders categories list
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class CategoryBlockService extends BaseBlockService
{

    protected $categoryManager;

    /**
     * @return CategoryManager
     */
    public function getCategoryManager()
    {
        return $this->categoryManager;
    }

    /**
     * Constructor
     *
     * @param string               $name        A block name
     * @param EngineInterface      $templating  Twig engine service
     * @param CategoryManagerInterface     $categoryManager The Category manager
     */
    public function __construct($name, EngineInterface $templating, CategoryManagerInterface $categoryManager)
    {
        parent::__construct($name, $templating);
        $this->categoryManager = $categoryManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {

	    $rootCategories = $this->getCategoryManager()->getRootCategory()->getChildren();

        return $this->renderResponse($blockContext->getTemplate(), array(
                'categories' => $rootCategories,
                'block'   => $blockContext->getBlock(),
                'context' => $blockContext,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        // no options available
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'template' => 'ACLMainBundle:Block:categories.html.twig',
                'ttl'      => 0
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Categorias da Home';
    }
}