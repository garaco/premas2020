<?php 
if ($_POST['method'] == 'search') {
	if ($result->num_rows > 0) {
		foreach ($result as $r) {
		
  ?>
                  <tr>
                    <th scope="row"><?= $r["Concepto"]; ?></th>
                    <td class="text-center"><?= $r["Medida"]; ?></td>
                    <td><?= $r["Codigo"]; ?></td>
                    <td class="text-center"><div <?=($r['Existencia'] == 0)?'style="background: #f00024; font-size: 14px; color: white; border-radius: 5px; font-weight: bold; width: 50px;"':'style="background: #00cc4b; font-size: 14px; color: white; border-radius: 5px; font-weight: bold; width: 50px;"'?>><?= $r['Existencia']?></div></td>
                  </tr>
 <?php }
	}
}
 ?>