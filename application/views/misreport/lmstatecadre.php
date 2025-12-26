  	<table class="table table-bordered">
  		<thead>
  			<tr>
  				<td>SL</td>
  				<td>Name</td>
  				<td>State Cadre Selection</td>
  				<td>Mouza Name</td>
  				<td>Lot Name</td>
  			</tr>
  		</thead>
  		<tbody>
  			<?php $i=0; foreach($lmstatecadre as $r) { ?>
  			<tr>
  				<td><?=$i+=1?></td>
  				<td><?=$r['name']?></td>
  				<td><?=strtoupper($r['confirm_y_n'])?></td>
  				<td><?=$r['mouza']?></td>
  				<td><?=$r['village']?></td>
  			</tr>
  		   <?php } ?>
  		</tbody>
  	</table>
