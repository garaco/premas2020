<?php
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Proveedores/save" method = "post" onsubmit="return validarProveedor();">
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-7">
      <label class="col-form-label">Nombre:</label>
          <input type="text" name="Nombre" id="Nombre" class="form-control" value="<?= $Nombre ?>" onkeyup="mayus(this);" autocomplete="off">
    </div>
    <div class="col-sm-5">
      <label class="col-form-label">RFC:</label>
          <input type="text" name="RFC" id="RFC" class="form-control" value="<?= $RFC ?>" onkeyup="mayus(this);" autocomplete="off">
    </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-12">
     <label class="col-form-label">Domicilio:</label>
         <input type="text" name="Domicilio" id="Domicilio" class="form-control" value="<?= $Domicilio ?>" onkeyup="mayus(this);" autocomplete="off">
   </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-3">
     <label class="col-form-label">Teléfono:</label>
         <input type="tel" name="Telefono" id="Telefono" class="form-control" maxlength="10"  value="<?= $Telefono ?>" autocomplete="off">
   </div>
   <div class="col-sm-4">
     <label class="col-form-label">Email:</label>
         <input type="text" name="Email" id="Email" class="form-control" value="<?= $Email ?>" autocomplete="off">
   </div>
   <div class="col-sm-5">
     <label class="col-form-label">Servicio:</label>
         <input type="text" name="Servicio" id="Servicio" class="form-control" value="<?= $Servicio ?>" onkeyup="mayus(this);" autocomplete="off">
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
<?php
}
//Comparo si el metodo es igual a delete mando a la vista la parte de eliminar
if ($_POST['method'] == 'delete') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Proveedores/remove" method = "post">
  <input type="hidden" name="id" value="<?= $Id; ?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label fa fa-exclamation-triangle"> ¿Seguro que desa eliminar el registro: <?= $Nombre ?> ?</label>
    </div>
 </div>
 <div class="clearfix"></div><hr>
 <div class="form-group">
     <div class="col-sm-12 text-right">
       <button type="submit" class="btn btn-success"><span class="icon-ok-circle">Aceptar</span></button>
       <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
     </div>
 </div>
 </form>
<?php
}
if ($_POST['method'] == 'search') {
  if ($result->num_rows>0) {
    foreach ($result as $r){
?>
<tr>
  <th scope="row"><?= $r["Nombre"]; ?></th>
  <td><?= $r["RFC"]; ?></td>
  <td><?= $r["Domicilio"]; ?></td>
  <td><?= $r["Telefono"]; ?></td>
  <td><?= $r["Email"]; ?></td>
  <td><?= $r["ActComercial"]; ?></td>
  <td>
    <center>
      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdProveedor"] ?>" data-model="Proveedores" data-operation="Editar" data-method="requested">
        <span class="icon-pencil"></span>
      </button>
    </center>
  </td>
  <td>
    <center>
      <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdProveedor"] ?>" data-model="Proveedores" data-operation="Eliminar" data-method="delete">
        <span class="icon-trash"></span>
      </button>
    </center>
  </td>
</tr>
<?php
    }
  }else{
    ?>
    <br>
<!--     <tr>
          <td colspan="7" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr> -->
    <?php
  }
}
if ($_POST['method'] == 'pagination') {
  if ($result->num_rows>0) {
    foreach ($result as $r){
?>
<tr>
  <th scope="row"><?= $r["Nombre"]; ?></th>
  <td><?= $r["RFC"]; ?></td>
  <td><?= $r["Telefono"]; ?></td>
  <td><?= $r["Email"]; ?></td>
  <td><?= $r["ActComercial"]; ?></td>
  <td>
    <center>
      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdProveedor"] ?>" data-model="Proveedores" data-operation="Editar" data-method="requested">
        <span class="icon-pencil"></span>
      </button>
    </center>
  </td>
  <td>
    <center>
      <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdProveedor"] ?>" data-model="Proveedores" data-operation="Eliminar" data-method="delete">
        <span class="icon-trash"></span>
      </button>
    </center>
  </td>
</tr>
<?php
    }
  }
}
 ?>
