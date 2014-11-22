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
		$qb = $this->getRepository()->createQueryBuilder('c')
		           ->select('c')
		           ->where('c.enabled = true')
		;

		$pCategories = $qb->getQuery()->execute();

		$categoryTree = array();

		foreach ($pCategories as $category) {
			$this->putInTree($category, $categoryTree);
		}

		return $categoryTree;
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