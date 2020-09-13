<?php
if ($_POST['method'] == 'Recover') {

 ?>
<form action = "<?php echo FOLDER_PATH ?>/Login/send" method = "post">
  <input type="hidden" name="key" value="<?php echo 'fant'; ?>"> 
   <div class="form-group row">
     <div class="col-sm-12">
       <label class="col-form-label">Usuario:</label>
        <input type="text" id="usaurio" name="usaurio" class="form-control" autocomplete="off" required>
    </div>
 </div>

 <div class="clearfix"></div><hr>
 <div class="form-group">
     <div class="col-sm-12 text-right">
       <button type="submit" class="btn btn-success btn-sm"><span class="icon-ok-circle">Enviar</span></button>
       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
     </div>
 </div>
</form>
<?php } ?>
