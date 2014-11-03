<?php

namespace ACL\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class CatalogController extends Controller
{
	/**
	 * @param $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @Route(name="sonata_catalog_index", path="/")
	 * @Route(name="sonata_catalog_category", path="/{category_slug}/{category_id}")
	 *
	 * @throws NotFoundHttpException
	 *
	 */
	public function indexAction(Request $request, $category_slug = 'all', $category_id = 0)
	{


		$page        = $this->getRequest()->get('page', 1);
		$displayMax  = $this->getRequest()->get('max', 9);
		$displayMode = $this->getRequest()->get('mode', 'grid');
		$filter      = $this->getRequest()->get('filter');
		$option      = $this->getRequest()->get('option');

		if (!in_array($displayMode, array('grid'))) { // "list" mode will be added later
			throw new NotFoundHttpException(sprintf('Given display_mode "%s" doesn\'t exist.', $displayMode));
		}

		$category = $this->retrieveCategoryFromQueryString();

		$this->get('sonata.seo.page')->setTitle($category ? $category->getName() : $this->get('translator')->trans('catalog_index_title'));

		$pager = $this->get('knp_paginator');
		$pagination = $pager->paginate($this->getProductSetManager()->getCategoryActiveProductsQueryBuilder($category, $filter, $option), $page, $displayMax);

		return $this->render('SonataProductBundle:Catalog:index.html.twig', array(
			'display_mode' => $displayMode,
			'pager'        => $pagination,
			'category'     => $category,
		));
	}

	/**
	 * Retrieve Category from its id and slug, if any.
	 *
	 * @return CategoryInterface|null
	 */
	protected function retrieveCategoryFromQueryString()
	{
		$categoryId   = $this->getRequest()->get('category_id');
		$categorySlug = $this->getRequest()->get('category_slug');

		if (!$categoryId || !$categorySlug) {
			return null;
		}

		return $this->getCategoryManager()->findOneBy(array(
			'id'      => $categoryId,
			'enabled' => true,
		));
	}

	/**
	 * Gets the product provider associated with $category if any
	 *
	 * @param CategoryInterface $category
	 *
	 * @return null|\Sonata\Component\Product\ProductProviderInterface
	 */
	protected function getProviderFromCategory(CategoryInterface $category = null)
	{
		if (null === $category) {
			return null;
		}

		$product = $this->getProductSetManager()->findProductForCategory($category);

		return $product ? $this->getProductPool()->getProvider($product) : null;
	}

	/**
	 * @return Pool
	 */
	protected function getProductPool()
	{
		return $this->get('sonata.product.pool');
	}

	/**
	 * @return ProductSetManager
	 */
	protected function getProductSetManager()
	{
		return $this->get('sonata.product.set.manager');
	}

	/**
	 * @return CurrencyDetector
	 */
	protected function getCurrencyDetector()
	{
		return $this->get('sonata.price.currency.detector');
	}

	/**
	 * @return CategoryManager
	 */
	protected function getCategoryManager()
	{
		return $this->get('sonata.classification.manager.category');
	}
}
