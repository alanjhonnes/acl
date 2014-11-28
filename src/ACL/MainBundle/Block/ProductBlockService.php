<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/26/2014
 * Time: 11:49 AM
 */

namespace ACL\MainBundle\Block;


use ACL\MainBundle\Entity\Product;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use ACL\MainBundle\Entity\ProductManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

class ProductBlockService extends BaseBlockService{

	protected $container;

	protected $productAdmin;

	/**
	 * @var ProductManager
	 */
	protected $productManager;

	/**
	 * @param string          $name
	 * @param EngineInterface $templating
	 * @param ProductManager $productManager
	 */
	public function __construct($name, EngineInterface $templating, ContainerInterface $container,ProductManager $productManager)
	{
		$this->name       = $name;
		$this->templating = $templating;
		$this->container = $container;
		$this->productManager = $productManager;
	}



	public function buildEditForm( FormMapper $formMapper, BlockInterface $block ) {

		$fieldDescription = $this->getProductAdmin()->getModelManager()->getNewFieldDescriptionInstance($this->getProductAdmin()->getClass(), 'product' );
		$fieldDescription->setAssociationAdmin($this->getProductAdmin());
		$fieldDescription->setAdmin($formMapper->getAdmin());
		$fieldDescription->setOption('edit', 'list');
		$fieldDescription->setAssociationMapping(array('fieldName' => 'product', 'type' => \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_ONE));

		$builder = $formMapper->create('productId', 'sonata_type_model_list', array(
			'sonata_field_description' => $fieldDescription,
			'class'             => $this->getProductAdmin()->getClass(),
			'model_manager'     => $this->getProductAdmin()->getModelManager()
		));

		$formMapper->add('settings', 'sonata_type_immutable_array', array(
			'keys' => array(
				array($builder, null, array('label' => 'Produto')),
			)
		));
	}

	/**
	 * @return \Sonata\AdminBundle\Admin\AdminInterface
	 */
	public function getProductAdmin()
	{
		if (!$this->productAdmin) {
			$this->productAdmin = $this->container->get('acl_main.admin.product');
		}

		return $this->productAdmin;
	}

	public function execute( BlockContextInterface $blockContext, Response $response = null ) {
		$product = $blockContext->getBlock()->getSetting('productId');

		//$product = new Product();

		return $this->renderResponse($blockContext->getTemplate(), array(
			'product'   => $product,
			'block'     => $blockContext->getBlock(),
			'settings'  => $blockContext->getSettings(),
		), $response);

	}

	public function setDefaultSettings( OptionsResolverInterface $resolver ) {
		parent::setDefaultSettings( $resolver );

		$resolver->setDefaults(array(
			'template' => 'ACLMainBundle:Block:product.html.twig',
			'productId' => null,
		));
	}

	public function load(BlockInterface $block)
	{
		$product = $block->getSetting('productId');

		if ($product) {
			$product = $this->productManager->findFullDetails($product);
		}

		$block->setSetting('productId', $product);
	}

	/**
	 * {@inheritdoc}
	 */
	public function prePersist(BlockInterface $block)
	{
		$block->setSetting('productId', is_object($block->getSetting('productId')) ? $block->getSetting('productId')->getId() : null);
	}

	/**
	 * {@inheritdoc}
	 */
	public function preUpdate(BlockInterface $block)
	{
		$block->setSetting('productId', is_object($block->getSetting('productId')) ? $block->getSetting('productId')->getId() : null);
	}

	public function getName() {
		return 'Produto';
	}


}