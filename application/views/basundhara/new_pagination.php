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
<div class="col-md-12 search-panel">
            <!-- Search form -->
            <form method="post">
                <div class="input-group mb-3">
                    <input type="text" name="searchKeyword" class="form-control" placeholder="Search by keyword..." value="<?php echo $searchKeyword; ?>">
                    <div class="input-group-append">
                        <input type="submit" name="submitSearch" class="btn btn-outline-secondary" value="Search">
                        <input type="submit" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset">
                    </div>
                </div>
            </form>
        </div>
<table class="table" id='dataTable1'>
	<thead>
	<tr>
		<th>Application No</th>
		<th>Application Date</th>
		<th>Request Type</th>
		<th>Urban/Rural+Village Name</th>
		<th>Mouza/Lat</th>
		<th>Pending With/Status</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php foreach($pending as $pen): ?>
	<tr>
		<td><?=$pen->application_no?></td>
		<td><?=$pen->date_submission?></td>
		<td><?=$pen->service?></td>
		<td><?=$pen->rurban?>/<?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?></td>
		<!-- <td><?=$this->utilityclass->getVillageName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no,$pen->village_code)?></td> -->
		<td><?=$this->utilityclass->getMouzaName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code)?>/<?=$this->utilityclass->getLotName($pen->dist_code,$pen->subdiv_code,$pen->cir_code,$pen->mouza_code,$pen->lot_no)?></td>
		<td>
			<?php if($pen->pending_with_officer=='F')
			echo 'NA / ';
			else
			echo $pen->pending_with_officer.' / ';
			if (($pen->pending_with_officer=='NA' || $pen->pending_with_officer=='Approved' || $pen->pending_with_officer=='F') && $pen->status=='F')
			{
				echo "<kbd>Delivered</kbd>";
			}
			else if ($pen->pending_with_officer =='NA' && $pen->status='R' )
			{
			   echo "<kbd>Rejected</kbd>";	
			}
			else if($pen->status=='Q'){
				echo "<kbd>Query Sent</kbd>";
			} 
			else 
				echo "<kbd>Pending</kbd>";	
			?>

		</td>
		<td>
			<?php if($pen->service_code=='1'){ ?>
			<a href='<?php echo base_url() ?>index.php/basundhara/inheritanceBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> View</a>
			</td>
			<?php }else if($pen->service_code=='2'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/deedBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='5'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/allotmentBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='3'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/partitionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='9'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/conversionBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }else if($pen->service_code=='4'){  ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/reclassBasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			
			<?php }else if($pen->service_code=='7'){  ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/areaCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }
			else if($pen->service_code=='6'){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/nameCorrectionbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			<?php }
			else if($pen->service_code=='8'){ ?>
			<a href='<?php echo base_url() ?>index.php/basundhara/nameCancelbasuCO?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> View</a></td>
			
			<?php }else if(($pen->service_code=='10') and ($pen->pending_with_officer=='CO')){ ?>
				<a href='<?php echo base_url() ?>index.php/basundhara/mobileUpdationBasu?app=<?=$pen->application_no?>' class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'> Forward</a></td>
			<?php }?>
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
    	$('#dataTable').DataTable({bFilter: false, bInfo: false});
} );
</script>