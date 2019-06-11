<?php
session_start();
session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], 0); 

/**
 * @access public
 * @copyright (c) 2018, Manejo Tenico de la Informacion
 * @version 1.0 - Clase core de los controladores
 *
 * @author v1.0 Jorge Correa <jorge.correa@tomsgreg.com>
 */
 class Controller 
 {
 	
 	function __construct()
 	{

 		$this->view = new View();
 		
 	}

 	function LoadModel($model)
 	{
 		$url='models/'.$model.'model.php';

 		if (isset($url))
 		{
 			require $url;

 			$ModelName=$model.'Model';

 			$this->model= new $ModelName();
 		}
 	}

 	public function ValidarUrl($listaurl=Array(),$subcadena)
	{
		$i=0;
		if(count($listaurl)!=0)
		{
			foreach($listaurl as $llave=>$valor)
			{
				$urlactual=str_replace($subcadena, "", $_SERVER['PHP_SELF']);
				if ($listaurl[$llave]['url']==$urlactual)
				{
					$i++;
				}				
			}			
		}
		if ($i==0)
		{
			header("location:../php/submit/ingreso/salir.php");

		}		
	}

	public function ValidarSesion() {
	
        if (!isset($_SESSION['ENTORNODECEVAL']) || !isset($_SESSION['ENTORNODECEVAL']['USU'])){  
            echo '<script type="text/javascript">alert("Su sesi\xf3n ha expirado.\nInicie nuevamente.");window.location="../ingreso/index";</script>';
            session_destroy();
            exit;
        }
        else{
        	$ahora = date("Y-n-j H:i:s"); 
        	$tiempo_transcurrido = (strtotime($ahora)-strtotime($_SESSION['ENTORNODECEVAL']['tiempo'])); 
        	if($tiempo_transcurrido >= 300)
        	{
 				echo '<script type="text/javascript">alert("Su sesi\xf3n ha expirado.\nInicie nuevamente.");window.location="../ingreso/index";</script>';
            	session_destroy();
            exit;
        	} 
        	
        }
    }

 	
 }
?>