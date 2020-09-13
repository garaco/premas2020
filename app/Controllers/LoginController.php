<?php
defined('BASEPATH') or exit('ERROR403');

require_once ROOT . FOLDER_PATH .'/app/Models/LoginModel.php';
require_once LIBS_ROUTE .'Session.php';

/**
* Login controller
*/
class LoginController extends Controller
{
  private $model;

  private $session;

  public function __construct()
  {
    $this->model = new LoginModel();
    $this->session = new Session();
  }

  public function index()
  {
    $this->render(__CLASS__);
  }

  public function signin($request_params)
  {
    if($this->verify($request_params))
      return $this->renderErrorMessage('Usuario y Contraseña son obligatorios');

    $result = $this->model->signIn($request_params['email']);

    if(!$result->num_rows)
      return $this->renderErrorMessage("El Usuario {$request_params['email']} no fue encontrado");

    $result = $result->fetch_object();

     if(!password_verify($request_params['password'], $result->Password))
       return $this->renderErrorMessage('La contraseña es incorrecta');

     $this->session->init();
     $this->session->add($result->Tipo, $result->Usuario);
     $this->session->add('id', $result->IdUsuario);
     $this->session->add('Tipo', $result->Tipo);
     $this->session->add('Dep', $result->IdDepartamento);
     $this->session->add('User', $result->Nombre_User);
     switch ($result->Tipo) {
        case 'SuperAdmin':
          header('location: '.FOLDER_PATH.'/Main');
        break;
        case 'Admin':
          header('location: '.FOLDER_PATH.'/Bitacora');
        break;
        case 'Normal':
          header('location: '.FOLDER_PATH.'/RBS');
        break;
        case 'SCM':
          header('location: '.FOLDER_PATH.'/SMC');
        break;
        case 'Asigna':
          header('location: '.FOLDER_PATH.'/Valida');
        break;
        default:
          //  header('location: '.FOLDER_PATH.'/Error403');
     }

   }

   public function recover(){
     require_once ROOT . FOLDER_PATH .'/app/Request/LoginRequest.php';
   }

  public function send($request_params){
    $usuarioBD="";$email="";
    $result = $this->model->User($request_params['usaurio']);
    foreach ($result as $r) {
      $usuarioBD=$r['Usuario'];
      $email=$r['Correo'];
    }
    if ($usuarioBD==$request_params['usaurio']) {

          $result = $this->model->des_decrypt($request_params['usaurio'],$request_params['key'].'asma');
          $asunto='Recuperación de contraseña del sistema PREMAS';
          foreach ($result as $r) {
              $msg='Estimado usuario: '.$usuarioBD."\n".'Se ha solicitado la recuperacion de su contraseña el dia '.date('d/m/Y',time()).' a las '.date("H:i:s")."\n".'Su contraseña actual es: '.$r['pass'];
          }
           mail($email,$asunto,$msg);
        return $this->renderSuccess("Se le envio la contraseña al siguiente correo: ".$email);
    }else{
       return $this->renderErrorMessage("El Usuario {$request_params['usaurio']} no fue encontrado, intentar de nuevo");
    }

    header('location: '.FOLDER_PATH.'');
  }

  private function verify($request_params)
  {
    return empty($request_params['email']) OR empty($request_params['password']);
  }

  private function renderErrorMessage($message)
  {
    $params = array('error_message' => $message);
    $this->render(__CLASS__, $params);
  }

  private function renderSuccess($message)
  {
    $params = array('success_message' => $message);
    $this->render(__CLASS__, $params);
  }

}
