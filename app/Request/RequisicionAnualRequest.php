<?php
require_once ROOT . FOLDER_PATH .'/app/Models/DepartamentoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/PartidasModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MaterialModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/ProyectoModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/MetasModel.php';
require_once ROOT . FOLDER_PATH .'/app/Models/RequisicionAnualModel.php';

static $IdMetas;


if ($_POST['method'] == 'requested') {
$req = new RequisicionAnualModel();
$proyRequest=$_POST['pagSelect'];
if($_POST['id']!=0){
  $req=$req->getByIdReq($_POST['id'],'IdPrograma_anual');
  $proyRequest=$req->IdProyecto;
}

?>
<!-- este formulario agrega por ajax para que no se cambia de pestaña cada que se agregue un registro -->
  <form id="form" method="post">
      <input type="hidden" name="model" value="RequisicionAnual">
      <input type="hidden" name="method" value="save">
      <input type="hidden" name="id"  value="<?= $_POST['id']; ?>">
      <input type="hidden" name="anio" id="anio" value="<?= $_POST['anio']; ?>">

      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label font-weight-bold">Proyecto</label>
          <select class="form-control badge badge-default bg-white" name="proyecto" id="proyecto">
            <?php
             $proyecto= $req->getProyecOne($proyRequest,$_POST['anio']);
             foreach ($proyecto as $d) {$IdMetas= $d['IdMeta']?>
            <option value="<?=$d['IdProyecto'].'|'.$IdMetas;?>"
              <?= ($d['IdProyecto'] == $proyRequest) ? ' selected' : '' ?>> <?=$d['sProyecto'];?>
            </option>
            <?php }?>
          </select>
          <input type="hidden" name="metas" value="<?= $IdMetas ?>">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          <label hidden class="col-form-label font-weight-bold">Departamento</label>
          <select hidden class="form-control badge badge-default bg-white" id="departamento" name="departamento" >
            <?php  $depa = new DepartamentoModel();
            ($Type == 'SuperAdmin') ? $depa= $depa->getById('idDepart',$_POST['pagDep']) : $depa= $depa->getById('idDepart',$this->session->get('Dep')) ;
            foreach ($depa as $d) {?>
            <option value="<?=$d['idDepart'];?>" <?= ($d['idDepart'] == $req->IdDepartamento) ? ' selected' : '' ?>>
              <?=$d['nombreDepto'];?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
         <label class="col-form-label font-weight-bold">Material</label>
         <select class="form-control badge badge-default bg-white" name="material" id="material" onChange="adicionales()">
           <?php  $depa = new MaterialModel();
           $depa= $depa->getAll('Concepto');?>
           <?php foreach ($depa as $d) {?>
           <option value="<?=$d['IDmaterial']."|".$d['Concepto']."|".$d['Medida']."|".$d['Precio']."|".$d['IdPartidas'];?>"
             <?= ($d['IDmaterial'] == $req->IdMaterial) ? ' selected' : '' ?>> <?= $d['Concepto']?>
           </option>
           <?php }?>
         </select>
       </div>
      </div>
      <div class="row" id="up">

       </div>
          <div class="row">
            <div class="col-sm-12">
              <label class="col-form-label font-weight-bold">Cantidad Mensual</label>
            </div>
          </div>
          <div class="clearfix"></div><hr>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Enero</label>
              <input type="number" name="Enero" id="Enero" class="form-control" value="<?=$req->Ene; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Febrero</label>
              <input type="number" name="Febrero" id="Febrero" class="form-control" value="<?=$req->Feb; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Marzo</label>
              <input type="number" name="Marzo" id="Marzo" class="form-control" value="<?=$req->Mar; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Abril</label>
              <input type="number" name="Abril" id="Abril" class="form-control" value="<?=$req->Abr; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Mayo</label>
              <input type="number" name="Mayo" id="Mayo" class="form-control" value="<?=$req->May; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Junio</label>
              <input type="number" name="Junio" id="Junio" class="form-control" value="<?=$req->Jun; ?>" min="0" pattern="^[0-9]+">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Julio</label>
              <input type="number" name="Julio" id="Julio" class="form-control" value="<?=$req->Jul; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Agosto</label>
              <input type="number" name="Agosto" id="Agosto" class="form-control" value="<?=$req->Ago; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Septiembre</label>
              <input type="number" name="Septiembre" id="Septiembre" class="form-control" value="<?=$req->Sep; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Octubre</label>
              <input type="number" name="Octubre" id="Octubre" class="form-control" value="<?=$req->Oct; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Noviembre</label>
              <input type="number" name="Noviembre" id="Noviembre" class="form-control" value="<?=$req->Nov; ?>" min="0" pattern="^[0-9]+">
            </div>
            <div class="col-sm-2">
              <label class="col-form-label font-weight-bold">Diciembre</label>
              <input type="number" name="Diciembre" id="Diciembre" class="form-control" value="<?=$req->Dic; ?>" min="0" pattern="^[0-9]+">
            </div>
          </div>
           <div class="clearfix"></div><hr>
      <div class="form-group ">
           <div class="col-sm-12 text-right ">
             <button type="submit" class="btn btn-success btn-sm" id="send" data-dismiss="modal" onclick="save('RequisicionAnual');"><span class="icon-ok-circle">Guardar</span></button>
             <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="icon-cancel-circle">Cancelar</span></button>
           </div>
      </div>
  </form>
<?php }else if($_POST['method'] == 'search'){
  // metodo para busqueda por departamento
  $req = new RequisicionAnualModel();
  $proyectos=$req->getProyectosDep($_POST['opt'],date('Y'));
  $conAll=0;
  $pagproy='';
?>
<!-- tabs de los proyectos -->
<ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-left:20px;">
  <?php $cont=0; foreach ($proyectos as $p){ ?>
    <li class="nav-item">
      <a class="pag_nav nav-link <?php if($cont==0) { echo 'active'; } ?> " id="ant-tab-<?= $cont; ?>" data-toggle="tab"
        href="#ant-<?= $cont;  ?>" role="tab" aria-controls="ant-<?= $cont;  ?>" aria-selected="true" onclick="tables(<?= $cont;?>,<?= $p['IdProyecto'];?>,<?= date('Y'); ?>,'RequisicionAnual')"
          >
        <?= $p['nProyecto']; ?>
      </a>
    </li>
  <?php $cont++; } ?>
</ul>
<!-- datos de tablas de acuerod a cada proyecto -->

<div class="tab-content" id="myTabContent">

  <?php $cont=0; foreach ($proyectos as $p){
     $conAll++;
     ($conAll==1)?$pagproy=$p['IdProyecto']:'';
     $explode = explode("-", $p['Proy']);
     $resultados=$req->getReqDep($p['IdUsuario'],date('Y'),$p['IdProyecto']);
    ?>
  <div class="tab-pane fade <?= ($cont==0) ? 'show active' : '';  ?>" id="ant-<?= $cont;  ?>" role="tabpanel" aria-labelledby="ant-tab-<?= $cont;  ?>">
    <label class="col-sm-12 col-form-label h2" style="font-weight:bold;"><?= $explode[0]; ?></label>
  <div class="container-fluid border" id="container-fluid-pago">
    <br>
    <div class="table table-bordered table-responsive-sm table-responsive-md small" >
      <table class="table table-sm table-striped table-hover" id="tableid<?= $conAll;?>">
        <thead class="thead-dark">
          <tr>
            <th rowspan="2" scope="col" class="text-center">Proyecto </th>
            <th rowspan="2" scope="col" class="text-center">Meta</th>
            <th rowspan="2" scope="col" class="text-center">Partida</th>
            <th rowspan="2" scope="col" class="text-center">Descipcion del Articulo</th>
            <th rowspan="2" scope="col" class="text-center">Unidad de Medida</th>
            <th rowspan="2" scope="col" class="text-center">Precio Unitario</th>
            <th colspan="12" scope="col" class="text-center">Cantidad Mensual</th>
            <th colspan="2" class="text-center">Total</th>
            <?php if($Type == 'SuperAdmin'){?><th colspan="2" class="text-center"></th><?php } ?>
          </tr>
          <tr>
            <th scope="col" class="text-center">Ene</th>
            <th scope="col" class="text-center">Feb</th>
            <th scope="col" class="text-center">Mar</th>
            <th scope="col" class="text-center">Abr</th>
            <th scope="col" class="text-center">May</th>
            <th scope="col" class="text-center">Jun</th>
            <th scope="col" class="text-center">Jul</th>
            <th scope="col" class="text-center">Ago</th>
            <th scope="col" class="text-center">Sep</th>
            <th scope="col" class="text-center">Oct</th>
            <th scope="col" class="text-center">Nov</th>
            <th scope="col" class="text-center">Div</th>
            <th scope="col" class="text-center">Cantidad</th>
            <th scope="col" class="text-center">Precio</th>
            <?php if($Type == 'SuperAdmin'){?><th scope="col" class="text-center"></th><?php } ?>
          </tr>
        </thead>
        <tbody class="container-table">
          <?php foreach ($resultados as $r) {?>
          <tr>
            <td class="small text-justify"> <?= $r->Proyectos;?></td>
            <td class="small text-justify"> <?= $r->Metas;?></td>
            <td class="small text-justify"> <?= $r->Partida;?></td>
            <td class="small text-justify"><?= $r->Articulo; ?> </td>
            <td class="text-center"><?= $r->UnidadMedida; ?></td>
            <td class="text-center"><?= $r->PU; ?></td>
            <td class="text-center"><?= $r->Ene;?></td>
            <td class="text-center"><?= $r->Feb; ?> </td>
            <td class="text-center"><?= $r->Mar; ?> </td>
            <td class="text-center"><?= $r->Abr; ?> </td>
            <td class="text-center"><?= $r->May; ?> </td>
            <td class="text-center"><?= $r->Jun; ?> </td>
            <td class="text-center"><?= $r->Jul; ?> </td>
            <td class="text-center"><?= $r->Ago; ?> </td>
            <td class="text-center"><?= $r->Sep; ?> </td>
            <td class="text-center"><?= $r->Oct; ?> </td>
            <td class="text-center"><?= $r->Nov; ?> </td>
            <td class="text-center"><?= $r->Dic; ?> </td>
            <td class="text-center"><?= $r->Cantidad; ?> </td>
            <td class="text-center"><?= "$".$r->Total; ?> </td>
            <?php if($Type == 'SuperAdmin'){?>
              <td>
              <center>
                <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Editar" data-method="requested" >
                  <span class="icon-pencil"></span>
                </button>
              </center>
          <center>
            <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Eliminar" data-method="delete" >
              <span class="icon-trash"></span>
            </button>
          </center>
              </td>
            <?php } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
     </div>
    </div>
    </div>
    <?php $cont++; } ?>
    <input type="hidden" id="pag-select" value="<?= $pagproy; ?>">
</div>

<?php
}else if($_POST['method'] == 'save'){
  $req = new RequisicionAnualModel();
  $resultados=$req->getReqDep($IdU,$yr,$dp);
   foreach ($resultados as $r) {?>
  <tr>
    <td class="small text-justify"> <?= $r->Proyectos;?></td>
    <td class="small text-justify"> <?= $r->Metas;?></td>
    <td class="small text-justify"> <?= $r->Partida;?></td>
    <td class="small text-justify"><?= $r->Articulo; ?> </td>
    <td class="text-center"><?= $r->UnidadMedida; ?></td>
    <td class="text-center"><?= $r->PU; ?></td>
    <td class="text-center"><?= $r->Ene;?></td>
    <td class="text-center"><?= $r->Feb; ?> </td>
    <td class="text-center"><?= $r->Mar; ?> </td>
    <td class="text-center"><?= $r->Abr; ?> </td>
    <td class="text-center"><?= $r->May; ?> </td>
    <td class="text-center"><?= $r->Jun; ?> </td>
    <td class="text-center"><?= $r->Jul; ?> </td>
    <td class="text-center"><?= $r->Ago; ?> </td>
    <td class="text-center"><?= $r->Sep; ?> </td>
    <td class="text-center"><?= $r->Oct; ?> </td>
    <td class="text-center"><?= $r->Nov; ?> </td>
    <td class="text-center"><?= $r->Dic; ?> </td>
    <td class="text-center"><?= $r->Cantidad; ?> </td>
    <td class="text-center"><?= "$".$r->Total; ?> </td>
      <?php if($Type == 'SuperAdmin'){?>
      <td>
      <center>
        <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Editar" data-method="requested" >
          <span class="icon-pencil"></span>
        </button>
      </center>
  <center>
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Eliminar" data-method="delete" >
      <span class="icon-trash"></span>
    </button>
  </center>
      </td>
    <?php } ?>
  </tr>
  <?php }
}
else if($_POST['method'] == 'onload'){
  $req = new RequisicionAnualModel();

  $resultados=$req->getReqDep($IdU,$_POST['anio'],$_POST['proy']);
   foreach ($resultados as $r) {?>
  <tr>
    <td class="small text-justify"> <?= $r->Proyectos;?></td>
    <td class="small text-justify"> <?= $r->Metas;?></td>
    <td class="small text-justify"> <?= $r->Partida;?></td>
    <td class="small text-justify"><?= $r->Articulo; ?> </td>
    <td class="text-center"><?= $r->UnidadMedida; ?></td>
    <td class="text-center"><?= $r->PU; ?></td>
    <td class="text-center"><?= $r->Ene;?></td>
    <td class="text-center"><?= $r->Feb; ?> </td>
    <td class="text-center"><?= $r->Mar; ?> </td>
    <td class="text-center"><?= $r->Abr; ?> </td>
    <td class="text-center"><?= $r->May; ?> </td>
    <td class="text-center"><?= $r->Jun; ?> </td>
    <td class="text-center"><?= $r->Jul; ?> </td>
    <td class="text-center"><?= $r->Ago; ?> </td>
    <td class="text-center"><?= $r->Sep; ?> </td>
    <td class="text-center"><?= $r->Oct; ?> </td>
    <td class="text-center"><?= $r->Nov; ?> </td>
    <td class="text-center"><?= $r->Dic; ?> </td>
    <td class="text-center"><?= $r->Cantidad; ?> </td>
    <td class="text-center"><?= "$".$r->Total; ?> </td>
      <?php if($Type == 'SuperAdmin'){?>
      <td>
      <center>
        <button type="button" class="btn btn btn-outline-info btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Editar" data-method="requested" >
          <span class="icon-pencil"></span>
        </button>
      </center>
  <center>
    <button type="button" class="btn btn btn-outline-danger btn-sm badge badge-pill" id="edita" value="1" data-toggle="modal" data-target="#ventana" data-id="<?= $r->IdPrograma_anual ?>" data-anio="<?= date('Y'); ?>" data-model="RequisicionAnual" data-operation="Eliminar" data-method="delete" >
      <span class="icon-trash"></span>
    </button>
  </center>
      </td>
    <?php } ?>
  </tr>
  <?php }
}else if ($_POST['method'] == 'delete') {
      $req = new RequisicionAnualModel();
      $req=$req->getByIdReq($_POST['id'],'IdPrograma_anual');
   ?>
    <form action = "<?php echo FOLDER_PATH ?>/RequisicionAnual/remove" method = "post">
      <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
      <div class="form-group row">
        <div class="col-sm-12">
          <label class="col-form-label h1"> ¿Seguro que desa eliminar: <?= $req->Articulo; ?> ?</label>
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
?>
