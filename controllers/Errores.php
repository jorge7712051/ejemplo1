<?php
/**
 * @access public
 * @copyright (c) 2018, Manejo Tenico de la Informacion
 * @version 1.0 - Clase encargada del manejo de errores de la pagina
*
 * @author v1.0 Jorge Correa <jorge.correa@tomsgreg.com>
 */
class Errores extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		$RemplazaAVista = array(
    		'MENSAJE' => 'PAGINA NO ENCONTRADA',    		
    	);
		
		$contenido=$this->view->set_contenido_vista($RemplazaAVista,'errores/index');
    	$Datos=array(
		   		'CONTENT'=>$contenido,
		   		'JAVASCRIPT-FOOTER'=>array(
            	'JS-INGRESO' =>'<script type="text/javascript" src="'.constant("RUTA_RAIZ").'public/js/login/login.js"></script>'          	
            ),
		);
		echo $this->view->render($Datos);	

	}
}

 ?>