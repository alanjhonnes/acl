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

use ACL\MainBundle\Entity\Brand;
use Application\Sonata\ProductBundle\Entity\Collection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadBrandData
 *
 * @package Sonata\Bundle\EcommerceDemoBundle\DataFixtures\ORM
 *
 * @author  Hugo Briand <briand@ekino.com>
 */
class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
	/**
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	protected $container;

	/**
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager)
	{

		$brand = new Brand();
		$brand->setName('Honeywell');
		$this->addReference('brand-' . $brand->getName(), $brand);
		$manager->persist($brand);


		$manager->flush();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 0;
	}
}
