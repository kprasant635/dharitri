<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-12">           
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <div class="panel-body">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr class='active'>
                <th>Mouza</th>
                <th>Lot</th>
                <th>Village</th>
                <th>Case Number</th>
                <th>Submission date</th>
                <th>Dag</th>
				<th>Patta</th>
				<th>Patta Type</th>
            </tr>
        </thead>
        <tbody>
		<?php foreach($office as $c ){
			$d=$c->dist_code;
			$s=$c->subdiv_code;
			$cr=$c->cir_code;
			?>
            <tr>
                <th><?php echo $this->utilityclass->getMouzaName($d,$s,$cr,$c->mouza_pargona_code); ?></th>
				<th><?php echo $this->utilityclass->getLotLocationName($d,$s,$cr,$c->mouza_pargona_code,$c->lot_no); ?></th>
				<th><?php echo $this->utilityclass->getVillageName($d,$s,$cr,$c->mouza_pargona_code,$c->lot_no,$c->vill_townprt_code); ?></th>
				<th><?php echo $c->case_no; ?></th>
				<th><?php echo date('d/m/Y',strtotime($c->date_entry)); ?></th>
				<th><?php echo $c->dag_no; ?></th>
				<th><?php echo $c->patta_no ;?></th>
				<th><?php echo $this->utilityclass->getPattaName($c->patta_type_code) ;?></th>
                
            </tr>
		<?php } ?>  
        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>	