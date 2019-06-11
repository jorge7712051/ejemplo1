<?php
require_once 'controllers/Errores.php';

class App 
{

	function __construct()
	{
		$url=isset($_GET['url']) ? $_GET['url'] : null ;
		$url=trim($url,'/');
		$url=explode('/', $url);

		//si no se especifica controlador
		if (empty($url[0])) {/*
			$ArchivoConntroller= 'controllers/Ingreso.php';
			require_once $ArchivoConntroller;
			$Controller= new Ingreso();			
			$Controller->LoadModel('Ingreso');
			$Controller->index();
			*/
			$ArchivoConntroller ='controllers/Errores.php';
			require_once $ArchivoConntroller;
			$Controller = new Errores();			
			$Controller->LoadModel('Error');
			$Controller->index();
			return false;

		}
		else
		{
			$ArchivoConntroller= 'controllers/'.$url[0].'.php';
		}
		

		if (file_exists($ArchivoConntroller))
		{
			require_once $ArchivoConntroller;
			$Controller = new $url[0];
			$Controller->loadModel($url[0]);
		//si existe una accion
			if (isset($url[1]))
			{
				$rutas=explode("-",$url[1]);
				if (!empty($rutas))
				{
					$metodo='';
					foreach ($rutas as $key => $value) 
					{
						$metodo .=ucwords($value);  
					}
					if (method_exists($Controller ,$metodo))
					{
						$Controller->{$metodo}();		
					}
							
				} 
				else
				{
					if (method_exists($Controller ,$url[1]))
					{
						$Controller->{$url[1]}();
					}
				}				
			}
			else
			{
				require_once $ArchivoConntroller;
				$Controller = new Errores();			
				$Controller->LoadModel('Error');
				$Controller->index();
				return false;
			}
		}
		else
		{
			
		}
		
		
	}

}
?>