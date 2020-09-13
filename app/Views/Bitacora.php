<?php defined('BASEPATH') or exit('ERROR403');
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Views/header.php';?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
        <?php
        $header = new header();
        $header->PushHeader('Bitacora');
          $fila=0;
     ?>
  </head>
  <body class="Colorpage" onload="myFunction()" style="margin:0;">
    <main id="wrapper">

  <nav class="navbar navbar-dark" style="padding: 0px; background-color : #1a2732">
<!--     <div class="container"> -->
      <div class="navbar-header">
        <label></label>
        <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
        <a class="navbar-brand text-white">  BITACORA DE REQUISICIONES </a>
      </div>
      <nav class="navbar navbar-expand-sm justify-content-center" style="background-color : #1a2732">

          <?php
          $num=0;
          foreach ($Foliorequisicion as $k) {
            if($k['dato']<>'0'){$num++;}

          }

           ?>
          <div class="dropdown" >
           <button type="button" class="btn botones dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
            <i class="fa fa-bell "><span class="badge pull-right bg-danger <?=($num > 0)?'text':''?> "><?= ($num > 0)?'+'.$num:0;?></span></i>
          </button>
            <div class="dropdown-menu dropdown-menu-right" id="myDropdown">
              <div class="panel panel-primary">

                <div class="panel-heading">
                <label class="panel-title dropdown-item disabled"><strong>Notificaciones</strong></label>
                <div class="dropdown-divider"></div>
                </div>
                <div class="panel-body">
            <?php
              $cont=0;
             foreach ($Foliorequisicion as $f)
             if($f['dato']<>'0'){
              $cont++;
             ?>
             <label class="dropdown-item disabled" style="padding-bottom: 0px; padding-top: 0px; color: black;"><?= $cont." ".$f['dato'];?></label>
              <?php
              }  ?>
            </div>
            </div>
            </div>
          </div>
        <div class="dropdown" data-toggle="tooltip" data-placement="top" title="Cerrar sesión">
         <button type="button" class="badge-pill btn botones dropdown-toggle dropdown-toggle-split text-white" data-toggle="dropdown"><span class="fa fa-list"></span>
        </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo FOLDER_PATH ?>/BitacoraAtendida"><span class="icon-clipboard-1"> Req. Atendidas</span></a>
            <a class="dropdown-item" href="<?php echo FOLDER_PATH ?>/SMC"><span class="icon-clipboard-1">Solicitudes de M.C</span></a>
            <a class="dropdown-item" data-toggle="modal" data-target="#ventana" data-id="0" data-model="Bitacora" data-operation="Nuevo usuario y contraseña" data-method="CambiarUserPass"><span class="fa fa-key"></span> Cambiar usuario y contraseña</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" data-method="Atendida" ><span class="icon-logout"> Cerrar sesión</span></a>
          </div>
        </div>

    </nav>
 <!--    </div> -->
  </nav>
  <br>
<div class="contentPage animate-des" >
  <div class="container-fluid ">
  <div class="container-fluid border bg-white" id="container-fluid-pago">
    <!-- ventana Modal -->
    <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-white"></h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
          </div>
          <!-- body de la venatan -->
          <div class="modal-body">

          </div>
        </div>
      </div>
    </div>
    <!-- filtro   -->
    <div id="filtro">
     <div class="row p-3">
    <div class="col-md-2">
      <div class="input-group input-group-sm">
        <div class="input-group-prepend ">
          <span class="input-group-text " id="validationTooltipUsernamePrepend" style="font-size: 12px;">Filtrar Por</span>
        </div>
        <?php $dato=array("Todos","Concepto","Fecha","Departamento","Estados"); ?>

        <select colspan="5" class="form-control badge badge-default " id="filtros" name="filtros" data-model="Bitacora" style="font-size: 12px;">
          <option value="<?=$dato[0]?>">Todos</option>
          <option  value="<?=$dato[1]?>">Concepto</option>
          <option value="<?=$dato[2]?>">Fecha</option>
          <option value="<?=$dato[3]?>" class="text-truncate" >Departamento</option>
          <option value="<?=$dato[4]?>">Estado</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="input-group-sm" id="ReBuscar" style="display:none;">
       <!--  <div class="container"> -->
          <div class="group">
            <input type="text" class="form-control form-control-sm" name="buscar" id="buscar" data-model="Bitacora" placeholder="Concepto" autocomplete="off" >
          </div>
      <!-- </div> -->
  <!--       <input type="text" class="input" placeholder="Concepto" name="buscar" id="buscar" data-model="Bitacora" autocomplete="off" > -->
      </div>

      <div class="input-group input-group-sm" id="estado" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text " id="">Estado</span>
        </div>
         <select class="form-control badge badge-default" id="selectE" name="selectE" data-model="Bitacora" style="font-size: 12px;">
          <option value="0" >Seleccione</option>
          <option value="PENDIENTE">PENDIENTE</option>
          <option value="AUTORIZADO">AUTORIZADO</option>
          <option value="NO AUTORIZADO" >NO AUTORIZADO</option>
        </select>
      </div>
      <div class="input-group input-group-sm" id="depar" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text "  id="Ndepa" style="font-size: 12px;">Departamento</span>
        </div>
          <select  class="form-control badge" name="IdDep" id="Depa" data-model="Bitacora" style="font-size: 12px;">
            <option value="0" >Seleccione..</option>
            <?php  $depa = new DepartamentoModel();
            $depa= $depa->getAll('idDepart');?>
            <?php foreach ($depa as $d) {?>
            <option value="<?=$d['idDepart']?>"> <?=$d['nombreDepto']?></option>
            <?php }?>
          </select>
      </div>
    </div>
    <div class="col-md-3">

       <div class="input-group input-group-sm" id="Desde" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text bg-white" id="">Desde:</span>
        </div>
        <input type="date" class="form-control" name="desde" id="desde" data-model="Bitacora">
      </div>
    </div>
    <div class="col-md-3">

      <div class="input-group input-group-sm" id="Hasta"  style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text bg-white" id="">Hasta:</span>
        </div>
         <input type="date" class="form-control" name="hasta" id="hasta" data-model="Bitacora">

      </div>

    </div>
    <div class="form-group col-sm-1" >

    </div>
  </div>
 </div>
 </div>
</div>


      <div class="container-fluid  ">
      <div class="container-fluid border bg-white" id="container-fluid-pago">
        <br>
        <div class="table table-responsive-sm table-responsive-md small ">
          <table class="table table-sm table-striped table-hover table-condensed table-bordered" id="table_id1">
            <thead class="thead-dark">
              <tr>
                <th scope="col" class="text-center">N° Requisición</th>
                <th scope="col" class="text-center">Costo</th>
                <th scope="col" class="text-center">Concepto</th>
                <th scope="col" class="text-center">Fecha de recepción</th>
                <th scope="col" class="text-center">Fecha de captura</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Fecha Autorizado</th>
                <th scope="col" class="text-center">Fecha Atendido</th>
                <th scope="col" class="text-center">Estatus</th>
                <th scope="col" class="text-center">Comentario</th>
                <th scope="col" class="text-center" Id="visible">PDF</th>
                <th scope="col" class="text-center" Id="visible">Editar</th>
                <th scope="col" class="text-center"></th>
              </tr>
            </thead>
            <tbody class="container-table">
              <?php
              // $num=0;
              foreach ($result as $r) {

                ?>
              <tr>

                <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
                <td class="text-right" > <?= '$'.$r["Costo"];?></td>
                <td class="small text-justify"><?= $r["Concepto"]; ?> </td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaReporte"]; ?></td>
                <td class="text-center"><?= $r["Estado"];?></td>
                <td class="text-center"><?= $r["FechaAutorizacion"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td class="text-justify"><?= $r["Estatus"]; ?> </td>
                <td class="text-justify"><?= $r["Comentario"];?></td>
                  <td Id="visible">
<!--                     <center>
                     <div class="btn-group">
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/show" method="post"  target="_blank">
                          <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                            <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
                          </button>
                          <button type="button" class="btn btn btn-outline-dark btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Bitacora" data-operation="Editar" data-method="requested">
                            <span class="icon-upload"></span>
                          </button>
                        </form>
                     </div>
                    </center> -->
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
                  <td Id="visible">
                    <center>
                          <button type="submit" class="btn btn btn-outline-success btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Bitacora" data-operation="Editar" data-method="addcomen" data-estado="<?=$r['Estado']?>" data-mes="<?=MES?>" data-datef="<?=$r['dateRecepcion']?>">
                            <span class="icon-pencil"></span>
                          </button>
                    </center>
                  </td>
                  <td>
                    <?php
                if ($r['FechaEntrega'] <= DATE && $r["Estado"] != 'AUTORIZADO') { ?>
                  <center>
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/Cancel" method="POST" id="form<?=$fila?>">
                        <input type="hidden" id="ID" name="ID" value="<?= $r['IdBitacora'].'|'.$r['IdDep'].'|'.MES.'|'.$r['dateRecepcion']?>">
                        <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill CancelarRequi" value="<?= $r['Foliorequisicion']?>" id="CancelarRequi<?=$fila?>" name="Cancelar" onclick="CancelarRequisicion(<?=$fila?>)" >
                        <span class="icon-trash"></span>
                      </button>
                       </form>
                  </center>
                <?php $fila++;
              }
                     ?>
                  </td>
              </tr>
              <?php  }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br>
    </div>
  </body>
  </main>
<?php require_once SCRIPTS; ?>
</html>
