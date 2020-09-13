<?php defined('BASEPATH') or exit('ERROR403'); 
  require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
  require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
  require_once ROOT . FOLDER_PATH .'/app/Models/ProyectoModel.php';
  require_once ROOT . FOLDER_PATH .'/app/Models/MetasModel.php';
  require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
  require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
  require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
    require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    
     <?php
        $header = new header();
        $header->PushHeader('Solicitud de requisición');          
     ?>
  </head>
  <body >
    <!-- Etiquetas con datos -->
    <div class="contentPage">
    <main>
    </br>
    <?php  
    $arrayMes = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
    // se ejecuta cuando se clic en editar las requisicion guardada
    if (isset($_POST['ID'])) {
      $RBS = new RBSModel();
      $consulta = $RBS->getAllGuardadas($_POST['ID'],'IdRequisicion');
      foreach ($consulta as $r) {
        $IdRequisicion=$r['IdRequisicion'];
        $Folio=$r['ForlioRequisicion'];
        $F_Solicitud=$r['FechaRecepcion'];
        $IdDepart=$r['idDepart'];
        $IdJefe=$r['Idjefe'];
        $concepto=$r['Concepto'];
        $F_Entrega=$r['FechaEntrega'];
      }
    }
    ?>
    <form action="<?php echo FOLDER_PATH ?>/RBS/save" method="post"  id="form">
      <input type="hidden" name="id" id="" value="<?= isset($_POST["id"] )?$_POST["id"]:$IdRequisicion?>">
      <input type="hidden" name="fecha" id="" value="<?= isset($_POST["fSolicitud"])?$_POST["fSolicitud"]:$F_Solicitud?>">
      <input type="hidden" name="area" id="" value="<?=isset($_POST["departamento"])?$_POST["departamento"]:$IdDepart?>">
      <input type="hidden" name="solicitante" id="" value="<?= isset($_POST["jefe"])?$_POST["jefe"]:$IdJefe?>">

      <input type="hidden" name="NRegistro" id="NRegistro" value="<?= $_POST["txtMaterial"] ?>">

      <input type="hidden" name="FechaEntrega" id="" value="<?=isset($_POST["FechaEntrega"])?$_POST["FechaEntrega"]:$F_Entrega?>">
      <input type="hidden" name="folio" id="" value="<?=isset($_POST['FolioRequisicion'])?$_POST['FolioRequisicion']:$Folio?>">
      <input type="hidden" name="update" value="<?=isset($ActionButton)?$ActionButton:''?>">
      <input type="hidden" id="idUser" name="idUser" value="<?=isset($_POST['user'])?$_POST['user']:$_POST['idUser']?>">
      <?php
        $fechaSolicitud=isset($_POST['fSolicitud'])?date('d/m/Y',strtotime($_POST['fSolicitud'])):date('d/m/Y',strtotime($F_Solicitud));
        $fechaEntrega=isset($_POST['FechaEntrega'])?date('d/m/Y',strtotime($_POST['FechaEntrega'])):date('d/m/Y',strtotime($F_Entrega));
      ?>
    <div class="container bg-light border">
      <div class="container bg-light">
      </br>
        <div class="form-group row border">
          <div class="col-sm-2 bg-white">
            <center><img src="<?php echo PATH_PUBLIC ?>\img\logoTec.png"></center>
          </div>
          <div class="col-sm-8 text-white"  style="background-color: #009999;">
          </br>
          <center>
            <h5 class="font-weight-bold">INSTITUTO TECNOLOGICO SUPERIOR DE SAN ANDRÉS TUXTLA</h5>
            <h5 class="font-weight-bold">REQUISICIÓN DE BIENES Y SERVICIOS</h5>
          </center>
          </div>
          <div class="col-sm-2 bg-white">
            <center><img src="<?php echo PATH_PUBLIC ?>\img\document.png"></center>
          </div>
          </div>
          <br>
          <div class="form-group row">
            <div class="offset-sm-1">
              <h5 class="font-weight-bold">Fecha de solicitud:</h5>
            </div>
            <div class="col-sm-4  border  border-top-0  border-left-0 border-right-0 border-secondary">
              <h7> <?= isset($fechaSolicitud)?$fechaSolicitud:''?> </h7>
            </div>
            <div class="col-sm-1">
              <h5 class="font-weight-bold">Folio:</h5>
            </div>
            <div class="col-sm-3  border  border-top-0  border-left-0 border-right-0 border-secondary">
              <h7><?=isset($_POST['FolioRequisicion'])?$_POST['FolioRequisicion']:$Folio?></h7>
            </div>
          </div>
          <div class="form-group row">
          <?php  $jefe = new JefesModel();
                  $JefeNombre = isset($_POST["jefe"])?$_POST["jefe"]:$IdJefe;
                  $jefe= $jefe->getJefe($JefeNombre);
          ?>
            <div class="offset-sm-1">
              <h5 class="font-weight-bold">Nombre del jefe(a) de area solicitante:</h5>
            </div>
            <div class="col-sm-4  border  border-top-0  border-left-0 border-right-0 border-secondary">
              <?php foreach ($jefe as $j) { ?>
                <h7><?=$j['Subfijo'].$j['Nombre'].' '.$j['A_paterno'].' '.$j['A_materno'] ?></h7>
              <?php }?>
            </div>
            </div>
            <div class="form-group row">
              <?php  $depa = new DepartamentoModel();
                  $departameto = isset($_POST["departamento"])?$_POST["departamento"]: $IdDepart;
                  $depa = $depa->getDepartamento($departameto);
              ?>
            <div class="offset-sm-1">
              <h5 class="font-weight-bold">Area Solicitante:</h5>
            </div>
            <div class="col-sm-7  border  border-top-0  border-left-0 border-right-0 border-secondary">
              <?php foreach ($depa as $de) { ?>
                <h7><?= $de['nombreDepto'] ?></h7>
              <?php } ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="offset-sm-1">
              <h5 class="font-weight-bold">Fecha de entrega:</h5>
            </div>
            <div class="col-sm-4  border  border-top-0  border-left-0 border-right-0 border-secondary">
              <h7><?= isset($fechaEntrega)?$fechaEntrega:''?></h7>
            </div>
          </div>
        </div>
      </div>
    </br>
      <!-- secion de tabla de datos  -->
    <div class="container bg-light border">
    <br>
    <!-- boton para agregar una nueva fila  -->
      <div class="container  border  border-top-0  border-left-0 border-right-0 border-success">
        <div class="btn btn-sm btn-primary" data-toggle="tooltip" title="Agregar material" id="btnNuevaFila"><span class="fa fa-plus-circle"></span></div>
        <label class="font-weight-bold">Agregar materiales a la requisición</label>
      </div>
 <!-- End boton para agregar una nueva fila  -->
    <br>
        <div class="table table-responsive-sm table-responsive-md">
          <table class="table table-sm table-hover ">
            <thead class="">
              <tr>
                <th scope="col" width="15%">Proyecto, Actividad y Accion</th>
                <th scope="col" width="15%">Partida Presupuestal</th>
                <th scope="col" width="5%">Cantidad</th>
                <th scope="col" width="45%">Descripcion</th>
                <th scope="col" width="10%">Unidad</th>
                <th scope="col" class="text-center" width="10%">Costo estimado total + IVA</th>
                
              </tr>
            </thead>
            <tbody id="tablaFormRequisicion">
              <?php $cant = isset($_POST['txtMaterial'])?$_POST['txtMaterial']:3;
              $i=0;
              if (isset($_POST['ID'])) {
                $result=$RBS->getMaterialesTem($_POST['ID']);
                
                foreach ($result as $r) {?>
                  <tr>
                    <td>
                  <?php 
                    $paa = new RequisicionAnualModel();
                    
                    $proyecto = $paa->getIdProyecto($_POST['user'],$r['Meta'],"2020");


                    
                    $metas=$paa->getIdMeta($_POST['user'],"2020");
                  ?>
                  <div class="row">
                    <div class="col-sm-6">
                   <select class="form-control badge bg-white" name="meta[]" id="meta<?=$i?>">
                    <?php foreach ($metas as $m) {?>
                      <option value="<?=$m['IdMeta']?>" <?= ($m['IdMeta']==$r['Meta']) ? ' selected' : ''; ?>><?= $m['EnumMeta']?></option>
                    <?php } ?>
                  </select>
                    </div>
                    <div class="col-sm-6">
                    <select class="form-control badge bg-white"  name="proyecto[]" id="proyecto<?=$i?>">
                    <?php foreach ($proyecto as $p) {?>
                      <option value="<?=$p['IdProyecto'].'-'.$_POST['user']?>"  <?= ($p['IdProyecto']==$r['Proyecto']) ? ' selected' : ''; ?>><?= $p['enum']?></option>
                    <?php } ?>
                    </select>
                    </div>
                  </div>
                    </td>
                    <td>
                  <?php 
                    $RequisicionAnual = new RequisicionAnualModel();
                    $partida = $RequisicionAnual->getIdPartida($_POST['user'],date('Y'),$r['Proyecto']);
                  ?>
                  <select class="form-control badge bg-white"  name="partida[]" id="partida<?= $i ?>" class="partida"  data-cont="<?= $i ?>" data-model="partida<?= $i ?>">
                    <option value="0">Seleccione</option>
                    <?php foreach ($partida as $p) {?>
                      <option value="<?=$p['IdPartida'].'-'.$_POST['user']?>" <?= ($p['IdPartida']==$r['Partida']) ? ' selected' : ''; ?>><?= $p['Codigo']?></option>
                    <?php } ?>
                  </select>




                </td>
                <td>
                  <input type="number" value="<?=$r['Cantidad']?>" class="form-control cantidad form-control-sm" min="1" name="cantidad[]" id="cantidad<?= $i ?>" data-cont="<?= $i ?>" data-model="RBS" > </input>
                </td>
                <td>
                  <select class="form-control form-control-sm " name="descripcion[]" id="descripcion<?= $i ?>" class="descripcion" data-cont="<?= $i ?>" data-model="descripcion<?= $i ?>">
                   <?php //$idPartida,$IdUsuario,$idMeta,$idProyecto
                   $result = $RBS->getMaterialUser($r['Partida'],$_POST['user'],$r['Meta'],$r['Proyecto']);
                   foreach ($result as $p) {?>
                   <option value="<?=$p['IdMaterial'].'-'.$_POST['user']?>" <?=($p['IdMaterial']==$r['Descripcion'])?'selected':''?>><?=$p['Articulo']?></option>
                  <?php 
                   }
                  
                    ?>
                  </select>
                </td>
                <td colspan="2">
                  <div class="row" id="MedidaCosto<?= $i ?>">
                    <div class="col-sm-6">
                  <input type="text" class="form-control" style="font-size: 10px;" name="unidad[]" value="<?=$r['Unidad']?>" >
                </div>
    
                <div class="col-sm-6">
                  <input type="text" class="form-control precio" style="font-size: 10px;" name="Precio[]" value="<?=$r['Costo']?>">
                </div>
                  </div>

                </td>

                  </tr>
                 
                  <?php
                $i++;}

              }
                ?>
                <input type="hidden" name="indice" id="indice" value="<?=$i?>">            
            </tbody>
          </table>
        </div>
    </div>
    <br>
    <div class="container border bg-light">
      </br>
      <div class="form-group row">
        <div class="col-sm-3">
          <label class="font-weight-bold">Lo anterior se utiliza en:</label>
        </div>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="concepto" id="concepto" value="<?=isset($concepto)?$concepto:''?>"></input>
        </div>
      </div>
      <hr>
      <div class="form-group row">
        <?php 
          $f=isset($_POST['FechaEntrega'])?$_POST['FechaEntrega']:'';
          $f_e=date('Y-m-d',strtotime($f));
          $f_Actual=DATE;
          $fecha1 = new DateTime($f_e);
          $fecha2 = new DateTime($f_Actual);
          $diff = $fecha2->diff($fecha1);
          // $bool=($diff->days > 4)?'':'disabled="false"';
         ?>
        <div class="col-sm-12 text-right" id="button_RBS" >
          <button type="button" class="btn btn-success"  value="Guardar" id="action" name="action" onclick="return validarRBS_Salida('action','¿Está seguro que desea guardar la requisición?<br>Si guarda la requisición tendrá 5 días hábiles para editar dicha requisición.  ');" <?php echo isset($_POST['ID'])?'':'style="display: none;"'?> ><span class="fa fa-floppy-o"> Guardar Solicitud</span>
          </button>
          <button type="button" class="btn btn btn-info" value="1" id="Enviar" name="Enviar" onclick="return validarRBS_Salida('Enviar','¿Está seguro que desea enviar la requisición?<br>Una vez enviado no podrá editar dicha requisición.');" <?php echo isset($_POST['ID'])?'':'style="display: none;"'?>><span class="fa fa-paper-plane"> Enviar Solicitud</span>
          </button>
          <button type="button" class="btn btn-danger" id="Cancelar"><span class="fa fa-times-circle" > Cancelar </span></button>
        </div>
      </div>
      
    </div>
  <!-- inicio -->
    <input type="hidden" id="mes" name="mes" value="<?= MES?>">
  <!-- fin  -->
  <!-- inicio el numero de dias entre la fecha de entrega y la de solicitud-->
  <input type="hidden" id="diff" value="<?=$diff->days?>">
  <!-- fin -->
  </form>

  </main>   
    </div>
  </body>
  <?php require_once SCRIPTS; ?>
</html>
