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

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadMediaData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    function getOrder()
    {
        return 2;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $gallery = $this->getGalleryManager()->create();

        $manager = $this->getMediaManager();
        $faker = $this->getFaker();

        $galleryFiles = Finder::create()->name('*.jpg')->in(__DIR__.'/../data/gallery');
		$iconFiles = Finder::create()->name('*.png')->in(__DIR__.'/../data/icons');

        $i = 0;
        foreach ($galleryFiles as $file) {
            $media = $manager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setName('Imagem galeria 1');
            $media->setDescription('Descricao da imagem');
            $media->setAuthorName('');
            $media->setCopyright('CC BY-NC-SA 4.0');

            $this->addReference('sonata-media-'.($i++), $media);

            $manager->save($media, 'default', 'sonata.media.provider.image');

            $this->addMedia($gallery, $media);
        }
		$i = 0;
	    foreach ($iconFiles as $file) {
		    $media = $manager->create();
		    $media->setBinaryContent($file);
		    $media->setEnabled(true);
		    $media->setName($file->getBasename());
		    $media->setDescription('Descricao da imagem');
		    $media->setAuthorName('');
		    $media->setCopyright('CC BY-NC-SA 4.0');
			$media->setContext('Categorias');
		    $this->addReference('icon-'.$file->getBasename('.png'), $media);

		    $manager->save($media, 'sonata_category', 'sonata.media.provider.image');

	    }
//
//        foreach ($paris as $file) {
//            $media = $manager->create();
//            $media->setBinaryContent($file);
//            $media->setEnabled(true);
//            $media->setName('Paris');
//            $media->setDescription('Paris');
//            $media->setAuthorName('Hugo Briand');
//            $media->setCopyright("CC BY-NC-SA 4.0");
//
//            $this->addReference('sonata-media-'.($i++), $media);
//
//            $manager->save($media, 'default', 'sonata.media.provider.image');
//
//            $this->addMedia($gallery, $media);
//        }
//
//        foreach ($switzerland as $file) {
//            $media = $manager->create();
//            $media->setBinaryContent($file);
//            $media->setEnabled(true);
//            $media->setName('Switzerland');
//            $media->setDescription('Switzerland');
//            $media->setAuthorName('Sylvain Deloux');
//            $media->setCopyright('CC BY-NC-SA 4.0');
//
//            $this->addReference('sonata-media-'.($i++), $media);
//
//            $manager->save($media, 'default', 'sonata.media.provider.image');
//
//            $this->addMedia($gallery, $media);
//        }

        $gallery->setEnabled(true);
        $gallery->setName('Galeria da Homepage');

        $gallery->setDefaultFormat('full');
        $gallery->setContext('default');

        $this->getGalleryManager()->update($gallery);

        $this->addReference('media-gallery', $gallery);
    }

    /**
     * @param \Sonata\MediaBundle\Model\GalleryInterface $gallery
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     * @return void
     */
    public function addMedia(GalleryInterface $gallery, MediaInterface $media)
    {
        $galleryHasMedia = new \Application\Sonata\MediaBundle\Entity\GalleryHasMedia();
        $galleryHasMedia->setMedia($media);
        $galleryHasMedia->setPosition(count($gallery->getGalleryHasMedias()) + 1);
        $galleryHasMedia->setEnabled(true);

        $gallery->addGalleryHasMedias($galleryHasMedia);
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getGalleryManager()
    {
        return $this->container->get('sonata.media.manager.gallery');
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }
}