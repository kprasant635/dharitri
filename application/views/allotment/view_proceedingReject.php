<div class="container-fluid form-top login">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info panel-form">
				<form class="form-horizontal  unicode" method="POST" >              
					<div class='panel-body'>
						<div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
							<table class="table table-bordered" style="font-size: 16px;" border="1">
								<tr style="color:#0000cc; text-align: center;">
									<td>Serial No and Date of Order</td>
									<td width="40%">Order and Signature of Officer</td>
									<td width="40%">Note Of Action Taken on Order</td>
								</tr>
								<tr style="color:#0000cc; text-align: center;">
									<td>১</td>
									<td>২</td>
									<td>৩</td>
								</tr>
								<?php $i = 1;
								if(isset($pd)){
								 foreach ($pd as $case): ?>
									<tr>
										<td><?php echo "(" . $i . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
										<td><?php echo $case->co_order; ?></td>
										<td><?php echo $case->note_on_order; ?></td>
									</tr>
								<?php $i++; endforeach; } ?>


								<?php $i = $count+1;
								if(isset($pet_proceeding)){
								 foreach ($pet_proceeding as $row): ?>

								<tr>
									<td><?php echo "(" . $i . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
									<td><?=$row->note_on_order?></td>
									<td></td>
								</tr>
								<?php $i++; endforeach; } ?>
								<?php if($pb) {
									?>
									<tr>
									<td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($pb->date_entry)); ?></td>
									<td><?=$pb->lm_comment?></td>
									<td><?=$pb->sk_comment?></td>
								</tr>
								<?php }  ?>
							</table>
						</div>
					</div>
				</form>
			</div>  
		</div>
	</div>
</div>
<script>
	$('#BackHome').click(function(){
		location.href = "<?php echo base_url(); ?>index.php/home";
	});
	var dateToday = new Date(); 
	$(function() {
		$( "#ddmmyy" ).datepicker({
			numberOfMonths: 3,
			showButtonPanel: true,
			minDate: dateToday
		});
	});
</script>