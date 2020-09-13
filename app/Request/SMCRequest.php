<?php  
 require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
if ($_POST['method'] == 'requested') {
  if ($ID == '0') {
   $FechaReporte=DATE;
  }
?>
<!-- INICIO DE FORMULARIO -->
<form action="<?php echo FOLDER_PATH ?>/SMC/save" method="post" enctype="multipart/form-data" onsubmit="return validarSMC();" >
      <input type="Hidden" name="id" id="idHidden" value="<?= $ID; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
      <?php if ($tipoUser=="SuperAdmin") {
      ?>
      <div class="form-group row">

          <div class="col-sm-12">
              <label class="col-form-label">Estado:</label>
              <div class="row">
                <div class="col-sm-12">
                <input type="text" class="form-control bg-white"  name="Estatus" id="Estatus"> 
                </div>
              </div>
              
            </div>
          </div>     
      <?php } if ($tipoUser == "Admin") {
      ?>

      <div class="row">
        <div class="col-sm-6">
          <label class="col-form-label">Estado:</label>
          <select class="form-control bg-white" name="selectEB" id="selectEB" style="font-size: 12px;">
              <option value="<?= $Estado ?>" ><?= $Estado ?></option>
              <option value="AUTORIZADO">AUTORIZADO</option>
              <option value="NO AUTORIZADO" >NO AUTORIZADO</option>
              <option value="PENDIENTE" >PENDIENTE</option>
          </select>
        </div>
        <div class="col-sm-6">
          <label class="col-form-label">Fecha:</label>
          <input type="date" class="form-control bg-white" name="fechaAutorizacion" value="<?=$FechaAutorizacion?>">
        </div>
      </div>        
      

    <br>
    <label class="col-form-label">Comentario:</label>
    <textarea class="col" name="Comentario" rows="4" autocomplete="off"><?=$Comentario?></textarea>
      <?php }if($tipoUser=="SCM") {
      ?>
 <div class="form-group row">

          <div class="col-sm-4">
              <label class="col-form-label">N° de requisición:</label>
              <div class="row">
<!--                <div class="col-sm-4">
                  <input type="text" class="form-control bg-white" value="SMC" readonly="true" name="Nfolio">
                </div> -->
                <div class="col-sm-12">
                <input type="text" class="form-control bg-white"  name="smc" id="SMC" value="<?= $Foliosmc?>" readonly> 
                </div>
              </div>
              
            </div>
            <div class="col-sm-4">
              <label class="col-form-label">Fecha de recepción:</label>
              <input type="date" class="form-control bg-white" id="SMCfechaRecepcion" name="frecepcion" value="<?=$fechaRecepcion?>"  requiered>
            </div>
            <div class="col-sm-4">
              <label class="col-form-label">Fecha de captura:</label>
           <input type="date" class="form-control bg-white " id="SMCfechaReporte" name="freporte" value="<?= $FechaReporte ?>" readonly>
           </div>
         </div>

        <div class="form-group row">
      <div class="col-sm-6">
        <label class="col-form-label">Solicitante:</label>
        <select class="form-control badge bg-white"  name="jefe" id="SMCjefe" data-model="Requisicion">
          <option value="0" >Seleccione solicitante </option>
            <?php  $jefe = new JefesModel();
            $jefe= $jefe->getAll('IdJefe'); ?>
            <?php foreach ($jefe as $j) {?>

          <option  value="<?=$j['IdJefe']?>"  <?= ($j['IdJefe']==$IdSolicitante) ? ' selected' : ''; ?>> <?=utf8_encode($j['Nombre'].' '.$j['A_paterno'].' '.$j['A_materno'])?></option><?php }?>
        </select>
        </div>
        <div class="col-sm-6">
          <label class="col-form-label">Departamento:</label>
          <select class="form-control badge badge-default bg-white" name="departamento" id="SMCdepartamento" >
            <option value="0" >Seleccione departamento </option>
            <?php  $depa = new DepartamentoModel();
            $depa= $depa->getAll('idDepart');?>
            <?php foreach ($depa as $d) {?>
            <option value="<?=$d['idDepart']?>" <?= ($d['idDepart']==$IdDep) ? ' selected' : ''; ?>> <?=utf8_encode($d['nombreDepto'])?></option>
            <?php }?>
          </select>
         </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <label class="col-form-label">Descripción del Servicio Solicitado o Falla a Reparar:</label>
            <br>
            <textarea cols="90" rows="2" name="concepto" id="SMCconcepto" autocomplete="off"" ><?= $Concepto ?></textarea>
           <!-- <input type="text" class="form-control bg-white" id="concepto"  name="concepto" value="<?= $Concepto ?>" requiered autocomplete="off"> -->
          </div>
           </div>
          <div class="form-group row">
           <div class="col-sm-12">
            <label class="col-form-label">Subir archivo:</label>
             <!-- <input type="file" accept="application/PDF" class="form-control bg-white" id="archivo" name="archivo" value="<?= $Archivo ?>"> -->
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroupFileAddon01">Subir</span>
  </div>
  <div class="custom-file">
    <!-- <input type="file" class="custom-file-input" id="inputGroupFile01"
      aria-describedby="inputGroupFileAddon01"> -->
      <input type="file" accept="application/PDF" class="custom-file-input" id="archivo"  name="archivo" aria-describedby="inputGroupFileAddon01">
    <label class="custom-file-label" for="archivo">Elija el archivo</label>
  </div>
</div>
          </div>
         </div>

<?php } ?>
         <div class="clearfix"></div><hr>
            <div class="form-group ">
               <div class="col-sm-12 text-right ">
                 <button type="submit" class="btn btn-success btn-sm"><span class="icon-ok-circle">Guardar</span></button>
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
               </div>
        </div>

</form>

<?php }
if($_POST['method'] == 'pagination'){
  foreach ($result as $r){
?>
  <tr>
                <th scope="row"><?=  $r["Foliorequisicion"]; ?></th>
                <td><?= $r["FechaRecepcion"]; ?></td>
                <td><?= $r["FechaReporte"]; ?></td>
                <td><?= utf8_encode($r["nombreDepto"]);?></td>
                <td><?= $r['Subfijo'].''.$r['Nombre'].' '.$r['A_paterno'].' '.$r['A_materno'] ;?></td>
                <td class="small text-justify"><?= $r["Concepto"];?></td>
                <td class="text-justify"><?= $r["Comentario"];?></td>
                <td>
                  
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/SMC/show" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
                      </button>
                    </form>
                  </center>
         
                  
                </td>
                <td>
                  <?php if ($r["Estatus"]=='ATENDIDA') {?>
                    <center>
                      <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill">
                        <span class="icon-pencil"></span>
                      </button>
                    </center>

                  <?php } else{ ?>
                  <center>
                    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" i
                    id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="SMC" data-operation="Editar" data-method="requested" >
                      <span class="icon-pencil"></span>
                    </button>
                  </center>
               <?php  }
                  ?>
                </td>
  </tr>
  <?php
  }
}
?>