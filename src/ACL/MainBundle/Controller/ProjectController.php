<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 1/9/2015
 * Time: 8:35 PM
 */

namespace ACL\MainBundle\Controller;


use ACL\MainBundle\Entity\ProjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 * @package ACL\MainBundle\Controller
 * @Route(path="/cases")
 */
class ProjectController extends Controller implements ContainerAwareInterface {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ProjectRepository
     */
    private $projectRepo;

    public function __construct(){

    }

    /**
     * @Route("/", name="acl.main.project.index")
     */
    public function indexAction(){

    }

    /**
     * @Route("/{project_slug}/{project_id}", name="acl.main.project.project")
     */
    public function projectAction($project_slug, $project_id){

    }


}