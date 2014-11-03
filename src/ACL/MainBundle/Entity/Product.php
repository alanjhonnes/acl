<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 10/31/2014
 * Time: 1:26 PM
 */

namespace ACL\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Product
 * @ORM\Entity(repositoryClass="ProductRepository")
 * @ORM\Table(name="product")
 */
class Product {

	/**
	 * @var
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank()
	 *
	 */
	protected $title;

	/**
	 * @var
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $description;

	/**
	 * @var
	 * @ORM\Column(type="smallint")
	 */
	protected $order;

	/**
	 * @var
	 * one
	 */
	protected $category;




} 