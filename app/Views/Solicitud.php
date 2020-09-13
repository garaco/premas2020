<?php defined('BASEPATH') or exit('ERROR403');
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Solicitud de pago</title>
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\siderbar.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\style.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\fontello\css\fontello.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\boostrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.bootstrap.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.core.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.default.css">
    <link rel="icon" type="image/png"  href="<?php echo PATH_PUBLIC ?>\img\logo1.png">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\font-awesome\css\font-awesome.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  </head>
  <div class="contentPage"> 
  <body>
  <nav class="navbar navbar-dark bg-primary" style="padding: 0px;">
    <!-- <div class="container"> -->
      <div class="navbar-header" style="padding-left: 10px;">
         <a class="navbar-brand text-white "> <span class="fa fa-files-o"></span> SOLICITUDES DE PAGO</a>
      </div>
      <nav class="navbar navbar-expand-sm bg-primary justify-content-center">
        <?php  if($user == 'Admin'){?>
          <a class="text-white text-decoration btn botonSP badge-pill" href="<?php echo FOLDER_PATH ?>/Bitacora"><span class="icon-clipboard-1"> Requisiciones</span></a>
          <a class="text-white btn botonSP badge-pill" method="post" href="<?php echo FOLDER_PATH ?>/BitacoraAtendida" data-method="Atendida" ><span class="icon-book"> Req. Atendidas</span></a>
        <?php }?>
        <div class="dropdown">
         <button type="button" class="btn btn-primary badge-pill dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"><span class="caret"></span><span class="fa fa-file-pdf-o"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">

          <a class="dropdown-item disabled" style="float:top; color:gray;"><span class="fa fa-file-pdf-o"></span> Exportar PDF</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" data-toggle="modal" data-target="#ventana" style="float:top" data-id="1" data-model="Solicitud" data-operation="Exportar" data-method="export"><span class="fa fa-calendar"></span> Fecha</a>
          <a class="dropdown-item" data-toggle="modal" data-target="#ventana" style="float:top" data-id="2" data-model="Solicitud" data-operation="Exportar" data-method="export"><span class="fa fa-calendar-check-o"></span> Estado y Fecha</a>
          
       
        </div>
        </div>
       <div class="dropdown">
         <button type="button" class="boton dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
        <span class="caret fa fa-user"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <?php if($user != 'Admin'){ ?>
          <a class="dropdown-item" data-toggle="modal" data-target="#ventana" data-id="0" data-model="Solicitud" data-operation="Nuevo usuario y contraseña / " data-method="CambiarUserPass"><span class="fa fa-key"></span> Cambiar usuario y contraseña</a>
          <div class="dropdown-divider"></div>
        <?php } ?>
          <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" data-method="Atendida" ><span class="icon-logout"> Cerrar sesión</span></a>
        </div>
        </div>
    </nav>


   <!--  </div> -->
  </nav>
  <br>
  <?php $usuario= $user?>
  <div class="container-fluid ">

  <div class="container-fluid border" id="container-fluid-pago">
    <!-- ventana Modal -->
    <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
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
    <div class="row p-3">
        <?php if($user == 'PagoSolicitud'){ ?>
        <div class="form-group col-sm-1">
          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Solicitud" data-operation="Agregar" data-method="requested">
            <span class="icon-plus-circle">Agregar</span>
          </button>
        </div>
        <?php } else{?>
      <div class="col-md-2">
        <div class="input-group input-group-sm">
          <div class="input-group-prepend ">
            <span class="input-group-text " id="validationTooltipUsernamePrepend" style="font-size: 12px;">Filtrar Por</span>
          </div>
          <?php $dato=array("Todos","Concepto","Estados","Autorizado"); ?>
          <select class="form-control badge badge-default " id="filtros" name="filtros" data-model="Solicitud" data-operation="<?= $user?>" style="font-size: 12px;">
            <option value="<?=$dato[0]?>">Todos</option>
            <option value="<?=$dato[1]?>">Concepto, Proveedor o ID</option>
            <option value="<?=$dato[2]?>">Estado</option>
            <?php if ($user == 'Admin') {?>
            <option value="<?=$dato[3]?>">Autorizado</option>
           <?php }?>
            
          </select>
        </div>
      </div>
      <?php }?>

      <div class="col-md-3">
        <?php if($user == 'PagoSolicitud'){?>
          <div class="input-group-sm" id="ReBuscar">
          <input type="text" class="form-control" placeholder="Búsqueda por Concepto" name="buscar" id="buscar" data-model="Solicitud" data-operation="<?=$user?>" autocomplete="off" >
          </div>
        <?php }else{?>
           <div class="input-group-sm" id="ReBuscar" style="display:none;">
          <input type="text" class="form-control" placeholder="Buscar" name="buscar" id="buscar" data-model="Solicitud" data-operation="<?=$user?>" autocomplete="off" >
        </div>
        <?php }?>
        <div class="input-group input-group-sm" id="estado" style="display:none;">
          <div class="input-group-prepend ">
            <span class="input-group-text " id="">Estado</span>
          </div>
           <select class="form-control badge badge-default" id="selectE" name="selectE" data-model="Solicitud" data-operation="<?=$user?>"  style="font-size: 12px;">
            <option value="0" >Seleccione</option>
            <option value="PAGADO">PAGADO</option>
          <option value="PENDIENTE">PENDIENTE</option>
          </select>
        </div>
        <div class="input-group input-group-sm" id="autorizado" style="display:none;">
          <div class="input-group-prepend ">
            <span class="input-group-text " id="">Autorizado</span>
          </div>
           <select class="form-control badge badge-default" id="selectAutorizado" name="selectAutorizado" data-model="Solicitud" data-operation="<?=$user?>"  style="font-size: 12px;">
            <option value="0" >Seleccione</option>
            <option value="SI">AUTORIZADOS</option>
          <option value="NO">NO AUTORIZADOS</option>
          </select>
        </div>
      
  </div>
   <div class="col-md-3">

              <div class="input-group input-group-sm" id="FechaDesde" style="display:none;">
               <div class="input-group-prepend ">
                 <span class="input-group-text bg-white" id="">Desde:</span>
               </div>
               <input type="date" class="form-control" name="Fechadesde" id="Fechadesde" data-model="Solicitud" data-operation="<?=$user?>" >
             </div>
    </div>
    <div class="col-md-3">
             <div class="input-group input-group-sm" id="FechaHasta"  style="display:none;">
               <div class="input-group-prepend ">
                 <span class="input-group-text bg-white" id="">Hasta:</span>
               </div>
                <input type="date" class="form-control" name="Fechahasta" id="Fechahasta" data-model="Solicitud" data-operation="<?=$user?>" >
             </div>
    </div>
</div>

  </div>
</div>

    <div class="container-fluid  ">
      <div class="container-fluid border" id="container-fluid-pago">
        <br>
        <div class="table table-bordered table-responsive-sm table-responsive-md small" id="tablePago">
          <table class="table table-sm table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col" class="text-center">Proveedor</th>
                <th scope="col" class="text-center" >Concepto</th>
                <th scope="col" class="text-center">Monto</th>
                <th scope="col" class="text-center">Fecha de solicitud</th>
                <th scope="col" class="text-center">Revisado</th>
                <th scope="col" class="text-center">Autorizado a pagar</th>
                <th scope="col" class="text-center">Fecha de autorizado</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Fecha del pago</th>
                <th scope="col" class="text-center">Comentario D.G</th>
                <th scope="col" class="text-center">Comentario C.</th>
                <th scope="col" class="text-center">Editar</th>
                 <?php  if($user == 'PagoSolicitud'){?> <th scope="col" class="text-center">Eliminar</th> <?php } ?>
              </tr>
          </thead>
        <tbody class="container-table" style="font-size: 12px;">
            <?php foreach ($result as $r){?>
            <tr>
              <th ><?= $r["Id"]; ?></th>
              <th scope="row"><?= $r["Proveedor"]; ?></th>
              <td class="text-justify" ><?= $r["Concepto"]; ?></td>
              <td class="text-right"><?= '$'.$r["Monto"]; ?></td>
              <td class="text-center"><?= $r["FechaSolicitud"]; ?></td>
              <td class="text-center">
                <?php if($r["Revisado"] == 'SI'){?>
                <label class="icon-ok"> SI</label>
                <?php } else{?>
                  <label class="icon-cancel-circle"> NO</label>
                <?php }?>
                </td>
              <td class="text-center">
                <?php if($r["AutorizadoPago"] == 'SI'){?>
                <label class="icon-ok"> SI</label>
                <?php } else{?>
                  <label class="icon-cancel-circle"> NO</label>
                <?php }?>
              </td>
              <td class="text-center"><?= $r["FechaAutorizado"]; ?></td>
              <td class="text-center"><?= $r["estado"]; ?></td>
              <td class="text-center"><?= $r["FechaPago"]; ?></td>
              <td class="text-center"><?= $r["Comentario"]; ?></td>
              <td class="text-center"><?= $r["ComentarioCapt"]; ?></td>
              <td>
              <center>
                <button type="button" id="boton" value="<?= $user ?>" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Solicitud" data-operation="Editar" data-method="addcomen">
                  <span class="icon-pencil"></span>
                </button>
              </center></td>
              <?php  if($user == 'PagoSolicitud'){?>
                <td>
                <center>
                  <button type="button" id="boton" value="<?= $user ?>" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Solicitud" data-operation="Eliminar" data-method="delete">
                    <span class="icon-trash"></span>
                  </button>
                </center>
                </td>
              <?php  }?>
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
              <a href="#" class="pag page-link" id="pag-prev" data-page="1" data-cont="<?= $cant ?>" data-reg="20" data-model="Solicitud">
                  <span aria-hidden="true">&laquo;</span>
              </a>
          </li>
            <?php for($i = 1; $i <= $pag; $i++){?>
              <li class="page-item">
                 <a href="#" class="pag page-link" data-page="<?= $i ?>" data-cont="<?= $cant ?>" data-reg="20" data-model="Solicitud">
                     <?=$i;?>
                 </a>
              </li>
             <?php } ?>
           <li class="page-item disabled">
               <a href="#" class="pag page-link" id="pag-next" data-page="<?= $pag ?>" data-cont="<?= $cant ?>" data-reg="20" data-model="Solicitud">
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
