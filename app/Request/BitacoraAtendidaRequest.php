<?php

if ($_POST['method'] == 'search' || $_POST['method'] == 'busca') {
  if ($result->num_rows>0) {

    foreach ($result as $r){
      ?>
              <tr>
                <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
                <td class="text-right" > <?= '$'.$r["Costo"];?></td>
                <td class="small"><?= $r["Concepto"]; ?> </td>
                <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
                <td class="text-center"><?= $r["FechaReporte"]; ?></td>
                <td class="text-center"><?= $r["FechaAutorizacion"];?></td>
                <td class="text-center"><?= $r["Estado"]; ?> </td>
                <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
                <td class="text-center"><?= $r["Estatus"]; ?> </td>
                <td><?= $r["Comentario"];?>
                </td>
                  <td>
<!--                     <center>
                     <div class="btn-group">
                        <form action="<?php echo FOLDER_PATH ?>/Bitacora/show" method="post"  target="_blank">
                          <button type="submit" class="btn btn btn-outline-primary btn-sm badge badge-pill" >
                            <span class="icon-doc-text-inv"></span><input type="hidden" name="file" value="<?= $r["Archivo"] ?>">
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
              </tr>
<?php

    }
  }else{
    ?>
    <br>
<!--       <tr>
          <td colspan="11" class="text-center font-weight-bold">Ningún elemento coincide con la búsqueda...</td>
      </tr> -->
 <?php
  }
}
?>
