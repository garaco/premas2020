<?php 

if ($_POST['method']=="requested") {
 ?>
 <div class="table table-responsive-sm table-responsive-md small">
 	<table class="table table-sm table-striped table-hover" id="table_main">
 		<thead class="thead-dark">
 			<tr>
                <th scope="col" class="text-center">N° de requisición</th>
                <th scope="col" class="text-center">Monto por adquisición</th>
<!--                 <th scope="col" class="text-center">Fecha de recepción</th>
                <th scope="col" class="text-center">Fecha de captura</th> -->
                <th scope="col" class="text-center">Departamento</th>
                <th scope="col" class="text-center">Solicitante</th>
                <th scope="col" class="text-center" >Concepto</th>
                <th scope="col" class="text-center">Fecha de autorización</th>
                <th scope="col" class="text-center">Estado de autorización</th>
                <!-- <th scope="col" class="text-center">Fecha de atención</th> -->
 			</tr>
 		</thead>
 		<tbody>
            <?php foreach ($result as $k) {
             ?>
 			<tr>
 				<td><?=$k['Foliorequisicion']?></td>
 				<td><?=$k['Costo']?></td>
<!--  				<td><?=$k['FechaRecepcion']?></td>
 				<td><?=$k['FechaReporte']?></td> -->
 				<td><?=$k['nombreDepto']?></td>
 				<td><?=$k['Subfijo'].$k['Nombre'].' '.$k['A_paterno'].' '.$k['A_materno']?></td>
 				<td><?=$k['Concepto']?></td>
 				<td><?=$k['FechaAutorizacion']?></td>
 				<td><?=$k['Estado']?></td>
 <!-- 				<td><?=$k['FechaAatencion']?></td> -->
 			</tr>
            <?php  }?>
 		</tbody>
 	</table>
 </div>
 <?php 
	}
  ?>
  <script type="text/javascript">
      
        $('#table_main').DataTable(
            {
                    "pagingType": "full_numbers",
                    "ordering": false,
                    "LengthMenu" : false,
                    language: {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     ">",
                            "sPrevious": "<"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                }
            );

  </script>