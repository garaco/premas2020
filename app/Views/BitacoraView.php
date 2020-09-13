<?php defined('BASEPATH') or exit('ERROR403');
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bitacora</title>
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\siderbar.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\style.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\fontello\css\fontello.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\boostrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\font-awesome\css\font-awesome.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.bootstrap.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.core.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.default.css">

    <link rel="icon" type="image/png"  href="<?php echo PATH_PUBLIC ?>\img\logo1.png">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  </head>
  <div class="contentPage">
    <nav class="navbar navbar-dark bg-primary" style="padding: 0px;">
    
      <div class="navbar-header">
        <label></label>
        <a class="navbar-brand text-white icon-clipboard-1"> BITACORA DE REQUISICIONES </a>
      </div>
      <nav class="navbar navbar-expand-sm bg-primary justify-content-center">
        <div class="dropdown">
         <button type="button" class="badge-pill btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"><span class="fa fa-list"></span> Opciones
        </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" data-toggle="modal" data-target="#ventana" data-id="0" data-model="BitacoraView" data-operation="Nuevo usuario y contraseña" data-method="CambiarUserPass"><span class="fa fa-key"></span> Cambiar usuario y contraseña</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" data-method="Atendida" ><span class="icon-logout"> Cerrar sesión</span></a>
          </div>
        </div>
    </nav>

  </nav>
  <br>
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
    <!-- - filtro   -->
   <div class="row p-3">
    <div class="col-md-2">
      <div class="input-group input-group-sm">
        <div class="input-group-prepend ">
          <span class="input-group-text " id="validationTooltipUsernamePrepend" style="font-size: 12px;">Filtrar Por</span>
        </div>
        <?php $dato=array("Todos","Concepto","Fecha","Departamento","Estados"); ?>

        <select colspan="5" class="form-control badge badge-default " id="filtros" name="filtros" data-model="BitacoraView" style="font-size: 12px;">
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
        <input type="text" class="form-control" placeholder="Concepto" name="buscar" id="buscar" data-model="BitacoraView" autocomplete="off" >
      </div>

      <div class="input-group input-group-sm" id="estado" style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text " id="">Estado</span>
        </div>
         <select class="form-control badge badge-default" id="selectE" name="selectE" data-model="BitacoraView" style="font-size: 12px;">
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
          <select  class="form-control badge" name="IdDep" id="Depa" data-model="BitacoraView" style="font-size: 12px;">
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
        <input type="date" class="form-control" name="desde" id="desde" data-model="BitacoraView">
      </div>
    </div>
    <div class="col-md-3">

      <div class="input-group input-group-sm" id="Hasta"  style="display:none;">
        <div class="input-group-prepend ">
          <span class="input-group-text bg-white" id="">Hasta:</span>
        </div>
         <input type="date" class="form-control" name="hasta" id="hasta" data-model="BitacoraView">

      </div>

    </div>

  </div>
  </div>

</div>

  <body>
    <div class="container-fluid  ">
      <div class="container-fluid border" id="container-fluid-pago">
        <br>
        <div class="table table-bordered table-responsive-sm table-responsive-md small" id="table">
          <table class="table table-sm table-striped table-hover">
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
                <td class="text-center"><?=$r["FechaAutorizacion"];?></td>
                <td class="text-center"><?= $r["Estado"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td><?=$r["Comentario"];?></td>
                  <td>
                    <center>
                     <div class="btn-group">
                        <form action="<?php echo FOLDER_PATH ?>/BitacoraView/show" method="post"  target="_blank">
                          <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                            <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
                          </button>
                        <!--  -->
                        </form>
                     </div>
                    </center>
                  </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
<br>
     <!-- Paginacion -->
 <div class="text-center">
   <nav aria-label="Paginación" id="pag-nav">
       <ul class="pagination pagination-sm justify-content-center">
         <li class="page-item disabled" >
              <a href="#" class="pag page-link" id="pag-prev" data-page="1" data-cont="<?= $cant ?>" data-reg="20" data-model="BitacoraView">
                  <span aria-hidden="true">&laquo;</span>
              </a>
          </li>
            <?php for($i = 1; $i <= $pag; $i++){?>
              <li class="page-item">
                 <a href="#" class="pag page-link" data-page="<?= $i ?>" data-cont="<?= $cant ?>" data-reg="20" data-model="BitacoraView">
                     <?=$i;?>
                 </a>
              </li>
             <?php } ?>
           <li class="page-item disabled">
               <a href="#" class="pag page-link" id="pag-next" data-page="<?= $pag ?>" data-cont="<?= $cant ?>" data-reg="20" data-model="BitacoraView">
                   <span aria-hidden="true">&raquo;</span>
               </a>
           </li>
           <li class="page-item disabled">
                <a class="info page-link">
                   <?php  echo '1-20 de '.$cant?>
                </a>
            </li>
       </ul>
   </nav>
 </div>
  </body>
  </div>
  
  <script src="<?php echo PATH_PUBLIC ?>\jquery\jquery.min.js"> </script>
  <script src="<?php echo PATH_PUBLIC ?>\js\siderbar.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\js\request.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\boostrap\js\bootstrap.min.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\js\alertify.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\js\alertify.min.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\js\mensaje.js"></script>
</html>
