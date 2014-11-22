<?php

namespace ACL\MainBundle\Controller;

use ACL\MainBundle\Entity\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CatalogController
 * @package ACL\MainBundle\Controller
 * @Route(path="/catalogo")
 */
class CatalogController extends Controller
{

	protected $request;

	/**
	 * @param $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @Route(name="catalog_index", path="/")
	 * @Route(name="catalog_category", path="/{category_slug}/{category_id}")
	 *
	 * @throws NotFoundHttpException
	 *
	 */
	public function indexAction(Request $request, $category_slug = 'all', $category_id = 0)
	{

		$this->request = $request;
		$page        = $this->request->get('page', 1);
		$displayMax  = $this->request->get('max', 9);
		$displayMode = $this->request->get('mode', 'grid');
		$filter      = $this->request->get('filter');
		$option      = $this->request->get('option');

		if (!in_array($displayMode, array('grid'))) { // "list" mode will be added later
			throw new NotFoundHttpException(sprintf('Given display_mode "%s" doesn\'t exist.', $displayMode));
		}

		$category = $this->retrieveCategoryFromQueryString();

		$this->get('sonata.seo.page')->setTitle($category ? $category->getName() : $this->get('translator')->trans('catalog_index_title'));

		$pager = $this->get('knp_paginator');
		$pagination = $pager->paginate($this->getProductManager()->getCategoryActiveProductsQueryBuilder($category, $filter, $option), $page, $displayMax);

		return $this->render('ACLMainBundle:Catalog:index.html.twig', array(
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
		$categoryId   = $this->request->get('category_id');
		$categorySlug = $this->request->get('category_slug');

		if (!$categoryId || !$categorySlug) {
			return null;
		}

		return $this->getCategoryManager()->findOneBy(array(
			'id'      => $categoryId,
			'enabled' => true,
		));
	}

	/**
	 * @return ProductManager
	 */
	protected function getProductManager()
	{
		return $this->get('acl.main.product.manager');
	}

	/**
	 * @return CategoryManager
	 */
	protected function getCategoryManager()
	{
		return $this->get('sonata.classification.manager.category');
	}
}
