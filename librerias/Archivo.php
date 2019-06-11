<?php

/**
 * Description of Archivo
 *
 * @author javierg.garcia
 */
abstract class Archivo {
    
    # Controlador de mensajes
    private $Respuesta;
    
    # Variables clase
    private $ExtensionesPermitidas;
    private $PatronNombrePermitido;
    
    public function __construct() {
        
        include_once RUTA_RAIZ."php/controladores/Respuesta.php";
        $this->Respuesta = new Respuesta();
    }
    
    public function getRespuesta() {
        return $this->Respuesta;
    }
    
    /**
     * 
     * @return array
     */
    public function getExtensionesPermitidas() {
        return $this->ExtensionesPermitidas;
    }

    /**
     * 
     * @param array $ExtensionesPermitidas
     */
    public function setExtensionesPermitidas($ExtensionesPermitidas) {
        $this->ExtensionesPermitidas = $ExtensionesPermitidas;
    }
    
    /**
     * 
     * @return string
     */
    public function getPatronNombrePermitido() {
        return $this->PatronNombrePermitido;
    }

    /**
     * 
     * @param string $PatronNombrePermitido
     */
    public function setPatronNombrePermitido($PatronNombrePermitido) {
        $this->PatronNombrePermitido = $PatronNombrePermitido;
    }
    
    /**
     * 
     * @param string $Nombre
     */
    public function validarExtensionArchivo($Nombre){
        
        # $Patron = "%\.(".implode("|", $this->getExtensionesPermitidas()).")$%i";
        $PartesNombre = explode(".", $Nombre);
        $Extension = array_pop($PartesNombre);
        
        if(in_array(trim(strtolower($Extension)), $this->getExtensionesPermitidas())){
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
     * 
     * @param string $Nombre
     * @return boolean
     */
    public function validarNombreArchivo($Nombre){
        
        if($this->getPatronNombrePermitido() <> '' AND preg_match($this->getPatronNombrePermitido(), $Nombre)){
            
            $BoolPermitido = true;
        }
        else if($this->getPatronNombrePermitido() <> ''){
            
            $BoolPermitido = false;
        }
        else{
            
            $BoolPermitido = true;
        }
        return $BoolPermitido;
    }
    
    /**
     * 
     * @param string $Nombre
     * @return string
     */
    public function obtenerExtension($Nombre){
        
        $PartesNombre = explode('.', $Nombre);
        $Extension = array_pop($PartesNombre);
        return $Extension;
    }
    
    /**
     * 
     * @param string $Nombre
     * @return array
     */
    public function obtenerTipo($Nombre){
        /*
        $FileInfo = new finfo(FILEINFO_MIME);
        $TF = $FileInfo->file($Nombre);
        
        return explode(" ", $TF);*/
    }
}
