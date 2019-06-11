<?php 
/**
 * 
 */
class Inventario extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->ValidarSesion();		
	}

	public function Index ()
	{
		$Clientes=$this->model->Clientesdeceval();
		$RemplazaAVista = array(
    			'TITULO' => "INVENTARIOS DECEVAL",
    			'CLIENTE'=>$Clientes
    			
    	);
		$contenido=$this->view->set_contenido_vista($RemplazaAVista,'inventario/index');
    	$Datos=array(
		   		'CONTENT'=>$contenido,
		   		'TITULO'=>'INVENTARIOS DECEVAL',
		   		'JAVASCRIPT'=>array(
            	'JS-INGRESO' =>'<script type="text/javascript" src="'.constant("RUTA_RAIZ").'public/js/reportes/reporte-inventario.js"></script>'          	
		   		),

		);
		echo $this->view->render($Datos);	
	}

	function render()
	{
		$this->index();
	}

	public function reporte ()
	{
		if (!empty($_POST) && isset($_POST))		
		{
			$this->model->Reporte($_POST);
		}		
		exit;
	}
}


?>