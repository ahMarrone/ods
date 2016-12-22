<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Indicadores;
use AppBundle\Entity\Metas;
use AppBundle\Form\IndicadoresType;

use Symfony\Component\HttpFoundation\File\File;

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

        $id_meta = $request->get('id_meta');
        $em = $this->getDoctrine()->getManager();   
        
        if (intval($id_meta) == 0)
        {
            $indicadores = $em->getRepository('AppBundle:Indicadores')->findAll();
            $titulo_meta = "TODAS";
        }
        else
        {
            //
            $meta = $em->getRepository('AppBundle:Metas')->findOneById($id_meta);
            $titulo_meta = $meta->getDescripcion();
            //
            $id_objetivo = $meta->getfkidObjetivo();
            $indicadores = $em->getRepository('AppBundle:Indicadores')->findByfkidmeta($id_meta);            
        }

        return $this->render('indicadores/index.html.twig', array(
            'indicadores' => $indicadores,
            'titulo_meta' => $titulo_meta,            
        ));
    }

    /**
     * Creates a new Indicadores entity.
     *
     * @Route("/new", name="admin_crud_indicadores_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $indicadore = new Indicadores();
        $params = $this->getRequest()->request->all();
        if (isset($params['id_meta_selected'])){
            $meta = $this->getDoctrine()->getRepository('AppBundle:Metas')->findOneById($params["id_meta_selected"]);
            $indicadore->setFkidmeta($meta);
        }
        $form = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore, array(
            'scopes_enabled' => $this->getEnabledScopes(),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addIndicadorMetadata($indicadore);

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
            //return $this->redirectToRoute('/');
            return $this->redirectToRoute('admin_crud_desglocesporindicador_new', array('id_indicador' => $indicadore->getId()));
        }

        return $this->render('indicadores/new.html.twig', array(
            'indicadore' => $indicadore,
            'form' => $form->createView(),
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload()
        ));
    }

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            array_push($list, array('id'=>$o->getId(),'desc'=>$o->getDescripcion()));
        }
        return $list;
    }

    private function getMetasPreload(){
        $list = array();
        $metas =  $this->getDoctrine()->getRepository('AppBundle:Metas')->findAll();
        foreach ($metas as $m) {
            array_push($list, array('id'=>$m->getId(),'desc'=>$m->getDescripcion(),'id_objetivo'=>$m->getFkidobjetivo()->getId()));
        }
        return $list;
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
        $editForm = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore, array(
                'scopes_enabled' => array('N'=>false,'P'=>false,'D'=>false), // en modo edicion, no se puede cambiar el ambito del indicador
            )
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addIndicadorMetadata($indicadore);

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

            return $this->redirectToRoute('admin_crud_indicadores_edit', array('id' => $indicadore->getId()));
        }

        return $this->render('indicadores/edit.html.twig', array(
            'indicadore' => $indicadore,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload(),
            'document_path_string' => $document_path_string,
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
        $form = $this->createDeleteForm($indicadore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($indicadore);
            $em->flush();
        }

        return $this->redirectToRoute('admin_crud_indicadores_index');
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
