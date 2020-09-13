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
  <body onload="myFunction()" style="margin:0;">

  <main id="wrapper">
  <nav class="navbar navbar-dark" style="padding: 0px; background-color : #1a2732">
 <!--    <div class="container"> -->
      <div class="navbar-header">
        <label></label>
        <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
        <a class="navbar-brand text-white"> BITACORA DE REQUISICIONES ATENDIDAS</a>
      </div>
      <nav class="navbar navbar-expand-sm justify-content-center" >
        <div class="dropdown">
         <button type="button" class="btn btn-dark badge-pill dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
        <span class="fa fa-list"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="<?php echo FOLDER_PATH ?>/Bitacora"><span class="icon-clipboard-1"> Requisiciones</span></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" data-method="Atendida" ><span class="icon-logout"> Cerrar sesión</span></a>
        </div>
        </div>
    </nav>
 <!--    </div> -->
  </nav>
  <br>
  <div class="animate-des">

  <div class="container-fluid ">
  <div class="container-fluid border" id="container-fluid-pago">
    <!-- ventana Modal -->
    <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white"></h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
          </div>
          <!-- body de la venatan -->
          <div class="modal-body">

          </div>
        </div>
      </div>
    </div>
    <!--- filtro   -->
   <div class="row p-3">
    <div class="col-md-2">
      <div class="input-group input-group-sm">
        <div class="input-group-prepend ">
          <span class="input-group-text " id="validationTooltipUsernamePrepend" style="font-size: 12px;">Filtrar Por</span>
        </div>
        <?php $dato=array("Todos","Concepto","Fecha","Departamento","Estados"); ?>

        <select colspan="5" class="form-control badge badge-default " id="filtros" name="filtros" data-model="BitacoraAtendida" style="font-size: 12px;">
          <option value="<?=$dato[0]?>">Todos</option>
          <option  value="<?=$dato[1]?>">Concepto</option>
          <option value="<?=$dato[2]?>">Fecha</option>
          <option value="<?=$dato[3]?>" class="text-truncate" >Departamento</option>
          <!-- <option value="<?=$dato[4]?>">Estado</option> -->
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="input-group-sm" id="ReBuscar" style="display:none;">
        <input type="text" class="form-control" placeholder="Concepto" name="buscar" id="buscar" data-model="BitacoraAtendida" autocomplete="off" >
      </div>

      <div class="input-group input-group-sm" id="estado" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text " id="">Estado</span>
        </div>
         <select class="form-control badge badge-default" id="selectE" name="selectE" data-model="BitacoraAtendida" style="font-size: 12px;">
          <option value="0" >Seleccione</option>
          <option value="PENDIENTE">PENDIENTE</option>
          <option value="AUTORIZADO">AUTORIZADO</option>
          <option value="NO AUTORIZADO" >NO AUTORIZADO</option>
          <!-- <option value="COTIZACION">COTIZACIÓN</option> -->
        </select>
      </div>
      <div class="input-group input-group-sm" id="depar" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text "  id="Ndepa" style="font-size: 12px;">Departamento</span>
        </div>
          <select  class="form-control badge" name="IdDep" id="Depa" data-model="BitacoraAtendida" style="font-size: 12px;">
            <option value="0" >Seleccione..</option>
            <?php  $depa = new DepartamentoModel();
            $depa= $depa->getAll('idDepart');?>
            <?php foreach ($depa as $d) {?>
            <option value="<?=$d['idDepart']?>"> <?=utf8_encode($d['nombreDepto'])?></option>
            <?php }?>
          </select>
      </div>
    </div>
    <div class="col-md-3">

       <div class="input-group input-group-sm" id="Desde" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text bg-white" id="">Desde:</span>
        </div>
        <input type="date" class="form-control" name="desde" id="desde" data-model="BitacoraAtendida">
      </div>
    </div>
    <div class="col-md-3">

      <div class="input-group input-group-sm" id="Hasta"  style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text bg-white" id="">Hasta:</span>
        </div>
         <input type="date" class="form-control" name="hasta" id="hasta" data-model="BitacoraAtendida">

      </div>

    </div>

  </div>
  </div>

</div>
    <div class="container-fluid  ">
      <div class="container-fluid border" id="container-fluid-pago">
        <br>
        <div class="table  table-responsive-sm table-responsive-md small" id="table">
          <table class="table table-sm table-striped table-hover table-bordered" id="table_id1">
            <thead class="thead-dark">
              <tr>
                <th scope="col" class="text-center">N° Requisición</th>
                <th scope="col" class="text-center">Costo</th>
                <th scope="col" class="text-center">Concepto</th>
                <th scope="col" class="text-center">Fecha de recepción</th>
                <th scope="col" class="text-center">Fecha de captura</th>
                <th scope="col" class="text-center">Fecha Autorizado</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Fecha Atendido</th>
                <th scope="col" class="text-center">Estatus</th>
                <th scope="col" class="text-center">Comentario</th>
                <th scope="col" class="text-center">Documento</th>
              </tr>
            </thead>
            <tbody class="container-table">
              <?php
              foreach ($result as $r) {?>
              <tr>
                <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
                <td class="text-right" > <?= '$'.$r["Costo"];?></td>
                <td class="small"><?= $r["Concepto"]; ?> </td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaReporte"]; ?></td>
                <td class="text-center"><?= $r["FechaAutorizacion"];?></td>
                <td class="text-center"><?= $r["Estado"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td class="text-center"><?= $r["Estatus"]; ?> </td>
                <td><?= $r["Comentario"];?>
                </td>
                  <td>
<!--                     <center>
                     <div class="btn-group">
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/show" method="post"  target="_blank">
                          <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                            <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
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
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
  </main>
  </body>
<?php require_once SCRIPTS; ?>
</html>
