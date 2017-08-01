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
                $objetivo_seleccionado = $objetivos[0]["id"];
                $meta_seleccionada = $metas[0]["id"];
            } else {
                $meta = $em->getRepository('AppBundle:Metas')->findOneById($id_meta);
                $meta_seleccionada = $meta->getId();
                $objetivo_seleccionado = $meta->getFkidobjetivo()->getId();
            }

            return $this->render('indicadores/index.html.twig', array(
                'indicadores' => $indicadores,
                'objetivos' => $this->getObjetivosPreload(),
                'metas' => $this->getMetasPreload(),
                'objetivo_seleccionado' => $objetivo_seleccionado,
                'meta_seleccionada' => $meta_seleccionada,            
            ));
        } else {
            $request->getSession()
                ->getFlashBag()
            ->add('warning', "Por favor, verifique que exista al menos una Meta cargada en el sistema");
            return $this->redirectToRoute('paneluser_index');
        }
    }

    /**
     * Creates a new Indicadores entity.
     *
     * @Route("/new", name="admin_crud_indicadores_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $indicadore = new Indicadores();
        $params = $this->getRequest()->request->all();
        if (isset($params['id_meta_selected'])){
            $meta = $this->getDoctrine()->getRepository('AppBundle:Metas')->findOneById($params["id_meta_selected"]);
            $indicadore->setFkidmeta($meta);
        }
        $form = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore, array(
            'scopes_enabled' => $this->getEnabledScopes(),
            'entity_manager' => $this->getDoctrine()->getManager(),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addIndicadorMetadata($indicadore);
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
            return $this->redirectToRoute("admin_crud_indicadores_index_idMeta", array('id_meta'=>$indicadore->getFkidmeta()->getId()));
            //return $this->redirectToRoute('admin_crud_indicadores_show', array('id'=> $indicadore->getId()));
            //return $this->redirectToRoute('admin_crud_desglocesporindicador_new', array('id_indicador' => $indicadore->getId()));
        }

        return $this->render('indicadores/new.html.twig', array(
            'indicadore' => $indicadore,
            'form' => $form->createView(),
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
            array_push($list, array('id'=>$m->getId(),'desc'=>$m->getDescripcion(),'id_objetivo'=>$m->getFkidobjetivo()->getId(),'code'=>$m->getCodigo(), 'code_objetivo'=>$m->getFkidobjetivo()->getCodigo()));
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
            $statement = $connection->prepare("SELECT MAX(codigo) FROM indicadores WHERE CONVERT(codigo, unsigned integer) > 0 AND fkIdMeta = :idmeta");
            $statement->bindValue('idmeta', $idMeta);
            $statement->execute();
            $results = $statement->fetchAll();
            if ($results){
                $highest_id = $results[0]["MAX(codigo)"] + 1;
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
        if (isset($params['id_meta_selected'])){
            $meta = $this->getDoctrine()->getRepository('AppBundle:Metas')->findOneById($params["id_meta_selected"]);
            $indicadore->setFkidmeta($meta);
        }
        $deleteForm = $this->createDeleteForm($indicadore);
        $document_path_string = $indicadore->getDocumentPath();
        if ($document_path_string != NULL){
            $indicadore->setDocumentPath(
                new File($this->getParameter('indicadores_technical_documents_directory').'/'.$indicadore->getDocumentPath())
            );
        }

        // Formateo fechas a 'yyyy' para visualizacion
        if ($indicadore->getFechametaintermedia() != NULL){
            $indicadore->setFechametaintermedia(explode('-',$indicadore->getFechametaintermedia())[0]);
        }
        if ($indicadore->getFechametafinal() != NULL){
        $indicadore->setFechametafinal(explode('-',$indicadore->getFechametafinal())[0]);
        }   
        $editForm = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore, array(
                'scopes_enabled' => array('N'=>false,'P'=>false,'D'=>false), // en modo edicion, no se puede cambiar el ambito del indicador
                'last_code_used' => $indicadore->getCodigo(),
                'entity_manager' => $this->getDoctrine()->getManager(),
            )
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addIndicadorMetadata($indicadore);

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
