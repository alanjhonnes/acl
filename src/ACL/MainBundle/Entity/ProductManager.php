<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 11/17/2014
 * Time: 2:57 PM
 */

namespace ACL\MainBundle\Entity;


use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\CoreBundle\Model\BaseEntityManager;

class ProductManager extends BaseEntityManager {


	public function getCategoryActiveProductsQueryBuilder(CategoryInterface $category = null, $filter = null, $option = null)
	{
		$queryBuilder = $this->getCategoryProductsQueryBuilder($category);
		$queryBuilder->andWhere('p.enabled = :enabled')
					 ->orderBy('p.position')
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
                             ->select('p, i')
		                     ->leftJoin('p.image', 'i')
							 ->orderBy('p.position');

		if ($category) {
			$queryBuilder
				->leftJoin('p.category', 'c')
				->leftJoin('c.parent', 'cp')
				->leftJoin('cp.parent', 'cp2')
				->leftJoin('cp2.parent', 'cp3')
				->andWhere('p.category = :categoryId')
				->orWhere('c.parent = :categoryId')
				->orWhere('c.parent = :categoryId')
				->orWhere('cp.parent = :categoryId')
				->orWhere('cp2.parent = :categoryId')
				->setParameter('categoryId', $category->getId());
		}

		return $queryBuilder;
	}

	public function getProductsByNameQueryBuilder($name){

		$queryBuilder = $this->getRepository()->createQueryBuilder('p');
		/* @var $queryBuilder QueryBuilder */
		$queryBuilder->select('p, i')
            ->leftJoin('p.image', 'i')
			->andWhere('p.name LIKE :productName')
			->orWhere('p.subname LIKE :productName')
			->orderBy('p.position')
			->setParameter('productName', '%'.$name.'%');

		return $queryBuilder;
	}

	/**
	 * Retrieve an active product from its id and its slug
	 *
	 * @param int    $id
	 * @param string $slug
	 *
	 * @return Product|null
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

	public function findFullDetails($id){
		$queryBuilder = $this->getRepository()->createQueryBuilder('p')
			->select('p, b, i, pd, ps, pv, g, imgs, pdm, psm, pvm, gm, imgsm, gmm, pdmm, psmm, pvmm, imgsmm')
			->leftJoin('p.brand', 'b')
	        ->leftJoin('p.image', 'i')

			->leftJoin('p.downloads', 'pd')
			->leftJoin('p.softwares', 'ps')
			->leftJoin('p.videos', 'pv')
			->leftJoin('p.gallery', 'g')
			->leftJoin('p.images', 'imgs')


			->leftJoin('pd.galleryHasMedias', 'pdm')
			->leftJoin('ps.galleryHasMedias', 'psm')
			->leftJoin('pv.galleryHasMedias', 'pvm')
            ->leftJoin('g.galleryHasMedias', 'gm')
            ->leftJoin('imgs.galleryHasMedias', 'imgsm')

			->leftJoin('gm.media', 'gmm')
			->leftJoin('pdm.media', 'pdmm')
			->leftJoin('psm.media', 'psmm')
			->leftJoin('pvm.media', 'pvmm')
			->leftJoin('imgsm.media', 'imgsmm')

			->andWhere('p.id = :id')
			->setParameter('id', $id)

		;
		return $queryBuilder->getQuery()->getOneOrNullResult();
	}

}
