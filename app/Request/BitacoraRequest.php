<?php
if ($_POST['method'] == 'requested') {

  ?>

<form action="<?php echo FOLDER_PATH ?>/Bitacora/saveFile" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $ID; ?>">
      <input type="hidden" name="requisicion" value="<?=$Foliorequisicon?>">
      <input type="hidden" name="fecha" value="<?=$Fecha?>">
      <input type="hidden" name="estado" value="<?=$Estado?>">
        <div class="form-group row">
          <div class="col-sm-8">
            <label class="col-form-label"><strong>REQUISICION: <?=$Foliorequisicon?></strong></label>
          </div>
         </div>
         <div class="form-group row">
          <div class="col-sm-12">
            <label class="col-form-label">Subir archivo:</label>
             <input type="file" class="form-control bg-white" id="file" name="archivo" value="<?= $Archivo ?>">
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
<?php }
if ($_POST['method'] == 'addcomen') {
?>
<form action="<?php echo FOLDER_PATH ?>/Bitacora/saveComen" method="post">
    <input type="hidden" name="id" value="<?= $ID.'|'.$IdDep.'|'.$mes.'|'.$dateRecepcion?>">
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
        <input type="date" class="form-control bg-white" name="frecepcion" value="<?= ($Estado == 'PENDIENTE')?DATE:$Fecha?>">
      </div>
    </div>
    <br>
    <label class="col-form-label">Comentario:</label>
    <textarea class="col" name="concepto" rows="4" autocomplete="off"><?= $Concepto ?></textarea>
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
if ($_POST['method'] == 'search' || $_POST['method'] == 'busca') {
  if ($result->num_rows>0) {
$fila=0;
    foreach ($result as $r){
      ?>
             <tr>
                <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
                <td class="text-right" > <?= '$'.$r["Costo"];?></td>
                <td class="small text-justify"><?= $r["Concepto"]; ?> </td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaReporte"]; ?></td>
                <td class="text-center"><?= $r["Estado"];?></td>
                <td class="text-center"><?= $r["FechaAutorizacion"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td class="text-justify"><?= $r["Estatus"]; ?> </td>
                <td class="text-justify"><?= $r["Comentario"];?></td>
                  <td Id="visible">
<!--                     <center>
                     <div class="btn-group">
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/show" method="post"  target="_blank">
                          <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                            <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
                          </button>
                          <button type="button" class="btn btn btn-outline-dark btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Bitacora" data-operation="Editar" data-method="requested">
                            <span class="icon-upload"></span>
                          </button>
                        </form>
                     </div>
                    </center> -->
                   <center>
                    <form action="<?php echo FOLDER_PATH ?>/visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                  </td>
                  <td Id="visible">
                    <center>
                          <button type="submit" class="btn btn btn-outline-success btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Bitacora" data-operation="Editar" data-method="addcomen" data-estado="<?=$r['Estado']?>">
                            <span class="icon-pencil"></span>
                          </button>
                    </center>
                  </td>
                  <td>
                    <?php 
                if ($r['FechaEntrega'] <= DATE && $r["Estado"] != 'AUTORIZADO') { ?>
                  <center>
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/Cancel" method="POST" id="form<?=$fila?>">
                        <input type="hidden" id="ID" name="ID" value="<?= $r['IdBitacora'].'-'.$r['IdDep']?>">
                        <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill CancelarRequi" value="<?= $r['Foliorequisicion']?>" id="CancelarRequi<?=$fila?>" name="Cancelar" onclick="CancelarRequisicion(<?=$fila?>)" >
                        <span class="icon-trash"></span>
                      </button>
                       </form>                     
                  </center>
                <?php $fila++; 
              }
                     ?>
                  </td>
              </tr>
<?php

    }
  }else{
    ?>
    <br>
<!--       <tr>
          <td colspan="12" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr> -->
 <?php
  }
}
if ($_POST['method'] == 'CambiarUserPass') {?>
    <form action="<?php echo FOLDER_PATH ?>/Bitacora/UpdateUserPass" method="POST" onsubmit="return validarUserPass();">
       <label><strong>Usuario anterior:</strong></label>
       <div class="form-group row">
<!--           <div class="col-sm-1">
            <span class="fa fa-user fa-2x" style="color: gray"></span>
          </div>
          <div class="col-sm-11">
          <div class="group">      
          <input type="text"  name="UserActual" id="userActual" class="form-control" placeholder="Usuario" autocomplete="off" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label class="label">Usuario</label>
          </div>

          </div> -->
      <div class="col-sm-12">
             <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white" id="basic-addon1"><i class="fa fa-user"  style="color: gray"></i></span>
              </div>
          <input type="text"  name="UserActual" id="userActual" class="form-control" placeholder="Usuario" autocomplete="off" required>
            </div>           
          </div>
         </div>
         <br><hr><br>
      <label><strong>Nuevo Usuario y Password:</strong></label>
       <div class="form-group row">
<!--           <div class="col-sm-1">
            <span class="fa fa-user fa-2x" style="color: gray"></span>
          </div>
          <div class="col-sm-11">
          <div class="group">      
            <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" autocomplete="off" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label class="label">Usuario</label>
          </div>
          
          </div> -->
          <div class="col-sm-12">
             <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white" id="basic-addon1"><i class="fa fa-user"  style="color: gray"></i></span>
              </div>
            <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" autocomplete="off" required>
            </div>           
          </div>
         </div>
      <div class=" row">
<!--           <div class="col-sm-1">
            <span ></span>
          </div>
          <div class="col-sm-11">
          <div class="group">      
           <input type="text" name="password" id="password" class="form-control" placeholder="Contraseña" autocomplete="off" required>
          <span class="highlight"></span>
            <span class="bar"></span>
            <label class="label">Contraseña</label> -->
<!--           </div>

          </div>  -->
          <div class="col-sm-12">
             <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white" id="basic-addon1"><i class="fa fa-lock"  style="color: gray"></i></span>
              </div>
              <input type="text" name="password" id="password" class="form-control" placeholder="Contraseña" autocomplete="off" required>
            </div>           
          </div>

         </div>
    <div class="clearfix"></div><hr>
      <div class="form-group">
        <div class="col-sm-12 text-right">
          <button type="submit" class="btn btn-success btn-sm" ><span class="icon-ok-circle">Guardar</span></button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
        </div>
      </div>
   </form>
<?php
}
if($_POST['method'] == 'pagination'){
   foreach ($result as $r){
     if ($r["Foliorequisicion"] != '') { 
?>
             <tr>
                
                <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
                <td class="text-right" > <?= '$'.$r["Costo"];?></td>
                <td class="small text-justify"><?= $r["Concepto"]; ?> </td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaReporte"]; ?></td>
                <td class="text-center"><?= $r["Estado"];?></td>
                <td class="text-center"><?= $r["FechaAutorizacion"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td class="text-justify"><?= $r["Estatus"]; ?> </td>
                <td class="text-justify"><?= $r["Comentario"];?></td>
                  <td Id="visible">
<!--                     <center>
                     <div class="btn-group">
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/show" method="post"  target="_blank">
                          <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                            <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
                          </button>
                          <button type="button" class="btn btn btn-outline-dark btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Bitacora" data-operation="Editar" data-method="requested">
                            <span class="icon-upload"></span>
                          </button>
                        </form>
                     </div>
                    </center> -->
                   <center>
                    <form action="<?php echo FOLDER_PATH ?>/visualiza/pdf" method="post"  target="_blank">
                      <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                        <span class="icon-doc-text-inv"></span>
                        <input type="hidden" name="num" value="PDFrequisicion">
                        <input type="hidden" name="file" value="<?= $r["IdBitacora"] ?>">
                      </button>
                    </form>
                  </center>
                  </td>
                  <td Id="visible">
                    <center>
                          <button type="submit" class="btn btn btn-outline-success btn-sm badge badge-pill" data-toggle="modal" data-target="#ventana" data-id="<?= $r["IdBitacora"] ?>" data-model="Bitacora" data-operation="Editar" data-method="addcomen" data-estado="<?=$r['Estado']?>">
                            <span class="icon-pencil"></span>
                          </button>
                    </center>
                  </td>
              </tr>
<?php } 
  } 
}?>
