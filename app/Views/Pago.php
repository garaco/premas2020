<?php defined('BASEPATH') or exit('ERROR403'); ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SOLICITUDES DE PAGO</title>
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\siderbar.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\style.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\fontello\css\fontello.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\boostrap\css\bootstrap.min.css">
    <link rel="icon" type="image/png"  href="<?php echo PATH_PUBLIC ?>\img\logo1.png">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  </head>

  <body class="bg-light">
   <main> <!--  class="offset-sm-1 col-md-9" -->
    <nav class="navbar navbar-dark bg-primary">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand text-white icon-clipboard-1" >SOLICITUDES DE PAGO </a>
        </div>
        <div class="dropdown">
         <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
        <span class="caret"></span>Opciones
        </button>
          <div class="dropdown-menu">
              <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
          </div>
        </div>
      </div>
    </nav>
    <br>
    <!--  <div class="container-fluid border"> -->
      <div class="container-fluid ">
        <div  class="container-fluid border" id="container-fluid">
         <div class="row p-3">
           <div class="form-group col-sm-1" >
               <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ventana" style="float:right" data-id="0" data-model="Pago" data-operation="Agregar" data-method="requested">
                  <span class="icon-plus-circle">Agregar</span>
               </button>
           </div>
        </div>
       </div>
     </div>
     <div class="modal fade" data-backdrop="static" keyboard="false" id="ventana" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title text-white"> </h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
                 </div>
                  <!-- body de la venatan -->
                 <div class="modal-body">
              </div>
             </div>
           </div>
        </div>

    <div class="container-fluid">
        <!-- secion de tabla de datos  -->
      <div class="container-fluid border" id="container-fluid" >
        <br>
      <div class="table-wrapper-scroll-y ">
        <div class="table table-bordered table-responsive-sm table-responsive-md small" id="table">
          <table class="table table-sm table-striped table-hover">
            <thead class="thead-dark" >
              <tr>
                <th scope="col" class="text-center">Folio</th>
                <th scope="col" class="text-center" >Concepto</th>
                <th scope="col" class="text-center">Monto</th>
                <th scope="col" class="text-center">Revisado</th>
                <th scope="col" class="text-center">Firmado</th>
                <th scope="col" class="text-center">Autorizado a pagar</th>
                <th scope="col" class="text-center">Atendido</th>
                <th scope="col" class="text-center">Fecha de pago</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Comentario</th>
                <th scope="col" class="text-center">Editar</th>
              </tr>
          </thead>
        <tbody class="container-table" style="font-size: 12px;">
            <?php foreach ($result as $r){?>
            <tr>
              <th scope="row"><?= $r["Folio"]; ?></th>
              <td ><?= $r["Concepto"]; ?></td>
              <td class="text-right"><?= '$'.$r["Monto"]; ?></td>
              <td class="text-center"><?= $r["Revisado"]; ?></td>
              <td class="text-center"><?= $r["Firmado"]; ?></td>
              <td class="text-center"><?= $r["AutorizadoPago"]; ?></td>
              <td class="text-center"><?= $r["Atendido"]; ?></td>
              <td class="text-center"><?= $r["Fecha"]; ?></td>
              <td class="text-center"><?= $r["estado"]; ?></td>
              <td class="text-center"><?= $r["Comentario"]; ?></td>
              <td class="text-center">
                <center>
                <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Pago" data-operation="Editar" data-method="requested">
                  <span class="icon-pencil"></span>
                </button>
              </center></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<!-- </div> -->
</main>
</body>
  <script src="<?php echo PATH_PUBLIC ?>\jquery\jquery.min.js"> </script>
  <script src="<?php echo PATH_PUBLIC ?>\js\siderbar.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\js\request.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\boostrap\js\bootstrap.min.js"></script>

</html>
