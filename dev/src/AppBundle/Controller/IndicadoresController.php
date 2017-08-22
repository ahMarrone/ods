<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Indicadores;
use AppBundle\Entity\Metas;
use AppBundle\Form\IndicadoresType;
use AppBundle\Entity\Desglocesindicadores;
use AppBundle\Entity\Valoresindicadores;
use AppBundle\Entity\Valoresindicadoresconfigfecha;
use AppBundle\Entity\Valoresindicadoresconfigfechadesgloces;

use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Indicadores controller.
 *
 * @Route("/admin/crud/indicadores")
 */
class IndicadoresController extends Controller
{
    /**
     * Lists all Indicadores entities.
     *
     * @Route("/list", name="admin_crud_indicadores_index")
     * @Route("/list/{id_meta}", requirements={"admin_crud_indicadores_index_idMeta":"\d+"}, name="admin_crud_indicadores_index_idMeta", defaults={"admin_crud_indicadores_index_idMeta" = 0})
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $id_meta = intval($request->get('id_meta'));
        $em = $this->getDoctrine()->getManager();  
        
        $objetivos = $this->getObjetivosPreload();
        $metas = $this->getMetasPreload();
        $indicadores = $em->getRepository('AppBundle:Indicadores')->findAll();
        if (count($metas)){
            if ($id_meta == 0){
                $objetivo_seleccionado = -1;
                $meta_seleccionada = -1;
            } else {
                $meta = $em->getRepository('AppBundle:Metas')->findOneById($id_meta);
                $meta_seleccionada = $meta->getId();
                $objetivo_seleccionado = $meta->getFkidobjetivo()->getId();
            }
            $dataToApprove = $this->getDictDataToApprove($this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->getIndicadoresDataToApprove());
            $indicadoresHasData = $this->getDictDataToApprove($this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->getIndicadoresHasData());
            return $this->render('indicadores/index.html.twig', array(
                'indicadores' => $indicadores,
                'objetivos' => $this->getObjetivosPreload(),
                'metas' => $this->getMetasPreload(),
                'objetivo_seleccionado' => $objetivo_seleccionado,
                'meta_seleccionada' => $meta_seleccionada,
                'indicador_has_data' => $indicadoresHasData,
                'data_to_approve' => $dataToApprove ,
                'api_urls' => array('new_indicador'=> $this->generateUrl('admin_crud_indicadores_new'))        
            ));
        } else {
            $request->getSession()
                ->getFlashBag()
            ->add('warning', "Por favor, verifique que exista al menos una Meta cargada en el sistema");
            return $this->redirectToRoute('paneluser_index');
        }
    }


    private function getDictDataToApprove($dataToApprove){
        $result = array();
        foreach ($dataToApprove as $config) {
            $result[$config->getIdindicador()->getId()] = 1;
        }
        return $result;
    }

    /**
     * Creates a new Indicadores entity.
     *
     * @Route("/new", name="admin_crud_indicadores_new")
     * @Route("/new/{id_meta}", requirements={"id_meta":"\d+"}, name="admin_crud_indicadores_new_idmeta", defaults={"id_meta" = -1})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request){    
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $indicadore = new Indicadores();
        $id_meta = intval($request->get('id_meta'));
        $em = $this->getDoctrine()->getManager(); 
        if ($id_meta == 0){
            $objetivo_seleccionado = -1;
            $meta_seleccionada = -1;
        } else {
            $meta = $em->getRepository('AppBundle:Metas')->findOneById($id_meta);
            $meta_seleccionada = $meta->getId();
            $objetivo_seleccionado = $meta->getFkidobjetivo()->getId();
        }
        $params = $this->getRequest()->request->all();
        if (isset($params['id_meta_selected'])){
            $meta = $this->getDoctrine()->getRepository('AppBundle:Metas')->findOneById($params["id_meta_selected"]);
            $indicadore->setFkidmeta($meta);
        }
        $form = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore, array(
            'entity_manager' => $this->getDoctrine()->getManager(),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addIndicadorMetadata($indicadore);
            $indicadore->setCodigo($indicadore->formatCodigo($indicadore->getCodigo()));
            // Fechas
            /*$datetime = new \DateTime();
            $newDate = $datetime->createFromFormat('Y-m-d', '2015-01-01');
            $newDate->format('d-m-Y');*/
            if ($indicadore->getFechametaintermedia() != NULL){
                $indicadore->setFechametaintermedia($indicadore->formatYearToDB($indicadore->getFechametaintermedia()));
            }
            if ($indicadore->getFechametafinal() != NULL){
                $indicadore->setFechametafinal($indicadore->formatYearToDB($indicadore->getFechametafinal()));
            }
            // documento técnico
            $document = $indicadore->getDocumentPath();
            if ($document){
                $fileName = md5(uniqid()).'.'.$document->guessExtension();
                $document->move(
                    $this->getParameter('indicadores_technical_documents_directory'),
                    $fileName
                );
                $indicadore->setDocumentPath($fileName);
            }
            //

            $em = $this->getDoctrine()->getManager();
            $em->persist($indicadore);
            $em->flush();
            $this->saveBaseDesglocesIndicadores($indicadore);
            $request->getSession()->getFlashBag()->add('success', "El Indicador ha sido dado de alta correctamente");
            return $this->redirectToRoute("admin_crud_indicadores_index_idMeta", array('id_meta'=>$indicadore->getFkidmeta()->getId()));
            //return $this->redirectToRoute('admin_crud_indicadores_show', array('id'=> $indicadore->getId()));
            //return $this->redirectToRoute('admin_crud_desglocesporindicador_new', array('id_indicador' => $indicadore->getId()));
        }

        return $this->render('indicadores/new.html.twig', array(
            'indicadore' => $indicadore,
            'form' => $form->createView(),
            'id_objetivo_selected' => $objetivo_seleccionado,
            'id_meta_selected' => $meta_seleccionada,
            'scopes_enabled' => true,
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload(),
            'api_urls' => array('get_next_indicador_code'=> $this->generateUrl('admin_crud_indicadores_get_next_indicador_code'))
        ));
    }


    // Guarda la relacion "sin desgloce" para el nuevo indicador
    private function saveBaseDesglocesIndicadores($indicador){
        $em = $this->getDoctrine()->getManager();
        $di = new Desglocesindicadores();
        $di->setIdindicador($indicador->getId());
        $di->setIddesgloce(0);
        $em->persist($di);
        $em->flush();
    }

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            array_push($list, array('id'=>$o->getId(),'desc'=>$o->getDescripcion(),'code'=>$o->getCodigo()));
        }
        return $list;
    }

    private function getMetasPreload(){
        $list = array();
        $metas =  $this->getDoctrine()->getRepository('AppBundle:Metas')->findAll();
        foreach ($metas as $m) {
            array_push($list, array('id'=>$m->getId(),'desc'=>$m->getDescripcion(),'id_objetivo'=>$m->getFkidobjetivo()->getId(),'code'=>$m->getvisibleCodigo(), 'code_objetivo'=>$m->getFkidobjetivo()->getCodigo()));
        }
        return $list;
    }

       /**
     *
     * @Route("/api/get_next_indicador_code", name="admin_crud_indicadores_get_next_indicador_code")
     * @Method("POST")
     */
    public function getNextIndicadorCodeAction(Request $request)
    {
        $content = $this->get("request")->getContent();
        if (!empty($content)){
            $data = json_decode($content, true);
            $response = $this->getIndicadorNextCode($data['meta_id']);
            return new JsonResponse($response);
        }
    }

    private function getIndicadorNextCode($idMeta){
        $highest_id = 1;
        if ($idMeta){
            $em = $this->getDoctrine()->getManager();
            $connection = $em->getConnection();
            $statement = $connection->prepare("SELECT MAX(CONVERT(SUBSTR(codigo,5), UNSIGNED INTEGER)) as max_code FROM indicadores WHERE codigo like '0000%'  AND fkIdMeta = :idmeta");
            $statement->bindValue('idmeta', $idMeta);
            $statement->execute();
            $results = $statement->fetchAll();
            if ($results){
                $highest_id = $results[0]["max_code"] + 1;
            }
        }
        return array("next_indicador_code" => $highest_id);
    }

    /**
     * Finds and displays a Indicadores entity.
     *
     * @Route("/detail/{id}", name="admin_crud_indicadores_show")
     * @Method("GET")
     */
    public function showAction(Indicadores $indicadore)
    {
        $deleteForm = $this->createDeleteForm($indicadore);

        return $this->render('indicadores/show.html.twig', array(
            'indicadore' => $indicadore,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Indicadores entity.
     *
     * @Route("/{id}/edit", name="admin_crud_indicadores_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Indicadores $indicadore)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $params = $this->getRequest()->request->all();
        $indicadore->setCodigo($indicadore->getVisibleCodigo());
        if (isset($params['id_meta_selected'])){
            $meta = $this->getDoctrine()->getRepository('AppBundle:Metas')->findOneById($params["id_meta_selected"]);
            $indicadore->setFkidmeta($meta);
        }
        $deleteForm = $this->createDeleteForm($indicadore);
        $document_path_string = $indicadore->getDocumentPath();
        if ($document_path_string != NULL){
            $indicadore->setDocumentPath(
                new File($this->getParameter('indicadores_technical_documents_directory').'/'.$indicadore->getDocumentPath(), false)
            );
        }
        // Formateo fechas a 'yyyy' para visualizacion
        if ($indicadore->getFechametaintermedia() != NULL){
            $indicadore->setFechametaintermedia(explode('-',$indicadore->getFechametaintermedia())[0]);
        }
        if ($indicadore->getFechametafinal() != NULL){
        $indicadore->setFechametafinal(explode('-',$indicadore->getFechametafinal())[0]);
        }
        $indicadoresHasData = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')->getIndicadoresHasData($indicadore->getId());
        $enableEditAmbito =  (count($indicadoresHasData)) ? false : true;
        $editForm = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore, array(
                'last_code_used' => $indicadore->getCodigo(),
                'entity_manager' => $this->getDoctrine()->getManager(),
            )
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addIndicadorMetadata($indicadore);
            $indicadore->setCodigo($indicadore->formatCodigo($indicadore->getCodigo()));
            if ($indicadore->getFechametaintermedia() != NULL){
                $indicadore->setFechametaintermedia($indicadore->formatYearToDB($indicadore->getFechametaintermedia()));
            }
            if ($indicadore->getFechametafinal() != NULL){
                $indicadore->setFechametafinal($indicadore->formatYearToDB($indicadore->getFechametafinal()));
            }

            // documento técnico
            $document = $indicadore->getDocumentPath();
            if ($document){
                $fileName = ($document_path_string) ? $document_path_string :  md5(uniqid()).'.'.$document->guessExtension();
                $document->move(
                    $this->getParameter('indicadores_technical_documents_directory'),
                    $fileName
                );
                $indicadore->setDocumentPath($fileName);
            } else {
                $indicadore->setDocumentPath($document_path_string);
            }
            //
            $em = $this->getDoctrine()->getManager();
            $em->persist($indicadore);
            $em->flush();
            $this->get('app.utils.scopes_service')->addEditSuccessToRequest($request);
            return $this->redirectToRoute('admin_crud_indicadores_index');
        }

        return $this->render('indicadores/edit.html.twig', array(
            'indicadore' => $indicadore,
            'edit_form' => $editForm->createView(),
            'scopes_enabled' => $enableEditAmbito,
            'delete_form' => $deleteForm->createView(),
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload(),
            'document_path_string' => $document_path_string,
            'api_urls' => array('get_next_indicador_code'=> $this->generateUrl('admin_crud_indicadores_get_next_indicador_code'))
        ));
    }

    /**
     * Deletes a Indicadores entity.
     *
     * @Route("/{id}", name="admin_crud_indicadores_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Indicadores $indicadore)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $form = $this->createDeleteForm($indicadore);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $configfechaEntity = $em->getRepository('AppBundle:Valoresindicadoresconfigfecha')->findByIdindicador($indicadore->getId());
            $configfechaDesglosesEntity = $em->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIdvaloresindicadoresconfigfecha($configfechaEntity);
            $valoresIndicadores = $em->getRepository('AppBundle:Valoresindicadores')->findByIdvaloresindicadoresconfigfecha($configfechaEntity);
            $this->deleteEntities($em,$valoresIndicadores);
            $this->deleteEntities($em,$configfechaDesglosesEntity);
            $this->deleteEntities($em,$configfechaEntity);
            $em->remove($indicadore);
            $em->flush();
            if ($indicadore->getDocumentPath() != null && $indicadore->getDocumentPath() != "") {
                unlink($this->getParameter('indicadores_technical_documents_directory') . "/" . $indicadore->getDocumentPath());
            }
            $request->getSession()->getFlashBag()->add('success', "El indicador ha sido eliminado correctamente");
        }
        return $this->redirectToRoute('admin_crud_indicadores_index');
    }


    private function deleteEntities($em, $entities){
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
    }

    /**
     * Creates a form to delete a Indicadores entity.
     *
     * @param Indicadores $indicadore The Indicadores entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Indicadores $indicadore)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_indicadores_delete', array('id' => $indicadore->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function addIndicadorMetadata(&$indicador){
        $indicador->setIdusuario($this->getUser());
        $indicador->setFechamodificacion(date_format(new \DateTime(), 'Y-m-d H:i:s'));
    }


    private function getEnabledScopes(){
        $scope = $this->get('app.utils.scopes_service');
        return $scope->getIndicadorScope();
    }
}
