<center><mark>Application Received in Basundhara </mark></center>
<table class="table" id='dataTable'>
	<thead>
	<tr>
		<th>Application No</th>
		<th>Application Date</th>
		<th>Village Name</th>
		<th>Query</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php foreach($pending as $pen):
 ?>
	<tr>
		<td><?=$pen->application_no?></td>
		<td><?=$pen->date_submission?></td>
		<td><?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?></td>
		<td><?=$pen->query?></td>
		<td>
			<?php if($pen->service_code=='1'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N')){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/inheritanceBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/inheritanceBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Action</a>
					<?php if($pen->is_urban=='N'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/fieldReport?app=<?=$pen->application_no?>' class='lmreportmut' > Report</a>
					<?php } ?>
				<?php } ?>
			</td>
			<?php }else if($pen->service_code=='2'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/deedBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/deedBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Action</a>
					<?php if($pen->is_urban=='N'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/fieldReport?app=<?=$pen->application_no?>' class='lmreportmut' > Report</a>
					<?php } else if($pen->is_urban=='Y'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/officeReport?app=<?=$pen->application_no?>' class='lmreportmut'> Report</a>
					<?php } ?>		
				<?php } ?>
				
			<?php }else if($pen->service_code=='5'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/allotmentBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/allotmentBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }else if($pen->service_code=='3'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/partitionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/partitionBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }else if($pen->service_code=='9'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/conversionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/conversionBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }else if($pen->service_code=='4'){  ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/reclassBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/reclassBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
			
			<?php }else if($pen->service_code=='7'){  ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/areaCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/areaCorrectionbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }
			else if($pen->service_code=='6'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/nameCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/nameCorrectionbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }
			else if($pen->service_code=='8'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/nameCancelbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/nameCancelbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
			
			
			<?php }else if($pen->service_code=='10'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/mobileUpdationBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/rtps/mobileUpdationBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
			<?php }?>
			</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<!--  -->
<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
} );
	$(function () {
        $('.lmreportmut').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });
        });
    });
</script>