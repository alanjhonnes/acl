<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ACL\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sonata\ClassificationBundle\Entity\CategoryManager;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\ClassificationBundle\Model\CategoryManagerInterface;
use Sonata\Component\Product\ProductCategoryManagerInterface;
use Sonata\Component\Product\ProductProviderInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;


/**
 * Class ProductMenuBuilder
 */
class ProductMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var RouterInterface
     */
    protected $router;

	protected $categoryManager;

    /**
     * Constructor
     *
     * @param MenuFactory                     $factory
     * @param CategoryManagerInterface        $categoryManager
     * @param RouterInterface                 $router
     */
    public function __construct(FactoryInterface $factory, CategoryManagerInterface $categoryManager, RouterInterface $router)
    {
        $this->factory         = $factory;
        $this->router          = $router;
	    $this->categoryManager = $categoryManager;
    }

    /**
     * @param array  $itemOptions The options given to the created menuItem
     * @param string $currentUri  The current URI
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createCategoryMenu(array $itemOptions = array(), $currentUri = null)
    {
        $menu = $this->factory->createItem('categories', $itemOptions);

        $this->buildCategoryMenu($menu, $itemOptions, $currentUri);

        return $menu;
    }

    /**
     * @param \Knp\Menu\ItemInterface $menu        The item to fill with $routes
     * @param array                   $options     The item options
     * @param string                  $currentUri  The current URI
     */
    public function buildCategoryMenu(ItemInterface $menu, array $options = array(), $currentUri = null)
    {
        $categories = $this->categoryManager->getCategoryTree();

        $this->fillMenu($menu, $categories, $options, $currentUri);
    }

    /**
     * Recursive method to fill $menu with $categories
     *
     * @param ItemInterface $menu
     * @param array         $categories
     * @param array         $options
     * @param string        $currentUri
     */
    protected function fillMenu(ItemInterface $menu, $categories, array $options = array(), $currentUri = null)
    {
        foreach ($categories as $category) {
            if (false === $category->getEnabled()) {
                continue;
            }

            $fullOptions = array_merge(array(
                'attributes'      => array('class' => ""),      // Ensuring it is set
                'route'           => 'catalog_category',
                'routeParameters' => array(
                    'category_id'   => $category->getId(),
                    'category_slug' => $category->getSlug()
                ),
                'extras'           => array(
                    'safe_label' => true
                )
            ), $options);

            if (null === $category->getParent()) {
                $fullOptions['attributes']['class'] = 'lead '.$fullOptions['attributes']['class'];
            }

            $child = $menu->addChild(
                $this->getCategoryTitle($category),
                $fullOptions
            );

            if (count($category->getChildren()) > 0) {
                if (null === $category->getParent()) {
                    $this->fillMenu($menu, $category->getChildren(), $options, $currentUri);
                } else {
                    $this->fillMenu($child, $category->getChildren(), $options, $currentUri);
                }
            }
        }
    }

    /**
     * Gets the HTML associated with the category menu title
     *
     * @param CategoryInterface $category A category instance*
     * @return string
     */
    protected function getCategoryTitle(CategoryInterface $category)
    {
        return sprintf("%s", $category->getName());
    }
}