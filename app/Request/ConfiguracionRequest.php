<?php
require_once ROOT . FOLDER_PATH .'/app/Models/ConfiguracionModel.php';
if ($_POST['method'] == 'requested') {
  $conf = new ConfiguracionModel();
  if($_POST['id']!=0){
    $conf=$conf->getId('IdConfiguracion',$_POST['id']);
  }
?>
<form action = "<?php echo FOLDER_PATH ?>/Configuracion/save" method = "post" >
  <input type="hidden" name="id" value="<?= $_POST['id']; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
  <div class="form-group row">
    <div class="col-sm-6">
      <label class="col-form-label">Opci&oacuten:</label>
          <select class="form-control" name="Anio">
            <option value="<?=date('Y'); ?>">Programa anual de requisicion del año <?= date('Y'); ?></option>
            <option value="<?=date('Y')+1; ?>">Programa anual de requisicion del año <?= date('Y')+1 ?></option>
          </select>
    </div>
    <div class="col-sm-6">
      <label class="col-form-label">Descripci&oacuten:</label>
          <input type="text" name="des" id="des" class="form-control" value="<?= utf8_encode($conf->Descripcion)  ?>" autocomplete="off" required>
    </div>
 </div>
 <div class="form-group row">
   <div class="col-sm-6">
          <label class="col-sm-6 col-form-label">Fecha Inicio:</label>
         <input type="Date" name="Inicio" id="Inicio" class="form-control" value="<?= $conf->FechaInicio; ?>" autocomplete="off" required>
   </div>
   <div class="col-sm-6">
          <label class="col-sm-6 col-form-label">Fecha Final:</label>
         <input type="Date" name="Final" id="Final" class="form-control" value="<?= $conf->FechaFinal; ?>" autocomplete="off" required>
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
  }else if ($_POST['method'] == 'Importar') {
    ?>
    <form action = "<?php echo FOLDER_PATH ?>/Configuracion/Import" method = "post" enctype="multipart/form-data" onsubmit="return validarsql('btn1','btn2');">
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label">Subir archivo:</label>
              <input type="file" class="form-control"  accept=".sql" name="db" autocomplete="off" required>
        </div>
     </div>

     <div class="clearfix"></div><hr>
     <div class="form-group">
         <div class="col-sm-12 text-right">
           <button type="submit" id="btn1" class="btn btn-success btn-sm"><span class="icon-ok-circle">Aceptar</span></button>
           <button type="button" id="btn2" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
         </div>
     </div>
    </form>
  <?php
}else if ($_POST['method'] == 'Exportar') {
    ?>
    <form action = "<?php echo FOLDER_PATH ?>/Configuracion/ExportExc" method = "post">
      <div class="form-group row">
        <div class="col-sm-3">
          <label class="col-form-label">Seleccione catalogo:</label>
        </div>
        <div class="col-sm-8">
              <select class="form-control" name="exportar">
                <option value="materiales">Catalogo de Materiales</option>
                <option value="partidas">Partidas Presupuestales</option>
                <option value="metas">metas</option>
                <option value="proyecto">proyectos</option>
                <option value="proveedores">proveerdor</option>
                <option value="departamento">departamento</option>
                <option value="jefe_area">Jefes de &Aacuterea</option>
              </select>
        </div>
     </div>

     <div class="clearfix"></div><hr>
     <div class="form-group">
         <div class="col-sm-12 text-right">
           <button type="submit" id="btn1" class="btn btn-success btn-sm"><span class="icon-ok-circle">Aceptar</span></button>
           <button type="button" id="btn2" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
         </div>
     </div>
    </form>
  <?php
}else if ($_POST['method'] == 'Subir') {
      ?>
      <form action = "<?php echo FOLDER_PATH ?>/Configuracion/ImportExc" method = "post" enctype="multipart/form-data" onsubmit="return validarsql('btn1','btn2');">
        <div class="form-group row">
          <div class="col-sm-6">
            <label class="col-form-label">Seleccione catalogo:</label>
                <select class="form-control" name="importa">
                  <option value="materiales">Catalogo de Materiales</option>
                  <option value="partidas">Partidas Presupuestales</option>
                  <option value="metas">metas</option>
                  <option value="proyecto">proyectos</option>
                  <option value="proveedores">proveerdor</option>
                  <option value="departamento">departamento</option>
                  <option value="jefe_area">Jefes de &Aacuterea</option>
                </select>
          </div>
          <div class="col-sm-6">
            <label class="col-form-label">Subir archivo:</label>
            <input type="file" class="form-control"  accept=".xls,.xlsm, xlsx" name="archivo" autocomplete="off" required>
          </div>
       </div>

       <div class="clearfix"></div><hr>
       <div class="form-group">
           <div class="col-sm-12 text-right">
             <button type="submit" id="btn1" class="btn btn-success btn-sm"><span class="icon-ok-circle">Aceptar</span></button>
             <button type="button" id="btn2" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
           </div>
       </div>
      </form>
    <?php
}
