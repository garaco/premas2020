<?php
defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Models/KardexModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/UsuariosModel.php';
require_once LIBS_ROUTE .'Session.php';

class UsuariosController extends Controller
{
  private $session;
  private $model;
  public static $indice;
  public function __construct()
  {
    $this->session = new Session();
    $this->model = new UsuariosModel();
    $this->session->init();
    if($this->session->get('Tipo')!='SuperAdmin')
      header('location: '.FOLDER_PATH.'/Error403');
  }

public function index()
  {
    $result = $this->model->getJoinAll();
    $user = $this->model->DatoUser($this->session->get('id'),'IdUsuario');
    $user = $user->fetch_object();
    $params = array('result'=> $result,'User'=>$user->Nombre_User);
    $this->render(__CLASS__, $params);

  }

  public function requested(){

    $ID=($_POST['id'] != 0)?$_POST['id']:'0'; $Usuario=""; $Nombre_User=""; $Apellidos_User=""; $Password="";
    $IdArea=""; $Area=""; $IdJefe=""; $Jefe=""; $IdDep=""; $Dep="";$Mail="";
    $data=$this->model->getUser($_POST['id']);
    foreach ($data as $d) {
      $Password=$d['pass'];
      $Usuario=$d['Usuario'];
      $IdArea=$d['IdArea'];
      $Area=$d['Tipo'];
      $IdJefe=$d['Idjefe'];
      $Jefe=$d['jefe'];
      $IdDep=$d['IdDepartamento'];
      $Dep=$d['nombreDepto'];
      $Nombre_User=$d['Nombre_User'];
      $Apellidos_User=$d['Apellidos_User'];
      $Mail=$d['Correo'];
    }
    require_once ROOT . FOLDER_PATH .'/app/Request/UsuariosRequest.php';
  }

    public function save(){
        $arrayExplode = explode('-', $_POST['Usuario']);
        $Nombre_User=$arrayExplode[0];
        $Apellidos_User=$arrayExplode[1];
        $area=$_POST['area'];
        $mail=$_POST["mail"];
        $password = $_POST["password"];
        $passwordConvert = password_hash($password, PASSWORD_DEFAULT);

      if ($_POST['id'] == 0) {
          $this->model->add($_POST['N_usuario'],$Nombre_User,$mail,$Apellidos_User,$passwordConvert,$_POST['password_alt'],$area,$_POST['departamento']);
      } else {
          $this->model->update($_POST['id'],$_POST['N_usuario'],$Nombre_User,$mail,$Apellidos_User,$passwordConvert,$_POST['password_alt'],$area,$_POST['departamento']);
      }


      $kardex = new KardexModel();
      $kardex->IdUsuario=$this->session->get('id');
      $kardex->Accion='Agrego';
      $kardex->Catalogo='Usuario';
      $kardex->Descripcion="se creo un nuevo usuario: ".$_POST['N_usuario'];
      $kardex->add();
      header('location: '.FOLDER_PATH.'/Usuarios');
  }
  public function delete()
  {
     $result = $this->model->getDatoUser($_POST['id']);

    foreach ($result as $r) {
      $ID=$r['IdUsuario'];
      $Usuario=$r['Usuario'];
      $Nombre_User=$r['Nombre_User'];
      $Apellidos_User=$r['Apellidos_User'];
      $Password=$r['Password'];
  }
  require_once ROOT . FOLDER_PATH .'/app/Request/UsuariosRequest.php';
}
public function remove()
{
  $this->model->delete($_POST['id']);
  $kardex = new KardexModel();
  $kardex->IdUsuario=$this->session->get('id');
  $kardex->Accion='Eliminar';
  $kardex->Catalogo='Usuario';
  $kardex->Descripcion="se ha elimino un usuario";
  $kardex->add();
  header('location: '.FOLDER_PATH.'/Usuarios');
}
  public function pagination(){
    $funcion = $_POST['function'];
    $result = $this->model->getJoinAll(($_POST['page']),($_POST['fin']));
    require_once ROOT . FOLDER_PATH .'/app/Request/UsuariosRequest.php';
  }
  private function verify($request)
  {
    return empty($request["id"]);
  }

}
?>
