<form method="POST" action="<?php echo base_url() . 'index.php/utilityController/urbanRuralpost' ?>">
<table class="table">
	<thead>
		<tr>
			<td>Village Name</td>
			<td>Rural</td>
			<td>Urban</td>
			<td>Update Status</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach ($list as $key => $value) {
			$rural=$position=null;
			$position =substr($value['vill_townprt_code'], 0, 1);
		?>
			<input type="hidden" name="dist_code" value="<?=$value['dist_code']?>">
			<input type="hidden" name="subdiv_code" value="<?=$value['subdiv_code']?>">
			<input type="hidden" name="cir_code" value="<?=$value['cir_code']?>">
			<input type="hidden" name="mouza_pargona_code" value="<?=$value['mouza_pargona_code']?>">
			<input type="hidden" name="lot_no" value="<?=$value['lot_no']?>">
			<input type="hidden" name="vill_townprt_code[<?=$i?>]" value="<?=$value['vill_townprt_code']?>">
		<tr>
			<td><?=$value['loc_name']?></td>
			<?php 
			if($value['rural_urban']=='R'){
				 $rural='checked';
			?>
			<td><input type="radio" value="R" <?= $rural;?> name="village[<?=$i?>]"> Rural </td>
			<td><input type="radio" value="U" name="village[<?=$i?>]"> Urban</td>
			<?php } else if($value['rural_urban']=='U') {  $rural="checked"; ?>
			<td><input type="radio" value="R" name="village[<?=$i?>]"> Rural </td>
			<td><input type="radio" value="U" <?= $rural;?> name="village[<?=$i?>]"> Urban</td>

			<?php }else{ ?>
			<td><input type="radio" value="R" name="village[<?=$i?>]"> Rural </td>
			<td><input type="radio" value="U" name="village[<?=$i?>]"> Urban</td>
			<?php } ?>
			<td class="text-danger"><?php echo $value['rural_urban']=='N' ? 'Not Updated' : 'Updated'; ?></td>
		</tr>
		<?php
		$i++;
		}
		 ?>
	</tbody>
</table>
<center><button type="submit" name="submit" class="btn btn-success" ><i class='fa fa-check'></i>&nbsp;Update Village Status</button></center>
</form>