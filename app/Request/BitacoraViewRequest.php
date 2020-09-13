<?php

if ($_POST['method'] == 'search') {
  if ($result->num_rows>0) {
    foreach ($result as $r){
?>
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
<?php
    }
  }else{
    ?>
    <br>
      <tr>
          <td colspan="10" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr>
 <?php
  }
}
if ($_POST['method'] == 'CambiarUserPass') {?>
<form action="<?php echo FOLDER_PATH ?>/BitacoraView/UpdateUserPass" method="POST" onsubmit="return validarUserPass();">
      <label><strong>Usuario anterior:</strong></label>
       <div class="form-group row">
          <div class="col-sm-1">
            <span class="fa fa-user fa-2x"></span>
          </div>
          <div class="col-sm-11">
          <input type="text" name="UserActual" id="userActual" class="form-control" autocomplete="off" placeholder="Usuario">
          </div>
         </div>
         <br><hr><br>
      <label><strong>Nuevo Usuario y Password:</strong></label>
       <div class="form-group row">
          <div class="col-sm-1">
            <span class="fa fa-user fa-2x"></span>
          </div>
          <div class="col-sm-11">
          <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="Usuario">
          </div>
         </div>
      <div class="form-group row">
          <div class="col-sm-1">
            <span class="fa fa-lock fa-2x"></span>
          </div>
          <div class="col-sm-11">
           <input type="text" name="password" id="password" class="form-control"  autocomplete="off" placeholder="Password">
          </div>
         </div>
    <div class="clearfix"></div><hr>
      <div class="form-group">
        <div class="col-sm-12 text-right">
          <button type="submit" class="btn btn-success btn-sm"><span class="icon-ok-circle">Guardar</span></button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
        </div>
      </div>
   </form>
<?php }
if($_POST['method'] == 'pagination'){
   foreach ($result as $r){
?>
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
<?php
}
}
?>