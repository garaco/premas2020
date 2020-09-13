<?php
defined('BASEPATH') or exit('ERROR403');
require_once LIBS_ROUTE .'Session.php';
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/LoginModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/BitacoraModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/ProyectoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MetasModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/KardexModel.php';
/**
* Main controller
*/
class RBSController extends Controller
{
  private $session;
  private $model;

  public function __construct()
  {
    $this->session = new Session();
    $this->model = new RBSModel();
    $this->model2 = new BitacoraModel();
    $this->session->init();

     if($this->session->get('Tipo')!='SuperAdmin' && $this->session->get('Tipo')!='Normal' && $this->session->get('Tipo')!='SCM'){
      header('location: '.FOLDER_PATH.'/Error403');
    }
}
  public function index()
  {
    $user = $this->model->DatoUser($this->session->get('id'),'IdUsuario');
    $user = $user->fetch_object();
    $result = $this->model->getJoinAll($user->IdDepartamento);  //para cada area
    $ReqGuardadas=$this->model->getAllGuardadas($user->IdDepartamento,'idDepart'); //para cada departamento
    $k= $this->model->getSQL();
    $Anio=$this->model->getAnio();
    $count=$this->model->CountProgramaAnual($this->session->get('id')); //obtiene el numero total de registro
    $count=$count->fetch_object();
    $total=$count->total;
    $params = array('result'=> $result,'tipouser'=>$this->session->get('Tipo'),'Departamento'=> $user->nombreDepto,'ID'=>$this->session->get('id'),'nameuser'=>$user->Usuario,
    'User'=>$user->Nombre_User,'IdDepartamento'=>$user->IdDepartamento,'ReqGuardadas' => $ReqGuardadas,'kardex'=>$k,'Anio'=>$Anio,'total'=>$total);
    $this->render(__CLASS__, $params);
  }


    public function save($request){
      if($this->verify($request)){
         header('location: '.FOLDER_PATH.'/RBS');
      }else{
            $array = array();
            $array[0]=0;
            $d=strtotime("+5 days"); //dias habiles para editar las requisiciones
            $fechalimite = date("Y-m-d", $d); // fecha de los dias habiles
            $id=$_POST["id"];
            $meta=isset($_POST["meta"])?$_POST["meta"]:$array;
            $proyecto=isset($_POST["proyecto"])?$_POST["proyecto"]:$array;
            $partida=isset($_POST["partida"])?$_POST["partida"]:'';
            $descripcion=isset($_POST["descripcion"])?$_POST["descripcion"]:'';
            $cantidad=isset($_POST["cantidad"])?$_POST["cantidad"]:'';
            $unidad=isset($_POST["unidad"])?$_POST["unidad"]:'';
            $precio=isset($_POST["Precio"])?$_POST["Precio"]:'';
            $cantid=($proyecto=='')?0:count($proyecto); //numero total de las proyectos
            $cant=count($meta); //numero total de metas por filas
            $idReqTem=array(); //array para almacenar los id de las requisiciones a actualizar
            $total=0;
            $action=isset($_POST['action'])?$_POST['action']:''; //tipo de accion del boton
            $arrayidDescripcion = array(); //almacena el id del material del formulario (material seleccionado)
            $arrayidPartida = array();
            $arrayidUsuario = array();
            $arrayCantidad = array();
            $arrayProyecto = array();
            $Descripcion = array();//almacena el id del material de la tabla requisicion_detalle_tem
            $mes=$_POST['mes'];
            $programaAnual = new RequisicionAnualModel();
            // este bucle es para obtener el costo total de la requisicion tanto para las nuevas req. o para las req a actualizar
            if (isset($_POST["descripcion"])) {
                for ($i=0; $i < $cantid; $i++) {
                     $total=$total+$precio[$i];
                }
                for ($i=0; $i < count($descripcion); $i++) {
                  $aux=$descripcion[$i];
                  $arrayExplode = explode('-', $aux);
                  $arrayidDescripcion[$i] = $arrayExplode[0];
                  $arrayidUsuario[$i] = $arrayExplode[1];

                  $auxPartida=$partida[$i];
                  $explodePartida = explode('-', $auxPartida);
                  $arrayidPartida[$i] = $explodePartida[0];

                  $auxProyecto=$proyecto[$i];
                  $explodeProyecto = explode('-', $auxProyecto);
                  $arrayProyecto[$i] = $explodeProyecto[0];
                }
            }

            if ($action == 'Guardar') { // si se da la accion de guardar la requisicion
              // if ($_POST['update'] == 'update') {
                $materiales=$this->model->getMaterialesTem($id);
                $indice=0;
                $indice1=0;
                if ($materiales->num_rows > 0) {  //se verifica se hay mas de o requisiciones ya almacenadas con el id de la req, si es asi se recorre cada material
                  foreach ($materiales as $r) {
                    $idReqTem[$indice] = $r['IdRequisicionDetalleTem'];
                    $arrayCantidad[$indice] = $r['Cantidad'];
                    $Descripcion[$indice] = $r['Descripcion'];
                    $indice++;
                  }
                }
                if ($indice == 0) { //Si no existe el id de la req en estadp guardado, se guarda la requisicion
                  $this->model->addRequisicion($id,$request["folio"], $request["fecha"],$fechalimite, $request["FechaEntrega"], $request["area"], $request["solicitante"], $request["concepto"],$total);
                 for ($i=0; $i <= $cant-1; $i++) {
                  $this->model->DetalleRBS('requisicion_detalle_tem','IdRequisicionDetalleTem',$id, $arrayProyecto[$i], $meta[$i], $arrayidPartida[$i], $unidad[$i], $arrayidDescripcion[$i], $precio[$i], $cantidad[$i],$request["FechaEntrega"]);

                                                              // $IdUsuario,$IdMaterial,$IdMeta,$idProyecto,$mes
                        $cantMes = $programaAnual->getMesMaterial($arrayidUsuario[$i],$arrayidDescripcion[$i],$meta[$i],$arrayProyecto[$i],$mes);
                       foreach ($cantMes as $k) {
                          $TotalArticulo=$k[$mes]-$cantidad[$i];
                                                  // $IdMaterial,$IdUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes
                          $programaAnual->updateMesArt($arrayidDescripcion[$i],$arrayidUsuario[$i],$TotalArticulo,$meta[$i],$arrayProyecto[$i],$mes);
                       }
                  }

                }else{ // Si hay materiales ya almacenados se actualiza la requisicion
                  $this->model->updateCostoTotal($id,$total);//se actualiza el costo total de la req.
                  for ($i=0; $i < $indice; $i++) {
                   $this->model->updateRequiGuardada($idReqTem[$i],$id, $arrayProyecto[$i], $meta[$i], $arrayidPartida[$i], $unidad[$i], $arrayidDescripcion[$i], $precio[$i], $cantidad[$i]);
                    if ($i <= $materiales->num_rows) {
                      RBSController::TotalArticulo($arrayidDescripcion[$i],$Descripcion[$i],$arrayCantidad[$i],$arrayidUsuario[$i],'',$cantidad[$i],'2',$meta[$i],$arrayProyecto[$i],$mes);
                    }

                  }
                 for ($i=$indice; $i <= $cant-1; $i++) {
                  $this->model->DetalleRBS('requisicion_detalle_tem','IdRequisicionDetalleTem',$id, $arrayProyecto[$i], $meta[$i], $arrayidPartida[$i], $unidad[$i], $arrayidDescripcion[$i], $precio[$i], $cantidad[$i],$request["FechaEntrega"]);

                       $cantMes = $programaAnual->getMesMaterial($arrayidUsuario[$i],$arrayidDescripcion[$i],$meta[$i],$arrayProyecto[$i],$mes);
                       RBSController::TotalArticulo($arrayidDescripcion[$i],'','',$arrayidUsuario[$i],$cantMes,$cantidad[$i],'1',$meta[$i],$arrayProyecto[$i],$mes);

                  }
                }
              // }

            }else{ // si se da la accion de enviar la requisicion
            $RBS = new RBSModel();
              if ($_POST['Enviar'] == 1) { //Si se da en el boton de enviar del formulario MaterialReq
              $cont=0;
              $RBS1 = new RBSModel();
              $RBS1->addBitacora($id,$request["folio"], $request["fecha"], $request["area"], $request["solicitante"],'PENDIENTE',$total, $request["concepto"], $request["FechaEntrega"]);

                $materiales = $RBS1->getMaterialesTem($id);
                $indice=0;
                if ($materiales->num_rows > 0) {
                  foreach ($materiales as $r) {
                    $idReqTem[$indice] = $r['IdRequisicionDetalleTem'];
                    $arrayCantidad[$indice] = $r['Cantidad'];
                    $Descripcion[$indice] = $r['Descripcion'];
                    $indice++;
                  }
                }

              for ($i=0; $i <= $cant-1; $i++) {
                $RBS_rd = new RBSModel();
              $programaAnual = new RequisicionAnualModel();
              $RBS_rd->DetalleRBS("requisicion_detalle","IdRequisicionDetalle",$id, $arrayProyecto[$i], $meta[$i], $arrayidPartida[$i], $unidad[$i], $arrayidDescripcion[$i], $precio[$i], $cantidad[$i],$request["FechaEntrega"]);
                    if ($i < $materiales->num_rows) {
                      RBSController::TotalArticulo($arrayidDescripcion[$i],$Descripcion[$i],$arrayCantidad[$i],$arrayidUsuario[$i],'',$cantidad[$i],'2',$meta[$i],$arrayProyecto[$i],$mes);
                    }else{

                        $cantMes = $programaAnual->getMesMaterial($arrayidUsuario[$i],$arrayidDescripcion[$i],$meta[$i],$arrayProyecto[$i],$mes);

                          // echo $arrayidDescripcion[$i].' '.' '.$arrayidUsuario[$i].' '.' '.$cantidad[$i].' '.' '.$meta[$i].' '.$arrayProyecto[$i].' '.$mes;

                       RBSController::TotalArticulo($arrayidDescripcion[$i],'','',$arrayidUsuario[$i],$cantMes,$cantidad[$i],'1',$meta[$i],$arrayProyecto[$i],$mes);
                    }

                }
                RBSController::Kardex('Envio','Requisicion','Envio la requisición '.$request["folio"]);
              }else{ //si se da clic en boton de enviar del formulario RBS
                $datosGenereal=$RBS->getAllGuardadas($id,'IdRequisicion');
                foreach ($datosGenereal as $d) {
                  $folio=$d["ForlioRequisicion"];
                  $RBS->addBitacora($id,$d["ForlioRequisicion"], $d["FechaRecepcion"], $d["idDepart"], $d["Idjefe"],'PENDIENTE',$d['Costo'], $d["Concepto"], $d["FechaEntrega"]);
                }
                $datoMateriales=$RBS->getMaterialesTem($id);
                foreach ($datoMateriales as $dm) {
                  $RBS->DetalleRBS('requisicion_detalle','IdRequisicionDetalle',$id, $dm['Proyecto'], $dm['Meta'], $dm['Partida'], $dm['Unidad'], $dm['Descripcion'], $dm['Costo'],$dm['Cantidad'],$dm['FechaEntrega']);
                }
                RBSController::Kardex('Envio','Requisicion','Envio la requisición '.$folio);
              }

              $extiMaterial=$RBS->exitMaterialesReq($id);
              if ($extiMaterial) { // Si ya existe un registro con ID en la tabla requisicion_detalle
                $materiales=$RBS->getMaterialesTem($id);// se obtiene el ID de la tabla requisicion_detalle_tem
                foreach ($materiales as $r) {
                  $RBS->deleteMateriales('requisicion_detalle_tem','IdRequisicionDetalleTem',$r['IdRequisicionDetalleTem']);//se elimina el registro
                }
              }
              $RBSDelet = new RBSModel();
              $exitRequisicion=$RBSDelet->exitRequisicion($id);// Si ya existe un registro con ID en la tabla bitacora
                if ($exitRequisicion) {
                    $RBS->deleteRequisicion('requisiciones','IdRequisicion',$id);//se elimina el registro en la tabla requisicion
                }

            }
        }
           header('location: '.FOLDER_PATH.'/RBS');
     }
    public function SaveMaterial($request){

        $this->model->DetalleRBS($request["id"], $request["meta"], $request["partida"], 'PIEZA', $request["arrayidDescripcion"],'0', $request["cantidad"]);

         header('location: '.FOLDER_PATH.'/MaterialReq');

     }

  //$cantArticulo es resultado de consulta,$Cantidad es el numero ingresado en formulario
     public function TotalArticulo($arrayidDescripcion,$Descripcion,$arrayCantidad,$arrayidUsuario,$cantArticulo,$Cantidad,$opcion,$IdMeta,$idProyecto,$mes)
     {
      $programaAnual = new RequisicionAnualModel();
      // $TotalArticulo=0;
      $i=0;
      switch ($opcion) {
        case '1':
          foreach ($cantArticulo as $r) {
          $TotalArticulo=$r[$mes]-$Cantidad;
          $programaAnual->updateMesArt($arrayidDescripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
          }
          break;
        case '2':
                      if ($arrayidDescripcion == $Descripcion
                          && $Cantidad > $arrayCantidad) {

                          $diferencia=$Cantidad-$arrayCantidad;


                          // $cant1 = $programaAnual->getTotalArticulo($arrayidUsuario,$arrayidDescripcion);
                          //                                      $IdUsuario,$IdMaterial,$IdMeta,$idProyecto,$mes
                          $cant1 = $programaAnual->getMesMaterial($arrayidUsuario,$arrayidDescripcion,$IdMeta,$idProyecto,$mes);

                           foreach ($cant1 as $a) {
                              $TotalArticulo=$a[$mes]-$diferencia;
                                                          // $IdMaterial,$IdUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes
                              $programaAnual->updateMesArt($arrayidDescripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
                           }

                      } if ($arrayidDescripcion == $Descripcion
                          && $Cantidad < $arrayCantidad) {

                          $diferencia=$arrayCantidad-$Cantidad;
                          // $cant2 = $programaAnual->getTotalArticulo($arrayidUsuario,$arrayidDescripcion);
                          $cant2 = $programaAnual->getMesMaterial($arrayidUsuario,$arrayidDescripcion,$IdMeta,$idProyecto,$mes);
                           foreach ($cant2 as $b) {
                              $TotalArticulo=$b[$mes]+$diferencia;

                              $programaAnual->updateMesArt($arrayidDescripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
                           }

                      } if ($arrayidDescripcion != $Descripcion
                              && $Cantidad == $arrayCantidad) {

                        $cant3 = $programaAnual->getMesMaterial($arrayidUsuario,$Descripcion,$IdMeta,$idProyecto,$mes);
                              foreach ($cant3 as $c) {
                              $TotalArticulo=$c[$mes]+$arrayCantidad;
                              $programaAnual->updateMesArt($Descripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
                            }

                              $cant4 = $programaAnual->getMesMaterial($arrayidUsuario,$arrayidDescripcion,$IdMeta,$idProyecto,$mes);
                               foreach ($cant4 as $d) {
                                  $TotalArticulo=$d[$mes]-$Cantidad;
                                  $programaAnual->updateMesArt($arrayidDescripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
                               }

                      }
                      if ($arrayidDescripcion != $Descripcion
                              && $Cantidad != $arrayCantidad) {

                        $cant3 = $programaAnual->getMesMaterial($arrayidUsuario,$Descripcion,$IdMeta,$idProyecto,$mes);
                              foreach ($cant3 as $c) {
                              $TotalArticulo=$c[$mes]+$arrayCantidad;
                              $programaAnual->updateMesArt($Descripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
                            }

                              $cant4 = $programaAnual->getMesMaterial($arrayidUsuario,$arrayidDescripcion,$IdMeta,$idProyecto,$mes);
                               foreach ($cant4 as $d) {
                                  $TotalArticulo=$d[$mes]-$Cantidad;
                                  $programaAnual->updateMesArt($arrayidDescripcion,$arrayidUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes);
                               }

                      }

          break;


      }

     }

    public function requested(){
        $IdBitacora="";
        $IdRequi="";
        $Foliorequisicon="";
        $fechaRecepcion="";
        $FechaReporte="";
        $IdDep="";
        $IdSolicitante="";
        $Concepto="";
        $costo="";
        $FechaAutorizacion="";
        $estado="";
        $FechaAatencion="";
        $Archivo="";
        $Status="";
        $UltimoRegitroBitacora = $this->model->UltimoRegitroBitacora();
        $UltimoRegitroRequi = $this->model->UltimoRegitroRequi();
        $IdDepartamento = $_POST['depto'];
        $idUser=$_POST['id'];
        $tipouser=$_POST['tipouser'];
        foreach ($UltimoRegitroBitacora as $ult) {
          $IdBitacora= $ult['IdBitacora'];
        }
        foreach ($UltimoRegitroRequi as $ultimo) {
          $IdRequi=$ultimo['IdRequisicion'];
        }
          if ($IdBitacora == null && $IdRequi == null) {
              $IdBitacora=1;
          }else{
            $IdBitacora=$IdBitacora+1;
            if ($IdRequi > $IdBitacora || $IdRequi == $IdBitacora ) {
              $IdBitacora=$IdRequi+1;
            }

          }
      require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';
    }
// funcion para obtener el id del usuario, esto para cuando el admin desea crear una requisicion de un departamento
    public function idUser()
    {
      $idDep=$_POST['idDep'];
      $RBS = new RBSModel();
      $result=$RBS->IdUsuario($idDep);
      if ($result->num_rows > 0) {

        $result=$result->fetch_object();

      }

    }

    // funcion para cancelar la requisicion
    public function Cancel()
    {
      // $mes=$_POST['Mes'];
      // echo $_POST['ID'].$mes;
      $arrayMes= explode('|',ArrayMes);
      $RBS = new RBSModel();
      $programaAnual = new RequisicionAnualModel();
      $arrayExplode = explode('|', $_POST['ID']);
      $IdRequisicion = $arrayExplode[0];
      $IdUsuario = $arrayExplode[1];
      $mes = $arrayExplode[2]; //nombre del mes actual
      $fechaentrega = $arrayExplode[3];
      $arrayCantidad = array();
      $arrayDescripcion = array();
      $indice = 0;
      $fecha=strtotime($fechaentrega);
      $m=date('m',$fecha); //numero del mes de la fecha que solicito la req.
      $mm=($m == 10) ? $m: str_replace('0','', $m);
      $mesF = $arrayMes[$mm-1]; //nombre del mes de la fecha que solicito la req.


      $consulta = $this->model->getMaterialesTem($IdRequisicion);
      foreach ($consulta as $r) {
        $arrayCantidad[$indice] = $r['Cantidad'];
        $arrayDescripcion[$indice]= $r['Descripcion'];
         $this->model->deleteMateriales('requisicion_detalle_tem','IdRequisicionDetalleTem',$r['IdRequisicionDetalleTem']);
         $indice++;
      }
      if ($mesF == $mes) {
        for ($i=0; $i < count($arrayDescripcion); $i++) {
          $progAnual = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$mes);
            foreach ($progAnual as $c) {
            $TotalArticulo=$c[$mes]+$arrayCantidad[$i];
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo,$mes);

          }
        }
      }else{
      $fecha2=strtotime(DATE); //fecha actual
      $m2=date('m',$fecha2); //numero del mes de la fecha posterior de la fecha actual
      $mm2=($m2 == 10) ? $m2: str_replace('0','', $m2);
      $mesF2 = $arrayMes[$mm2]; //nombre del mes de la fecha posterior de la fecha actual.

        for ($i=0; $i < count($arrayDescripcion); $i++) {
          $totalmes1=0;//total del material del mes de la fecha que solicito la req.
          $totalmes2=0;//total del material para el mes posterior.
          $mesfechaEntrega = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$mesF);

          $mesDespues = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$mesF2);
            foreach ($mesfechaEntrega as $c) {
            $totalmes1=$c[$mesF];
            $TotalArticulo1=$c[$mesF]-$c[$mesF];
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo1,$mesF);

          }
          foreach ($mesDespues as $md) {
            $totalmes2=$md[$mesF2];
            $TotalArticulo2=$md[$mesF2]+($totalmes1+$arrayCantidad[$i]);
            $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo2,$mesF2);
          }

        }

      }
      // for ($i=0; $i < count($arrayDescripcion); $i++) {
      //   $progAnual = $programaAnual->getMesMaterial($IdUsuario,$arrayDescripcion[$i],$mes);
      //     foreach ($progAnual as $c) {
      //     $TotalArticulo=$c[$mes]+$arrayCantidad[$i];
      //     $programaAnual->updateMesArt($arrayDescripcion[$i],$IdUsuario,$TotalArticulo,$mes);

      //   }
      // }

        $this->model->deleteRequisicion('requisiciones','IdRequisicion',$IdRequisicion);
        RBSController::Kardex('Cancelar','Alta Requisicion','Cancelo la requisición '.'RBS-'.$IdRequisicion.'-2019');
        header('location: '.FOLDER_PATH.'/RBS');

    }

// funcion para ver los materiales recibidos
    public function Detalle()
    {
      $detalleMaterial = new RBSModel();
      $result = $detalleMaterial->DatoMateriales($_POST['id']);

       require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';
    }
    public function Kardex($accion,$Catalogo,$Descripcion)
    {
        $kardex = new KardexModel();
        $kardex->IdUsuario=$this->session->get('id');
        $kardex->Accion=$accion;
        $kardex->Catalogo=$Catalogo;
        $kardex->Descripcion=$Descripcion;
        $kardex->add();
    }
    // =====================[ Funcion para llenar el select proyectos dependiendo de la meta ] ==============
    public function selectMeta()
    {
      $idmeta= $_POST['idmeta'];
      $idUser=$_POST['idUser'];
      $programaAnual = new RequisicionAnualModel();
      $proyecto = $programaAnual->getIdProyecto($idUser,$idmeta,"2020");
       require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';
    }
    // =====================[ Funcion para llenar el select partidas dependiendo del proyecto ] ==============

    public function selectProyecto()
    {
       //$anio=date('Y');
      $anio="2020";
      $idUser=$_POST['idUser'];
      $array = explode('-', $_POST['idProyecto']);
      $idProyecto=$array[0];
      $programaAnual = new RequisicionAnualModel();
      $partidas = $programaAnual->getIdPartida($idUser,$anio,$idProyecto);
       require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';
    }



    //================ [ funcion para llenar el select de los materiales de la partida presupuestal ] ======
    public function seleccion()
    {
      $funcion = $_POST['function'];
      if(empty($funcion)){
        header('location: '.FOLDER_PATH.'/RBS');
      }
      $result = explode('-', $_POST['id']);
      $idPartida = $result[0];
      $IdUsuario =  $result[1];
      $mes = $_POST['mes'];

      // $dataIdMeta=explode('-',$_POST['idmeta'] );
      // $idmeta=$dataIdMeta[0];
      $idmeta=$_POST['idmeta'];
      $dataIdProyecto=explode('-', $_POST['idProyecto']);
      $idProyecto=$dataIdProyecto[0]; //se obtiene el id del proyecto

      $result = $this->model->getMaterialUser($idPartida,$IdUsuario,$idmeta,$idProyecto);
      require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';

    }
    // funcion para llenar unidad y costo en MaterialReq
    public function selectUnidadCosto()
    {
      $funcion = $_POST['function'];
      if(empty($funcion)){
        header('location: '.FOLDER_PATH.'/RBS');
      }
        $num_cantidad = $_POST["num_cantidad"];
        $array=explode('-', $_POST['id']);
        $num = count($array);
        $IdMaterial = $array[0];
        $IdUsuario = ($num==2)?$array[1]:$array[0];
        $meta = $_POST["meta"];
        $Dataproyecto = $_POST["proyecto"];
        $arrayProyecto = array();
        $explodeProyecto = explode('-',$Dataproyecto);
        $proyecto = $explodeProyecto[0];
        $programaAnual = new RequisicionAnualModel();
        $mes = $_POST['mes'];
        $cont = $_POST['cont'];
        // $NumtotalMaterial = $programaAnual->getTotalArticulo($IdUsuario,$IdMaterial);
        $totalMaterialMes =$programaAnual->getMesMaterial($IdUsuario,$IdMaterial,$meta,$proyecto,$mes);
        if ($totalMaterialMes->num_rows > 0) {
          foreach ($totalMaterialMes as $total) {
            if ($total[$mes] >= $num_cantidad) {
              $result = $this->model->getMedidaCosto($IdMaterial);
            }else{
              $CantidadArticulo=$total[$mes];
            }
          }
        }else{
          $result = $this->model->getMedidaCosto($IdMaterial);
        }

      require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';

    }

    public function Cancelar(){

      $this->model->Cancelar($_POST['id']);
      header('location: '.FOLDER_PATH.'/RBS');
    }
    public function tableReload(){
      $result = $this->model->getJoinAll($_POST['valueselect']);  //para cada area
      $ReqGuardadas=$this->model->getAllGuardadas($_POST['valueselect'],'idDepart'); //para cada departamento


      require_once ROOT . FOLDER_PATH .'/app/Request/RBSRequest.php';
    }

    private function verify($request)
    {
      return empty($request['id']);
    }

    public function logout()
    {
      $this->session->close();
      header('location: '.FOLDER_PATH.'/login');
    }

    public function __destruct()
    {
      $this->model;
    }

  }
  ?>
