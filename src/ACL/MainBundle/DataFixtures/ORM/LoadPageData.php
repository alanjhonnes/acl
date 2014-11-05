<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACL\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Sonata\PageBundle\Model\SiteInterface;
use Sonata\PageBundle\Model\PageInterface;

use Symfony\Cmf\Bundle\RoutingBundle\Tests\Unit\Doctrine\Orm\ContentRepositoryTest;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPageData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function getOrder()
    {
        return 4;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $site = $this->createSite();
        $this->createGlobalPage($site);
        $this->createHomePage($site);
        $this->create404ErrorPage($site);
        $this->create500ErrorPage($site);
        $this->createBlogIndex($site);

	    $this->createProductPage($site);
	    $this->createWhoWeArePage($site);
	    $this->createContactUsPage($site);


        //$this->createGalleryIndex($site);
        //$this->createMediaPage($site);

        //$this->createBasketPage($site);
        //$this->createUserPage($site);
        //$this->createApiPage($site);
        //$this->createLegalNotesPage($site);
        //$this->createTermsPage($site);

        // Create footer pages

        //$this->createClientTestimonialsPage($site);
        //$this->createPressPage($site);
        //$this->createFAQPage($site);

        //$this->createBundlesPage($site);

        //$this->createSubSite();
    }

    /**
     * @return SiteInterface $site
     */
    public function createSite()
    {
        $site = $this->getSiteManager()->create();

        $site->setHost('localhost');
        $site->setEnabled(true);
        $site->setName('localhost');
        $site->setEnabledFrom(new \DateTime('now'));
        $site->setEnabledTo(new \DateTime('+20 years'));
        $site->setRelativePath("");
        $site->setIsDefault(true);

        $this->getSiteManager()->save($site);

        return $site;
    }


    /**
     * @param SiteInterface $site
     */
    public function createBlogIndex(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();

        $blogIndex = $pageManager->create();
        $blogIndex->setSlug('blog');
        $blogIndex->setUrl('/blog');
        $blogIndex->setName('News');
        $blogIndex->setTitle('News');
        $blogIndex->setEnabled(true);
        $blogIndex->setDecorate(1);
        $blogIndex->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $blogIndex->setTemplateCode('default');
        $blogIndex->setRouteName('sonata_news_home');
        $blogIndex->setParent($this->getReference('page-homepage'));
        $blogIndex->setSite($site);

        $pageManager->save($blogIndex);
    }


    /**
     * @param SiteInterface $site
     */
    public function createHomePage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        $this->addReference('page-homepage', $homepage = $pageManager->create());
        $homepage->setSlug('/');
        $homepage->setUrl('/');
        $homepage->setName('Home');
        $homepage->setTitle('Homepage');
        $homepage->setEnabled(true);
        $homepage->setDecorate(1);
        $homepage->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $homepage->setTemplateCode('default');
        $homepage->setRouteName(PageInterface::PAGE_ROUTE_CMS_NAME);
        $homepage->setSite($site);

        $pageManager->save($homepage);

        // CREATE A HEADER BLOCK
        $homepage->addBlocks($contentTop = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $homepage,
            'code' => 'content_top',
        )));

        $contentTop->setName('The container top container');

        $blockManager->save($contentTop);

        // add a block text
        $contentTop->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', <<<CONTENT
<div class="col-md-3 welcome"><h2>Welcome</h2></div>
<div class="col-md-9">
    <p>
        This page is a demo of the Sonata Sandbox available on <a href="https://github.com/sonata-project/sandbox">github</a>.
        This demo try to be interactive so you will be able to found out the different features provided by the Sonata's Bundle.
    </p>

    <p>
        First this page and all the other pages are served by the <code>SonataPageBundle</code>, a page is composed by different
        blocks.
    </p>
</div>
CONTENT
        );
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($homepage);


        $homepage->addBlocks($content = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $homepage,
            'code' => 'content',
        )));
        $content->setName('The content container');
        $blockManager->save($content);

//        // Add media gallery block
//        $content->addChildren($gallery = $blockManager->create());
//        $gallery->setType('sonata.media.block.gallery');
//        $gallery->setSetting('galleryId', $this->getReference('media-gallery')->getId());
//        $gallery->setSetting('context', 'default');
//        $gallery->setSetting('format', 'big');
//        $gallery->setPosition(1);
//        $gallery->setEnabled(true);
//        $gallery->setPage($homepage);

	    //TODO add ACL categories block

	    //TODO add ACL partners page

        // Add recent products block
//        $content->addChildren($newProductsBlock = $blockManager->create());
//        $newProductsBlock->setType('sonata.product.block.recent_products');
//        $newProductsBlock->setSetting('number', 4);
//        $newProductsBlock->setSetting('title', 'New products');
//        $newProductsBlock->setPosition(2);
//        $newProductsBlock->setEnabled(true);
//        $newProductsBlock->setPage($homepage);

        // Add homepage bottom container
        $homepage->addBlocks($bottom = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $homepage,
            'code'    => 'content_bottom',
        ), function ($container) {
            $container->setSetting('layout', '{{ CONTENT }}');
        }));
        $bottom->setName('The bottom content container');

//        // Add homepage newsletter container
//        $bottom->addChildren($bottomNewsletter = $blockInteractor->createNewContainer(array(
//            'enabled' => true,
//            'page'    => $homepage,
//            'code'    => 'bottom_newsletter',
//        ), function ($container) {
//            $container->setSetting('layout', '<div class="block-newsletter col-sm-6 well">{{ CONTENT }}</div>');
//        }));
//        $bottomNewsletter->setName('The bottom newsetter container');
//        $bottomNewsletter->addChildren($newsletter = $blockManager->create());
//        $newsletter->setType('sonata.demo.block.newsletter');
//        $newsletter->setPosition(1);
//        $newsletter->setEnabled(true);
//        $newsletter->setPage($homepage);
//
//        // Add homepage embed tweet container
//        $bottom->addChildren($bottomEmbed = $blockInteractor->createNewContainer(array(
//            'enabled' => true,
//            'page'    => $homepage,
//            'code'    => 'bottom_embed',
//        ), function ($container) {
//            $container->setSetting('layout', '<div class="col-sm-6">{{ CONTENT }}</div>');
//        }));
//        $bottomEmbed->setName('The bottom embedded tweet container');
//        $bottomEmbed->addChildren($embedded = $blockManager->create());
//        $embedded->setType('sonata.seo.block.twitter.embed');
//        $embedded->setPosition(1);
//        $embedded->setEnabled(true);
//        $embedded->setSetting('tweet', "https://twitter.com/dunglas/statuses/438337742565826560");
//        $embedded->setSetting('lang', "en");
//        $embedded->setPage($homepage);

        $pageManager->save($homepage);
    }

    /**
     * @param SiteInterface $site
     */
    public function createProductPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();

        $category = $pageManager->create();

        $category->setSlug('shop-category');
        $category->setUrl('/shop/category');
        $category->setName('Shop');
        $category->setTitle('Shop');
        $category->setEnabled(true);
        $category->setDecorate(1);
        $category->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $category->setTemplateCode('default');
        $category->setRouteName('sonata_catalog_index');
        $category->setSite($site);
        $category->setParent($this->getReference('page-homepage'));

        $pageManager->save($category);
    }



    /**
     * Creates the "Who we are" content page (link available in footer)
     *
     * @param SiteInterface $site
     *
     * @return void
     */
    public function createWhoWeArePage(SiteInterface $site)
    {
        $this->createTextContentPage($site, 'who-we-are', 'Who we are', <<<CONTENT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut quis sapien gravida, eleifend diam id, vehicula erat. Aenean ultrices facilisis tellus. Vivamus vitae molestie diam. Donec quis mi porttitor, lobortis ipsum quis, fermentum dui. Donec nec nibh nec risus porttitor pretium et et lorem. Nullam mauris sapien, rutrum sed neque et, convallis ullamcorper lacus. Nullam vehicula a lectus vel suscipit. Nam gravida faucibus fermentum.</p>
<p>Pellentesque dapibus eu nisi quis adipiscing. Phasellus adipiscing turpis nunc, sed interdum ante porta eu. Ut tempus, purus posuere molestie cursus, quam nisi fermentum est, dictum gravida nulla turpis vel nunc. Maecenas eget sem quam. Nam condimentum mi id lectus venenatis, sit amet semper purus convallis. Nunc ullamcorper magna mi, non adipiscing velit semper quis. Duis vel justo libero. Suspendisse laoreet hendrerit augue cursus congue. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
<p>Nullam dignissim sapien vestibulum erat lobortis, sed imperdiet elit varius. Fusce nisi eros, feugiat commodo scelerisque a, lacinia et quam. In neque risus, dignissim non magna non, ultricies faucibus elit. Vivamus in facilisis enim, porttitor volutpat justo. Praesent placerat feugiat nibh et fermentum. Vivamus eu fermentum metus. Sed mattis volutpat quam a suscipit. Donec blandit sagittis est, ac tristique arcu venenatis sed. Fusce vel libero id lectus aliquet sollicitudin. Fusce ultrices porta est, non pellentesque lorem accumsan eget. Fusce id libero sit amet nulla venenatis dapibus. Maecenas fermentum tellus eu magna mollis gravida. Nam non nibh magna.</p>
CONTENT
        );
    }

    /**
     * Creates the "Contact us" content page (link available in footer)
     *
     * @param SiteInterface $site
     *
     * @return void
     */
    public function createContactUsPage(SiteInterface $site)
    {
        $this->createTextContentPage($site, 'contact-us', 'Contact us', <<<CONTENT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut quis sapien gravida, eleifend diam id, vehicula erat. Aenean ultrices facilisis tellus. Vivamus vitae molestie diam. Donec quis mi porttitor, lobortis ipsum quis, fermentum dui. Donec nec nibh nec risus porttitor pretium et et lorem. Nullam mauris sapien, rutrum sed neque et, convallis ullamcorper lacus. Nullam vehicula a lectus vel suscipit. Nam gravida faucibus fermentum.</p>
<p>Pellentesque dapibus eu nisi quis adipiscing. Phasellus adipiscing turpis nunc, sed interdum ante porta eu. Ut tempus, purus posuere molestie cursus, quam nisi fermentum est, dictum gravida nulla turpis vel nunc. Maecenas eget sem quam. Nam condimentum mi id lectus venenatis, sit amet semper purus convallis. Nunc ullamcorper magna mi, non adipiscing velit semper quis. Duis vel justo libero. Suspendisse laoreet hendrerit augue cursus congue. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
<p>Nullam dignissim sapien vestibulum erat lobortis, sed imperdiet elit varius. Fusce nisi eros, feugiat commodo scelerisque a, lacinia et quam. In neque risus, dignissim non magna non, ultricies faucibus elit. Vivamus in facilisis enim, porttitor volutpat justo. Praesent placerat feugiat nibh et fermentum. Vivamus eu fermentum metus. Sed mattis volutpat quam a suscipit. Donec blandit sagittis est, ac tristique arcu venenatis sed. Fusce vel libero id lectus aliquet sollicitudin. Fusce ultrices porta est, non pellentesque lorem accumsan eget. Fusce id libero sit amet nulla venenatis dapibus. Maecenas fermentum tellus eu magna mollis gravida. Nam non nibh magna.</p>
CONTENT
        );
    }



    /**
     * Creates simple content pages
     *
     * @param SiteInterface $site    A Site entity instance
     * @param string        $url     A page URL
     * @param string        $title   A page title
     * @param string        $content A text content
     *
     * @return void
     */
    public function createTextContentPage(SiteInterface $site, $url, $title, $content)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        $page = $pageManager->create();
        $page->setSlug(sprintf('/%s', $url));
        $page->setUrl(sprintf('/%s', $url));
        $page->setName($title);
        $page->setTitle($title);
        $page->setEnabled(true);
        $page->setDecorate(1);
        $page->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $page->setTemplateCode('default');
        $page->setRouteName('page_slug');
        $page->setSite($site);
        $page->setParent($this->getReference('page-homepage'));

        $page->addBlocks($block = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $page,
            'code'    => 'content_top',
        )));

//        // add the breadcrumb
//        $block->addChildren($breadcrumb = $blockManager->create());
//        $breadcrumb->setType('sonata.page.block.breadcrumb');
//        $breadcrumb->setPosition(0);
//        $breadcrumb->setEnabled(true);
//        $breadcrumb->setPage($page);

        // Add text content block
        $block->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', sprintf('<h2>%s</h2><div>%s</div>', $title, $content));
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($page);

        $pageManager->save($page);
    }

    public function create404ErrorPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        $page = $pageManager->create();
        $page->setName('_page_internal_error_not_found');
        $page->setTitle('Error 404');
        $page->setEnabled(true);
        $page->setDecorate(1);
        $page->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $page->setTemplateCode('default');
        $page->setRouteName('_page_internal_error_not_found');
        $page->setSite($site);

        $page->addBlocks($block = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $page,
            'code'    => 'content_top',
        )));

        // add the breadcrumb
//        $block->addChildren($breadcrumb = $blockManager->create());
//        $breadcrumb->setType('sonata.page.block.breadcrumb');
//        $breadcrumb->setPosition(0);
//        $breadcrumb->setEnabled(true);
//        $breadcrumb->setPage($page);

        // Add text content block
        $block->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<h2>Error 404</h2><div>Page not found.</div>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($page);

        $pageManager->save($page);
    }

    public function create500ErrorPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        $page = $pageManager->create();
        $page->setName('_page_internal_error_fatal');
        $page->setTitle('Error 500');
        $page->setEnabled(true);
        $page->setDecorate(1);
        $page->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $page->setTemplateCode('default');
        $page->setRouteName('_page_internal_error_fatal');
        $page->setSite($site);

        $page->addBlocks($block = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $page,
            'code'    => 'content_top',
        )));

        // add the breadcrumb
//        $block->addChildren($breadcrumb = $blockManager->create());
//        $breadcrumb->setType('sonata.page.block.breadcrumb');
//        $breadcrumb->setPosition(0);
//        $breadcrumb->setEnabled(true);
//        $breadcrumb->setPage($page);

        // Add text content block
        $block->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<h2>Error 500</h2><div>Internal error.</div>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($page);

        $pageManager->save($page);
    }

    /**
     * @param SiteInterface $site
     */
    public function createGlobalPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        $global = $pageManager->create();
        $global->setName('global');
        $global->setRouteName('_page_internal_global');
        $global->setSite($site);

        $pageManager->save($global);

        // CREATE A HEADER BLOCK
        $global->addBlocks($header = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $global,
            'code' => 'header',
        )));

        $header->setName('The header container');

        $header->addChildren($text = $blockManager->create());

        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<a class="logo" href="/"><img src="/img/logo.png" alt="ACL Security"/></a></h2>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);

        $global->addBlocks($headerTop = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $global,
            'code' => 'header-top',
        ), function ($container) {
            $container->setSetting('layout', '<div class="pull-right">{{ CONTENT }}</div>');
        }));

        $headerTop->setPosition(1);

        $header->addChildren($headerTop);



        $global->addBlocks($headerMenu = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $global,
            'code' => 'header-menu',
        )));

        $headerMenu->setPosition(2);

        $header->addChildren($headerMenu);

        $headerMenu->setName('The header menu container');
        $headerMenu->setPosition(3);
        $headerMenu->addChildren($menu = $blockManager->create());

        $menu->setType('sonata.block.service.menu');
        $menu->setSetting('menu_name', "ACLMainBundle:Builder:mainMenu");
        $menu->setSetting('safe_labels', true);
        $menu->setPosition(3);
        $menu->setEnabled(true);
        $menu->setPage($global);

        $global->addBlocks($footer = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'footer'
        ), function ($container) {
            $container->setSetting('layout', '<div class="row page-footer well">{{ CONTENT }}</div>');
        }));

        $footer->setName('The footer container');

        // Footer : add 3 children block containers (left, center, right)
        $footer->addChildren($footerLeft = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content'
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-3">{{ CONTENT }}</div>');
        }));

        $footer->addChildren($footerLinksLeft = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content',
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-2 col-sm-offset-3">{{ CONTENT }}</div>');
        }));

        $footer->addChildren($footerLinksCenter = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content'
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-2">{{ CONTENT }}</div>');
        }));

        $footer->addChildren($footerLinksRight = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content'
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-2">{{ CONTENT }}</div>');
        }));

        // Footer left: add a simple text block
        $footerLeft->addChildren($text = $blockManager->create());

        $text->setType('acl.block.service.partners');
//        $text->setSetting('content', '<h2>Sonata Demo</h2><p class="handcraft">HANDCRAFTED IN PARIS<br />WITH MIXED HERITAGE</p><p><a href="http://twitter.com/sonataproject" target="_blank">Follow Sonata on Twitter</a></p>');

        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);


        $pageManager->save($global);
    }

    /**
     * @return \Sonata\PageBundle\Model\SiteManagerInterface
     */
    public function getSiteManager()
    {
        return $this->container->get('sonata.page.manager.site');
    }

    /**
     * @return \Sonata\PageBundle\Model\PageManagerInterface
     */
    public function getPageManager()
    {
        return $this->container->get('sonata.page.manager.page');
    }

    /**
     * @return \Sonata\BlockBundle\Model\BlockManagerInterface
     */
    public function getBlockManager()
    {
        return $this->container->get('sonata.page.manager.block');
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }

    /**
     * @return \Sonata\PageBundle\Entity\BlockInteractor
     */
    public function getBlockInteractor()
    {
        return $this->container->get('sonata.page.block_interactor');
    }
}
