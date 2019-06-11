<?php 

/**
 * 
 */
class Ingreso extends Controller
{
	
	public $Mensaje='';

	function __construct()
	{
		parent::__construct();
		$this->view->mensaje="";
		
	}



	public function Index ()
	{
		//$this->model->insert();
		
		$RemplazaAVista = array(
    		'MENSAJE' => $this->Mensaje,    		
    	);

		if (!empty($_POST) && isset($_POST))
		
		{
			$Mensaje=$this->model->ValidarLogin($_POST);
			$RemplazaAVista['MENSAJE'] = $Mensaje;
    		$contenido=$this->view->set_contenido_vista($RemplazaAVista,'ingreso/index');
    		$Datos=array(
		   		 'CONTENT'=>$contenido,		   		
			);
		    echo $this->view->render($Datos);
			exit;
		}

		$contenido=$this->view->set_contenido_vista($RemplazaAVista,'ingreso/index');
    	$Datos=array(
		   		'CONTENT'=>$contenido,
		   		'JAVASCRIPT-FOOTER'=>array(
            	'JS-INGRESO' =>'<script type="text/javascript" src="'.constant("RUTA_RAIZ").'public/js/login/login.js"></script>'          	
            ),
		);
		echo $this->view->render($Datos);	
	}
/*
	function render()
	{
		$this->index();
	}
*/
	function salir()
	{
		session_destroy();
		header("Location:index");
	}

	function CambioContrasena()
	{
		$this->ValidarSesion();	
		$RemplazaAVista = array(
    		'TITULO' => 'CAMBIO DE CONTRASEÑA',    		
    	);
    	
		if (!empty($_POST) && isset($_POST))
		
		{
			echo json_encode($this->model->CambioPass($_POST));			
			exit;
		}

		$contenido=$this->view->set_contenido_vista($RemplazaAVista,'ingreso/cambio-contrasena');
    	$Datos=array(
		   		'CONTENT'=>$contenido,
		   		'JAVASCRIPT-FOOTER'=>array(
            	'JS-INGRESO' =>'<script type="text/javascript" src="'.constant("RUTA_RAIZ").'public/js/login/cambio-contrasena.js"></script>'          	
            ),
		);
		echo $this->view->render($Datos);
	}
	
}

 ?>