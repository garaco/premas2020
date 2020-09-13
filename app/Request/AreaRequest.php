<?php
require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Area/save" method = "post" onsubmit="return validarArea();">
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label">Código:</label>
          <input type="number" name="codigo" id="codigo" min="1" class="form-control" value="<?= $codigo ?>" autocomplete="off">
    </div>
 </div>
 <div class="form-group row">
   <label class="col-sm-12 col-form-label">Área:</label>
   <div class="col-sm-12">
         <input type="text" name="NombreArea" id="NombreArea" class="form-control" value="<?= $NombreArea ?>" onkeyup="mayus(this);" autocomplete="off">
   </div>
 </div>
  <div class="form-group row">
   <label class="col-sm-12 col-form-label">Responsable:</label>
   <?php
    $jefe = new JefesModel();
    $alljefes= $jefe->getAll('IdJefe');
   ?>
   <div class="col-sm-12">
         <select class="form-control form-control-sm" id="resposable" name="responsable">
           <option value="-1">Seleccione</option>
           <?php
           foreach ($alljefes as $value) {
           ?>
            <option <?= ($responsable == $value['IdJefe'])?'selected':'' ?> value="<?= $value['IdJefe']?>"><?= $value['Subfijo'].$value['Nombre'].' '.$value['A_paterno'].' '.$value['A_materno']?></option>
           <?php
            }
           ?>
         </select>
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
<form action = "<?php echo FOLDER_PATH ?>/Area/remove" method = "post">
  <input type="hidden" name="Id" value="<?= $Id; ?>">
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
  <td><?=($r['NombreArea']) ?></td>
  <td><?= $r["jefe_responsable"]; ?></td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdArea"] ?>" data-model="Partidas" data-operation="Editar" data-method="requested">
      <span class="icon-pencil"></span>
    </button>
  </td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdArea"] ?>" data-model="Partidas" data-operation="Eliminar" data-method="delete">
      <span class="icon-trash"></span>
    </button>
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
 ?>
