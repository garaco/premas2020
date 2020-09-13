

<?php
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/AreaModel.php';


 if ($_POST['method'] == 'requested') {
?>

<form action = "<?php echo FOLDER_PATH ?>/Jefes/save" method = "post" onsubmit="return validarJefeArea();">
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-3">
      <label class="col-form-label">Sufijo:</label>

     <select class="form-control badge badge-default" name="subfijo" id="sufijo">
       <option value=" <?=$subfijo;?>"> <?=$subfijo;?></option>
       <option value="LIC.">LIC.</option>
       <option value="ING.">ING.</option>
       <option value="MTRA.">MTRA.</option>
       <option value="MTRO.">MTRO.</option>
       <option value="DOC.">DOC.</option>
     </select>
    </div>
    <div class="col-sm-9">
      <label class="col-form-label">Nombre:</label>
          <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $nombre ?>" onkeyup="mayus(this);" autocomplete="off">
    </div>
 </div>

   <div class="form-group row">
       <div class="col-sm-6">
      <label class="col-form-label">Apellido paterno:</label>
          <input type="text" name="paterno" id="paterno" class="form-control" value="<?= $paterno ?>" onkeyup="mayus(this);" autocomplete="off">
    </div>
       <div class="col-sm-6">
      <label class="col-form-label">Apellido materno:</label>
          <input type="text" name="materno" id="materno" class="form-control" value="<?= $materno ?>" onkeyup="mayus(this);" autocomplete="off" >
    </div>
 </div>

 <div class="form-group row ">
   <div class="col-sm-6">
     <label class="col-form-label ">Departamento:</label>
  <select class="form-control badge badge-default" name="departamento" id="departamento">
    <option value="0">Seleccione departamento</option>
        <?php
        $depa = new DepartamentoModel();
        $depa=$depa->getAll('idDepart');
           foreach ($depa as $d) {?>
         <option value="<?=$d['idDepart']?>" <?= ($d['idDepart']==$Iddep) ? ' selected' : ''; ?>> <?=$d['nombreDepto'];?> </option>
       <?php
        }
        ?>
        </select>

    </div>

   <div class="col-sm-6">
     <label class="col-form-label ">Área:</label>

        <select class="form-control badge badge-default" name="area" id="area">
          <option value="0">Seleccione área</option>
        <?php
        $area = new AreaModel();
        $area=$area->getAll('IdArea');
           foreach ($area as $a) {?>
         <option value="<?=$a['IdArea']?>" <?= ($a['IdArea']==$Idarea) ? ' selected' : ''; ?>> <?=($a['NombreArea'])?> </option>
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

if ($_POST['method'] == 'delete') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Jefes/remove" method = "post">
  <input type="hidden" name="id" value="<?=$Id;?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label font-weight-bold fa fa-exclamation-triangle"> ¿Seguro que desa eliminar a: <?= $subfijo .' '. $nombre .' '.$paterno.' '.$materno ?> ?</label>
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
      static $count = 1;
?>
<tr>
  <th scope="row"><?= $count++;?></th>
  <td><?=$r['Subfijo'].''.$r['Nombre'];?></td>
  <td><?=$r['A_paterno'];?></td>
  <td><?=$r['A_materno'];?></td>
  <td><?=($r['Departamento']);?></td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdJefe"] ?>" data-model="Jefes" data-operation="Editar" data-method="requested">
      <span class="icon-pencil"></span>
    </button>
  </td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdJefe"] ?>" data-model="Jefes" data-operation="Eliminar" data-method="delete">
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
          <td colspan="7" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
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
  <td><?=$r['Subfijo'].''.$r['Nombre'];?></td>
  <td><?=$r['A_paterno'];?></td>
  <td><?=$r['A_materno'];?></td>
  <td><?=($r['Departamento']);?></td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdJefe"] ?>" data-model="Jefes" data-operation="Editar" data-method="requested">
      <span class="icon-pencil"></span>
    </button>
  </td>
  <td class="text-center">
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdJefe"] ?>" data-model="Jefes" data-operation="Eliminar" data-method="delete">
      <span class="icon-trash"></span>
    </button>
  </td>
</tr>
<?php
    }
  }
}
 ?>
