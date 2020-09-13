<?php defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RBSModel.php';
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
     <?php
        $header = new header();
        $header->PushHeader('Gestion de Requisiciones');
     ?>
  </head>

  <body class="Colorpage body bg-white" id="body" onload="myFunction()" style="margin:0;">

    <!-- loader -->
    <div id="loader"></div>
    <!-- end loader -->
  <main id="wrapper">
     <?php require_once SIDERBAR; ?>
     <div id="page-content-wrapper">
       <nav class="navbar navbar-dark colornavbar" style="padding: 0px;">

        <div class="container-fluid">

          <div class="navbar-header">
            <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
            <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
            <a class="navbar-brand font-weight-bold text-white" style="font-size: 15px;">REQUISICIONES DE BIENES Y SERVICIOS</a>
          </div>
          <nav class="navbar navbar-expand-sm justify-content-center">
          <div class="dropdown" >
           <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
             <span class="caret"></span>Requisiciones por año
          </button>
            <div class="dropdown-menu" id="myDropdown">
                <?php
                $cont=0;
                for ($i=2018; $i <= $ano=date('Y') ; $i++) {
                $cont++;
                ?>
                  <button class="dropdown-item boton_ano" value="<?=$i?>" id="boton_ano<?=$cont?>" data-cont="<?=$cont?>" data-model="Requisicion" style="padding-top: 0px; padding-bottom: 0px;"><span class="fa fa-angle-right"> <?= $i?> </span></button>
               <div class="dropdown-divider" ></div>
                <?php  }?>
            </div>
          </div>
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
             foreach ($Foliorequisicion as $f){
               if($f['dato']<>'0'){
                 $cont++;

             ?>
             <label class="dropdown-item disabled" style="padding-bottom: 0px; padding-top: 0px; color: black;">
              <?= $cont." ".$f['dato'];?></label>
              <?php
              }  }
              if($cont==0){
              ?>
              <label class="dropdown-item disabled" >0 notificación</label>
              <?php
              }
               ?>
            </div>
            </div>
            </div>
          </div>
          <div class="dropdown" data-toggle="tooltip" data-placement="top" title="Exportar en Excel">
           <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown" >
          <span class="fa fa-file-excel-o"></span>
          </button>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item disabled" style="float:top; color:gray; ">Exportar:</a>
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ventana" style="float:top" data-id="1" data-model="Requisicion" data-operation="Exportar" data-method="export"><span class="icon-ok"> Todo</span> </a>
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ventana" style="float:right" data-id="2" data-model="Requisicion" data-operation="Exportar" data-method="export"><span class=" icon-wpforms"> Estado y Fecha</span></a>
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ventana" style="float:right" data-id="3" data-model="Requisicion" data-operation="Exportar" data-method="export"><span class="icon-calendar-empty"> Fecha</span></a>
            </div>
          </div>
        <div class="dropdown" data-toggle="tooltip" data-placement="top" title="Cerrar sesión">
          <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
            <span class="fa fa-user-circle"></span> <label > <?=$User?></label>
         </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
        </div>
        </div>
          </nav>

        </div>
      </nav>
    <div class="contentPage">
 <!--  class="offset-sm-1 col-md-9" -->

      <div id="" class="animate-des main">
      <br>
       <div class="container-fluid ">
        <div class="container-fluid border bg-white">
          <div  class="container-fluid" id="container-fluid-pago">
           <div class="row p-3 ">

           <div class="col-md-2">
             <div class="input-group input-group-sm">
               <div class="input-group-prepend ">
                 <span class="input-group-text " id="validationTooltipUsernamePrepend" style="font-size: 12px;">Filtrar Por</span>
               </div>
               <?php $dato=array("Todos","Concepto","Fecha","Departamento","Estados"); ?>

               <select class="form-control badge badge-default " id="filtros" name="filtros" data-model="Requisicion" style="font-size: 12px;">
                 <option value="<?=$dato[0]?>">Todos</option>
                 <option value="<?=$dato[1]?>">Requisición</option>
                 <option value="<?=$dato[2]?>">Fecha</option>
                 <option value="<?=$dato[3]?>">Departamento</option>
                 <option value="<?=$dato[4]?>">Estado</option>
               </select>
             </div>
           </div>
           <div class="col-md-3">
             <div class="input-group-sm" id="ReBuscar" style="display:none;">
               <input type="text" class="form-control" placeholder="N° Requisicion" name="buscarRequi" id="buscarRequi" data-model="Requisicion" autocomplete="off" autofocus>
             </div>

             <div class="input-group input-group-sm" id="estado" style="display:none;">
               <div class="input-group-prepend ">
                 <span class="input-group-text " id="">Estado</span>
               </div>
                <select class="form-control badge badge-default" id="selectE" name="selectE" data-model="Requisicion" style="font-size: 12px;">
                 <option value="0" >Seleccione</option>
                 <option value="PENDIENTE">PENDIENTE</option>
                 <option value="AUTORIZADO">AUTORIZADO</option>
                 <option value="NO AUTORIZADO">NO AUTORIZADO</option>
                 <!-- <option value="COTIZACION">COTIZACIÓN</option> -->
               </select>
             </div>
             <div class="input-group input-group-sm" id="depar" style="display:none;">
               <div class="input-group-prepend ">
                 <span class="input-group-text "  id="Ndepa" style="font-size: 12px;">Departamento</span>
               </div>
                 <select  class="form-control badge" name="IdDep" id="Depa" data-model="Requisicion" style="font-size: 12px;">
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
               <input type="date" class="form-control" name="desde" id="desde" data-model="Requisicion">
             </div>
           </div>
           <div class="col-md-3">

             <div class="input-group input-group-sm" id="Hasta"  style="display:none;">
               <div class="input-group-prepend ">
                 <span class="input-group-text bg-white" id="">Hasta:</span>
               </div>
                <input type="date" class="form-control" name="hasta" id="hasta" data-model="Requisicion">
             </div>

           </div>

         </div>
        </div>
        <?php if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show small text-center" id="success-alert" role ="alert"> <div id="check"><img src="<?php echo PATH_PUBLIC ?>\img\Error.png" alt="" ></div>
            <strong><label ><?=isset($error_message)?$error_message:''?></label></strong>
        </div>

        <?php } ?>
      </div>

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
    <div class="container-fluid bg-white border">
      <!-- secion de tabla de datos  -->
      <br>
      <?php
       $Material;
       $this->Material = new MaterialModel();
       $Num_estado;
       $this->Num_estado = new RBSModel();
       $fila=0;
       ?>
      <div class="table-wrapper-scroll-y ">
        <div class="table table-responsive table-responsive-sm table-responsive-md small" >
          <table class="table table-sm table-striped table-hover" id="table_id1">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" class="text-center">N° de requisición</th>
                <th scope="col" class="text-center">Monto por adquisición</th>
                <th scope="col" class="text-center">Fecha de recepción</th>
                <th scope="col" class="text-center">Fecha de captura</th>
                <th scope="col" class="text-center">Departamento</th>
                <th scope="col" class="text-center">Solicitante</th>
                <th scope="col" class="text-center" >Concepto</th>
                <th scope="col" class="text-center">Fecha de autorización</th>
                <th scope="col" class="text-center">Estado de autorización</th>
                <th scope="col" class="text-center">Fecha de atención</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Comentario</th>
                <th scope="col" class="text-center">PDF</th>
                <th scope="col" class="text-center">Editar</th>
                <th scope="col" class="text-center"></th>
              </tr>
            </thead>
            <tbody class="container-table" style="font-size: 12px;">
              <?php
               foreach ($result as $r){?>
              <tr>
                <th scope="row"><?=($r["Estado"]=='AUTORIZADO' && $r["Estatus"]!='ATENDIDA')?'<span class="parpadea text-parpadeo fa fa-circle"></span>':''?>  <?= ($r["Foliorequisicion"] != '') ? $r["Foliorequisicion"] : '<div class=" talk-bubble tri-right right-in "><div class="talktext">NO DEFINIDO</div></div>' ?> </th>
                <td class="text-right"><?= '$'.''.$r["Costo"];?></td>
                <td><?= $r["FechaRecepcion"]; ?></td>
                <td><?= $r["FechaReporte"]; ?></td>
                <td><?= $r["nombreDepto"];?></td>
                <td><?= $r['Subfijo'].''.$r['Nombre'].' '.$r['A_paterno'].' '.$r['A_materno'] ;?></td>
                <td class="small text-justify"><?= $r["Concepto"];?></td>
                <td><?= $r["FechaAutorizacion"];?></td>
                <td class="text-center"><?= $r["Estado"];?></td>
                <td>
                  <?php if ($r["Estado"]=='AUTORIZADO' && $r["FechaAatencion"]=='00/00/0000') {?>
                    <center>
                      <form action="<?php echo FOLDER_PATH ?>/Requisicion/saveDATE" method="post">
                        <button type="submit" class="btn btn btn-outline-success btn-sm badge badge-pill" >
                          <span class="icon-plus-circle"></span><input type="hidden" name="fecha" value="<?= DATE ?>">
                          <input type="hidden" name="id" value="<?= $r["IdBitacora"] ?>">

                        </button>
                      </form>
                    </center>
                  <?php } else{
                  echo $r["FechaAatencion"];
                }
                  ?>
                </td>
                <td class="text-justify">
                  <?= $r["Estatus"] ?>
                </td>
                <td class="text-justify"><?= $r["Comentario"];?></td>
                <td>
                  <?php if ($r['Foliorequisicion'] != "") { ?>
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                  <?php } ?>

                </td>
                <td>
                  <?php if ($r["Estatus"]=='ATENDIDA') {?>
                    <center>
                      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill">
                        <span class="icon-pencil"></span>
                      </button>
                    </center>

                  <?php } else{ ?>
                  <center>
                    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill"
                    id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Requisicion" data-operation="Editar" data-method="requested" data-estado="<?=$r['Estado']?>">
                      <span class="icon-pencil"></span>
                    </button>
                  </center>
               <?php  }
                  ?>
                </td>
                <td>
                  <?php

                    if ($r["Estado"]=='AUTORIZADO' && $r["Estatus"]!='ATENDIDA') {
                      $id=$r['IdBitacora'];
                      $Cantidad = $this->Material->CantidadMaterial($id);
                      $Num_estado = $this->Num_estado->Num_estadoMaterial($id);
                      $num_fila = $Num_estado->num_rows;
                      $cont=0;
                      $cont2=0;
                      foreach ($Num_estado as $N_e) {
                          if ($N_e['Num_estado'] == 1) {
                            $cont2++;
                          }
                      }
                      foreach ($Cantidad as $mt) {
                        if ($mt['Cantidad'] > $mt['Existencia']) {
                          $cont++;
                        }
                      }
                      if ($cont2 != $num_fila) {
                      if ($cont >= 1) {
                  ?>
                 <center>
                    <button type="button" class="btn btn btn-warning btn-sm badge badge-pill"
                    data-toggle="modal" data-target="#ventana" data-id="<?= $r['IdBitacora'] ?>" data-model="Requisicion" data-operation="Advertencia" data-method="Advertencia" >
                      <span class="fa fa-exclamation-triangle"></span>
                    </button>
                  </center>
                  <?php }
                }
                }if ($r['FechaEntrega'] < DATE && $r["Estado"] != 'AUTORIZADO') { ?>
                  <center>
                        <form action="<?php echo FOLDER_PATH ?>/Requisicion/Cancel" method="POST" id="form<?=$fila?>">
                        <input type="hidden" name="Mes" value="<?=MES?>">
                        <input type="hidden" name="ID" value="<?= $r['IdBitacora'].'|'.$r['IdDep'].'|'.MES.'|'.$r['dateRecepcion']?>">
                        <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill CancelarRequi" value="<?= $r['Foliorequisicion']?>" id="CancelarRequi<?=$fila?>" name="Cancelar" onclick="CancelarRequisicion(<?=$fila?>)" >
                        <span class="icon-trash"></span>
                      </button>
                       </form>
                  </center>
                <?php $fila++; } ?>
                </td>
              </tr>
            <?php  } ?>
            </tbody>
          </table>
        </div>
    </div>

    </div>
    </div>
    <br>
  </div>

    </div>
     </div>

  </main>
  <!-- para saber el numero total de botones de cancelar requisicion -->
  <input type="hidden" id="NumReqCancelar" value="<?=$fila?>">
  </body>
<?php require_once SCRIPTS; ?>

</html>
