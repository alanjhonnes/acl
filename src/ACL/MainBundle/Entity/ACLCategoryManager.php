<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/21/2014
 * Time: 5:26 PM
 */

namespace ACL\MainBundle\Entity;


use Sonata\ClassificationBundle\Entity\CategoryManager;
use Sonata\ClassificationBundle\Model\CategoryInterface;

class ACLCategoryManager extends CategoryManager {


	/**
	 * Gets the category tree
	 *
	 * @return CategoryInterface[]
	 */
	public function getCategoryTree()
	{
		$categories =  $this->getCategories();

		$categoryTree = array();

		foreach ($categories as $category) {
			$this->putInTree($category, $categoryTree);
		}

		return $categoryTree;

//		$qb = $this->getRepository()->createQueryBuilder('c')
//		           ->select('c')
//				   ->leftJoin('c.parent', 'cp')
//			       ->leftJoin('c.media', 'm')
//		           ->where('c.enabled = true')
//
//		;
//
//		$pCategories = $qb->getQuery()->execute();
//
//		$categoryTree = array();
//
//		foreach ($pCategories as $category) {
//			$this->putInTree($category, $categoryTree);
//		}
//
//		return $categoryTree;
	}

	/**
	* Load all categories from the database, the current method is very efficient for < 256 categories
	*
	*/
	protected function loadCategories()
	{
		if ($this->categories !== null) {
			return;
		}

		$this->categories = array();

		$categories = $this->getObjectManager()->createQuery(sprintf('SELECT c FROM %s c INDEX BY c.id ORDER BY c.position ASC', $this->class))
		                   ->execute();

		foreach ($categories as $category) {
			$this->categories[$category->getId()] = $category;

			$parent = $category->getParent();

			$category->disableChildrenLazyLoading();

			if (!$parent) {
				$categories[] = $category;
				continue;
			}

			$parent->addChild($category);
		}
	}

	/**
	 * Finds $category place in $tree
	 *
	 * @param CategoryInterface $category
	 * @param array             $tree
	 */
	protected function putInTree(CategoryInterface $category, array &$tree)
	{
		if (null === $category->getParent()) {
			$tree[$category->getId()] = $category;
		} else {
			$this->putInTree($category->getParent(), $tree);
		}
	}

} 
