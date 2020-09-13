<?php
if($_POST['method'] == 'pagination'){
  foreach ($result as $r){
  ?>
  <tr>
    <th scope="row"> <?= $r["Foliorequisicion"]; ?> </th>
    <td class="text-right" > <?= '$'.$r["Costo"];?></td>
    <td class="small text-justify"><?= $r["Concepto"]; ?> </td>
    <td class="text-center"><?= $r["FechaRecepcion"]; ?></td>
    <td><?= $r["nombreDepto"];?></td>
    <td class="text-center"><?= $r["Estado"];?></td>
    <td class="text-center"><?= $r["FechaAutorizacion"]; ?> </td>
    <td class="text-center"><?= $r["FechaAatencion"]; ?> </td>
    <td class="text-justify"><?= $r["Estatus"]; ?> </td>
  </tr>
  <?php
  }
}
?>
