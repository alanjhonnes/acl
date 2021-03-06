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
use Symfony\Component\DependencyInjection\ContainerAware;


/**
 * Class Builder
 *
 * @package Sonata\Bundle\DemoBundle\Menu
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class Builder extends ContainerAware
{
    /**
     * Creates the header menu
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $isFooter = array_key_exists('is_footer', $options) ? $options['is_footer'] : false;

        $shopCategories = $this->container->get('sonata.classification.manager.category')->findBy(array('enabled' => true, 'parent' => null));

        $menuOptions = array_merge($options, array(
            'childrenAttributes' => array('class' => 'nav nav-justified nav-top'),
        ));

        $menu = $factory->createItem('main', $menuOptions);


        $shopMenuParams = array('route' => 'sonata_catalog_index');

//        if (count($shopCategories) > 0 && !$isFooter) {
//            $shopMenuParams = array_merge($shopMenuParams, array(
//                'attributes' => array('class' => 'dropdown'),
//                'childrenAttributes' => array('class' => 'dropdown-menu'),
//                'linkAttributes' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'data-target' => '#'),
//                'label' => 'Products <b class="caret caret-menu"></b>',
//                'extras' => array(
//                    'safe_label' => true,
//                )
//            ));
//        }
//
//        if ($isFooter) {
//            $shopMenuParams = array_merge($shopMenuParams, array(
//                'attributes' => array('class' => 'span2'),
//                "childrenAttributes" => array('class' => 'nav')
//            ));
//        }

        $menu->addChild('Empresa', array( 'route' => 'page_slug',
                                          'routeParameters' => array(
                                              'path' => '/empresa',
                                          )));



        $shop = $menu->addChild('Produtos', array('label' => 'Produtos', 'route' => 'catalog_index',
            'extras' => array(
                'routes' => array('catalog_category', 'catalog_product', 'catalog_search')
            )));

        $menu->addChild('Parceiros', array( 'route' => 'partners_index'));

        $menu->addChild('Notícias', array('route' => 'sonata_news_archive',
            'extras' => array(
                'routes' => array('sonata_news_view', 'sonata_news_tag')
            )));

        $menu->addChild('Cases', array( 'route' => 'acl.main.project.index'));

        $menu->addChild('Treinamento', array( 'route' => 'acl.main.trainning.index',
            'extras' => array('routes' => array('acl.main.trainning.search'))
        ));

        $menu->addChild('Contato', array( 'route' => 'acl.main.contact.index'));

//        foreach ($shopCategories as $category) {
//            $shop->addChild($category->getName(), array(
//                'route' => 'sonata_catalog_category',
//                'routeParameters' => array(
//                    'category_id'   => $category->getId(),
//                    'category_slug' => $category->getSlug()),
//                )
//            );
//        }


        return $menu;
    }

    public function footerMenu(FactoryInterface $factory, array $options)
    {
        return $this->mainMenu($factory, array_merge($options, array('is_footer' => true)));
    }
}
