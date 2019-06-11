<?php

/**
 * @access public
 * @copyright (c) 2016, Manejo Tenico de la Informacion
 * @since Enero 2016
 * 
 * @version 1
 * 
 * @uses Transformar una matriz en un archivo de excel
 * 
 * @internal Las variables estan creadas segun el estandar CamelCase http://es.wikipedia.org/wiki/CamelCase
 * 
 * @author v1.0 Javier Garcia <javier.23.2010@gmail.com>
 */

class ArrayAExcel{
    
    private $PHPExcel;
    private $Formato;
    private $Bordes;
    private $PrimeraFila;
    private $CamposATipar;
    private $RutaTemporalDescarga;
    
    /**
     * 
     * @param string $Titulo
     * @param string $Descripcion
     * @param string $Categoria
     */
    public function __construct($Titulo, $Descripcion, $Categoria) {
        
        include_once 'librerias/PHPExcel.php';
        $this->PHPExcel = new PHPExcel();
        
        $this->getPHPExcel()->getProperties()
            ->setCreator("Manejo Técnico de la Información <sistemas.tv@thomasgreg.com>")
            ->setLastModifiedBy("Manejo Técnico de la Información <sistemas.tv@thomasgreg.com>")
            ->setTitle($Titulo)
            ->setSubject("")
            ->setDescription($Descripcion)
            ->setCategory($Categoria);
        
        $this->setFormato('xlsx');
        $this->setBordes();
        $this->setPrimeraFila();
        $this->setRutaTemporalDescarga('../tmp/');
        
    }
    
    /**
     * 
     * @return PHPExcel
     */
    private function getPHPExcel() {
        return $this->PHPExcel;
    }
    
    /**
     * 
     * @return string
     */
    public function getFormato() {
        return $this->Formato;
    }

    /**
     * 
     * @param string $Formato
     */
    public function setFormato($Formato) {
        $this->Formato = $Formato;
    }
    
    /**
     * 
     * @return array
     */
    private function getBordes() {
        return $this->Bordes;
    }

    /**
     * 
     * @return array
     */
    private function getPrimeraFila() {
        return $this->PrimeraFila;
    }
    
    /**
     * 
     * @return array
     */
    private function getCamposATipar() {
        return $this->CamposATipar;
    }
    
    /**
     * 
     * @param string $Llave
     * @return string
     */
    private function getTipadoCampo($Llave) {
        return $this->CamposATipar[$Llave];
    }
        
    /**
     * 
     * @param array $Bordes
     */
    public function setBordes($Bordes = array()) {
        
        $this->Bordes = (count($Bordes) > 0) ? $Bordes : array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
        );
    }

    /**
     * 
     * @param array $PrimeraFila
     */
    public function setPrimeraFila($PrimeraFila = array()) {
        
        $this->PrimeraFila = (count($PrimeraFila)) ? array_merge($this->getBordes(), $PrimeraFila) : array_merge($this->getBordes(), array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '9BBB59')
            ),
            'font' => array(
                'color' => array(
                    'rgb' => '000000'
                )
            )
        ));
    }
    
    /**
     * 
     * @param string $RutaTemporalDescarga
     */
    function setRutaTemporalDescarga($RutaTemporalDescarga) {
        $this->RutaTemporalDescarga = $RutaTemporalDescarga;
    }
    
    /**
     * 
     * return string
     */
    function getRutaTemporalDescarga() {
        return $this->RutaTemporalDescarga;
    }
    
    /**
     * 
     * @param array $CamposATipar
     */
    function setCamposATipar($CamposATipar) {
        $this->CamposATipar = $CamposATipar;
    }
    
    /**
     * 
     * @param int $Columnas
     * @return string
     */
    private function numeroAColumna($Columnas){
        
        $numeric = $Columnas % 26;
        $Letra = chr(65 + $numeric);
        $Auxiliar = intval($Columnas / 26);
        if ($Auxiliar > 0) {
            return $this->numeroAColumna($Auxiliar - 1) . $Letra;
        }
        else {
            return $Letra;
        }
    }
    
    /**
     * 
     * @param int $Limite
     * @return array
     */
    private function obtenerNumeracionColumnas($Limite = 25){
        
        $Abecedario = array();
        if(is_int($Limite)){
            
            for($i=0; $i<$Limite; $i++){
                $Abecedario[]= $this->numeroAColumna($i);
            }
        }
        return $Abecedario;
    }
    
    /**
     * 
     * @param array $Arreglo
     * @param array $Mostrar
     */
    public function generar($Arreglo, $Mostrar) {
        
        $Columnas = $this->obtenerNumeracionColumnas(count($Mostrar));
        
        $Fila = 1;
        $Columna = 0;
        # Colocar titulos
        foreach ($Mostrar AS $M){
            
            $this->getPHPExcel()->setActiveSheetIndex(0)->setCellValue($Columnas[$Columna].$Fila, $M);
            $Columna++;
        }
        
        # Colocar contenido informe, si hay campos para tipar realiza un proceso distinto, se parte en dos para evitar gastos de memoria inecesarios
        if(count($Arreglo) > 0){
            
            if(count($this->getCamposATipar()) == 0){

                foreach($Arreglo AS $A) {

                    $Fila++;
                    $DetalleColumna = array_merge($Mostrar, array_intersect_key($A, $Mostrar));

                    $Columna = 0;
                    foreach ($DetalleColumna as $DC) {

                        $this->getPHPExcel()->setActiveSheetIndex(0)
                            ->setCellValue($Columnas[$Columna].$Fila, $DC);
                        $Columna++;
                    }
                }
            }
            else{
                $ATipar = array_keys($this->getCamposATipar());

                foreach($Arreglo AS $A) {

                    $Fila++;
                    $DetalleColumna = array_merge($Mostrar, array_intersect_key($A, $Mostrar));
                    $Columna = 0;

                    foreach ($DetalleColumna as $Llave => $DC) {

                        $Encontrado = array_search($Llave, $ATipar);

                        if($Encontrado !== FALSE){

                            $Tipado = $this->getTipadoCampo($Llave);

                            if($Tipado == 'STRING'){
                                $this->getPHPExcel()->setActiveSheetIndex(0)->setCellValueExplicit($Columnas[$Columna].$Fila, $DC, PHPExcel_Cell_DataType::TYPE_STRING);
                            }
                            elseif($Tipado == 'NUMERIC'){
                                $this->getPHPExcel()->setActiveSheetIndex(0)->setCellValueExplicit($Columnas[$Columna].$Fila, $DC, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            }
                        }
                        else{
                            $this->getPHPExcel()->setActiveSheetIndex(0)->setCellValue($Columnas[$Columna].$Fila, $DC);
                        }
                        $Columna++;
                    }
                }
            }
        }
        
        # Estilos
        $this->getPHPExcel()->getActiveSheet()->getStyle('A1:'.$Columnas[$Columna-1].$Fila)->applyFromArray($this->getBordes());
        $this->getPHPExcel()->getActiveSheet()->getStyle('A1:'.$Columnas[count($Columnas)-1].'1')->applyFromArray($this->getPrimeraFila());
        
        # Ajustar texto a la columna
        foreach ($Columnas AS $C){
            $this->getPHPExcel()->getActiveSheet()->getColumnDimension($C)->setAutoSize(true);
        }
    }
    
    /**
     * 
     * @return string
     */
    private function claseSegunFormato() {
        return ($this->getFormato() == "xlsx") ? "Excel2007" : "Excel5";
    }


    /**
     * 
     * @param string $NombreArchivo
     */
    public function descargar($NombreArchivo) {
        
        //$this->guardar($NombreArchivo, "/tmp/");
        $this->guardar($NombreArchivo, "tmp/");
        //header("location: ".$this->getRutaTemporalDescarga().$NombreArchivo.".".$this->getFormato());
        
        /*$Tipo = $this->claseSegunFormato();
        
        $objWriter = PHPExcel_IOFactory::createWriter($this->getPHPExcel(), $Tipo);
        
        # header('Content-Type: text/html; charset=ANSI');
        header('Content-Type: application/vnd.ms-excel; charset=UTF8');
        header('Content-Disposition: attachment;filename="'.$NombreArchivo.'.'.$this->getFormato().'"');
        header('Cache-Control: max-age=0');
        
        $objWriter->save('php://output');*/
    }
    
    /**
     * 
     * @param string $NombreArchivo
     * @param string $Ruta
     */
    public function guardar($NombreArchivo, $Ruta) {
        
        $Tipo = $this->claseSegunFormato();
        $N=$NombreArchivo.'.'.$this->getFormato();
        $objWriter = PHPExcel_IOFactory::createWriter($this->getPHPExcel(), $Tipo);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$N.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
       
    }
    
    /**
     * 
     */
    public function __destruct() {
        
    }
    
    /**
     * Método setAutoFiltros: establece autofiltros en una fila de Excel
     * 
     * @param type String $rango
     */
    public function setAutoFiltros($rango){
        $this->getPHPExcel()->getActiveSheet()->setAutoFilter($rango);
    }
    
    
    /*
     * Método inmovilizarSuperior: inmoviliza el panel superior de la hoja de Excel
     */
    public function inmovilizarSuperior(){
        $this->getPHPExcel()->getActiveSheet()->freezePane('A2');
    }
    
    /**
     * Método setCeldaComentario: Pone un comentario flotante en una celda de Excel
     * 
     * @param type String  $celda 
     * @param type String  $comentario
     * @param type Integer $ancho
     * @param type Integer $alto
     * @param type String  $autor
     * @param type Boolean $negrilla
     */
    
    public function setCeldaComentario($celda,$comentario,$ancho=300,$alto=150,$autor='',$negrilla=false){
        $objComentario = $this->getPHPExcel()->getActiveSheet()->getComment($celda)->getText()->createTextRun($comentario);
        $this->getPHPExcel()->getActiveSheet()->getComment($celda)->setWidth($ancho.'pt');
        $this->getPHPExcel()->getActiveSheet()->getComment($celda)->setHeight($alto.'pt');
        $objComentario->getFont()->setBold($negrilla);
        if($autor!=''){
            $this->getPHPExcel()->getActiveSheet()->getComment($celda)->setAuthor($autor);
        }
    }    
    
    /**
     * 
     * @param array $Arreglo
     * @param string $Llave
     * @param string $Contenido
     * @return array
     */
    public function arrayALlaveContenido($Arreglo, $Llave, $Contenido) {
        
        $ArrayFinal = array();
        foreach ($Arreglo as $Ar) {
            @$ArrayFinal[$Ar[$Llave]] = $Ar[$Contenido];
        }
        return $ArrayFinal;
    }
                                
}
