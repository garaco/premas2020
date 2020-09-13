<?php defined('BASEPATH') or exit('ERROR403');
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gestión de Requisiciones</title>
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\siderbar.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\css\style.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\fontello\css\fontello.css">
    <link rel="stylesheet" href="<?php echo PATH_PUBLIC ?>\boostrap\css\bootstrap.min.css">
    <link rel="icon" type="image/png"  href="<?php echo PATH_PUBLIC ?>\img\logo1.png">
    <link href="<?php echo PATH_PUBLIC ?>\css\prints.css" rel="stylesheet" type="text/css" media="print">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  </head>
  <nav class="navbar navbar-dark bg-primary">
    <div class="container">
      <div class="navbar-header">
        <label></label>
        <a class="navbar-brand text-white icon-clipboard-1"> REQUISICIONES DE BIENES Y SERVICIOS </a>
      </div>
      <nav class="navbar navbar-expand-sm bg-primary justify-content-center">
        <div class="dropdown">
         <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
        <span class="caret"></span>Opciones
        </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" data-method="Atendida" ><span class="icon-logout"> Cerrar sesión</span></a>
          </div>
        </div>
    </nav>
    </div>
  </nav>
  <br>
  </div>


  <body>
    <br>
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
                <th scope="col" class="text-center">Departamento</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Fecha Autorizado</th>
                <th scope="col" class="text-center">Fecha Atendido</th>
                <th scope="col" class="text-center">Estatus</th>
              </tr>
            </thead>
            <tbody class="container-table">
              <?php
              foreach ($result as $r) {?>
              <tr>
                <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
                <td class="text-right" > <?= '$'.$r["Costo"];?></td>
                <td class="small text-justify"><?= $r["Concepto"]; ?> </td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td><?= $r["nombreDepto"];?></td>
                <td class="text-center"><?= $r["Estado"];?></td>
                <td class="text-center"><?= $r["FechaAutorizacion"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td class="text-justify"><?= $r["Estatus"]; ?> </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="text-center">
      <nav aria-label="Paginación" id="pag-nav">
          <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item disabled" >
                 <a href="#" class="pag page-link" id="pag-prev" data-page="1" data-cont="<?= $cant ?>" data-reg="20" data-model="RequisicionView">
                     <span aria-hidden="true">&laquo;</span>
                 </a>
             </li>
               <?php for($i = 1; $i <= $pag; $i++){?>
                 <li class="page-item">
                    <a href="#" class="pag page-link" data-page="<?= $i ?>" data-cont="<?= $cant ?>" data-reg="20" data-model="RequisicionView">
                        <?=$i;?>
                    </a>
                 </li>
                <?php } ?>
              <li class="page-item disabled">
                  <a href="#" class="pag page-link" id="pag-next" data-page="<?= $pag ?>" data-cont="<?= $cant ?>" data-reg="20" data-model="RequisicionView">
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
  <script src="<?php echo PATH_PUBLIC ?>\jquery\jquery.min.js"> </script>
  <script src="<?php echo PATH_PUBLIC ?>\js\siderbar.js"></script>
  <script src="<?php echo PATH_PUBLIC ?>\js\request.js"></script>

  <script src="<?php echo PATH_PUBLIC ?>\boostrap\js\bootstrap.min.js"></script>

</html>
