<?php
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
if ($_POST['method'] == 'requested') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Material/save" method = "post" onsubmit="return validarMaterial();">
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label">Concepto:</label>
      <input type="text" name="Concepto" id="Concepto" class="form-control" value="<?= $Concepto ?>" onkeyup="mayus(this);" autocomplete="off">
    </div>
 </div>
   <div class="row">
    <div class="col-sm-6">
       <div class="form-group row">
         <label class="col-sm-12 col-form-label">Unidad de medida:</label>
        <div class="col-sm-12">
          <input type="text" name="Medida" id="Medida" class="form-control" value="<?= $Medida ?>" onkeyup="mayus(this);" autocomplete="off">
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group row">
        <label class="col-sm-12 col-form-label">Precio:</label>
      <div class="col-sm-12">
        <input type="number" step="0.01" min="0" name="Precio" id="Precio" class="form-control" value="<?= $Precio ?>" autocomplete="off" placeholder="$" >
      </div>
      </div>
    </div>
  </div>
   <div class="form-group row">
   <label class="col-sm-12 col-form-label">Partida:</label>
   <div class="col-sm-12">
    <select name="Partida" id="Partida" class="form-control badge">
      <option value="0">Seleccione</option>
      <?php
      $partidas=new PartidasModel();
      $result=$partidas->getAll('Codigo');
      foreach ($result as $r) {?>
        <option value="<?=$r['IdPartida']?>"<?= ($r['Codigo']==$Partida) ? ' selected' : ''; ?>><?=$r['Codigo']?></option>
      <?php  }?>
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
<form action = "<?php echo FOLDER_PATH ?>/Material/remove" method = "post">
  <input type="hidden" name="id" value="<?= $Id; ?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label fa fa-exclamation-triangle"> ¿ <strong>Seguro que desa eliminar el registro: </strong><?= $concepto ?> ?</label>
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
}if ($_POST['method'] == 'Existencia') {
?>
<form action="<?php echo FOLDER_PATH?>/Material/addExistencia" method="post" onsubmit="return validaExistencia();">
  <input type="hidden" name="id" value="<?=$_POST['id']?>">
  <input type="hidden" name="function" value="<?=$_POST['function']?>">
  <input type="hidden" name="material" value="<?=$_POST['valorBoton']?>">
  <label class="col-form-label"> <strong style="font-size: 20px;">Material:</strong> <?=$_POST['valorBoton']?></label><br>
  <label class="col-form-label">Cantidad de material:</label>
  <input type="number" class="form-control" name="Existencia" id="Existencia" min="1">
  <hr>
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
                  <th scope="row"><?= $r["Concepto"]; ?></th>
                  <td><?= $r["Medida"]; ?></td>
                  <td style="text-align: right;"><?='$'.''. $r["Precio"]; ?></td>
                  <td><?= $r["Codigo"]; ?></td>
                  <td>
                    <center>
                      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill fa fa-pencil" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IDmaterial"] ?>" data-model="Material" data-operation="Editar" data-method="requested">
                      </button>
                    </center>
                  </td>
                  <td>
                    <center>
                      <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill fa fa-trash-o" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IDmaterial"] ?>" data-model="Material" data-operation="Eliminar" data-method="delete">
                      </button>
                    </center>
                  </td>
                </tr>
<?php
    }
  }else{
    ?>
    <br>
    <td colspan="6" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
    <?php
  }
}

?>
