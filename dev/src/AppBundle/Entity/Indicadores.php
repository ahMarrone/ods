<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Indicadores
 */
class Indicadores
{

    /**
     * @var \AppBundle\Entity\Metas
     */
    private $fkidmeta;



    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $valmin;

    /**
     * @var integer
     */
    private $valmax;

    /**
     * @var string
     */
    private $ambito;

    /**
     * @var string
     */
    private $fechamodificacion;

    /**
     * @var \AppBundle\Entity\Usuarios
     */
    private $idusuario;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $iddesgloce;

    /**
     * @var boolean
     */
    private $visible;

    /**
     * @var string
     */
    private $fechasdestacadas;

    /**
     * @var integer
     */
    private $id;

        /**
     * @var string
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $documentpath;

       /**
     * @var string
     */
    private $fechametaintermedia;

    /**
     * @var string
     */
    private $valoresperadometaintermedia;

    /**
     * @var string
     */
    private $fechametafinal;

    /**
     * @var string
     */
    private $valoresperadometafinal;






    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Indicadores
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Indicadores
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valmin
     *
     * @param integer $valmin
     * @return Indicadores
     */
    public function setValmin($valmin)
    {
        $this->valmin = $valmin;

        return $this;
    }

    /**
     * Get valmin
     *
     * @return integer 
     */
    public function getValmin()
    {
        return $this->valmin;
    }

    /**
     * Set valmax
     *
     * @param integer $valmax
     * @return Indicadores
     */
    public function setValmax($valmax)
    {
        $this->valmax = $valmax;

        return $this;
    }

    /**
     * Get valmax
     *
     * @return integer 
     */
    public function getValmax()
    {
        return $this->valmax;
    }

    /**
     * Set ambito
     *
     * @param string $ambito
     * @return Indicadores
     */
    public function setAmbito($ambito)
    {
        $this->ambito = $ambito;

        return $this;
    }

    /**
     * Get ambito
     *
     * @return string 
     */
    public function getAmbito()
    {
        return $this->ambito;
    }

    /**
     * Set visiblenacional
     *
     * @param boolean $visiblenacional
     * @return Indicadores
     */
    public function setVisiblenacional($visiblenacional)
    {
        $this->visiblenacional = $visiblenacional;

        return $this;
    }

    /**
     * Get visiblenacional
     *
     * @return boolean 
     */
    public function getVisiblenacional()
    {
        return $this->visiblenacional;
    }

    /**
     * Set visibleprovincial
     *
     * @param boolean $visibleprovincial
     * @return Indicadores
     */
    public function setVisibleprovincial($visibleprovincial)
    {
        $this->visibleprovincial = $visibleprovincial;

        return $this;
    }

    /**
     * Get visibleprovincial
     *
     * @return boolean 
     */
    public function getVisibleprovincial()
    {
        return $this->visibleprovincial;
    }

    /**
     * Set visiblemunicipal
     *
     * @param boolean $visiblemunicipal
     * @return Indicadores
     */
    public function setVisiblemunicipal($visiblemunicipal)
    {
        $this->visiblemunicipal = $visiblemunicipal;

        return $this;
    }

    /**
     * Get visiblemunicipal
     *
     * @return boolean 
     */
    public function getVisiblemunicipal()
    {
        return $this->visiblemunicipal;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkidmeta
     *
     * @param \AppBundle\Entity\Metas $fkidmeta
     * @return Indicadores
     */
    public function setFkidmeta(\AppBundle\Entity\Metas $fkidmeta = null)
    {
        $this->fkidmeta = $fkidmeta;

        return $this;
    }

    /**
     * Get fkidmeta
     *
     * @return \AppBundle\Entity\Metas 
     */
    public function getFkidmeta()
    {
        return $this->fkidmeta;
    }

    public function __toString(){
        return (string) $this->getId() . ' - ' . substr($this->getDescripcion(), 0, 100);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->iddesgloce = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valmin = 0;
        $this->valmax = 100;
    }

    /**
     * Set fechamodificacion
     *
     * @param string $fechamodificacion
     * @return Indicadores
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return string 
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Set idusuario
     *
     * @param \AppBundle\Entity\Usuarios $idusuario
     * @return Indicadores
     */
    public function setIdusuario(\AppBundle\Entity\Usuarios $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \AppBundle\Entity\Usuarios 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Add iddesgloce
     *
     * @param \AppBundle\Entity\Desgloces $iddesgloce
     * @return Indicadores
     */
    public function addIddesgloce(\AppBundle\Entity\Desgloces $iddesgloce)
    {
        $this->iddesgloce[] = $iddesgloce;

        return $this;
    }

    /**
     * Remove iddesgloce
     *
     * @param \AppBundle\Entity\Desgloces $iddesgloce
     */
    public function removeIddesgloce(\AppBundle\Entity\Desgloces $iddesgloce)
    {
        $this->iddesgloce->removeElement($iddesgloce);
    }

    /**
     * Get iddesgloce
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIddesgloce()
    {
        return $this->iddesgloce;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Indicadores
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set fechasdestacadas
     *
     * @param string $fechasdestacadas
     * @return Indicadores
     */
    public function setFechasdestacadas($fechasdestacadas)
    {
        $this->fechasdestacadas = $fechasdestacadas;

        return $this;
    }

    /**
     * Get fechasdestacadas
     *
     * @return string 
     */
    public function getFechasdestacadas()
    {
        return $this->fechasdestacadas;
    }

    /**
     * Set documentpath
     *
     * @param string $documentpath
     * @return Indicadores
     */
    public function setDocumentpath($documentpath)
    {
        $this->documentpath = $documentpath;

        return $this;
    }

    /**
     * Get documentpath
     *
     * @return string 
     */
    public function getDocumentpath()
    {
        return $this->documentpath;
    }
 
    /**
     * Set fechametaintermedia
     *
     * @param string $fechametaintermedia
     * @return Indicadores
     */
    public function setFechametaintermedia($fechametaintermedia)
    {
        $this->fechametaintermedia = $fechametaintermedia;

        return $this;
    }

    /**
     * Get fechametaintermedia
     *
     * @return string 
     */
    public function getFechametaintermedia()
    {
        return $this->fechametaintermedia;
    }

    /**
     * Set valoresperadometaintermedia
     *
     * @param string $valoresperadometaintermedia
     * @return Indicadores
     */
    public function setValoresperadometaintermedia($valoresperadometaintermedia)
    {
        $this->valoresperadometaintermedia = $valoresperadometaintermedia;

        return $this;
    }

    /**
     * Get valoresperadometaintermedia
     *
     * @return string 
     */
    public function getValoresperadometaintermedia()
    {
        return $this->valoresperadometaintermedia;
    }

    /**
     * Set fechametafinal
     *
     * @param string $fechametafinal
     * @return Indicadores
     */
    public function setFechametafinal($fechametafinal)
    {
        $this->fechametafinal = $fechametafinal;

        return $this;
    }

    /**
     * Get fechametafinal
     *
     * @return string 
     */
    public function getFechametafinal()
    {
        return $this->fechametafinal;
    }

    /**
     * Set valoresperadometafinal
     *
     * @param string $valoresperadometafinal
     * @return Indicadores
     */
    public function setValoresperadometafinal($valoresperadometafinal)
    {
        $this->valoresperadometafinal = $valoresperadometafinal;

        return $this;
    }

    /**
     * Get valoresperadometafinal
     *
     * @return string 
     */
    public function getValoresperadometafinal()
    {
        return $this->valoresperadometafinal;
    }



    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Indicadores
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }


    public function formatYearToDB($fecha){
        return $fecha . "-01-01";
    }


    public function isFechaHito($fecha){
        $dates = split(";", $this->getFechasdestacadas());
        foreach ($dates as $tmpDate) {
            if ($tmpDate == $fecha){
                return true;
            }
        }
        return false;
    }
}
