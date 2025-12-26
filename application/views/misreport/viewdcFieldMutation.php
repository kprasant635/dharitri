<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12  panel panel-default panel-body ">
            <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2e4d8e"> Field Mutation Order Passed with specific date </h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">All cases Details</h3>
                </div>
                <div class="panel-body">
                    <table id="dataTable" class="display table" cellspacing="0" width="100%" >
						<thead class='active'>
							<tr>
								<th>Sl No</th>
								<th>Application Date</th>
								<th>Mutation No</th>
								<th>Circle Name</th>
								<th>Lot No</th>
								<th>Village Name</th>
								<th>Dag No</th>
								<th>Applicant Name</th>
								<th>Order Pass Date</th>
								
							</tr>
						</thead>
						<tbody>
						<?php $i=1;
						foreach($result as $key=>$value):?>
						<tr>
								<td><?=$i;?></td>
								<td><?=date('d/m/Y',strtotime($value['entrydate']))?></td>
								<td><span class='red'><?php 
														$caseno=explode("#",$key);
														echo $caseno[0];
														//echo $caseno[1];
								?></span></td>
								<td><?=$this->utilityclass->getCircleName($value['dist'],$value['sub'],$value['cir'])?></td>
								<td><?=$this->utilityclass->getLotName($value['dist'],$value['sub'],$value['cir'],$value['mou'],$value['lot'])?></td>
								<td><?=$this->utilityclass->getVillageName($value['dist'],$value['sub'],$value['cir'],$value['mou'],$value['lot'],$value['vill'])?></td>
								<td><?=$value['dag_no']?></td>
								<td><span class='green'><?=$value['occupant']."</span><br>(".$value['gurdian'].")";?></td>
								<td><?=date('d/m/Y',strtotime($value['finaldate']));?></td>
							</tr>
						<?php 
						$i++;
						endforeach;
						?>
						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    $('#dataTable').DataTable();
	});
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport' ?>";
    };
	
</script>