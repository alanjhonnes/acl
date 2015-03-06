<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 3/4/2015
 * Time: 8:58 PM
 */

namespace ACL\MainBundle\Controller;


use ACL\MainBundle\Entity\TrainningSession;
use ACL\MainBundle\Entity\TrainningSessionRepository;
use Entity\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class TrainningSessionController
 * @package ACL\MainBundle\Controller
 * @Route("/treinamento/workshops")
 */
class TrainningSessionController extends Controller {

    /**
     * @Route("", name="acl.main.trainningsession.index")
     */
    public function indexAction(){
        $trainnings = $this->getRepository()->getActiveTrainningSessions();

        $months = $this->separateByMonth($trainnings);

        return $this->render('ACLMainBundle:TrainningSession:index.html.twig', array(
            'trainnings' => $trainnings,
            'category' => null,
            'months' => $months
        ));
    }

    /**
     * @Route("/categoria/{category_slug}/{category_id}", name="acl.main.trainningsession.category")
     */
    public function categoryAction($category_slug, $category_id){
        $trainnings = $this->getRepository()->getActiveTrainningSessionsByCategory($category_id);
        $category = $this->getCategoryRepository()->find($category_id);

        $months = $this->separateByMonth($trainnings);

        return $this->render('@ACLMain/TrainningSession/index.html.twig', array(
            'trainnings' => $trainnings,
            'category' => $category,
            'months' => $months
        ));
    }

    /**
     * @Route("/visualizar/{id}", name="acl.main.trainningsession.view")
     */
    public function viewAction($id){
        $trainning = $this->getRepository()->getTrainningSessionById($id);
        $category = null;
        if($trainning){
            $category = $trainning->getCategory();
        }
        return $this->render('@ACLMain/TrainningSession/view.html.twig', array(
            'trainning' => $trainning,
            'category' => $category
        ));
    }

    /**
     * @return TrainningSessionRepository
     */
    protected function getRepository(){
        return $this->getDoctrine()->getRepository('ACLMainBundle:TrainningSession');
    }

    /**
     * @return CategoryRepository
     */
    protected function getCategoryRepository(){
        return $this->getDoctrine()->getRepository('ApplicationSonataClassificationBundle:Category');
    }

    /**
     * @param $trainnings TrainningSession[]
     * @return array
     */
    private function separateByMonth($trainnings)
    {
//        $months = array('Jan' => array(), 'Fev' => array(), 'Mar' => array(), 'Abr' => array(),
//            'Maio' => array(), 'Jun' => array(), 'Jul' => array(), 'Ago' => array(),
//            'Set' => array(), 'Out' => array(), 'Nov' => array(), 'Dez' => array() );
        $months = array();
        foreach ($trainnings as $trainning) {
            $date = $trainning->getDate();
            $monthNumber = $date->format('n');
            $monthName = $this->getMonth($monthNumber);
            //create months
            if(!array_key_exists($monthName, $months)){
                $months[$monthName] = array();
            }
            $months[$monthName][] = $trainning;
        }
        return $months;
    }

    /**
     * @param $monthNumber integer
     * @return string
     */
    private function getMonth($monthNumber){
        switch ($monthNumber){
            case 1:
                return 'Janeiro';
                break;
            case 2:
                return 'Fevereiro';
                break;
            case 3:
                return 'Março';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Maio';
                break;
            case 6:
                return 'Junho';
                break;
            case 7:
                return 'Julho';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Setembro';
                break;
            case 10:
                return 'Outubro';
                break;
            case 11:
                return 'Novembro';
                break;
            case 12:
                return 'Dezembro';
                break;
            default:
                return '';
        }
    }

}
