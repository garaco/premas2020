<?php
require_once ROOT . FOLDER_PATH .'/app/Models/AreaModel.php';
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Departamento/save" method = "post" onsubmit="return validarDepartamento();">
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
 <div class="form-group row">
   <div class="col-sm-12">
     <label class="col-form-label ">Área:</label>
     <select class="form-control badge badge-default" name="area" id="area">
       <option value="0">SELECCIONE ÁREA</option>
        <?php
        $area = new AreaModel();
        $area=$area->getAll('IdArea');
           foreach ($area as $d) {?>
         <option value="<?=$d['IdArea']?>" <?= ($d['IdArea']==$codigo) ? ' selected' : ''; ?>> <?=utf8_encode($d['NombreArea'])?> </option>
       <?php
        }
        ?>
    </select>

    </div>
 </div>
 <div class="form-group row">
   <label class="col-sm-12 col-form-label">Departamento:</label>
   <div class="col-sm-12">
         <textarea class="col" name="nombreDepto" id="nombreDepto" rows="4" onkeyup="mayus(this);" ><?= $nombreDepto ?></textarea>
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
<form action = "<?php echo FOLDER_PATH ?>/Departamento/remove" method = "post">
  <input type="hidden" name="Id" value="<?= $Id; ?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label fa fa-exclamation-triangle"> ¿Seguro que desa eliminar el registro: <?= $nombreDepto ?> ?</label>
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
      static $count = 1;
?>
<tr>
  <th scope="row"><?= $count++;?></th>
  <td><?=$r['nombreDepto'] ?></td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["idDepart"] ?>" data-model="Departamento" data-operation="Editar" data-method="requested">
      <span class="icon-pencil"></span>
    </button>
  </td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["idDepart"] ?>" data-model="Departamento" data-operation="Eliminar" data-method="delete">
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
if ($_POST['method'] == 'pagination') {
  if ($result->num_rows>0) {
    foreach ($result as $r){
      static $count = 1;
?>
<tr>
  <th scope="row"><?= $count++;?></th>
  <td><?=$r['nombreDepto'] ?></td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["idDepart"] ?>" data-model="Departamento" data-operation="Editar" data-method="requested">
      <span class="icon-pencil"></span>
    </button>
  </td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["idDepart"] ?>" data-model="Departamento" data-operation="Eliminar" data-method="delete">
      <span class="icon-trash"></span>
    </button>
  </td>
</tr>
<?php
    }
  }
}
 ?>
