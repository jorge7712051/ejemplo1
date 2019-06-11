<?php 

/**
 * 
 */
class ClienteModel extends Model
{
	public $NombreTabla='cliente';

	function __construct($DB=MTICLASS_ATLAS)
	{
		parent::__construct($DB);
	}


	public function listarcliente($Filtro = array(), $Tipo = "Html", $Selected = "") {
        
        $Configuracion = array(
            'configuracionconsulta' => $Filtro,
            'request'=>"getClientes",
            'modelo'=>'cliente',
            'base'=>MTICLASS_ATLAS                  
        );

        $Listado =$this->Conectar($Configuracion,'POST');
        
        if($Tipo == "Html"){
            
            $Html = "";
            foreach ($Listado as $Motivo) {
                
                $Html .= "<option value='".$Motivo['id_cliente']."' ".(($Selected == $Motivo['id_cliente']) ? "selected" : "").">".$Motivo['razonsocial']."</option>";
            }
            return $Html;
        }
        elseif($Tipo == "Json"){
            
            return json_encode($Listado);
        }
        else{
            return $Listado;
        }
    }

	
}

 ?>