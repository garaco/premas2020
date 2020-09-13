<?php
require_once ROOT . FOLDER_PATH .'/app/Models/AreaModel.php';
require_once ROOT . FOLDER_PATH .'/app/Views/header.php'; ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
      <?php $header = new header();
        $header->PushHeader('Areas');
   ?>
</head>
  <body class="Colorpage" onload="myFunction()" style="margin:0;">

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
          <a class="navbar-brand font-weight-bold text-white" >LISTADO DE ÁREAS</a>
        </div>
        <div class="col-sm-6" >
            <label class="sr-only">Buscar</label>
            <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar" id="buscar" data-model="Area" autocomplete="off">
          </div>
        <div class="dropdown " data-toggle="tooltip" data-placement="top" title="Cerrar sesión">
         <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
        <span class="fa fa-user-circle"></span> <label><?=$User?></label>
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
            <label class="font-weight-bold">ALTA DE ÁREA</label>
        </div>
      </div>
        <div class="row">

          <!-- Button que manda a llamar la ventana modal -->
          <div class="form-group col-sm-1.5 p-3" >
            <!-- data-id="0" data-model="Partidas" data-operation="Agregar" data-method="requested" -->
            <!-- en el data-id se manda el id si es que se edita sino entonce se debe mandar 0-->
            <!-- en el data-model se debe mandar el nombre de la vista, en data-operation el tipo de operacion y en data-method el metodo al cual se va llamar-->
            <!-- esto se manda al archivo request.js -->
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Area" data-operation="Agregar" data-method="requested">
                 <span class="icon-plus-circle">Agregar</span>
              </button>
          </div>

        </div>
        <!-- INICIO DE FORMULARIO -->
            <!-- ventana Modal -->
            <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
              <div class="modal-dialog" role="document">
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
      <br>
        <!-- secion de tabla de datos  -->
      <div class="container border bg-white" >
        <br>
      <div class="row">
        <div class="col-sm-12">
          <label class=" form-control text-center font-weight-bold" style="border: white;">
            <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">LISTA DE ÁREAS</label>
        </div>
      </div>
      <hr style="border-color: green; margin: 0; padding: 5px;">
      <div class="table-wrapper-scroll-y">
        <div class="table table-responsive-sm table-responsive-md small">
          <table class="table table-sm table-striped table-hover" id="table_id1">
            <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Área</th>
                  <th scope="col">Responsable</th>
                  <th scope="col" class="text-center">Editar</th>
                  <th scope="col" class="text-center">Eliminar</th>
                </tr>
              </thead>
              <tbody class="container-table">
                <?php foreach ($result as $r){ ?>
                <tr>
                  <th scope="row"><?= $r["Num"]; ?></th>
                  <td><?= $r["NombreArea"]; ?></td>
                  <td><?= $r["jefe_responsable"]; ?></td>
                  <td>
                    <center>
                      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdArea"] ?>" data-model="Area" data-operation="Editar" data-method="requested">
                        <span class="icon-pencil"></span>
                      </button>
                    </center>
                  </td>
                  <td>
                    <center>
                      <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdArea"] ?>" data-model="Area" data-operation="Eliminar" data-method="delete">
                        <span class="icon-trash"></span>
                      </button>
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

    </div>

  </main>
  </body>
<?php require_once SCRIPTS; ?>
</html>
