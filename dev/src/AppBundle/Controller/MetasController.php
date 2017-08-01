<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Metas;
use AppBundle\Form\MetasType;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Metas controller.
 *
 * @Route("/admin/crud/metas")
 */
class MetasController extends Controller
{
    /**
     * Lists all Metas entities.
     *
     * @Route("/list", requirements={"admin_crud_metas_index":"\d+"}, name="admin_crud_metas_index")
     * @Route("/list/{id_objetivo}", requirements={"admin_crud_metas_index_idObjetivo":"\d+"}, name="admin_crud_metas_index_idObjetivo", defaults={"admin_crud_metas_index_idObjetivo" = 0})
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $id_objetivo = $request->get('id_objetivo');
        $em = $this->getDoctrine()->getManager();
        $objetivos = $this->getObjetivosPreload();
        $metas = $em->getRepository('AppBundle:Metas')->findAll();
        $objetivoSelected = (intval($id_objetivo) == 0) ? $objetivos[0]['id'] : intval($id_objetivo);
        /*if (intval($id_objetivo) == 0)
        {
            $metas = $em->getRepository('AppBundle:Metas')->findAll();
            $titulo_objetivo = "TODOS";
        }
        else
        {

            $objetivo = $em->getRepository('AppBundle:Objetivos')->findOneById($id_objetivo);
            $titulo_objetivo = $objetivo->getDescripcion();
            $metas = $em->getRepository('AppBundle:Metas')->findByfkidobjetivo($id_objetivo);            
        }*/

        return $this->render('metas/index.html.twig', array(
            'metas' => $metas,
            'titulo_objetivo' => "titulo objetivo",
            'objetivos' => $objetivos,
            'objetivo_selected' => $objetivoSelected,
        ));
    }

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            array_push($list, array('id'=>$o->getId(),'desc'=>$o->getDescripcion(), 'code'=>$o->getcodigo()));
        }
        return $list;
    }

    /**
     * Creates a new Metas entity.
     *
     * @Route("/new", name="admin_crud_metas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $meta = new Metas();
        $form = $this->createForm('AppBundle\Form\MetasType', $meta, array(
            'entity_manager' => $this->getDoctrine()->getManager(),
            'scopes_enabled' => $this->getEnabledScopes(),
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addMetaMetadata($meta);
            $meta->setAmbito('N');
            $em = $this->getDoctrine()->getManager();
            $em->persist($meta);
            $em->flush();

            return $this->redirectToRoute('admin_crud_metas_index_idObjetivo', array('id_objetivo' => $meta->getFkidobjetivo()->getId()));
        }

        return $this->render('metas/new.html.twig', array(
            'meta' => $meta,
            'form' => $form->createView(),
            'api_urls' => array('get_next_meta_code'=> $this->generateUrl('admin_crud_metas_get_next_meta_code'))
        ));
    }

    /**
     * Finds and displays a Metas entity.
     *
     * @Route("/detail/{id}", name="admin_crud_metas_show")
     * @Method("GET")
     */
    public function showAction(Metas $meta)
    {
        $deleteForm = $this->createDeleteForm($meta);

        return $this->render('metas/show.html.twig', array(
            'meta' => $meta,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     *
     * @Route("/api/get_next_meta_code", name="admin_crud_metas_get_next_meta_code")
     * @Method("POST")
     */
    public function getNextMetaCodeAction(Request $request)
    {
        $content = $this->get("request")->getContent();
        if (!empty($content)){
            $data = json_decode($content, true);
            $response = $this->getMetaNextCode($data['objetivo_id']);
            return new JsonResponse($response);
        }
    }

    private function getMetaNextCode($idObjetivo){
        $highest_id = 1;
        if ($idObjetivo){
            $em = $this->getDoctrine()->getManager();
            $connection = $em->getConnection();
            $statement = $connection->prepare("SELECT MAX(codigo) FROM metas WHERE CONVERT(codigo, unsigned integer) > 0 AND fkIdObjetivo = :idobjetivo");
            $statement->bindValue('idobjetivo', $idObjetivo);
            $statement->execute();
            $results = $statement->fetchAll();
            if ($results){
                $highest_id = $results[0]["MAX(codigo)"] + 1;
            }
        }
        return array("next_meta_code" => $highest_id);
    }

    /**
     * Displays a form to edit an existing Metas entity.
     *
     * @Route("/{id}/edit", name="admin_crud_metas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Metas $meta)
    {
        $em = $this->getDoctrine()->getManager();
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $deleteForm = $this->createDeleteForm($meta);
        $editForm = $this->createForm('AppBundle\Form\MetasType', $meta, array(
            'entity_manager' => $this->getDoctrine()->getManager(),
            'scopes_enabled' => array('N'=>false,'P'=>false,'D'=>false), // en modo edicion, no se puede cambiar el ambito de la meta
            'last_code_used' => $meta->getCodigo()
        ));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addMetaMetadata($meta);
            $em->persist($meta);
            $em->flush();
            $this->get('app.utils.scopes_service')->addEditSuccessToRequest($request);
            return $this->redirectToRoute('admin_crud_metas_index');
        }
        $indicadoresMeta = $em->getRepository('AppBundle:Indicadores')->findByfkidmeta($meta->getId());
        return $this->render('metas/edit.html.twig', array(
            'meta' => $meta,
            'meta_has_indicadores' => count($indicadoresMeta),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'api_urls' => array('get_next_meta_code'=> $this->generateUrl('admin_crud_metas_get_next_meta_code'))
        ));
    }

    /**
     * Deletes a Metas entity.
     *
     * @Route("/{id}", name="admin_crud_metas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Metas $meta)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $form = $this->createDeleteForm($meta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $indicadoresMeta = $em->getRepository('AppBundle:Indicadores')->findByfkidmeta($meta->getId());
            if (count($indicadoresMeta)) {
                $request->getSession()->getFlashBag()->add('warning', "No se puede eliminar una meta que tiene Indicadores asociados");
                return $this->redirectToRoute('paneluser_index');
            } else {
                $em->remove($meta);
                $em->flush();
            }
        }

        return $this->redirectToRoute('admin_crud_metas_index');
    }

    /**
     * Creates a form to delete a Metas entity.
     *
     * @param Metas $meta The Metas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Metas $meta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_metas_delete', array('id' => $meta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    private function addMetaMetadata(&$meta){
        $meta->setIdusuario($this->getUser());
        $meta->setFechamodificacion(date_format(new \DateTime(), 'Y-m-d H:i:s'));
    }


    private function getEnabledScopes(){
        $scope = $this->get('app.utils.scopes_service');
        return $scope->getMetasScopes();
    }
}
