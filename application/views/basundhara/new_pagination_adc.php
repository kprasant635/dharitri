<style>
.center {
  text-align: center;
}

.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
<center><mark>Application Received in Basundhara </mark></center>
<table class="table" id='dataTable1'>
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
					<a href='<?php echo base_url() ?>index.php/basundhara/inheritanceBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/inheritanceBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Action</a>
					<?php if($pen->is_urban=='N'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/fieldReport?app=<?=$pen->application_no?>' class='lmreportmut' > Report</a>
					<?php } ?>
				<?php } ?>
			</td>
			<?php }else if($pen->service_code=='2'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/deedBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/deedBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Action</a>
					<?php if($pen->is_urban=='N'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/fieldReport?app=<?=$pen->application_no?>' class='lmreportmut' > Report</a>
					<?php } else if($pen->is_urban=='Y'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/officeReport?app=<?=$pen->application_no?>' class='lmreportmut'> Report</a>
					<?php } ?>		
				<?php } ?>
				
			<?php }else if($pen->service_code=='5'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/allotmentBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/allotmentBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Action</a>
					<a href='<?php echo base_url() ?>index.php/allotment/viewproReject?app=<?=$pen->application_no?>' class='lmreportmut'> Report</a>
				<?php } ?>
				
			<?php }else if($pen->service_code=='3'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/partitionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/partitionBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'></i> Action</a>
					<?php if($pen->is_urban=='N'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/fieldReport?app=<?=$pen->application_no?>' class='lmreportmut' > Report</a>
					<?php } else if($pen->is_urban=='Y'){ ?>
						<a href='<?php echo base_url() ?>index.php/lmmutation/officeReport?app=<?=$pen->application_no?>' class='lmreportmut'> Report</a>
					<?php } ?>	
				<?php } ?>
				
			<?php }else if($pen->service_code=='9'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/conversionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/conversionBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }else if($pen->service_code=='4'){  ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/reclassBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/reclassBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
			
			<?php }else if($pen->service_code=='7'){  ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/areaCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/areaCorrectionbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }
			else if($pen->service_code=='6'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/nameCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/nameCorrectionbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
				
			<?php }
			else if($pen->service_code=='8'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/nameCancelbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/nameCancelbasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
			
			
			<?php }else if($pen->service_code=='10'){ ?>
				<?php if(($pen->allow_reapply=='Y') or ($pen->allow_reapply=='A') or ($pen->allow_reapply=='N') ){ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/mobileUpdationBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm  btn-info"><i class='fa fa-check-square-o'></i> View</a>
				<?php }else{ ?>
					<a href='<?php echo base_url() ?>index.php/basundhara/mobileUpdationBasu?app=<?=$pen->application_no?>' class="btn btn-sm  btn-primary"><i class='fa fa-check-square-o'> Action</a>
				<?php } ?>
			<?php }?>
			</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="center">
<div class="pagination">
            <?php echo $this->pagination->create_links(); ?>
</div></div>

<script>
	$(document).ready( function () {
    	$('#dataTableT').DataTable({bFilter: false, bInfo: false});
} );
</script>