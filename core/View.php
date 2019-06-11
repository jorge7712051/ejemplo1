<?php
/**
 * 
 */
class View 
{
	public $Menu;

	function __construct()
	{
		       
               
        if(isset($_SESSION)){
            
            if(isset($_SESSION['ENTORNODECEVAL']['MENU_HTML']) AND trim($_SESSION['ENTORNODECEVAL']['MENU_HTML']) == '' OR !isset($_SESSION['ENTORNODECEVAL']['MENU_HTML'])){    
                $this->CrearMenu();
                $_SESSION['ENTORNODECEVAL']['MENU_HTML'] = $this->getMenu();
            }
            else{
                $this->setMenu($_SESSION['ENTORNODECEVAL']['MENU_HTML']);
            }
        }
        else{
            $this->setMenu('');
        }
	}

	function Render($Parametros = array())
	{
		
              
		$ParamtrosDefecto = array(
			'TITULO' => 'DECEVAL',
			'METADATA' => array(
                "CHARSET" => '<meta charset="utf-8">',
                "X-FRAME" => '<meta http-equiv="X-Frame-Options" content="deny">',
                "CACHE" => '<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate, private">',
                "PRAGMA" => '<meta http-equiv="pragma" content="no-cache" />',
               "AUTOR1" => '<meta name="author" content="Aplicativo - Jorge Correa <jorge.correa@thomasgreg.com>">',
             ),
            'JAVASCRIPT'=>array(
            	'JQUERRY' =>'<script type="text/javascript" src="'.constant("RUTA_RAIZ").'public/js/jquery-1.11.2.min.js"></script>',
            	'BOOSTRAP-POPPER' =>'<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>' , 
            	'BOOSTRAP-JS' =>'<script type="text/javascript" src="'.constant("RUTA_RAIZ").'public/js/bootstrap.min.js"></script>' ,
            ),
            'JAVASCRIPT-FOOTER' => array(                
            ),
            'CSS'=>array(
            	'BOOSTRAP-CSS' =>'<link href="'.constant("RUTA_RAIZ").'public/css/bootstrap.css" rel="stylesheet">',
                'PAGINA-CSS' =>'<link href="'.constant("RUTA_RAIZ").'public/css/layaout/layaout.css" rel="stylesheet">'           ),
            'HEADER' => $this->set_contenido_vista(array( "MENU" => $this->getMenu()), "header"),
            'LAYOUT' => "layaout",
            'CONTENT'=>"CONTENIDO",
           
		);
		$ar_USAR = $this->array_merge_multidimensional($ParamtrosDefecto, $Parametros);

		$Vista = $this->set_contenido_vista($ar_USAR,$ar_USAR['LAYOUT']);
        return $Vista;
   }


   public function set_contenido_vista($datos,$NombreVista)
   {
        $Vista='views/'. $NombreVista .'.php';
        $VistaContenido = file_get_contents($Vista);
        foreach($datos as $clave => $valor){
            if(is_array($valor)) $valor = implode(" ",$valor);
            $VistaContenido = str_replace("{".$clave."}",$valor,$VistaContenido);
        }
        return $VistaContenido;
    }

    private function array_merge_multidimensional($ar_DEFAULT, $ar_EXTENDS){
        
        foreach($ar_DEFAULT AS $K => $C){
            if(isset($ar_EXTENDS[$K])){
                
                if(is_array($ar_DEFAULT[$K])){
                    $ar_USAR[$K] = array_merge($ar_DEFAULT[$K],$ar_EXTENDS[$K]);
                }
                else if($ar_EXTENDS[$K] == ''){
                    $ar_USAR[$K] = $ar_DEFAULT[$K];
                }
                else{
                    $ar_USAR[$K] = $ar_EXTENDS[$K];
                }
            }
            else{
                $ar_USAR[$K] = $ar_DEFAULT[$K];
            }
        }
        return $ar_USAR;
    }

    public	 function setMenu($menu)
    {
    	$this->Menu=$menu;
 	}

 	public function getMenu()
 	{
 		return $this->Menu;
 	}

 	public function CrearMenu()
 	{
 		if(isset($_SESSION['ENTORNODECEVAL']['MENU'])){
            $MODULOS = array_unique(array_column($_SESSION['ENTORNODECEVAL']['MENU'],'modulo'));

            $HTML = '';
            foreach ($MODULOS AS $M){

                if($M != 'null'){
                    $APLICACIONES = array_filter($_SESSION['ENTORNODECEVAL']['MENU'], function($var) use($M) {
                        # Filtra las aplicaciones de cada modulo
                        return in_array($M, $var) ? true : false;
                    });
                    $Itera = 1;

                    foreach ($APLICACIONES AS $APS){

                        if($Itera == 1){
                            $HTML .= '<li class="nav-item  dropdown">';
                            $HTML .= '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa '.$APS['icono'].'"></span> '.$APS['modulo'].' <span class="caret"></span></a>';
                            $HTML .= '<ul class="dropdown-menu" role="menu">';
                        }
                        $HTML .= '<li><a class="dropdown-item" href="'.$_SESSION['ENTORNODECEVAL']["URL"]."/MtiDeceval/".$APS['url'].'">'.$APS['descripcion'].'</a></li>';

                        if(count($APLICACIONES) == $Itera){
                            $HTML .= '</ul>' .
                            '</li>';
                        }
                        $Itera++;
                    }
                }
            }
            $this->setMenu($HTML);
        }

 	}



//require 'views/'. $NombreVista .'.php';
	

}

?>