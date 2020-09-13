<?php
 require_once ROOT . FOLDER_PATH .'/app/Models/JefesModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
    $Material;
    $this->Material = new MaterialModel();
// Comparo si el tipo de metodo si es request manda la parte de agregar o editar
if ($_POST['method'] == 'requested') {
   $FechaReporte=DATE;
   $Cont_atendidos=0; //contador para los materiales atendidos
?>
<!-- INICIO DE FORMULARIO -->
<form action="<?php echo FOLDER_PATH ?>/Requisicion/save" method="post" enctype="multipart/form-data" onsubmit="return validarReq();" >

      <?php if ($fecha_entrega < DATE && $estado != 'AUTORIZADO') { //si se cumple manda el mensaje de que no se puede modificar
       ?>
   <div class="form-group row">
    <div class="col-sm-2"style="color: blue;">
      <center><label class="col-form-label"><span class="fa fa-info-circle fa-4x"></span></label></center>
    </div>
    <div class="col-sm-10">
       <label>No se puede modificar debido que la Fecha de entrega de la requisición <strong><?=$Foliorequisicon?></strong> era para la fecha: <?=date('d/m/Y',strtotime($fecha_entrega))?>.</label>
    </div>
 </div>
 <div class="clearfix"></div><hr>
 <div class="form-group">
     <div class="col-sm-12 text-right">
       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
     </div>
 </div>       
     <?php }else{  //si no se cumple el IF si permite modificar?>
      <input type="hidden" name="id" id="idHidden" value="<?= $ID; ?>"> <!-- es un campo invisible que sirve para mandar el id-->
      <div class="form-group row">

          <div class="col-sm-4">
              <label class="col-form-label">N° de requisición:</label>
              <input type="text" class="form-control bg-white"  name="requisicion" id="Num" value="<?=$Foliorequisicon?>"  autocomplete="off" readonly >
            </div>
            <div class="col-sm-4">
              <label class="col-form-label">Fecha de recepción:</label>
              <input type="date" class="form-control bg-white" id="recepcion" name="frecepcion" value="<?=$fechaRecepcion?>"  requiered>
            </div>
            <div class="col-sm-4">
              <label class="col-form-label">Fecha de captura:</label>
           <input type="date" class="form-control bg-white " id="reporte" name="freporte" value="<?= $FechaReporte ?>" readonly>
           </div>
         </div>

        <div class="form-group row">
      <div class="col-sm-6">
        <label class="col-form-label">Solicitante:</label>
        <select class="form-control badge bg-white"  name="jefe" id="jefe" data-model="Requisicion">
          <option value="0" >Seleccione solicitante </option>
            <?php  $jefe = new JefesModel();
            $jefe= $jefe->getAll('IdJefe'); ?>
            <?php foreach ($jefe as $j) {?>

          <option  value="<?=$j['IdJefe']?>"  <?= ($j['IdJefe']==$IdSolicitante) ? ' selected' : ''; ?>> <?=$j['Nombre'].' '.$j['A_paterno'].' '.$j['A_materno']?></option><?php }?>
        </select>
        </div>
        <div class="col-sm-6">
          <label class="col-form-label">Departamento:</label>
          <label></label>
          <select class="form-control badge badge-default bg-white" name="departamento" id="depa" >
            <option value="0" >Seleccione departamento </option>
            <?php  $depa = new DepartamentoModel();
            $depa= $depa->getAll('idDepart');?>
            <?php foreach ($depa as $d) {?>
            <option value="<?=$d['idDepart']?>" <?= ($d['idDepart']==$IdDep) ? ' selected' : ''; ?>> <?=$d['nombreDepto']?></option>
            <?php }?>
          </select>
         </div>
        </div>
        <?php if ($estado != 'AUTORIZADO') {
         ?>
        <div class="form-group row">
          <div class="col-sm-12">
            <label class="col-form-label">Concepto:</label>
            <br>
            <input type="text" class="form-control bg-white" name="concepto" id="concepto" readonly value="<?= $Concepto ?>">
          </div>
        </div>
        <div class="form-group row">

          <div class="col-sm-4">
            <label class="col-form-label">Monto estimado por adquisición:</label>
            <input type="text" class="form-control bg-white" id="monto" name="monto" value="<?=$costo?>" requiered autocomplete="off" >
          </div>
           <div class="col-sm-4">
            <label class="col-form-label">Status:</label>
            <input type="text" class="form-control bg-white" id="Status" name="Status" value="<?=$Status?>" autocomplete="off">
          </div >
          <?php 
            if ($num_estado == 0) {
           ?>
          <div class="col-sm-4">
            <label class="col-form-label">Enviar:</label><br>
            <label>SI</label>
             <input type="radio" name="Enviar" value="SI" required="">
            <label>NO</label>
             <input type="radio" name="Enviar" value="NO" required="">
          </div>
          <?php 
            }?>
         </div>
         <?php }
            if ($estado == 'AUTORIZADO') {
           ?>
          <label>Materiales:</label>
         <table class="table table-sm table-striped small">
          <thead>
            <tr>
            <th><?php if ($num_estado != 0) {
                 ?>
              <input type="checkbox" class="selectAll" name="selectAll" id="selectAll" value="">
            <?php } ?>
            </th>
            <th>Proyecto</th>
            <th>Meta</th>
            <th>Partida</th>
            <th>Unidad</th>
            <th>Descricion</th>
            <th>Costo</th>              
            </tr>

          </thead>
           <tbody>
             <?php
              foreach ($datoMaterial as $dato) {
              ?>
              <tr>
                <td><?php if ($dato['Num_estado'] == 0) {
                 ?>
                  <input type="checkbox" class="selectCkeck" name="idMaterial[]" value="<?=$dato['Descripcion']?>">
                  <?php }else{
                    ?>
                  <label><span class="fa fa-check-circle-o"></span></label>
                <?php $Cont_atendidos++;} ?>
                </td>
                <td><?=$dato['Proyecto']?></td>
                <td><?=$dato['Meta']?></td>
                <td><?=$dato['Codigo']?></td>
                <td><?=$dato['Medida']?></td>
                <td><?=utf8_encode($dato['Concepto'])?></td>
                <td><?=$dato['Costo']?></td>
                <input type="hidden" name="IdRequisicionDetalle[]" value="<?=$dato['IdRequisicionDetalle']?>">
              </tr>
              <?php  
              }
               ?>
           </tbody>
         </table>
         <?php } ?>
         <div class="clearfix"></div><hr>
            <div class="form-group ">
               <div class="col-sm-12 text-right ">
                <?php if ($datoMaterial->num_rows == $Cont_atendidos) {//si son igual se pone el boton cerrar
                 ?> 
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
                <?php }else{ //si no se pone el boton guardar y cancelar?>
                 <button type="submit" class="btn btn-success btn-sm" name="btn_Guardar" value="<?=($estado != 'AUTORIZADO')?0:1?>"><span class="icon-ok-circle">Guardar</span></button>
                 <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
                 <?php } ?>
               </div>
        </div>
        <?php } ?>
</form>

<?php }
if ($_POST['method'] == 'export') {
?>
<form action="<?php echo FOLDER_PATH ?>/Requisicion/Exportar" method="post"  >
 <?php
 if($id == 1){
 ?>  <input type="hidden" name="id" value="<?= $id; ?>">
  <div class="row">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="col-sm-12 font-weight-bold icon-doc-inv" style="text-align: center;">
      <label class="col-sm-12 font-weight-bold"> Exportando requisiciones</label>
    </div>
  </div>

  <div class="clearfix"></div><hr>
    <div class="form-group ">
      <div class="col-sm-12 text-right "> <!-- onclick="validarExport()"  -->
        <button type="submit" class="btn btn-success btn-sm" onclick="closeModal()"><span class="icon-ok-circle">Guardar</span></button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
      </div>
  </div>
<?php }
 if($id == 2){
?>
<input type="hidden" name="id" id="IdHiddenExport1" value="<?= $id; ?>">
  <div class="row">
    <div class="col-sm-12 font-weight-bold border-bottom" style="text-align: center;">
       <label>Fecha de captura</label>
    </div>
  </div>

    <div class="row">
      <div class="col-sm-3">
        <label class="col-form-label font-weight-bold">Estado:</label>
        <select class="form-control bg-white" name="selectEstado" id="selectEstado" style="font-size: 12px;">
            <option value="0" >SELECCIONE</option>
            <option value="AUTORIZADO">AUTORIZADO</option>
            <option value="NO AUTORIZADO" >NO AUTORIZADO</option>
            <option value="PENDIENTE" >PENDIENTE</option>
        </select>
      </div>
      <div class="col-sm-4">
        <label class="col-form-label font-weight-bold">Desde:</label>
        <input type="date" class="form-control bg-white" name="FechaDesde" id="FechaDesde" >
      </div>
      <div class="col-sm-4">
        <label class="col-form-label font-weight-bold">Hasta:</label>
        <input type="date" class="form-control bg-white" name="FechaHasta" id="FechaHasta" >
      </div>
    </div>
    <div class="clearfix"></div><hr>
    <div class="form-group ">
      <div class="col-sm-12 text-right "> <!-- onclick="validarExport()"  -->
        <button type="submit" class="btn btn-success btn-sm" onclick="return validarExportEF() && closeModal()" ><span class="icon-ok-circle">Guardar</span></button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
      </div>
    </div>
</form>

<?php
  }
  if($id == 3){
 ?>
    <input type="hidden" name="id" id="IdHiddenExport2" value="<?= $id; ?>">
     <div class="row">
        <div class="col-sm-12 font-weight-bold border-bottom" style="text-align: center;">
           <label>Fecha de captura</label>
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
        <button type="submit" class="btn btn-success btn-sm" onclick="return validarExportF() && closeModal()"><span class="icon-ok-circle" >Guardar</span></button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
      </div>
    </div>
<?php
  }
}
if ($_POST['method'] == 'search' || $_POST['method'] == 'filto_ano') {
  if ($result->num_rows>0) {
       $Material;
       $this->Material = new MaterialModel();
       $Num_estado;
       $this->Num_estado = new RBSModel();
       $fila=0;
    foreach ($result as $r){
?>
              <tr>
                <th scope="row"><?=($r["Estado"]=='AUTORIZADO' && $r["Estatus"]!='ATENDIDA')?'<span class="parpadea text-parpadeo fa fa-circle"></span>':''?>  <?= ($r["Foliorequisicion"] != '') ? $r["Foliorequisicion"] : '<div class=" talk-bubble tri-right right-in "><div class="talktext">NO DEFINIDO</div></div>' ?> </th>
                <td class="text-right"><?= '$'.''.$r["Costo"];?></td>
                <td><?= $r["FechaRecepcion"]; ?></td>
                <td><?= $r["FechaReporte"]; ?></td>
                <td><?= $r["nombreDepto"];?></td>
                <td><?= $r['Subfijo'].''.$r['Nombre'].' '.$r['A_paterno'].' '.$r['A_materno'] ;?></td>
                <td class="small text-justify"><?= $r["Concepto"];?></td>
                <td><?= $r["FechaAutorizacion"];?></td>
                <td class="text-center"><?= $r["Estado"];?></td>
                <td>
                  <?php if ($r["Estado"]=='AUTORIZADO' && $r["FechaAatencion"]=='00/00/0000') {?>
                    <center>
                      <form action="<?php echo FOLDER_PATH ?>/Requisicion/saveDATE" method="post">
                        <button type="submit" class="btn btn btn-outline-success btn-sm badge badge-pill" >
                          <span class="icon-plus-circle"></span><input type="hidden" name="fecha" value="<?= DATE ?>">
                          <input type="hidden" name="id" value="<?= $r["IdBitacora"] ?>">

                        </button>
                      </form>
                    </center>
                  <?php } else{
                  echo $r["FechaAatencion"];
                }
                  ?>
                </td>
                <td class="text-justify">
                  <?= $r["Estatus"] ?>
                </td>
                <td class="text-justify"><?= $r["Comentario"];?></td>
                <td>
                  <?php if ($r['Foliorequisicion'] != "") { ?>
                    <center>
                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                  <?php } ?>

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
                    <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill"
                    id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Requisicion" data-operation="Editar" data-method="requested" data-estado="<?=$r['Estado']?>">
                      <span class="icon-pencil"></span>
                    </button>
                  </center>
               <?php  }
                  ?>
                </td>
                <td>
                  <?php

                    if ($r["Estado"]=='AUTORIZADO' && $r["Estatus"]!='ATENDIDA') {
                      $id=$r['IdBitacora'];
                      $Cantidad = $this->Material->CantidadMaterial($id);
                      $Num_estado = $this->Num_estado->Num_estadoMaterial($id);
                      $num_fila = $Num_estado->num_rows;
                      $cont=0;
                      $cont2=0;
                      foreach ($Num_estado as $N_e) {
                          if ($N_e['Num_estado'] == 1) {
                            $cont2++;
                          }
                      }
                      foreach ($Cantidad as $mt) {
                        if ($mt['Cantidad'] > $mt['Existencia']) {
                          $cont++;
                        }
                      }
                      if ($cont2 != $num_fila) {
                      if ($cont >= 1) {
                  ?>
                 <center>
                    <button type="button" class="btn btn btn-warning btn-sm badge badge-pill"
                    data-toggle="modal" data-target="#ventana" data-id="<?= $r['IdBitacora'] ?>" data-model="Requisicion" data-operation="Advertencia" data-method="Advertencia" >
                      <span class="fa fa-exclamation-triangle"></span>
                    </button>
                  </center>
                  <?php }
                }
                }if ($r['FechaEntrega'] < DATE && $r["Estado"] != 'AUTORIZADO') { ?>
                  <center>
                        <form action="<?php echo FOLDER_PATH ?>/Requisicion/Cancel" method="POST" id="form<?=$fila?>">
                        <input type="hidden" name="Mes" value="<?=MES?>">
                        <input type="hidden" name="ID" value="<?= $r['IdBitacora'].'|'.$r['IdDep'].'|'.MES.'|'.$r['dateRecepcion']?>">
                        <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill CancelarRequi" value="<?= $r['Foliorequisicion']?>" id="CancelarRequi<?=$fila?>" name="Cancelar" onclick="CancelarRequisicion(<?=$fila?>)" >
                        <span class="icon-trash"></span>
                      </button>
                       </form>
                  </center>
                <?php $fila++; } ?>
                </td>
              </tr>
<?php
    }
  }else{
    ?>
    <br>
<!--       <tr>
          <td colspan="15" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr> -->
<?php 
  }
}if ($_POST['method'] == 'Advertencia') {
  $cont=0;?>
  <label style="font-size: 20px;"><strong>Para poder ser atendida esta requisición se necesita:</strong></label>
  <?php
  foreach ($result as $r) {
    if ($r['Cantidad'] > $r['Existencia']) {
      $diferencia = $r['Cantidad'] - $r['Existencia'];
      $cont++;
 ?>
  <label class="text-justify"><strong><?= $cont?>.- </strong><?=$diferencia.' '.utf8_encode($r['Concepto']); ?>, ya que solo se cuenta con <?=$r['Existencia']?> en existencia y se requiere de <?=$r['Cantidad']?> de este material.</label>
 <?php 
      }
    }
  ?>
<div class="clearfix"></div><hr>
    <div class="form-group ">
      <div class="col-sm-12 text-right ">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cerrar</span></button>
      </div>
    </div>
 <?php  
}
if($_POST['method'] == 'pagination'){
  foreach ($result as $r){
  ?>
  <tr>
    <th scope="row"><?=($r["Estado"]=='AUTORIZADO' && $r["Estatus"]!='ATENDIDA')?'<span class="parpadea text-parpadeo fa fa-circle"></span>':''?>  <?= ($r["Foliorequisicion"] != '') ? $r["Foliorequisicion"] : '<div class=" talk-bubble tri-right right-in "><div class="talktext">NO DEFINIDO</div></div>' ?> </th>
    <td class="text-right"><?= '$'.''.$r["Costo"];?></td>
    <td><?= $r["FechaRecepcion"]; ?></td>
    <td><?= $r["FechaReporte"]; ?></td>
    <td><?= utf8_encode($r["nombreDepto"]);?></td>
    <td><?= $r['Subfijo'].''.$r['Nombre'].' '.$r['A_paterno'].' '.$r['A_materno'];?></td>
    <td class="small text-justify"><?= $r["Concepto"];?></td>
    <td><?= $r["FechaAutorizacion"];?></td>
    <td class="text-center"><?= utf8_encode($r["Estado"] ); ?></td>
    <td>
    <?php if ($r["Estado"]=='AUTORIZADO' && $r["FechaAatencion"]=='00/00/0000') {?>
      <center>
        <form action="<?php echo FOLDER_PATH ?>/Requisicion/saveDATE" method="post">
          <button type="submit" class="btn btn btn-outline-success btn-sm badge badge-pill" >
            <span class="icon-plus-circle"></span><input type="hidden" name="fecha" value="<?= DATE ?>">
            <input type="hidden" name="id" value="<?= $r["IdBitacora"] ?>">
            <input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
          </button>
        </form>
      </center>
    <?php } else{
    echo $r["FechaAatencion"];
  }
    ?>
  </td>
   <td><?= utf8_encode($r["Estatus"] ) ?></td>
    <td class="text-justify"><?= $r["Comentario"]  ?></td>
    <td>
      <?php if ($r['Foliorequisicion'] != "") { ?>
          <center>
            <form action="<?php echo FOLDER_PATH ?>/visualiza/pdf" method="post"  target="_blank">
              <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
               <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
              </button>
             </form>
            </center>
      <?php } ?>
                  
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
          <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Requisicion" data-operation="Editar" data-method="requested">
            <span class="icon-pencil"></span>
           </button>
         </center>
      <?php  }
      ?>
    </td>
      <td>
        <?php 
          if ($r["Estado"]=='AUTORIZADO' && $r["Estatus"]!='ATENDIDA') {
          $id=$r['IdBitacora'];
           $Cantidad = $this->Material->CantidadMaterial($id);
            $cont=0;
            foreach ($Cantidad as $mt) {
              if ($mt['Cantidad'] > $mt['Existencia']) {
                $cont++;
              }
            }
            if ($cont >= 1) {
        ?>
       <center>
          <button type="button" class="btn btn btn-warning btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r['IdBitacora'] ?>" data-model="Requisicion" data-operation="Advertencia" data-method="Advertencia" ><span class="fa fa-exclamation-triangle"></span>
          </button>
         </center>
        <?php }
      }  ?>
      </td>
  </tr>
  <?php
  }
}
?>
