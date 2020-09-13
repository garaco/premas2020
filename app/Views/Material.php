<?php
 require_once ROOT . FOLDER_PATH .'/app/Views/header.php'; ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <?php
        $header = new header();
        $header->PushHeader('MATERIAL');
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
             <a class="navbar-brand font-weight-bold text-white" >MATERIALES</a>
           </div>
           <div class="col-sm-6" >
               <label class="sr-only">Buscar</label>
               <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar" id="buscar" data-model="Material" autocomplete="off">
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
              <label class="font-weight-bold">ALTA DE MATERIALES</label>
          </div>
        </div>
        <div class="row form-group">

            <div class="col-sm-2" ><br>

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" data-id="0" data-model="Material" data-operation="Agregar" data-method="requested">
                   <span class="icon-plus-circle">NUEVO MATERIAL</span>
                </button>
            </div>

            <div class="col-sm-4 text-right" >
              <br>

            </div>
            <div class="col-sm-4">
              <form action="<?php echo FOLDER_PATH?>/Material/PDF" method="POST">
              <div class="row" style="display: none;" id="RangoFecha">

                <div class="col-sm-6" ><br>
                  Desde: <input type="date" class="form-control form-control-sm" name="">
                </div>
                <div class="col-sm-6"><br>
                  Hasta: <input type="date" class="form-control form-control-sm" name=""><br>
                  <button type="submit" class="btn btn-sm btn-success" id="button" style="float: right; display: none;">Exportar</button>
                </div>
                </div>

                <div class="row" id="existencia"  style="display: none;">
                  <div class="col-sm-12"><br>
                   <select id="Selectexistencia" class="badge" >
                    <option value="0">Seleccione</option>
                    <option value="1">Todo</option>
                    <option value="2">Fecha</option>

                </select>
                  </div>

                </div>

                <div class="row" style="display: none;" id="Fecha">
                <div class="col-sm-6" ><br>
                  Desde: <input type="date" class="form-control form-control-sm" name="">
                </div>
                <div class="col-sm-6"><br>
                  Hasta: <input type="date" class="form-control form-control-sm" name=""><br>
                  <button type="submit" class="btn btn-sm btn-success" style="float: right;">Exportar</button>
                </div>
                </div>

  </form>
              </div>


            </div>

          <!-- </div> -->
        </div>

      <br>
      <div class="container border bg-white" >

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

        <div class="row justify-content-md-center">
          <div class="col-sm-12">
            <label class=" form-control text-center font-weight-bold" style="border: white;">
              <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">LISTA DE MATERIALES</label>
          </div>
        </div>
        <hr style="border-color: green; margin: 0; padding: 5px;">
        <br>
          <!-- secion de tabla de datos  -->
          <div class="table-wrapper-scroll-y">
            <div class="table table-responsive-sm table-responsive-md small" >
              <table class="table table-sm table-striped table-hover" id="table_id1">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Concepto</th>
                    <th scope="col" class="text-center">Unidad de Medida</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Partida</th>
                    <th scope="col" colspan="" class="text-center">Acción</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="container-table" style="font-size: 12px;">
                  <?php foreach ($result as $r){ ?>
                  <tr>
                    <th scope="row"><?= $r["Concepto"]; ?></th>
                    <td class="text-center"><?= $r["Medida"]; ?></td>
                    <td style="text-align: right;"><?='$'. $r["Precio"]; ?></td>
                    <td><?= $r["Codigo"]; ?></td>

                    <td>
                      <center>
                        <button type="button" class="btn btn-outline-info btn-sm badge badge-pill fa fa-pencil" data-toggle="modal" data-target="#ventana" data-id="<?= $r['IDmaterial'] ?>" data-model="Material" data-operation="Editar" data-method="requested">
                        </button>
                      </center>

                    </td>
                    <td>
                      <center>
                        <button type="button" class="btn btn-outline-danger btn-sm badge badge-pill fa fa-trash-o" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IDmaterial"] ?>" data-model="Material" data-operation="Eliminar" data-method="delete">
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

        <br>
  </div>
    </div>

  </main>
</body>
<?php require_once SCRIPTS; ?>

</html>
