<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/17/2014
 * Time: 2:57 PM
 */

namespace ACL\MainBundle\Entity;


use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\CoreBundle\Model\BaseEntityManager;

class ProductManager extends BaseEntityManager {


	public function getCategoryActiveProductsQueryBuilder(CategoryInterface $category = null, $filter = null, $option = null)
	{
		$queryBuilder = $this->getCategoryProductsQueryBuilder($category);
		$queryBuilder->andWhere('p.enabled = :enabled')
		             ->setParameter('enabled', true);

		if (null !== $filter) {
			// TODO manage various filter types
			$queryBuilder->andWhere(sprintf("p.%s %s :%s", $filter, '>', $filter))
			             ->setParameter(sprintf(":%s", $filter), $option);
		}

		return $queryBuilder;
	}

	/**
	 * Returns QueryBuilder for products.
	 *
	 * @param CategoryInterface $category
	 *
	 * @return QueryBuilder
	 */
	protected function getCategoryProductsQueryBuilder(CategoryInterface $category = null)
	{
		$queryBuilder = $this->getRepository()->createQueryBuilder('p')
		                     ->leftJoin('p.image', 'i')
		                     ->leftJoin('p.gallery', 'g');

		if ($category) {
			$queryBuilder
				->leftJoin('p.category', 'c')
				->andWhere('p.category = :categoryId')
				->setParameter('categoryId', $category->getId());
		}

		return $queryBuilder;
	}

	/**
	 * Retrieve an active product from its id and its slug
	 *
	 * @param int    $id
	 * @param string $slug
	 *
	 * @return ProductInterface|null
	 */
	public function findEnabledFromIdAndSlug($id, $slug)
	{
		return $this->getRepository()
		            ->findOneBy(array(
			            'id' => $id,
			            'slug' => $slug,
			            'enabled' => true
		            ));
	}

} 