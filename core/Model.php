<?php

/**
 * 
 */
class Model  
{
	
    private $MtiMiddle= "http://172.17.6.79/apmtr/api.php";

	function __construct($DB=MTICLASS_ATLAS,$AutoCommit = true)
	{
		
	}


	function cleanInput($input) {
    
    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Elimina Javascript
        '@<[\/\!]*?[^<>]*?>@si', // Elimina etiquetas HTML
        '@<style[^>]*?>.*?</style>@siU', // Elimina propiedades del style
        '@<![\s\S]*?--[ \t\n\r]*>@', // Elimina comentarios multilínea
        '@( INSERT | insert )@',
        '@(SELECT | SELECT |select | select)@',
        '@( UPDATE | update )@',
        '@( DELETE | delete )@',
        '@( UNION | union )@',
        '@( COPY | copy )@',
        '@( DROP | drop )@',
        '@( DUMP | dump )@',
        '@( AND | and )@',
        '@( OR | or )@',
        '@( SET | set )@'
            // Elimina consulta SQL
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

    public function Camporequerido($datos=array())
    {
        $Errores=array();
        foreach ($datos as $key => $value)
        {
            if(trim($value) == '')
            {
               $Errores[$key]= 'El campo es requerido *';
            }        
        }
                
        $retVal = (count($Errores) > 0) ?  $Errores : true ;
        return $retVal;
    }


    public function Comparacion($datouno,$datodos,$campo)
    {
        $Errores=array();
        if($datouno == $datodos){
            return true;
        } else {
           $Errores[$campo]= 'El campo no coincide';
           return $Errores;
        }
    }


    protected function Conectar($Parametros,$Metodo)
    {
        $ch = curl_init($this->MtiMiddle);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $Metodo);

        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($Parametros));

        $response = curl_exec($ch);

        //$response = utf8_encode($response);
        curl_close($ch);
       if($response)
       { 
         //print_r($response);
            $Datos=json_decode($response,true);
            return $Datos;
       } 
        
               
            
    }



}

?>
