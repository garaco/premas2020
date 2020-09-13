<?php
 require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/ProveedoresModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionModel.php';
 require_once ROOT . FOLDER_PATH .'/app/Views/header.php';
 ?>
<!DOCTYPE html>
<html>
<head>
<?php 
        $header = new header();
        $header->PushHeader('Orden de compra');
?>
	<title></title>
</head>
<body onload="myFunction()" style="margin:0;">
	<?php
	$Area_solicitante = new DepartamentoModel();
	$Area_solicitante = $Area_solicitante->allDepartamento();

	$folioRequisicion = new RequisicionModel();
	$folioRequisicion = $folioRequisicion->Foliorequisicion();
	 // echo json_encode($folioRequisicion, JSON_FORCE_OBJECT);
 ?>
    <!-- loader -->
    <div id="loader"></div>
    <!-- end loader -->
  <main id="wrapper">
     <?php require_once SIDERBAR; ?>
     <div id="page-content-wrapper">
	    <nav class="navbar navbar-dark" style="background-color : #1a2732">
	      <div class="container-fluid">
	        <div class="navbar-header">
	        	<label class="icon-th-list" id="menu-toggle"  data-toggle="tooltip" title="Menú"></label>
	          <a href = "<?php echo FOLDER_PATH ?>/Main" class="navbar-brand text-white font-weight-light"> <img src="<?php echo PATH_PUBLIC ?>/img/home.png"></span> INICIO  / </a>
	          <a class="navbar-brand font-weight-bold text-white" >ORDEN DE COMPRA DEL BIEN O SERVICIO</a>
	        </div>
	          <!-- <div class="col-sm-4"  >
	            <label class="sr-only">Buscar</label>
	            <input type="text" class="form-control" placeholder="Buscar" name="buscar" id="buscar" data-model="Compra" autocomplete="off">
	          </div> -->
	        <div class="dropdown " data-toggle="tooltip" data-placement="top" title="Cerrar sesión">
            <button type="button" class="btn botones dropdown-toggle dropdown-toggle-split badge-pill text-white" data-toggle="dropdown">
              <span class="fa fa-user-circle"></span> <label><?=$User?></label>
           </button>
	          <div class="dropdown-menu dropdown-menu-right">
	              <a class="dropdown-item" method="post" href="<?php echo FOLDER_PATH ?>/Main/logout" ><span class="icon-logout"> Cerrar sesión</span></a>
	          </div>
	        </div>
	      </div>
	    </nav>
	    <div class="contentPage animate-des main">
	<br>
	    <!-- Inicio Ventana modal -->
	            <div class="modal fade" data-backdrop="static" keyboard="false" id="ventanaCompra" aria-hidden="true">
	              <div class="modal-dialog modal-lg" role="document">
	                <div class="modal-content">
	                  <div class="modal-header bg-dark">
	                    <h5 class="modal-title text-white"> </h5>
	                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
	                  </div>

	                  <!-- body de la venatan -->
	                  <div class="modal-body">

	                </div>
	              </div>
	            </div>
	        </div>
	    <!-- fin ventana modal -->
	    <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left:50px;">
	     <li class="nav-item">
	       <a class="nav-link active" id="alta-tab" data-toggle="tab" href="#alta" role="tab" aria-controls="alta" aria-selected="true">Orden Compra</a>
	     </li>
	     <li class="nav-item">
	       <a class="nav-link" id="realizadas-tab" data-toggle="tab" href="#realizadas" role="tab" aria-controls="realizadas" aria-selected="false">OC Realizadas</a>
	     </li>
	     <li class="nav-item">
	       <a class="nav-link" id="relacion-tab" data-toggle="tab" href="#relacion" role="tab" aria-controls="relacion" aria-selected="false">Relación Requisición</a>
	     </li>	     
	     <li class="nav-item">
	       <a class="nav-link" id="entrada-tab" data-toggle="tab" href="#entrada" role="tab" aria-controls="entrada" aria-selected="false">Entrada Materiales</a>
	     </li>
	   </ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="alta" role="tabpanel" aria-labelledby="alta-tab">
		<br>
	    <div class="container border" >
	    	<!-- encabezado del contenedor -->
	       <div class="row justify-content-md-center">
	        <div class="col-sm-12 alert-color">
            <img src="<?php echo PATH_PUBLIC ?>/img/add.png">
              <label class="font-weight-bold">ALTA ORDEN DE COMPRA</label>
	        </div>
	      </div>
	      <br>
	        <?php if (isset($error_message)) {
	        ?>
	        <div class="alert alert-danger alert-dismissible fade show small" id="success-alert" role ="alert"><span class="fa fa-exclamation-triangle fa-2x" style="color: orange;"></span><strong><label style="padding-left: 10px; font-weight: bold; font-size: 14px;"><?=isset($error_message)?$error_message:''?></label></strong>
	        </div>

	        <?php } ?>
	      <form action="<?php echo FOLDER_PATH ?>/Compra/save" method="post" onsubmit="return ValidarOrdenCompra();" name="formulario">
	      <div class="row">
	      	<div class="col-sm-1">
	      		<label>Proveedor </label>
	      	</div>
	      	<div class="col-sm-4">
	      		<?php
	      		$proveedor = new ProveedoresModel();
	     		$nombre = $proveedor->Allproveedor();
	      		 ?>
	     		<!-- <input type="text" class="form-control" name="Proveerdor"> -->
	     		<select name="Proveerdor" class="form-control badge" id="proveedor">
	     			<option value="0">Seleccione</option>
	     			<?php
	     				foreach ($nombre as $n) {
	     			 ?>
	     			 	<option value="<?= $n['IdProveedor']?>"><?= $n['Nombre']?></option>
	     			 <?php
	     			 	}
	     			  ?>

	     		</select>
	      	</div>
	      	<div class="col-sm-3">
	      		<label>No. de orden de compra: </label>
	      	</div>
	      	<div class="col-sm-4">
	      		<input type="text" class="form-control form-control-sm bg-white" name="NumCompra" id="NumCompra" readonly="true" value="<?=$folioNumCompra?>">
	      	</div>
	      </div>
	      <br>
	      <div class="row">
	       	 <div class="col-sm-1">
	      		<label>Fecha</label>
	      	</div>
	      	<div class="col-sm-4">
	     		<input type="date" class="form-control form-control-sm" name="fecha" id="fecha"  onchange=" CompararFecha();">
	      	</div>
	      	<div class="col-sm-3">
	      		<label>Fecha Entrega del Bien o Servicio </label>
	      	</div>
	      	<div class="col-sm-4">
	      		<input type="date" class="form-control form-control-sm" name="fechaEntrega" id="fechaEntrega" onchange=" CompararFecha();">
	      	</div>
	      </div>
			<br>
			<div class="row" id="num_requsicion">
				<div class="col-sm-3">
					<label>Seleccione Número de requisición:</label>
				</div>
				<div class="col-sm-3">
					<select class="form-control form-control-sm" id="select_num_requisicion" data-model="Compra" >
						<option value="0" >seleccione</option>
						<?php foreach ($foliosRequisicion as $fr) {
								if ($fr['NumMaterialRd'] > $fr['NumMaterialOC']) {
						 ?>

						 <option value="<?=$fr['IdBitacora'].'|'.$fr['IdDep'].'|'.$fr['departamento'].'|'.$fr['Foliorequisicion']?>"><?=$fr['Foliorequisicion']?></option>
						<?php
								}
							}
						 ?>
					</select><br>
				</div>
			</div>

			<div class="table table-responsive-sm table-responsive-md small" id="tCompra">
				<table class="table table-sm  table-hover" >
					<thead>
						<tr>
							<th class="text-center" width="5%">Cantidad</th>
							<th class="text-center" width="10%">Unidad</th>
							<th class="text-center" width="33%">Descripción</th>
							<th class="text-center" width="15%">Área solicitante</th>
							<th class="text-center" width="12%">No.Requisición</th>
							<th class="text-center" width="10%">Precio Unitario</th>
							<th class="text-center" width="10%">Importe Parcial</th>
							<th class="text-center" width="2%"></th>
							<th class="text-center" width="3%"></th>
						</tr>
					</thead>
					<tbody id="tablaCompra">

					</tbody>

				</table>

			</div>
			<br>
			<div class="row">
				<div class="col-sm-10" >
					<label style="float: right;">IVA:</label>
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control bg-white" name="iva" id="iva" readonly="" placeholder="$">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10" >
					<label style="float: right;">IMPORTE TOTAL:</label>
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control bg-white" name="ImporteTotal" id="ImporteTotal" readonly="" placeholder="$">
				</div>
			</div>
			<br><hr>
			<div class="form-group">
				<div class="col-sm-12 text-right">
					<!-- <button class="btn btn-sm btn-danger" onclick="location.reload()"><span class="fa fa-times-circle"></span> Cancelar</button> -->

					<button type="submit" class="btn btn-sm btn-success"  > <span class="fa fa-check"></span> Guardar</button>
				</div>
			</div>
			<br>


	 </form>
	</div>
		</div>
		<div class="tab-pane fade" id="realizadas" role="tabpanel" aria-labelledby="realizadas-tab">
	<br>
		<div class="container border">
		 <div class="row justify-content-md-center">
	        <div class="col-sm-12 alert-color" >
              <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
                <label class="font-weight-bold"> ORDEN DE COMPRA REALIZADAS</label>
	           <!-- <i class="fa fa-angle-down" style="padding-left: 10px;"></i> -->
	        </div>
	     </div>
			<!-- <br> -->
			<!-- <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#TablaOrdenCompra">Ver ordenes de compras</button> -->
			<hr>
		     <div style="float: right;">
	    		<a href="<?php echo FOLDER_PATH ?>/Compra/ExportExcel" class="btn btn-sm btn-success  badge badge-round">
	    			<span class="fa fa-download"></span> Exportar Excel</a>
		     </div>
			<div>
					<div class="table  table-responsive-sm table-responsive-md small">
						<table class="table table-sm table-striped table-hover" id="table_id1">
							<thead class="thead-dark" >
								<tr>
									<th class="text-center">Proveedor</th>
									<th class="text-center" >No. de orden de compra</th>
									<th class="text-center" >Fecha pedido</th>
									<th class="text-center" >Fecha entrega</th>
									<th class="text-center" >Importe total</th>
									<th class="text-center" >PDF</th>
									<!-- <th class="text-center" >Editar</th> -->
								</tr>
							</thead>
							<tbody id="">
							<?php
							if ($result->num_rows > 0) {
								foreach ($result as $r) {
							 ?>
							 <tr>
							 	<td><?=$r['Nombre']?></td>
								 <td class="text-center"><?=$r['Num_compra']?></td>
								 <td class="text-center"><?=$r['FechaPedido']?></td>
								 <td class="text-center"><?=$r['FechaEntrega']?></td>
								 <td class="text-right"><?='$ '.$r['ImporteTotal']?></td>
								 <td>
								<center>
				                    <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
				                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
				                        <span class="icon-doc-text-inv"></span>
				                        <input type="hidden" name="num" value="PDFordenCompra">
				                        <input type="hidden" name="file" value="<?= $r["IDcompra"] ?>">
				                      </button>
				                    </form>
				                  </center>
								 </td>
							 </tr>

							 <?php
							 		}
							 	}
							  ?>
							</tbody>

						</table>

					</div>
			</div>

		</div>
		</div>
<div class="tab-pane fade" id="relacion" role="tabpanel" aria-labelledby="relacion-tab">
	<br>
		<div class="container border">
		 <div class="row justify-content-md-center">
	        <div class="col-sm-12 alert-color" >
              <img src="<?php echo PATH_PUBLIC ?>/img/lista.png">
                <label class="font-weight-bold"> Relación de Requisiciones Ejercicio <?php echo date('Y');?></label>

                <button class="btn btn-sm btn-success badge badge-round"></button>
	           <!-- <i class="fa fa-angle-down" style="padding-left: 10px;"></i> -->
	        </div>
	     </div>
	     <hr>
		 <div style="float: right; padding-left: 2px;">
	    	<a href="<?php echo FOLDER_PATH ?>/Compra/ExportExcelRRE" class="btn btn-sm btn-success  badge badge-round">
	    			<span class="fa fa-download"></span> Exportar Excel</a>
		 </div>	
	     <div style="float: right;">
     	
				 <form action="<?php echo FOLDER_PATH ?>/Visualiza/pdf" method="post"  target="_blank">
				  <button type="submit" class="btn btn-sm btn-success badge badge-round" >
				  	<span class="icon-doc-text-inv"></span> Ver PDF
				         <input type="hidden" name="num" value="PDFrelacionRBS">
				         <input type="hidden" name="file" value="all">
				   </button>
				  </form>      	     	
	     </div>
			<!-- <br> -->
			<div>
					<div class="table  table-responsive-sm table-responsive-md small">
						<table class="table table-sm table-striped table-hover" id="table_id2">
							<thead class="thead-dark" >
								<tr>
									<th class="text-center">N Requisición</th>
									<th class="text-center" >No. de orden de compra</th>
									<th class="text-center" >Fecha </th>
									<th class="text-center" >Area</th>
									<th class="text-center" >Solicitante</th>
									<th class="text-center" >Concepto</th>
									<th class="text-center" >Partida</th>
									<!-- <th class="text-center" >Editar</th> -->
								</tr>
							</thead>
							<tbody id="">
							<?php
							if ($relacionEjercicio->num_rows > 0) {
								foreach ($relacionEjercicio as $r) {
							 ?>
							 <tr>
							 	<td><?=$r['Foliorequisicion']?></td>
								 <td class="text-center"><?=$r['Num_compra']?></td>
								 <td class="text-center"><?=$r['FechaPedido']?></td>
								 <td class="text-center"><?=$r['NombreArea']?></td>
								 <td class="text-right"><?=$r['solicitante']?></td>
								 <td class="text-right"><?=$r['Concepto']?></td>
								 <td class="text-right"><?=$r['Codigo']?></td>
								 

							 </tr>

							 <?php
							 	}
							 	}else{
							  ?>
							<?php }
							?>
							</tbody>

						</table>

					</div>
			</div>

		</div>
		</div>
		<div class="tab-pane fade" id="entrada" role="tabpanel" aria-labelledby="entrada-tab">
			<br>
		<div class="container border">
		 <div class="row justify-content-md-center">
	        <div class="col-sm-12 alert-color" >
            <img src="<?php echo PATH_PUBLIC ?>/img/material.png">
              <label class="font-weight-bold"> ENTRADA DE MATERIALES COMPRADOS </label>
	           <!-- <i class="fa fa-angle-down" style="padding-left: 10px;"></i> -->
	        </div>
	     </div>
	     <br>
	 <div class="form-group row">
	   <div class="col-sm-2">
	   	<input type="hidden" name="id" value="<?=$ID?>">
	   	<label>N° Orden de compra</label>

		</div>
		<div class="col-sm-3">
	  	<select class="form-control" id="SelectNum_compra" data-model="Compra">
	  		<option value="0">Seleccione</option>
	  		<?php foreach ($NumOrdenCompra as $or) {

	  		 ?>
	  		 <option value="<?=$or['IDcompra']?>"><?=$or['Num_compra']?></option>
	  		<?php } ?>
	  	</select>
		</div>
	 </div>
	 <form enctype="multipart/form-data"  id="formAddMaterial" method="POST">
			<div class="table table-responsive-sm table-responsive-md small">
				<table class="table table-sm  table-hover" id="TableEntradaMaterial">
					<thead>
						<tr>
							<th class="text-center" width="2%">
								<input type="checkbox" class="selectAllMat" name="selectAll" id="selectAll" style="display: none;">
							</th>
							<th class="text-center" width="5%">Cantidad</th>
							<th class="text-center" width="10%">Unidad</th>
							<th class="text-center" width="33%">Descripción</th>
							<th class="text-center" width="15%">Área solicitante</th>
							<th class="text-center" width="15%">No.Requisición</th>
							<th class="text-center" width="10%">Precio Unitario</th>
							<th class="text-center" width="10%">Importe Parcial</th>
						</tr>
					</thead>
					<tbody id="tablaEntradaMat">

					</tbody>

				</table>

			</div>

		<div class="form-group row">
	 		<div class="col-sm-12">
	 			<button type="button" class="btn btn-success btn-sm" style="float: right; display: none;" id="btn_GuardarEM" ><span class="fa fa-check"></span> Guardar</button>
	 		</div>
	 	</div>
	 </form>
		</div>

	   	</div>
	</div>
	</div>

	</div>
<input type="hidden" id="num_tabla" value="4">
</main>

</body>
<?php require_once SCRIPTS; ?>


</html>
