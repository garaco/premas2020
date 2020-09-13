<?php defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Views/header.php'; ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
       <?php
         $header = new header();
         $header->PushHeader('SOLICITUD DE MANTENIMIENTO CORRECTIVO');
     ?>
	<title></title>
</head>
<body class="Colorpage" onload="myFunction()" style="margin:0;">
<main id="wrapper">
      <?php require_once SIDERBAR; ?>
  <div id="loader"> </div>
      <div id="page-content-wrapper">
     <nav class="navbar navbar-dark" style="background-color : #1a2732">

      <div class="container-fluid">
        <div class="navbar-header">
          <?php if ($tipoUser=="SuperAdmin") {
         ?>
          <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
          <?php   } ?>
          <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
          <a class="navbar-brand font-weight-bold text-white" >SOLICITUD DE MANTENIMIENTO CORRECTIVO</a>
        </div>
        <div class="dropdown ">
         <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
         	<span class="fa fa-user-circle"></span> <label > <?=$User?></label>
         </button>
          <div class="dropdown-menu dropdown-menu-right">
          <?php if ($tipoUser=="Admin") {?>
          <a class="dropdown-item" href="<?php echo FOLDER_PATH ?>/Bitacora"><span class="icon-clipboard-1"> Requisiciones</span></a>
          <div class="dropdown-divider"></div>
          <?php   }if ($tipoUser=="SCM") { ?>
						<a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RBS" ><span class="fa fa-address-card-o"> </span> Alta Requisiciones</a>
						<a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/RequisicionAnual" ><span class="fa fa-calendar-o"> </span> Programa Anual Requisiciones</a>
	          <div class="dropdown-divider"></div>
					<?php   } ?>
              <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
          </div>
        </div>
      </div>
    </nav>
<!-- ventana modal -->
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
 <!-- fin ventana modal -->

    <div class="contentPage">
 <br>
 <?php if ($tipoUser!="SuperAdmin" && $tipoUser!="Admin") {
  ?>
      <div class="container-fluid">
        <div class="container-fluid border bg-white" id="container-fluid-pago" >
                <!-- BOTON DE AGREGAR  -->
               <div class="row justify-content-md-center">
                <div class="col-sm-12 alert-color">
                    <img src="<?php echo PATH_PUBLIC ?>/img/add.png">
                      <label class="font-weight-bold">
                        ALTA DE SOLICITUD</label>
                </div>
              </div>
              <div class="row">

                <!-- Button que manda a llamar la ventana modal -->
                <div class="form-group col-sm-1.5 p-3" >

                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="SMC" data-operation="Agregar" data-method="requested" data-depto="<?=$tipoUser?>">
                       <span class="icon-plus-circle">Agregar</span>
                    </button>
                </div>
        </div>
      </div>
      <br>
      </div>
<?php } ?>
          <div class="container-fluid">
            <!-- secion de tabla de datos  -->
          <div class="container-fluid border bg-white" id="container-fluid-pago" >
            <br>
            <div class="row">
              <div class="col-sm-12">
                <label class=" form-control text-center font-weight-bold" style="border: white;">
                  <img src="<?php echo PATH_PUBLIC ?>/img/lista.png"> LISTA DE SMC</label>
              </div>
            </div>
            <hr style="border-color: green; margin: 0; padding: 5px;">
            <div class="table-wrapper-scroll-y ">
              <div class="table table-responsive-sm table-responsive-md small" id="">
                <table class="table table-sm table-striped table-hover" id="table_id1">
                  <thead class="thead-dark" >
                    <tr>
                      <th scope="col" class="text-center">Folio</th>
                      <th scope="col" class="text-center">Fecha de recepción</th>
                      <th scope="col" class="text-center">Fecha de captura</th>
                      <th scope="col" class="text-center">Departamento</th>
                      <th scope="col" class="text-center">Solicitante</th>
                      <th scope="col" class="text-center" >Concepto</th>
                      <th scope="col" class="text-center">Comentario</th>
                      <?php if ($tipoUser=="SuperAdmin" || $tipoUser=="Admin") {  ?>
                        <th scope="col" class="text-center">Estado</th>
                      <?php   } ?>
                      <th scope="col" class="text-center">PDF</th>
                      <th scope="col" class="text-center">Editar</th>
                    </tr>
                  </thead>
                  <tbody class="container-table" style="font-size: 12px;">
                    <?php foreach ($result as $r){?>
                    <tr>
                      <th scope="row"><?=  $r["Folio"]; ?></th>
                      <td><?= $r["FechaRecepcion"]; ?></td>
                      <td><?= $r["FechaReporte"]; ?></td>
                      <td><?= utf8_encode($r["nombreDepto"]);?></td>
                      <td><?= utf8_encode($r['Subfijo'].''.$r['Nombre'].' '.$r['A_paterno'].' '.$r['A_materno']) ;?></td>
                      <td class="text-justify"><?=utf8_encode($r["Concepto"]);?></td>
                      <td class="text-justify"><?= utf8_encode($r["Comentario"]);?></td>
                      <?php if ($tipoUser=="SuperAdmin" || $tipoUser=="Admin") {  ?>
                      <td class="text-justify"><?= ($r["Estatus"]) ;?></td>
                      <?php } ?>
                      <td>

                        <center>
                          <form action="<?php echo FOLDER_PATH ?>/SMC/show" method="post"  target="_blank">
                            <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                              <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
                            </button>
                          </form>
                        </center>
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
                          <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" i
                          id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Idsmc"] ?>" data-model="SMC" data-operation="Editar" data-method="requested" data-depto="<?=$tipoUser?>">
                            <span class="icon-pencil"></span>
                          </button>
                        </center>
                     <?php  }
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
          </div>
          </div>
          <br>

          </div>
            <br>

    </div>
      </div>


</main>
<?php require_once SCRIPTS; ?>
</body>
</html>
