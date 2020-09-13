<?php
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Metas/save" method = "post" onsubmit="return validar();">
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label">Codigo:</label>
          <input type="text" name="codigo" class="form-control" id="codigo" min="1" value="<?= $codigo ?>"autocomplete="off">
    </div>
 </div>
 <div class="form-group row">
   <label class="col-sm-12 col-form-label">Concepto:</label>
   <div class="col-sm-12">
     <textarea class="col" name="concepto" id="concepto" rows="4" autocomplete="off" onkeyup="mayus(this);"><?= $concepto ?></textarea>
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
<form action = "<?php echo FOLDER_PATH ?>/Metas/remove" method = "post">
  <input type="hidden" name="id" value="<?= $Id; ?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label fa fa-exclamation-triangle"> ¿Seguro que desa eliminar el registro: <?= $codigo ?> ?</label>
    </div>
 </div>
 <div class="clearfix"></div><hr>
 <div class="form-group">
     <div class="col-sm-12 text-right">
       <button type="submit" class="btn btn-success btn-sm"><span class="icon-ok-circle">Aceptar</span></button>
       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
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
  <th scope="row"><?= $r["Num"]; ?></th>
  <td><?= $r["Concepto"]; ?></td>
  <td>
    <center>
      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdMetas"] ?>" data-model="Metas" data-operation="Editar" data-method="requested">
        <span class="icon-pencil"></span>
      </button>
    </center>
  </td>
  <td>
    <center>
      <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdMetas"] ?>" data-model="Metas" data-operation="Eliminar" data-method="delete">
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
    <tr>
          <td colspan="4" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr>
    <?php
  }
}
if ($_POST['method'] == 'pagination') {
  if ($result->num_rows>0) {
    foreach ($result as $r){
 ?>

<tr>
  <th scope="row"><?= $r["Num"]; ?></th>
  <td><?= $r["Concepto"]; ?></td>
  <td>
    <center>
    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdMetas"] ?>" data-model="Metas" data-operation="Editar" data-method="requested">
      <span class="icon-pencil"></span>
    </button>
  </center>
  </td>
  <td>
    <center>
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdMetas"] ?>" data-model="Metas" data-operation="Eliminar" data-method="delete">
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
