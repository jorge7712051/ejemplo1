<?php
error_reporting(E_ALL);
ini_set('display_error', 'On');
ini_set("session.use_only_cookies","1"); 
ini_set("session.use_trans_sid","0"); 


#constantes

$Directorio = 'MtiDeceval'; 
defined('RUTA_RAIZ') or define('RUTA_RAIZ', "http://".$_SERVER['HTTP_HOST']."/$Directorio/");


$Entorno = 'Produccion';

switch ($Entorno) {
    case 'Desarrollo':
        # Conexiones por mticlass desarrollo
        defined("MTICLASS_ATLAS") or define("MTICLASS_ATLAS", "atlaspreproduc");
        defined("MTICLASS_USUARIOS") or define("MTICLASS_USUARIOS", "managerusersdav");
        defined("MTICLASS_GENERADOR_REPORTES") or define("MTICLASS_GENERADOR_REPORTES", "genreppreproduc");
        
        # Alias base de datos desarrollo
        defined("SCH_ATLAS") or define("SCH_ATLAS", "atlas.");
        defined("SCH_GENERADOR_REPORTES") or define("SCH_GENERADOR_REPORTES", "genrep.");        
       
        
         
        break;

    case 'Produccion':
        # Conexiones por mticlass produccion
        defined("MTICLASS_ATLAS") or define("MTICLASS_ATLAS", "atlas");
        defined("MTICLASS_USUARIOS") or define("MTICLASS_USUARIOS", "manageruserspro");
        defined("MTICLASS_GENERADOR_REPORTES") or define("MTICLASS_GENERADOR_REPORTES", "genrep");
        
        # Alias base de datos producción
        defined("SCH_ATLAS") or define("SCH_ATLAS", "atlas.");
        defined("SCH_GENERADOR_REPORTES") or define("SCH_GENERADOR_REPORTES", "genrep.");
        
       
        break;
    case 'Calidad':
        # Conexiones por mticlass QA
        defined("MTICLASS_ATLAS") or define("MTICLASS_ATLAS", "atlasqa");
        defined("MTICLASS_USUARIOS") or define("MTICLASS_USUARIOS", "managerusersqa");
        defined("MTICLASS_GENERADOR_REPORTES") or define("MTICLASS_GENERADOR_REPORTES", "genrepqa");
        
        # Alias base de datos QA
        defined("SCH_ATLAS") or define("SCH_ATLAS", "atlas.");
        defined("SCH_GENERADOR_REPORTES") or define("SCH_GENERADOR_REPORTES", "genrep.");
        
        
        break;
    default:
        break;
}
?>