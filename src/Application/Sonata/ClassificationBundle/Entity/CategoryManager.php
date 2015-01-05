<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 12/30/2014
 * Time: 5:13 PM
 */

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Sonata\ClassificationBundle\Entity\CategoryManager as BaseCategoryManager;

class CategoryManager extends BaseCategoryManager {


    /**
     * @return CategoryInterface[]
     */
    public function findRootCategories(){

    }

    /**
     * @return CategoryInterface[]
     */
    public function findRootCategoriesWithIcons(){
        $criteria = new Criteria();
        $criteria->andWhere($criteria->expr()->isNull('parent'))
                 ->andWhere($criteria->expr()->neq('media', null ));
        return $this->getRepository()->matching($criteria, 'name ASC');

    }

}