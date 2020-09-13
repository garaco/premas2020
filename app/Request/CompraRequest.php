
<?php 
if ($_POST['method'] == 'AgregarRequisicion') {
 ?>
 <div class="form-group row">
   <div class="col-sm-6">
   	<input type="hidden" name="id" value="<?=$ID?>">
   	<label>Folio requisición</label>
  	<input type="text" class="form-control" name="folioRe" id="folioRe" value="<?=$Foliorequisicion?>">
	</div>
	 <div class="col-sm-6">
	 	<label>Departamento</label>
	 	<input type="text" class="form-control" name="Departamento" id="Departamento" value="<?=$Departamento?>">
	 </div>
 </div>
  <div class="form-group row">
   	<div class="col-sm-12">
   		
   		<table class="table table-sm table-striped small table-condensed">
   			<thead>
   			<tr>
   				<!-- <th><input type="checkbox" name=""></th> -->
   				<th width="5%"></th>
   				<th width="10%">Cantidad</th>
   				<th width="15%">Unidad</th>
   				<th width="33%">Materiales</th>
   				<th width="20%">Precio Unitario</th>
   				<th width="12%">IVA</th>
   			</tr>			
			</thead>
			<tbody>
   			<?php 
   			$i=0;
   			foreach ($result as $k) {
   				//if ($k['flag'] == 0) {
   					
   				
   			 ?>
   			<tr>
   				<td><input type="checkbox" class="checkboxMaterial" id="checkbox<?=$i?>" value="<?=$i?>">
   					<input type="hidden" id="idReqYmat<?=$i?>" value="<?=$ID.'-'.$idIdDep.'-'.$k['Descripcion']?>">
   				</td>
   				<td><input type="number" class="form-control form-control-sm" id="Cantidad<?=$i?>" value="<?=$k['Cantidad']?>"></td>
   				<td><input type="text" class="form-control form-control-sm" id="Unidad<?=$i?>" value="<?=$k['Medida']?>" style="font-size: 11px"></td>
   				<td><input type="text" class="form-control form-control-sm" id="Concepto<?=$i?>" value="<?=$k['Concepto']?>" style="font-size: 11px"></td>
   				<td><input type="number" class="form-control form-control-sm" id="Precio_unitario<?=$i?>" value="<?=$k['Costo']?>"></td>
   				<td><input type="number" class="form-control form-control-sm" id="Iva<?=$i?>"></td><!-- concepto no definido -->

   			</tr>
   			<?php //} 
   				$i++;
   				}
   			?>
   			<input type="hidden" id="totalmaterial" value="<?=$i?>">				
			</tbody>

   		</table>
   		
 	</div>
 </div>
  <div class="clearfix"></div><hr>
 <div class="form-group">
     <div class="col-sm-12 text-right">
       <button type="button" class="btn btn-success btn-sm" id="btnOrdenCompra" onclick="datos(<?=$i?>)"><span class="icon-plus-circle">Agregar</span></button>
       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
     </div>
 </div>
<?php 
} 
if ($_POST['method'] == 'AlmacenarTabla') {
	for ($i=0; $i < count($precio_unitario); $i++) {
 ?>
 <tr id="fila<?=$arrayIndice[$i]?>">
 	<input type="hidden" name="datos[]" value="<?=$arraydReqYmat[$i].'-'.$arraycantidad[$i].'-'.$arrayprecio_unitario[$i].'-'.$Importe_parcial[$i]?>">
 	<td class="text-center"><?=$arraycantidad[$i]?></td>
 	<td class="text-center"><?=$arrayunidad[$i]?></td>
 	<td class="text-justify"><?=$arrayconcepto[$i]?></td>
 	<td class="text-center"><?=$Departamento?></td>
 	<td class="text-center"><?=$folioRequisicion?></td>
 	<td class="text-center"><?=$arrayprecio_unitario[$i]?></td>
 	<td class="text-center" id="i_p<?=$arrayIndice[$i]?>"><?=$Importe_parcial[$i]?></td>

	<td>
		
		<button class="btn btn-sm btn-danger badge " id="borrar<?=$arrayIndice[$i]?>" onclick="return eliminarFila(<?=$arrayIndice[$i]?>);" data-toggle="tooltip" data-placement="top" title="Remover fila"><span class="fa fa-minus-circle fa-2x"></span></button>
		
	</td>  
	<td style="visibility: hidden;"><?=$arrayIva[$i]?></td> 	
 </tr>
<?php 
}}


if ($_POST['method'] == 'EntradaMaterial') {
	if ($datosTabla) {
	$i=0;
		foreach ($datosTabla as $datos) {
 ?>
		 	<tr>
		 		<td>
		 		<input type="checkbox" class="selectAddMaterial" id="checkbox<?=$i?>">
		 		<input type="hidden" name="Id[]" value="<?=$idOrdCom.'-'.$datos['IDdetalleDescripcion'].'-'.$datos['Descripcion'].'-'.$datos['Cantidad']?>">	
		 		</td>
				<td class="text-center">
					<?=$datos['Cantidad']?>
				</td>
				<td class="text-center">
					<?=$datos['Medida']?>
				</td>
				<td class="text-justify">
					<?=utf8_encode($datos['DescripcionMaterial'])?>
				</td>
				<td class="text-center">
					<?=$datos['departamento']?>
				</td>
				<td class="text-center">
					<?=$datos['Folio']?>
				</td>
				<td class="text-center">
					<?=$datos['Precio_unitario']?>
				</td>
				<td class="text-center">
					<?=$datos['Importe_parcial']?>
				</td>
			</tr>
 <?php    $i++;
		}
?>
	<input type="hidden" id="num" value="<?=$i?>">
<?php 	
	} 
} if ($_POST['method'] == 'DeptoYMateriales') {
 	$i=0;
 foreach ($result as $r) {
 ?>	
 
 	<div class="col-sm-8">
 <!-- 		<select class="form-control" multiple="multiple" name="Descripcion[]" id="Descripcion<?= $i ?>" data-cont="<?= $i ?>" style="font-size: 11px;height: 100px;" >
 			<option value="0" >Seleccionar</option> -->
 		<?php
 		$diferencia=""; $resultado=""; 
 		foreach ($materiales as $m) {	
 			if ($m['Cantidad'] > $m['Existencia']){
             $diferencia=$m['Cantidad']-$m['Existencia'];
             $resultado=$diferencia.' '.$m['Concepto'].', '.$resultado;
           }
       }	
 		 ?>
 		 <textarea cols="3" class="form-control" name="Descripcion[]" id="Descripcion<?= $i ?>"><?=$resultado?></textarea>
 		<!-- </select>  -->
 		

 	</div>
 	<div class="col-sm-4">
 		<input type="hidden" name="IdAreaSolicitante[]" value="<?= $r['idDepart'] ?>">
		<label class="form-control" style="font-size: 11px;"><?= utf8_decode($r['nombreDepto']) ?></label>
 	</div>
 <?php $i++; 
 	}
  } ?>