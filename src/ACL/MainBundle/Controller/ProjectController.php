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
 */
class ProjectController extends Controller {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ProjectRepository
     */
    private $projectRepo;

    public function __construct(){
        //$this->projectRepo = $this->getProjectRepository();
    }

    /**
     * @Route("/cases", name="acl.main.project.index")
     * @Template
     */
    public function indexAction(){
        $projects = $this->getProjectRepository()->findAllWithMedia();
        return array('projects' => $projects);
    }

    /**
     * @Route("/cases/{project_slug}/{project_id}", name="acl.main.project.project")
     * @Template
     */
    public function projectAction($project_slug, $project_id){
        return array();
    }

    /**
     * @return ProjectRepository
     */
    private function getProjectRepository(){
        return $this->getDoctrine()->getRepository('ACLMainBundle:Project');
    }


}
