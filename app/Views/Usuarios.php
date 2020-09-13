<?php defined('BASEPATH') or exit('ERROR403');
require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
<?php
        $header = new header();
        $header->PushHeader('Usuarios');
?>
  </head>

  <body class="Colorpage"  onload="myFunction()" style="margin:0;">

    <!-- loader -->
    <div id="loader"></div>
    <!-- end loader -->
  <main id="wrapper">
     <?php require_once SIDERBAR; ?>
     <div id="page-content-wrapper">
      <nav class="navbar navbar-dark colornavbar">
        <div class="container-fluid">
          <div class="navbar-header">
            <label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
            <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
            <a class="navbar-brand font-weight-bold text-white" >USUARIOS</a>
          </div>
          <div class="dropdown ">
            <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
           <span class="fa fa-user-circle"></span> <label > <?=$User?></label>
           </button>
          <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
          </div>
          </div>
        </div>
      </nav>
    <div class="contentPage animate-des main">

      <br>
      <div class="container border bg-white">
        <div class="row justify-content-md-center">
          <div class="col-sm-12 alert-color">
            <img src="<?php echo PATH_PUBLIC ?>/img/add.png">
              <label class="font-weight-bold">ALTA DE USUARIOS</label>
          </div>
        </div>
        <div class="row">

            <div class="form-group col-sm-1.5 p-3" >

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Usuarios" data-operation="Agregar" data-method="requested">
                   <span class="icon-plus-circle">Agregar</span>
                </button>
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
            </div>
          <!-- </div> -->
        </div>

      </div>

      <br>
      <div class="container border bg-white">
        <div class="row justify-content-md-center">
          <div class="col-sm-12">
            <label class=" form-control text-center font-weight-bold" style="border: white;">
              <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">LISTA DE USUARIOS</label>
          </div>
        </div>
        <hr style="border-color: green; margin: 0; padding: 5px;">
          <br>
          <!-- secion de tabla de datos  -->
          <div class="table-wrapper-scroll-y">
            <div class="table table-responsive-sm table-responsive-md small" id="table">
              <table class="table table-sm table-striped table-hover" id="table_id1">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nombre del Usuario</th>
                    <th scope="col">Apellidos del usuario</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Editar</th>
                  </tr>
                </thead>
                <tbody class="container-table" style="font-size: 12px;">
                  <?php foreach ($result as $r){ ?>
                  <tr>
                    <th scope="row"><?= $r["Nombre_User"]; ?></th>
                    <td><?= $r["Apellidos_User"]; ?></td>
                    <td><?= $r["Usuario"]; ?></td>
                    <td><?= $r["Correo"]; ?></td>
                    <td><?= $r["dep"]; ?></td>
                    <td><center><button type="button" class="btn btn btn-outline-primary btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdUsuario"] ?>" data-model="Usuarios" data-operation="Editar" data-method="requested">
                          <span class="icon-pencil"></span></button></center></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
  </div>
  </div>
    </div>

  </main>
</body>
<?php require_once SCRIPTS; ?>
</html>
