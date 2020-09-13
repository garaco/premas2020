<?php
require_once ROOT . FOLDER_PATH .'/app/Views/header.php'; 
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';  ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
        <?php
          $header = new header();
          $header->PushHeader('Gestión de Requisiciones');
     ?>
  </head>

  <body class="Colorpage" onload="myFunction()" style="margin:0;">
    <main id="wrapper">
    <?php require_once SIDERBAR; ?>
     <div id="loader"> </div>
     <input type="hidden" id="tipouserAdmin" value="<?=$tipouser?>">
       <nav class="navbar navbar-expand navbar-dark navbar-light justify-content colornavbar" style="padding: 0px; padding-left: 30px;">
        <div class="<?php if ($tipouser == 'SuperAdmin') {echo 'container';} ?> collapse navbar-collapse" id="navbarText">
         <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <?php if ($tipouser <> 'SuperAdmin') { ?>
               <img style="padding: 5px 5px; width: 50px; height: 50px;"src="<?php echo PATH_PUBLIC ?>\img\logo.png">
             <?php } else if ($tipouser == 'SuperAdmin'){ ?>
                 <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
                 <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
               <?php } ?>
            <a class="navbar-brand font-weight-bold text-white" style="font-size: 15px;">REQUISICIONES DE BIENES Y SERVICIOS   <?=$tipouser != "SuperAdmin"?' / '.$Departamento:''?></a>
            </li>
        </ul>
        <div class="dropdown" style="padding-right: 30px;">
          <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
            <span class="fa fa-user-circle"></span> <label > <?=$User?></label>
         </button>
        <div class="dropdown-menu dropdown-menu-right">
          <?php if ($tipouser <> 'SuperAdmin') { ?>
            <?php if ($tipouser == 'SCM') { ?>
              <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/SMC" ><span class="fa fa-address-card-o"> </span> Alta Solicitud Mantenimiento</a>
            <?php } ?>
            <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RBS" ><span class="fa fa-address-card-o"> </span> Alta Requisiciones</a>
            <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RequisicionAnual" ><span class="fa fa-calendar-o"> </span> Programa Anual Requisiciones</a>
            <div class="dropdown-divider"></div>
          <?php } ?>
          <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
        </div>
        </div>
      </div>
    </nav>
    <div class="contentPage animate-des main">
  <br>
      <!--  <div class="container-fluid border"> -->
  <div class="container">
    <div class="container-fluid border bg-white" id="container-fluid-pago">
      <div class="row justify-content-md-center">
        <div class="col-sm-12 alert-color">
            <img src="<?php echo PATH_PUBLIC ?>/img/add.png">
            <label class="font-weight-bold">
              ALTA DE REQUISICIONES</label>
        </div>
      </div>
      <div class="row">
        <?php if ($total > 0 || $tipouser == 'SuperAdmin') {
        ?>
        <div class="col-sm-1.5 p-3" >
          <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#ventana" style="float:right" data-depto="<?=$IdDepartamento?>" data-id="<?=$ID?>" data-tipouser="<?=$tipouser?>" data-model="RBS" data-operation="Agregar" data-method="requested">
                    <span class="icon-plus-circle">Agregar</span>
          </button>
        </div>
        <?php  } else{?>
          <div class="nota">
            <div class="notabody"><center ><strong>Nota:</strong> No cuenta con ningún registro su programa anual, por lo tanto no puede crear una solictud de requisición.</center></div>


          </div>
          <?php
          } ?>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-white"> </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
          </div>
          <!-- body de la venatan -->
        <div class="modal-body">

        </div>
        </div>
      </div>
    </div>
    <br>
    <div  class="container-fluid border bg-white" id="container-fluid-pago" >
      <div class="row justify-content-md-center">
        <div class="col-sm-12 alert-color">
            <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
            <label class="font-weight-bold">
              LISTA DE REQUISICIONES</label>
        </div>
      </div>
      <br>
      <?php 
        if($tipouser == 'SuperAdmin'){
          $depto= new DepartamentoModel();
          $ResultDepto=$depto->allDepartamento();
       ?>
       <div class="row">
         <div class="col-sm-6">
            <select class="form-control form-control-sm" id="selectDeptosRBS">
             <option value="-1" style="font-weight: bold;">Seleccione departamento </option>
             <?php foreach ($ResultDepto as $v) {  ?>
              <option value="<?=$v['idDepart']?>"><?=$v['nombreDepto']?></option>
             <?php }  ?>
           </select>          
         </div>
       </div>

       <?php 
          }
        ?>
      <br>
       <ul class="nav nav-tabs" id="TabRBS" role="tablist" style="padding-left:50px;">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" value="Enviadas-1">Enviadas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="guardadas-tab" data-toggle="tab" href="#guardadas" role="tab" aria-controls="guardadas" aria-selected="false" value="Guardadas-2">Guardadas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="aceptadas-tab" data-toggle="tab" href="#aceptadas" role="tab" aria-controls="aceptadas" aria-selected="false" value="Autorizadas-3">Autorizadas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="materialRecibido-tab" data-toggle="tab" href="#materialRecibido" role="tab" aria-controls="materialRecibido" aria-selected="false" value="Recibido-4">Material Recibido</a>
        </li>
      </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <br>
    <div class="table-wrapper-scroll-y ">
      <div class="table table-responsive-sm table-responsive-md small">
        <table class="table table-sm table-striped table-hover" id="tableid1">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" class="text-center">Nº requisición</th>
                <th scope="col" class="text-center">Fecha de solicitud</th>
                <th scope="col" class="text-center">Fecha de Entrega</th>
                <th scope="col" class="text-center">Costo Total</th>
                <th scope="col" class="text-center">PDF</th>
                <?php if ($tipouser != 'SuperAdmin') {  ?>
                <th scope="col" class="text-center">Cancelar</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody  style="font-size: 12px;" id="container-table1">
              <?php
              if ($result->num_rows > 0) {
              foreach ($result as $r){
              if ($r["Estado"] <> 'AUTORIZADO') {
                ?>
                <tr>
                <td class="text-center"><?= $r["Foliorequisicion"]; ?></td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r["Costo"]; ?></td>
                <td>
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                </td>
                <?php if ($tipouser != 'SuperAdmin') {  ?>
                <td>
                  <center>
                  <form action="<?php echo FOLDER_PATH ?>/RBS/Cancelar" method="post" >
                    <button type="submit" class="btn btn btn-outline-danger btn-sm badge badge-pill" >
                      <span class="fa fa-times"></span>
                      <input type="hidden" name="id" value="<?= $r["IdBitacora"] ?>">
                    </button>
                  </form>
                </center>
                </td>
              </tr>

                <?php }
                  }
                }
              }
          ?>
            </tbody>
          </table>
        </div>
    </div>
      </div>
      <div class="tab-pane fade" id="guardadas" role="tabpanel" aria-labelledby="guardadas-tab">

      <br>
      <div class="table table-responsive-sm table-responsive-md small">
        <table class="table table-sm table-striped table-hover" id="tableid2">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" class="text-center">Nº requisición</th>
                <th scope="col" class="text-center">Fecha de solicitud</th>
                <th scope="col" class="text-center">Fecha de Entrega</th>
                <th scope="col" class="text-center">Costo Total</th>
                <?php if ($tipouser != 'SuperAdmin') { ?>
                <th scope="col" class="text-center">Acción</th>
                <th scope="col" class="text-center"></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody  style="font-size: 12px;" id="container-table2">
              <?php
              $fila=0;
              if ($ReqGuardadas->num_rows > 0) {
              foreach ($ReqGuardadas as $r){?>
                 <tr>
                <td class="text-center"><?= $r["ForlioRequisicion"]; ?></td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r["Costo"]; ?></td>
                <?php if ($tipouser != 'SuperAdmin'){ ?>
                <td>
                  <?php if ($r['FechaLimite'] <= DATE) {

                   ?>
                   <center>
                        <form action="<?php echo FOLDER_PATH ?>/RBS/save" method="POST" id="form" onclick="ConfirmarRE(<?=$fila?>);">
                        <input type="hidden" name="id" value="<?= $r['IdRequisicion']?>">
                        <button type="button" class="btn btn btn-outline-success btn-sm badge badge-pill" value="2" id="Enviar<?=$fila?>" name="Enviar" style="width: 100px;">
                        <span class="icon-ok"> Enviar</span>
                      </button>
                       </form>
                        <form action="<?php echo FOLDER_PATH ?>/RBS/Cancel" method="POST" id="form<?=$fila?>">
                        <input type="hidden" name="Mes" value="<?=MES?>">
                        <input type="hidden" name="ID" value="<?= $r['IdRequisicion'].'|'.$ID.'|'.MES.'|'.$r["FechaRecepcion"]?>">
                        <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill CancelarRequi" value="<?= $r['ForlioRequisicion']?>" id="CancelarRequi<?=$fila?>" name="Cancelar" onclick="CancelarRequisicion(<?=$fila?>)" style="width: 100px;">
                        <span class="icon-cancel-circle"> Cancelar</span>
                      </button>
                       </form>
                   </center>

                    <?php  $fila++;
                  }else{?>
                    <center>
                      <form action="<?php echo FOLDER_PATH ?>/MaterialReq" method="POST">
                        <input type="hidden" name="ID" value="<?= $r['IdRequisicion']?>">
                        <input type="hidden" name="user" value="<?= $ID?>">
                        <button type="submit" class="btn btn btn-outline-info btn-sm badge badge-pill" value="update" id="action" name="action" style="width: 100px;">
                        <span class="icon-pencil"> Editar</span>
                      </button>
                      </form>

                    </center>
                    <?php

                  }
                  ?>
                </td>
                <td class="text-center"><?php

                  $fechalimite=$r['FechaLimite'];
                  $fechaActual=date('Y-m-d');
                  $fecha1 = new DateTime($fechalimite);
                  $fecha2 = new DateTime($fechaActual);
                  if ($fechaActual <= $fechalimite) {
                  $diff = $fecha2->diff($fecha1);
                  }else{
                     $diff=$fecha1->diff($fecha1);
                  }
                  switch ($diff->days) {
                    case '1':
                          echo '<div style="background-color: rgb(255, 51, 51);  color: white;">Hasta hoy podrá editar la requisición</div>';
                      break;
                    case $diff->days >= 0:
                          echo $diff->days.' día';
                      break;
                  }
                 ?></td>
              <?php } ?>                 
              </tr>

                <?php
                }
              }else{$CeroReqGuardadas=true;

             }
          ?>
            </tbody>
          </table>
        </div>


      </div>
      <div class="tab-pane fade" id="aceptadas" role="tabpanel" aria-labelledby="aceptadas-tab">
      <br>
      <div class="table table-responsive-sm table-responsive-md small">
        <table class="table table-sm table-striped table-hover" id="tableid3">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" class="text-center">Nº requisición</th>
                <th scope="col" class="text-center">Fecha de solicitud</th>
                <th scope="col" class="text-center">Fecha de Entrega</th>
                <th scope="col" class="text-center">Costo Total</th>
                <th scope="col" class="text-center">PDF</th>
              </tr>
            </thead>
            <tbody  style="font-size: 12px;" id="container-table3">
              <?php
              if ($result->num_rows > 0) {
              foreach ($result as $r2){
                if ($r2["Estado"] == 'AUTORIZADO') {
                ?>
                 <tr>
                <td class="text-center"><?= $r2["Foliorequisicion"]; ?></td>
                <td class="text-center"><?= $r2["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r2["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r2["Costo"]; ?></td>
                <td>
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r2["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                </td>
              </tr>

                <?php
                }
              }
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="materialRecibido" role="tabpanel" aria-labelledby="materialRecibido-tab">
      <br>
      <div class="table table-responsive-sm table-responsive-md small">
        <table class="table table-sm table-striped table-hover" id="tableid4">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" class="text-center">Nº requisición</th>
                <th scope="col" class="text-center">Fecha de solicitud</th>
                <th scope="col" class="text-center">Fecha de Entrega</th>
                <th scope="col" class="text-center">Costo Total</th>
                <th scope="col" class="text-center">Detalle</th>
              </tr>
            </thead>
            <tbody  style="font-size: 12px;" id="container-table4">
              <?php
              if ($result->num_rows > 0) {
              foreach ($result as $r3){
                if ($r3["Estado"] == 'AUTORIZADO') {
                ?>
                 <tr>
                <td class="text-center"><?= $r3["Foliorequisicion"]; ?></td>
                <td class="text-center"><?= $r3["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r3["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r3["Costo"]; ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn btn-outline-success btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?=$r3['IdBitacora']?>" data-model="RBS" data-operation="Detalle" data-method="Detalle" style="width: 100px; font-size: 12px;"><span class="fa fa-eye"> Ver</span></button></td>
              </tr>

                <?php
                }
              }
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
      <br>

  <input type="hidden" id="num_tabla" value="4">
    </div>

    </div>

  </div>
 </main>


  </body>
<?php require_once SCRIPTS; ?>

</html>
