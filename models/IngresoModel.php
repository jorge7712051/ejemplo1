<?php

/**
 * 
 */
class IngresoModel extends Model
{
	
	public $NombreTabla="mu_users";
	public $TablaPerfiles="mu_perfiloptions";
	public $Menu=array();
	public $DatosUsuario=array();
  public $Error=array();
  public $Usuario;
  public $Password;
  public $RepetirPassword;

	function __construct($DB=MTICLASS_USUARIOS)
	{
		parent::__construct($DB);
	}

  public function validate($esenario)
  {
     $Errores= array();
    switch ($esenario) {
      case 'login':
        $requeridos= array('Usuario'=>getUsuario(),'nuevopass'=>getPassword());
        $Errores = ($this->Camporequerido($requeridos)) ? true  : $this->Camporequerido($requeridos) ;
         

        break;

      case 'CambioPass':
       
        $Requeridos= array('nuevopass'=>$this->getPassword(),'repetirpass'=>$this->getRepetirPassword());
        $Temp = $this->Camporequerido($Requeridos);    
        if (is_array($Temp)) { 
             $Temp = $this->Camporequerido($Requeridos);
             $Errores = array_merge($Errores, $Temp);
        }
        unset($Temp);
        $Temp = $this->Comparacion($this->getPassword(),$this->getRepetirPassword(),'repetirpass');    
        if (is_array($Temp)) {           
           $Errores = array_merge($Errores, $Temp);
        }     
        break;
      
      default:
        # code...
        break;
    }

    if (count($Errores)>0)
    {
      $Errores['repetirpass'] = 'El campo no coincide';
      $this->setError($Errores);
      return false;
    }
    else 
    {
      return true;
    }
    
      
  }


  public function getError()
  {
    return $this->Error;
  }

  public function setError($Datos)
  {
    $this->Error=$Datos;
  }

  public function getDatosUsuario()
  {
    return $this->DatosUsuario;
  }

  public function setDatosUsuario($Datos)
  {
    $this->DatosUsuario=$Datos;
  }

  public function getMenu()
  {
    return $this->Menu;
  }

  public function setMenu($Datos)
  {
    $this->Menu=$Datos;
  }

  public function getUsuario()
  {
    return $this->Usuario;
  }

  public function setUsuario($Datos)
  {
    $this->Usuario=$Datos;
  }

  public function getPassword()
  {
    return $this->Password;
  }

  public function setPassword($Datos)
  {
    $this->Password=$Datos;
  }
    public function getRepetirPassword()
  {
    return $this->RepetirPassword;
  }

  public function setRepetirPassword($Datos)
  {
    $this->RepetirPassword=$Datos;
  }

	public function ValidarLogin ($post)
	{
		$Mensaje='';
		$Configuracion = array(
            'loginuser' => strtoupper($post['usuario']),
            'passuser' => md5($post['password']),
            'id_application' => 361,
            'request'=>"metodoLogin",
            'modelo'=>'user',
            'base'=>MTICLASS_USUARIOS                  
    );
      $usuario =$this->Conectar($Configuracion,'POST');
        
       
      if(count($usuario)>0)
       {
       		$this->setDatosUsuario($usuario);
       		$ConfiguracionOp = array( 
                            'id_perfil' =>  $usuario[0]['id_profile'],
                            'modelo'=>'user',
                            'request'=>"GetMenu",
                            'base'=>MTICLASS_USUARIOS     
                            );
       		$Menu=$this->Conectar($ConfiguracionOp,'POST');

       		if(count($Menu)>0)
       		{
       			$this->setMenu($Menu);
       			$Url=$this->cleanInput($post['cargaUrl']);
       			$this->Crearsesion($Url);      			
       			header("Location:".$Url."/MtiDeceval/".$Menu[0]['url']);
       		} 
       	}	
		return $Mensaje='<div class="alert alert-danger">Datos Incorrcetos</div>';

	}

	private function Crearsesion($Url='')
	{
    session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], 0); 
		$_SESSION['ENTORNODECEVAL'] = array(
            'USU' => $this->getDatosUsuario(),
            'MENU' => $this->getMenu(),   
            'URL'=>$Url,       
            'TIEMPO_LIMITE' => 3000,
            'tiempo' => date("Y-n-j H:i:s")
        );

	}


	

  public function CambioPass($post)
  {

    if($_SESSION['ENTORNODECEVAL']['USU'][0]['passuser'] == md5($this->cleanInput($post['passwactual'])))
    {
      $this->setPassword($post['nuevopass']);
      $this->setRepetirPassword($post['repetirpass']);
      if ($this->validate('CambioPass'))
      {
        $DatosInsertar = array("passuser" => md5($post['nuevopass']),
                              "id_user" => $_SESSION['ENTORNODECEVAL']['USU'][0]['id_user'],
                              "NombreTabla"=>$this->NombreTabla,
                              "request"=>"EditarPassword",
                              "base"=>MTICLASS_USUARIOS,
                              "modelo"=>"user"
                        );
        $respuesta=$this->Conectar($DatosInsertar,'POST');
        return   $respuesta;

      }
      else { return $this->getError(); }
    } 
    else 
      return array('passwactual' =>'La contraseña actual no coincide');
      
  }


   


}

?>

