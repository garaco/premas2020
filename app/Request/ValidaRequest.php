<?php
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/ProyectoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MetasModel.php';
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
?>
<form action = "<?php echo FOLDER_PATH ?>/Valida/save" method = "post">
  <input type="hidden" name="id" value="<?= $_POST['id']; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label">Departamento</label>
      <select class="form-control badge badge-default bg-white" name="departamento">
        <?php if($_POST['id']!=0){ ?> <option value="<?=$IdDep;?>"> <?=utf8_encode($Departamento);?></option> <?php }
        $depa = new DepartamentoModel();
        $depa= $depa->getAll('IdArea');
        foreach ($depa as $d) {?>
        <option value="<?=$d['idDepart'];?>"> <?=utf8_encode($d['nombreDepto']);?> </option>
        <?php }?>
      </select>
    </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-12">
     <label class="col-sm-12 col-form-label">Meta</label>
     <select class="form-control badge badge-default bg-white" name="metas" >
       <?php if($_POST['id']!=0){ ?> <option value="<?=$IdMeta;?>"> <?=utf8_encode($Meta);?> </option> <?php }
       $meta = new MetasModel();
       $meta= $meta->getAll('IdMetas');
       foreach ($meta as $d) {?>
       <option value="<?=$d['IdMetas'];?>"> <?=utf8_encode($d['Concepto']);?></option>
     <?php } ?>
     </select>
   </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-12">
     <label class="col-sm-12 col-form-label">Proyecto</label>
     <select class="form-control badge badge-default bg-white" name="proyecto" >
       <?php if($_POST['id']!=0){ ?> <option value="<?=$IdPro;?>"> <?=utf8_encode($Proyecto);?> </option> <?php }
       $proyecto = new ProyectoModel();
       $proyecto= $proyecto->getAll('IdProyecto');
        foreach ($proyecto as $d) {?>
       <option value="<?=$d['IdProyecto'];?>"> <?=utf8_encode($d['Concepto']);?></option>
       <?php }?>
     </select>
   </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-12">
     <label class="col-sm-12 col-form-label">Año</label>
     <select class="form-control" name="anio">
       <?php if($_POST['id']!=0){ ?> <option value="<?=$year;?>"> <?=$year;?> </option> <?php } ?>
       <option value="<?=date('Y'); ?>"> Año <?= date('Y'); ?></option>
       <option value="<?=date('Y')+1; ?>"> Año <?= date('Y')+1 ?></option>
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
<form action = "<?php echo FOLDER_PATH ?>/Valida/remove" method = "post">
  <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label ">  <?= ucwords(strtolower('se eliminara: '.$Departamento.' con mata'.$Meta.' y proyecto '.$Proyecto.' del año '.$year)); ?> </label>
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

 ?>
