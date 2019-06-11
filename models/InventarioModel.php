<?php 

/**
 * 
 */
class InventarioModel extends Model
{
	public $Cliente;


	function __construct($DB=MTICLASS_ATLAS)
	{
		parent::__construct($DB);
		require_once 'models/ClienteModel.php';
		include_once 'librerias/ArrayAExcel.php';
		$Cliente = new ClienteModel($DB);
		$this->setCliente($Cliente);

	}

	public function getCliente()
	{
		return $this->Cliente;
	}

	public function setCliente($cliente)
	{
		$this->Cliente=$cliente;
	}

	public function ClientesDeceval()
	{
		$Busqueda=array(
			'razonsocial'=>'DECEVAL',
    		'orden'=>array(
    			'razonsocial' => 'ASC'
    		),
		);

		return $this->getCliente()->listarcliente($Busqueda,'Html');
	}

	public function Reporte($idcliente)
	{
		//$contenido= $this->ConsultaInventario($idcliente['id_cliente']);
        $Configuracion = array(
            'id_cliente' => $idcliente['id_cliente'],
            'request'=>"getReporte",
            'modelo'=>'reporte',
            'base'=>MTICLASS_ATLAS                  
        );

        $contenido =$this->Conectar($Configuracion,'POST');

		$AExcel = new ArrayAExcel("Listado_usuarios_al_".date("Y-m-d"), "Listado Inventario", "Informes");
        # Indica los campos a mostrar en el archivo de excel
        $Mostrar = array(
            'razonsocial' => 'CLIENTE',
            'numidentificacion'=>'NUMERO DE IDENTIFICACION',
            'numcontrato' => 'NUMERO PAGARE',
            'id_deceval'=>'ID DECEVAL'        
        );       

        # Indica los campos a tipar
        $ATipar = array(
            "numidentificacion" => "STRING"
        );
        $AExcel->setCamposATipar($ATipar);
        # Genera archivo
        $AExcel->generar( $contenido, $Mostrar);
        # Solicita el archivo generado para descarga
        $AExcel->descargar('Pagares'.date("Ymd"));
                        
    }
	


	




}


?>