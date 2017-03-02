<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * PanelUser controller.
 *
 * @Route("/paneluser")
 */
class PanelUserController extends Controller
{

	/**
     * Muestra panel de usuario.
     *
     * @Route("/", name="paneluser_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $stats = $this->getStats();
        $dataToApprove = $this->getDataToApprove();
        return $this->render('paneluser/index.html.twig', array(
            'stats'=>$stats,
            'dataToAprove' => $dataToApprove
            )
        );
    }



    private function getStats(){
        $stats = array();
        $em = $this->getDoctrine()->getManager();
        $toAprove = $em->getRepository('AppBundle:Valoresindicadores')->findByAprobado(0);
        $objetivos = $em->getRepository('AppBundle:Objetivos')->findAll();
        $metas = $em->getRepository('AppBundle:Metas')->findAll();
        $indicadores = $em->getRepository('AppBundle:Indicadores')->findAll();
        $stats = array(
            "toAprove" => count($toAprove),
            "objetivos_count" => count($objetivos),
            "metas_count" => count($metas),
            "indicadores_count" => count($indicadores)
        );
        return $stats;
    }


    private function getDataToApprove(){
        $result = array();
        $rows = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->getIndicadoresDataToApprove();
        foreach ($rows as $config) {
            $result[$config->getIdindicador()->getId()] = $this->getIndicadorCode($config->getIdindicador());
        }
        return $result;
    }


    private function getIndicadorCode($indicadorObject){
        return $indicadorObject->getFkidmeta()->getFkidobjetivo()->getCodigo() . "." . 
               $indicadorObject->getFkidmeta()->getCodigo() . "." . 
               $indicadorObject->getCodigo();
    }

}