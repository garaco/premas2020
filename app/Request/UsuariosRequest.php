<?php
 require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/UsuariosModel.php';

if ($_POST['method'] == 'requested') {
 ?>
<form action = "<?php echo FOLDER_PATH ?>/Usuarios/save" method = "post" onsubmit="return validaUsuario();">
  <input type="hidden" name="id" value="<?= $ID; ?>"> <!-- es un campo invisible que sirve para mandar el id-->

  <div class="form-group row">
      <div class="col-sm-12">
      <label class="col-form-label ">Usuario:</label>
  <select class="form-control badge" name="Usuario" id="Usuario">
    <?php if ($_POST['id']!=0){ ?>
      <option value="<?= $Nombre_User.'-'.$Apellidos_User ?>"> <?= $Nombre_User ?> </option>
  <?php } else { ?>
      <option value="0">Seleccione Usuario</option>
    <?php
  }
    $departamento = new JefesModel();
    $jefe_depa = $departamento->getAll('IdArea');
     $US = new UsuariosModel();
     $Usuarios = $US->getJoinAll();
     $boleanJefe=false;
     foreach ($jefe_depa as $j_a) {
      $Nombre_User=$j_a['Subfijo'].$j_a['Nombre'];
      $Apellidos_User=$j_a['A_paterno'].' '.$j_a['A_materno'];
     ?>
     <option value="<?=$Nombre_User.'-'.$Apellidos_User?>" <?=($boleanJefe)?'disabled="disabled"style="background-color:gray; color: white;"':'';?> > <?=$Nombre_User.' '.$Apellidos_User;?> </option>
       <?php
        $boleanJefe=false;
     }
     ?>
       </select>
     </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-12">

   </div>
 </div>
 <div class="form-group row">
 	 <div class="col-sm-6">
     <label class="col-form-label ">Departamento:</label>
  <select class="form-control badge" name="departamento" id="departamento">
    <?php if ($_POST['id']<>0){ ?>
      <option value="<?= $IdDep ?>"><?= $Dep ?></option>
  <?php }
        $depa = new DepartamentoModel();
        $depa=$depa->getAll('idArea');
           foreach ($depa as $d) {
             ?>
         <option value="<?=$d['idDepart']?>"> <?=$d['nombreDepto'];?> </option>
       <?php
            }
        ?>
        </select>
    </div>
     <div class="col-sm-6">
      <label class="col-form-label">Tipo de Usuario:</label>
       <select class="form-control badge" name="area" id="area">
         <?php if ($_POST['id']<>0){
           switch ($Area) {
             case 'Normal':
               $data='REQUISICIONE y P.A.A.';
               break;
             case 'SCM':
               $data='MANTENIMIENTO';
               break;
             case 'Asigna':
               $data='ASIGNACION DE METAS Y PARTIDAS';
               break;
             case 'SuperAdmin':
               $data='ADMINISTRADOR';
               break;
             case 'Admin':
               $data='ADMINISTRADOR/DIRECTOR';
               break;
           }
           ?>
           <option value="<?= $Area ?>"><?= $data ?></option>
       <?php } ?>
        <option value="Normal">REQUISICIONE y P.A.A. </option>
        <option value="SCM">MANTENIMIENTO</option>
        <option value="Asigna">ASIGNACION DE METAS Y PARTIDAS</option>
        <option value="SuperAdmin">ADMINISTRADOR</option>
        <option value="Admin">ADMINISTRADOR/DIRECTOR</option>
       </select>
    </div>
 </div>
 <div class="form-group row">
  <div class="col-sm-6">
          <label class="col-form-label">Nombre de Usuario:</label>
          <input type="text" class="form-control" name="N_usuario" id="N_usuario"  value="<?= $Usuario  ?>" placeholder="Usuario" autocomplete="off" required>
  </div>
    <div class="col-sm-6">
          <label class="col-form-label">Correo Electronico:</label>
          <input type="email" class="form-control" name="mail" id="mail"  value="<?= $Mail ?>" placeholder="Ejemplo@gmail.com" autocomplete="off" required>
  </div>
 </div>
 <div class="form-group row">
 	<div class="col-sm-6">
 	     <label class="col-form-label">Contraseña:</label>
    <div class="input-group-append">
         <input type="password" name="password" id="password" class="form-control" value="<?= $Password ?>" autocomplete="off">
         <button type="button" name="button" class="btn btn-primary" onclick="mostrarContrasena()" ><span class="fa fa-eye icon"></span></button>
    </div>
 	</div>
 	  <div class="col-sm-6">
       <label class="col-form-label">Confirmar Contraseña:</label>
    <div class="input-group-append">
         <input type="password" name="password_alt" id="password_alt" class="form-control" value="<?= $Password ?>" autocomplete="off">
         <button type="button" name="button" class="btn btn-primary" onclick="mostrarPass()" ><span class="fa fa-eye icon2"></span></button>
    </div>
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
 } if ($_POST['method'] == 'delete') {
  ?>
  <form action = "<?php echo FOLDER_PATH ?>/Usuarios/remove" method = "post">
  <input type="hidden" name="id" value="<?= $ID; ?>">
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="col-form-label "><span class="fa fa-exclamation-triangle fa-2x" style="color: orange;"></span>  ¿Seguro que desa eliminar el usuario: <strong><?= $Usuario ?></strong>, que pertenece a <strong><?=$Nombre_User?> <?=$Apellidos_User?></strong>?</label>
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
