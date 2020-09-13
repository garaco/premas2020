<?php
 require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';

// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
?>
<!-- INICIO DE FORMULARIO -->
<form action="<?php echo FOLDER_PATH ?>/Solicitud/save" method="post" onsubmit="return validarSolPa();" >
      <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label">Proveedor:</label>
          <input type="text" class="form-control"  name="proveedor" id="proveedor" value="<?=$Proveedor?>" autocomplete="off" requiered autofocus >
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label">Concepto:</label>
          <input type="text" class="form-control"  name="SPconcepto" id="SPconcepto" value="<?=$Concepto?>" autocomplete="off" requiered>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-4">
          <label class="col-form-label">Monto:</label>
          <input type="number" step="0.01" class="form-control" pattern="\$[0-9]*+(.[0-9]*)\" name="SPmonto" id="SPmonto" value="<?=$Monto?>" autocomplete="off">
        </div>
        <div class="col-sm-5">
          <label class="col-form-label">Fecha de solicitud:</label>
          <input type="date" class="form-control" name="fsolicitud" id="fsolicitud" value="<?=$FechaSolicitud?>" autocomplete="off" >
        </div>
        <div class="col-sm-3">
        <label class="col-form-label">Revisado:</label>
        <select class="form-control bg-white" name="Revisado" id="Revisado" style="font-size: 12px;">
         <option value="0" selected="true">seleccione</option>
         <option value="SI">SI</option>
         <option value="NO">NO</option>
       </select>
        </div>
      </div>

      <div class="clearfix"></div><hr>
        <div class="form-group">
          <div class="col-sm-12 text-right">
              <button type="submit" class="btn btn-success btn-sm"><span class="icon-ok-circle">Guardar</span>
              </button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
          </div>
        </div>
</form>
<?php
}else if($_POST['method'] == 'addcomen'){
?>
<form action="<?php echo FOLDER_PATH ?>/Solicitud/saveComen" method="post">
  <?php if($user == 'Admin'){?>
    <input type="hidden" name="id" value="<?= $Id; ?>">
    <input type="hidden" name="user" value="<?= $user; ?>">
    <div class="row">
      <div class="col-sm-6">
        <label class="col-form-label">Autorizado a Pagar:</label>
        <select class="form-control bg-white" name="AutorizaPago" style="font-size: 12px;">
          <option value="<?= $AutorizadoPago ?>" ><?= $AutorizadoPago ?></option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
        </select>
      </div>
      <div class="col-sm-6">
        <label class="col-form-label">Fecha autorizado:</label>
        <input type="date" class="form-control bg-white" name="fAutorizado" value="<?= $FechaAutorizado ?>">
      </div>
    </div>
    <br>
    <label class="col-form-label">Comentario:</label>
    <textarea class="col" name="Comentario" rows="4" autocomplete="off"><?= $Comentario ?></textarea>
    <div class="clearfix"></div><hr>
            <div class="form-group">
               <div class="col-sm-12 text-right">
                 <button type="submit" class="btn btn-success btn-sm" onclick="mensajeSave();"><span class="icon-ok-circle">Guardar</span></button>
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
               </div>
        </div>
<?php }if($user == 'PagoSolicitud'){?>
  <input type="hidden" name="id" value="<?= $Id; ?>"> <!-- es un campo invisible que sirve para mandar el id--><input type="hidden" name="user" value="<?= $user; ?>">
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label">Proveedor:</label>
          <input type="text" class="form-control"  name="UpdateProveedor" id="UpdateProveedor" value="<?= $Proveedor; ?>"autocomplete="off" requiered autofocus >
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label">Concepto:</label>
          <input type="text" class="form-control"  name="Updateconcepto" id="Updateconcepto" autocomplete="off" value="<?= $Concepto; ?>"requiered>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-4">
          <label class="col-form-label">Monto:</label>
          <input type="number" step="0.01"  class="form-control" pattern="[0-9]*+(\.[0-9]*)" name="Updatemonto" id="Updatemonto" autocomplete="off" value="<?= $Monto; ?>">
        </div>
        <div class="col-sm-5">
          <label class="col-form-label">Fecha de solicitud:</label>
          <input type="date" class="form-control" name="Updatefsolicitud" id="Updatefsolicitud" autocomplete="off" value="<?= $FechaSolicitud?>">
        </div>
        <div class="col-sm-3">
        <label class="col-form-label">Revisado:</label>
         <select class="form-control bg-white" name="UpdateRevisado" style="font-size: 12px;">
          <option value="<?= $Revisado?>"><?= $Revisado?></option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
        </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label">Comentario:</label>
          <textarea class="col" name="Updatecomentario" id="Updatecomentario" rows="4" autocomplete="off"><?= $ComentarioCapt ?></textarea>
        </div>
      </div>
      <div class="clearfix"></div><hr>
        <div class="form-group">
          <div class="col-sm-12 text-right">
              <button type="submit" class="btn btn-success btn-sm" onclick="mensajeSave();"><span class="icon-ok-circle">Guardar</span>
              </button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
          </div>
        </div>
<?php } if($user == 'Pago'){?>
    <input type="hidden" name="id" value="<?= $Id; ?>">
    <input type="hidden" name="user" value="<?= $user; ?>">
    <div class="row">
      <div class="col-sm-6">
        <label class="col-form-label">Estado:</label>
        <select class="form-control bg-white" name="UpdateStatus" style="font-size: 12px;">
          <option value="<?= $estado ?>" ><?= $estado ?></option>
          <option value="PAGADO">PAGADO</option>
          <option value="PENDIENTE">PENDIENTE</option>
        </select>
      </div>
      <div class="col-sm-6">
        <label class="col-form-label">Fecha del pago:</label>
        <input type="date" class="form-control bg-white" name="UpdatefPago" value="<?= $FechaPago ?>">
      </div>
    </div>

    <div class="clearfix"></div><hr>
            <div class="form-group">
               <div class="col-sm-12 text-right">
                 <button type="submit" class="btn btn-success btn-sm" onclick="mensajeSave();"><span class="icon-ok-circle">Guardar</span></button>
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
               </div>
        </div>

<?php }?>
</form>
<?php
} if ($_POST['method'] == 'delete') {
    if ($estado == 'PAGADO') {  ?>
   <div class="form-group row">
    <div class="col-sm-2"style="color: blue;">
      <center><label class="col-form-label"><span class="fa fa-info-circle fa-4x"></span></label></center>
    </div>
    <div class="col-sm-10">
      <label class="col-form-label ">El registro con concepto: <strong><?= $concepto ?></strong>.</label>
      <label class="col-form-label ">No se puede eliminar debido a que ha sido pagado</label>
    </div>
 </div>
 <div class="clearfix"></div><hr>
 <div class="form-group">
     <div class="col-sm-12 text-right">
       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
     </div>
 </div>

<?php
 }else {
?>
<form action = "<?php echo FOLDER_PATH ?>/Solicitud/remove" method = "post">
  <input type="hidden" name="id" value="<?= $Id; ?>">
  <div class="form-group row">
    <div class="col-sm-2"style="color: rgb(255,128,0);">
      <center><label class="col-form-label"><span class="fa fa-exclamation-triangle fa-4x"></span></label></center>
    </div>
    <div class="col-sm-10">
      <label class="col-form-label">¿Seguro que desea eliminar el registro con concepto: <strong><?= $concepto ?></strong> ?</label>
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
}
if ($_POST['method'] == 'search') {
  if ($result->num_rows>0) {
    foreach ($result as $r){
?>
    <?php foreach ($result as $r){?>
     <tr>
              <th ><?= $r["Id"]; ?></th>
              <th scope="row"><?= $r["Proveedor"]; ?></th>
              <td class="text-justify" ><?= $r["Concepto"]; ?></td>
              <td class="text-right"><?= '$'.$r["Monto"]; ?></td>
              <td class="text-center"><?= $r["FechaSolicitud"]; ?></td>
              <td class="text-center">
                <?php if($r["Revisado"] == 'SI'){?>
                <label class="icon-ok"> SI</label>
                <?php } else{?>
                  <label class="icon-cancel-circle"> NO</label>
                <?php }?>
                </td>
              <td class="text-center">
                <?php if($r["AutorizadoPago"] == 'SI'){?>
                <label class="icon-ok"> SI</label>
                <?php } else{?>
                  <label class="icon-cancel-circle"> NO</label>
                <?php }?>
              </td>
              <td class="text-center"><?= $r["FechaAutorizado"]; ?></td>
              <td class="text-center"><?= $r["estado"]; ?></td>
              <td class="text-center"><?= $r["FechaPago"]; ?></td>
              <td class="text-center"><?= $r["Comentario"]; ?></td>
              <td class="text-center"><?= $r["ComentarioCapt"]; ?></td>
              <td>
              <center>
                <button type="button" id="boton" value="<?= $user ?>" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Solicitud" data-operation="Editar" data-method="addcomen">
                  <span class="icon-pencil"></span>
                </button>
              </center></td>
               <?php  if($user == 'PagoSolicitud'){?>
                <td>
                <center>
                  <button type="button" id="boton" value="<?= $user ?>" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Solicitud" data-operation="Eliminar" data-method="delete">
                    <span class="icon-trash"></span>
                  </button>
                </center>
                </td>
              <?php  }?>
    </tr>
      <?php }
    }
  }else{
    ?>
    <br>
    <?php if($user == 'PagoSolicitud'){?>
      <tr>
          <td colspan="14" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr>
    <?php }else {?>
       <tr>
          <td colspan="13" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr>
 <?php
    }
  }
}
if ($_POST['method'] == 'export') {
?>
<form action="<?php echo FOLDER_PATH ?>/Solicitud/ExportarPDF" method="post">
 <?php
 if($id == 1){
 ?>  <!-- <input type="hidden" name="id" value="<?= $id; ?>"> -->
    <input type="hidden" name="id" id="IdHiddenExport1" value="<?= $id; ?>">
     <div class="row">
        <div class="col-sm-12 font-weight-bold border-bottom" style="text-align: center;">
           <label>Fecha de solicitud</label>
        </div>
      </div>
    <div class="row">
      <div class="col-sm-6">
        <label class="col-form-label font-weight-bold">Desde:</label>
        <input type="date" class="form-control bg-white" name="fechaDesde" id="fechaDesde" >
      </div>
      <div class="col-sm-6">
        <label class="col-form-label font-weight-bold">Hasta:</label>
        <input type="date" class="form-control bg-white" name="fechaHasta" id="fechaHasta" >
      </div>
    </div>
    <div class="clearfix"></div><hr>
    <div class="form-group ">
      <div class="col-sm-12 text-right "> <!-- onclick="validarExport()"  -->
        <button type="submit" class="btn btn-success btn-sm" onclick="return validarExportF() && closeModal()"><span class="fa fa-share-square-o" ></span> Exportar</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
      </div>
    </div>
<?php }
 if($id == 2){
?>
<input type="hidden" name="id" id="IdHiddenExport2" value="<?= $id; ?>">
  <div class="row">
    <div class="col-sm-12 font-weight-bold border-bottom" style="text-align: center;">
       <label>Fecha de solicitud</label>
    </div>
  </div>

    <div class="row">
      <div class="col-sm-3">
        <label class="col-form-label font-weight-bold">Estado:</label>
        <select class="form-control bg-white" name="selectEstado" id="selectEstado" style="font-size: 12px;">
            <option value="0" >SELECCIONE</option>
            <option value="PAGADO">PAGADO</option>
            <option value="PENDIENTE" >PENDIENTE</option>
        </select>
      </div>
      <div class="col-sm-4">
        <label class="col-form-label font-weight-bold">Desde:</label>
        <input type="date" class="form-control bg-white" name="fechaDesde" id="FechaDesde" >
      </div>
      <div class="col-sm-4">
        <label class="col-form-label font-weight-bold">Hasta:</label>
        <input type="date" class="form-control bg-white" name="fechaHasta" id="FechaHasta" >
      </div>
    </div>
    <div class="clearfix"></div><hr>
    <div class="form-group ">
      <div class="col-sm-12 text-right "> <!-- onclick="validarExport()"  -->
        <button type="submit" class="btn btn-success btn-sm" onclick="return validarExportEF() && closeModal()" ><span class="fa fa-share-square-o"></span> Exportar</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
      </div>
    </div>
</form>
<?php
  }
}
if ($_POST['method'] == 'CambiarUserPass') {?>
<form action="<?php echo FOLDER_PATH ?>/Solicitud/UpdateUserPass" method="POST" onsubmit="return validarUserPass();">
      <label><strong>Usuario anterior:</strong></label>
       <div class="form-group row">
          <div class="col-sm-1">
            <span class="fa fa-user fa-2x"></span>
          </div>
          <div class="col-sm-11">
            <input type="text" name="UserActual" id="userActual" class="form-control" autocomplete="off" placeholder="Usuario">
          </div>
        </div>
        <br><hr><br>
      <label><strong>Nuevo Usuario y Password:</strong></label>
       <div class="form-group row">
          <div class="col-sm-1">
            <span class="fa fa-user fa-2x"></span>
       </div>
          <div class="col-sm-11">
           <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="Usuario">
          </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-1">
          <span class="fa fa-lock fa-2x"></span>
          </div>
        <div class="col-sm-11">
           <input type="text" name="password" id="password" class="form-control"  autocomplete="off" placeholder="Password">
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
if($_POST['method'] == 'pagination'){
   foreach ($result as $r){
?>
            <tr>
              <th ><?= $r["Id"]; ?></th>
              <th scope="row"><?= $r["Proveedor"]; ?></th>
              <td class="text-justify" ><?= $r["Concepto"]; ?></td>
              <td class="text-right"><?= '$'.$r["Monto"]; ?></td>
              <td class="text-center"><?= $r["FechaSolicitud"]; ?></td>
              <td class="text-center">
                <?php if($r["Revisado"] == 'SI'){?>
                <label class="icon-ok"> SI</label>
                <?php } else{?>
                  <label class="icon-cancel-circle"> NO</label>
                <?php }?>
                </td>
              <td class="text-center">
                <?php if($r["AutorizadoPago"] == 'SI'){?>
                <label class="icon-ok"> SI</label>
                <?php } else{?>
                  <label class="icon-cancel-circle"> NO</label>
                <?php }?>
              </td>
              <td class="text-center"><?= $r["FechaAutorizado"]; ?></td>
              <td class="text-center"><?= $r["estado"]; ?></td>
              <td class="text-center"><?= $r["FechaPago"]; ?></td>
              <td class="text-center"><?= $r["Comentario"]; ?></td>
              <td class="text-center"><?= $r["ComentarioCapt"]; ?></td>
              <td>
              <center>
                <button type="button" id="boton" value="<?= $user ?>" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Solicitud" data-operation="Editar" data-method="addcomen">
                  <span class="icon-pencil"></span>
                </button>
              </center></td>
              <?php  if($user == 'PagoSolicitud'){?>
                <td>
                <center>
                  <button type="button" id="boton" value="<?= $user ?>" class="btn btn btn-outline-danger btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["Id"] ?>" data-model="Solicitud" data-operation="Eliminar" data-method="delete">
                    <span class="icon-trash"></span>
                  </button>
                </center>
                </td>
              <?php  }?>
          </tr>
<?php } 
}
?>