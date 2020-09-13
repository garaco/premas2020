<?php
 require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';

// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
  if($IdBitacora ==" "){
    $FechaReporte=DATE;
  }
  
    $FechaSolicitud=DATE;
    $fechaReq = date('Y');
    $folio='RBS-'.$IdBitacora.'-'.$fechaReq;
?>
<!-- INICIO DE FORMULARIO -->
<form action="<?php echo FOLDER_PATH ?>/MaterialReq" method="post" onsubmit="return validarRBS_Entrada();">
      <input type="hidden" name="id" id="idHidden" value="<?= $IdBitacora; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
      <!-- se envia el folio de la requisicion -->
      <input type="hidden" name="FolioRequisicion" value="<?=$folio?>">
       <!-- input oculto para enviar el numero de linea -->
      <input type="hidden" id="idUser" name="idUser" value="<?=$idUser?>">
      <label class="font-weight-bold text-success fa fa-pencil-square-o"> DATOS GENERALES</label>
      <hr style=" margin: 0; padding: 5px;">
      <div class="form-group row">
            <div class="col-sm-6">
              <label class="col-form-label font-weight-bold">Fecha de Solicitud:</label>
              <input type="date" class="form-control form-control-sm bg-white" id="fSolicitud" name="fSolicitud" value="<?=$FechaSolicitud ?>" <?=($tipouser!='SuperAdmin')?'readonly':'' ?>  >
            </div>
             <div class="col-sm-6">
              <!-- <label class="col-form-label font-weight-bold">Número de material a solicitar:</label> -->
              <!-- <input type="number" class="form-control bg-white" id="txtMaterial" name="txtMaterial" min="1" max="30" autocomplete="off" required=""> -->
              <label class="col-form-label font-weight-bold">Fecha de Entrega:</label>
              <input type="date" name="FechaEntrega" id="FechaEntrega" class="form-control form-control-sm" onchange=" CompararFechaRBS()">
            </div>
         </div>
        <?php 
        if ($tipouser == 'SuperAdmin') {
         ?>
         <div class="row">
          <div class="col-sm-6">
           <label class="col-form-label font-weight-bold">Solicitante:</label>   
           <select class="form-control form-control-sm" id="SelectJefeAreaRBS" name="jefe" data-model="RBS">
            <option value="0">Seleccione</option>
            <?php 
            $jefe = new JefesModel();
            $jefe= $jefe->getAll('IdJefe');
            foreach ($jefe as $j_A) {
             ?>
             <option value="<?=$j_A['IdJefe']?>"><?=$j_A['Subfijo'].$j_A['Nombre'].' '.$j_A['A_paterno'].' '.$j_A['A_materno']?></option>
            <?php } ?>
             
           </select>           
         </div>
         <div class="col-sm-6">
            <label class="col-form-label font-weight-bold">Departamento:</label>    
            <select class="form-control form-control-sm" name="departamento" id="departamento"> 
              <option>Seleccione</option>
              <?php 
              $depa = new DepartamentoModel();
              $depa= $depa->allDepartamento();
              foreach ($depa as $depto) {
              ?>
              <option value="<?=$depto['idDepart']?>"><?=$depto['nombreDepto']?></option>
              <?php }  ?>
            </select>       
         </div>          
         </div>


         <?php 
       }else{
          ?>
        <div class="form-group row">
      <div class="col-sm-6">
        <label class="col-form-label font-weight-bold">Solicitante:</label>          
            <?php  $jefe = new JefesModel();
              $jefe = $jefe->getAllJefes_area($IdDepartamento);

             ?>
            
            <?php foreach ($jefe as $j) {
              $idDepartamnto=$j['IdDep'];?>
              <!--input oculto para id del departameto -->
              <input type="hidden" name="jefe" value="<?=$j['IdJefe']?>">
              <input type="text" name="NombreJefeDepto" class="form-control form-control-sm bg-white" value="<?= $j['Subfijo'].$j['Nombre'].' '.$j['A_paterno'].' '.$j['A_materno']?>" readonly>
              <?php }?>
     
        </div>
        <div class="col-sm-6">
          <label class="col-form-label font-weight-bold">Departamento:</label>
           <br>
            <?php  $depa = new DepartamentoModel();

              $depa= $depa->Departamento_area($idDepartamnto);
            ?>
            <?php foreach ($depa as $d) {?>
              <!-- input oculto para id del departameto -->
            <input type="hidden" name="departamento" value="<?=$d['idDepart']?>"> 
            <input type="text" name="NombreDepartamento" class="form-control form-control-sm bg-white" value="<?=$d['nombreDepto']?>" readonly>
            <?php }?>
          <!-- </select> -->
         </div>
        </div>
          <?php 
         }
           ?>

         <div class="clearfix"></div><hr>
            <div class="form-group ">
               <div class="col-sm-12 text-right ">
                 <button type="submit" class="btn btn-success btn-sm"><span class="icon-ok-circle">Guardar</span></button>
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
               </div>
        </div>
</form>
<?php 
  } if ($_POST['method'] == 'Detalle') {
 ?>
 <table class="table table-sm table-striped small">
  <thead>
    <tr>
      <th>Estado</th>
      <th>Material</th>
      <th>Unidad de Medida</th>
      <th>Cantidad</th>
      <th>Costo</th>
    </tr>
  </thead>
   <tbody>
    <?php 
    foreach ($result as $r) {
     ?>
     <tr>
       <td><?=($r['Num_estado'] == 0)?'<span class="fa fa-question-circle fa-2x" style="color:blue;"></span>':'<span class="fa fa-check-square-o fa-2x" style="color:green;"></span>'?></td>
       <td><?=$r['Concepto']?></td>
       <td><?=$r['Medida']?></td>
       <td><?=$r['Cantidad']?></td>
       <td><?='$'.$r['Costo']?></td>
     </tr>
     <?php  
       }?>
   </tbody>
 </table>
         <div class="clearfix"></div><hr>
            <div class="form-group ">
               <div class="col-sm-12 text-right ">
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
               </div>
        </div>

<?php 
 } if ($_POST['method'] == 'selectMeta') {
      if ($proyecto->num_rows > 0) {
  ?> 
       <option value="0"></option>
    <?php 
        foreach ($proyecto as $r) {
     ?>
          <option value="<?=$r['IdProyecto'].'-'.$idUser?>"><?=$r['enum']?></option>
  <?php 
        }
      }
   }
   if ($_POST['method'] == 'selectProyecto') {
    if ($partidas->num_rows > 0) {
   ?>
      <option value="0">Seleccione</option>
<?php 
        foreach ($partidas as $r) {
 ?>
          <option value="<?=$r['IdPartida'].'-'.$idUser?>"><?=$r['Codigo']?></option>
<?php   }
      }
    }
if ($_POST['method'] == 'seleccion') {
  if ($result->num_rows > 0) {
 ?>

<option value="0">Seleccione</option>
   <?php  foreach ($result as $r) {
     ?>
    <option value="<?=$r['IdMaterial'].'-'.$IdUsuario?>"><?=$r['Articulo']?></option>
<?php 
    }
   }else{
?>
    <option value="">Partida presupuestal no contiene material</option>
<?php
  }
}
  if ($_POST['method'] == 'selectUnidadCosto') {
    if (isset($CantidadArticulo)) {
      $Articulo=($CantidadArticulo==0)?0:$CantidadArticulo;
?>
<!-- <div class="col-sm-12">
  <div class="alert alert-danger" role ="alert" style="padding-bottom: 3px; padding-top: 3px;">Solo cuenta con la cantidad de <?=$Articulo?> del Material seleccionado</div>
</div> -->
  <script type="text/javascript">
    alertaRBS('En el mes:<?=$mes?>  Solo cuenta con la cantidad de <?=$Articulo?> del Material seleccionado');
  // $('#action').attr("disabled", true);
    $("#descripcion"+<?=$cont?>).val(0);
    $("#cantidad"+<?=$cont?>).val('');
  </script>
<?php
    }else{
    if ($result->num_rows > 0) {
      foreach ($result as $r) {
      $precio = $r["Precio"]*$num_cantidad;
  ?>
<div class="col-sm-6">
  <input type="text" class="form-control" style="font-size: 10px;" name="unidad[]" value="<?=$r['Medida']?>" >
</div>
    
<div class="col-sm-6">
  <input type="text" class="form-control precio" style="font-size: 10px;" name="Precio[]" value="<?=$precio?>">
</div>
    <script type="text/javascript">

  $('#action').attr("disabled", false);

  </script>  

<?php   
      }
    }
    }

  }
  if($_POST['method'] == 'tableReload'){
    if($_POST['optionTabs'] == 'Enviadas'){
      if ($result->num_rows > 0) {
              foreach ($result as $r){
              if ($r["Estado"] <> 'AUTORIZADO') {
?>
                <tr>
                <td class="text-center"><?= $r["Foliorequisicion"]; ?></td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r["Costo"]; ?></td>
                <td>
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                </td>
<!--                 <td>
                  <center>
                  <form action="<?php echo FOLDER_PATH ?>/RBS/Cancelar" method="post" >
                    <button type="submit" class="btn btn btn-outline-danger btn-sm badge badge-pill" >
                      <span class="fa fa-times"></span>
                      <input type="hidden" name="id" value="<?= $r["IdBitacora"] ?>">
                    </button>
                  </form>
                </center>
                </td> -->
              </tr>
<?php 
          }
        }
      }
    }

    if ($_POST['optionTabs'] == 'Guardadas') {
      if ($ReqGuardadas->num_rows > 0) {
        foreach ($ReqGuardadas as $r){      
 ?>
             <tr>
                 <td class="text-center"><?= $r["ForlioRequisicion"]; ?></td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r["Costo"]; ?></td>              
             </tr>

<?php   }     
      }
    }
    if ($_POST['optionTabs'] == 'Autorizadas') {
      if ($result->num_rows > 0) {
        foreach ($result as $r2){
          if ($r2["Estado"] == 'AUTORIZADO') {      
 ?>    
                 <tr>
                <td class="text-center"><?= $r2["Foliorequisicion"]; ?></td>
                <td class="text-center"><?= $r2["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r2["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r2["Costo"]; ?></td>
                <td>
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r2["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                </td>
              </tr>

 <?php 
          }
        }  
      }
    }
    if ($_POST['optionTabs'] == 'Recibido') {
        if ($result->num_rows > 0) {
          foreach ($result as $r3){
            if ($r3["Estado"] == 'AUTORIZADO') {      
 ?>
                 <tr>
                <td class="text-center"><?= $r3["Foliorequisicion"]; ?></td>
                <td class="text-center"><?= $r3["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r3["FechaEntrega"]; ?></td>
                <td class="text-right"><?= '$ '.$r3["Costo"]; ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn btn-outline-success btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?=$r3['IdBitacora']?>" data-model="RBS" data-operation="Detalle" data-method="Detalle" style="width: 100px; font-size: 12px;"><span class="fa fa-eye"> Ver</span></button></td>
              </tr>
<?php  
          }
        }  
      }
    }
  }
 ?>
