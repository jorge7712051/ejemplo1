<?php 

/**
 * 
 */
class ManagerUserModel extends Model
{
	
	public $option= array();

	function __construct(argument)
	{
		
	}


	public function ObtenerModulos($ConfiguracionEnviada = array())
	{
		$ConfiguracionDefecto = array(
            'id_perfil' =>'',                                
        );

        $ConfiguracionExtendida = array_merge($ConfiguracionDefecto, $ConfiguracionEnviada);	

		if($ConfiguracionExtendida['id_perfil'] != ''){
            $FiltroSQL[] = $this->crearFiltro('u', 'loginuser', $ConfiguracionExtendida['loginuser']);
        }      

        $ConsultaSQL = "            
        SELECT
           	op.*
        FROM
            mu_perfiloption po 
        LEFT JOIN  mu_options op ON po.id_option = op.id_option "                 
        .((count($FiltroSQL) > 0) ? ' WHERE '.implode(" AND ",$FiltroSQL) : '')."
        ".((isset($OrdenarPor)) ? "ORDER BY ".$OrdenarPor : '')."                     
        ".((isset($Limite)) ? $Limite : '')."
        "; 
        var_dump($ConsultaSQL);        
        $ResultadoSQL = $this->pasarelaSql($ConsultaSQL,'assoc');  
        return $ResultadoSQL;

	}

	
}

 ?>