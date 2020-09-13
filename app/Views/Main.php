<?php defined('BASEPATH') or exit('ERROR403'); ?>
<!DOCTYPE html>
<html>
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio</title>
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\siderbar.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\style.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\fontello\css\fontello.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\boostrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\alertify.bootstrap.css">
    <link rel="icon" type="image/png"  href="<?php echo PATH_PUBLIC ?>\img\logo1.png">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\font-awesome\css\font-awesome.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\spinner.scss">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\loader.css">

</head>

  <?php
  $totalRequisicion="0";
  $totalNoAutorizado="0";
  $totalAutorizado="0";
  $totalAtendida="0";
  foreach ($totalr as $t) {
    $totalRequisicion=$totalRequisicion+1;
  }
  foreach ($NoAutorizado as $NA) {
    $totalNoAutorizado=$totalNoAutorizado+1;
  }
  foreach ($Autorizado as $A) {
    $totalAutorizado=$totalAutorizado+1;
  }
  foreach ($Atendida as $aten) {
    $totalAtendida=$totalAtendida+1;
  }
  ?>
  <body onload="myFunction()" style="margin:0;" >
      <!-- loader -->
      <div id="loader"></div>
      <!-- end loader -->
    <main id="wrapper" >
    <?php require_once SIDERBAR; ?>
    <nav class="navbar navbar-expand   navbar-light justify-content nav-color" style="padding: 0px;">
       <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
      <div class="container-fluid nav-space">
       <!--  <label class="icon-th-list" data-toggle="tooltip" title="Menú"></label> -->

        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="navbar-brand font-weight-bold text-white" >ADMINISTRADOR  </a>
            </li>
          </ul>
        <div class="dropdown" style="float: right;">
          <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
            <span class="caret fa fa-user-circle"></span> <label><?=$User?></label>
          </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item " method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
        </div>
        </div>
        </div>
      </div>

    </nav>
    <nav class="navbar navbar-expand   navbar-light justify-content nav-color" style="padding: 0px; background: #005eab;">
      <div class="container nav-space">
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="navbar-brand text-white font-weight-light"> <img style="width: 50px; height: 50px;"src="<?php echo PATH_PUBLIC ?>\img\adminis.png"> </a>
              <a class="navbar-brand font-weight-bold text-white" >DEPARTAMENTO DE RECURSOS MATERIALES</a>
            </li>
          </ul>

        </div>
      </div>

    </nav>
<div class="contentPage animate-des main">
  <br>

    <div class="container">
      <div class="container-fluid ">
        <div class="container-fluid border bg-white" id="container-fluid-pago">
          <div class="row justify-content-md-center">
            <div class="col-sm-12 alert-color">
                <img src="<?php echo PATH_PUBLIC ?>/img/general.png">
                <label class="font-weight-bold ">DATOS GENERALES DE REQUISICIONES </label>
            </div>
          </div>
          </div>
        </div>
        <br>
      <div class="row justify-content-md-center">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <a href="">
          </a>
          <div class="alert text-center text-white" style="background-color: rgb(255,117,020);">
            <img src="<?php echo PATH_PUBLIC ?>/img/listado.png">
            <br><br>
            <label class="h5"><b><?=$totalRequisicion ?> </b> <br> Total de Requisiciones Realizadas</label>
            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#ventana" data-model="Main" data-operation="" data-method="requested" data-concepto="Realizadas" data-name="Requisiciones Realizadas"><i class="fa fa-external-link fa-2x"></i></button>
          </div>
        </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="alert text-center text-white" style="background-color: rgb(38,194,129); opacity: 1;">
          <img src="<?php echo PATH_PUBLIC ?>/img/autorizacion.png">
            <br><br>
            <label class="h5"><b><?=$totalAutorizado?></b> <br> Requisiciones Autorizadas</label>
            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#ventana" data-model="Main" data-operation="" data-method="requested" data-concepto="Autorizadas" data-name="Requisiciones Autorizadas"><i class="fa fa-external-link fa-2x"></i></button>
         </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="alert text-center text-white" style="background-color: rgb(255, 0, 54);">
          <img src="<?php echo PATH_PUBLIC ?>/img/negado.png">
          <br><br>
          <label class="h5">&nbsp;<b><?=$totalNoAutorizado?></b> <br> Requisiciones no Autorizadas</label>
            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#ventana" data-model="Main" data-operation="" data-method="requested" data-concepto="NoAutorizadas" data-name="Requisiciones No Autorizadas"><i class="fa fa-external-link fa-2x"></i></button>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="alert text-center text-white" style="background-color:rgb(0, 148, 255); ">
          <img src="<?php echo PATH_PUBLIC ?>/img/sello.png">
          <br><br>
          <label class="h5"><b><?=$totalAtendida?></b> <br> Requisiciones Atendidas</label>
            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#ventana" data-model="Main" data-operation="" data-method="requested" data-concepto="Atendidas" data-name="Requisiciones Atendidas"><i class="fa fa-external-link fa-2x"></i></button>


        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid ">
      <div class="container-fluid border bg-white" id="container-fluid-pago">
        <div class="row justify-content-md-center">
          <div class="col-sm-12 alert-color">
            <img src="<?php echo PATH_PUBLIC ?>/img/notifity.png">
              <label class="font-weight-bold ">NOTIFICACIONES </label>
          </div>
        </div>
        </div>
      </div>
    <div class="container-fluid  ">
      <div class="container-fluid border" id="container-fluid-pago">

        <div class="table table-responsive-sm table-responsive-md small">
        <table class="table table-sm table-striped table-hover" id="table_id1">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" >#</th>
                <th scope="col" class="text-center">Descripción</th>
              </tr>
            </thead>
            <tbody  style="font-size: 12px;">
              <?php $n=1; foreach ($Foliorequisicion as $k) {
                    if($k['dato']<>'0'){ ?>
                      <tr>
                        <td class="h5 text-center" style="background: <?= ($n%2==0)?'#099cd2':'#26c281';  ?> ; font-family: Arial black;"> <?= $n++; ?> </td>
                        <td class="h5 text-center" ><?= $k['dato'] ?> </td>
                      </tr>
                <?php }
                  } ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <br><br>
    </div>
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
</main>
<footer class="page-footer" id="footer">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3" style="background: #f0f0f0; color: black;"> Copyright ITSSAT. ©2019 </div>
  <!-- Copyright -->

</footer>
<?php require_once SCRIPTS; ?>
</body>
</html>
