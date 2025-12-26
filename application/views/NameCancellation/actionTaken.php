<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Note of Action Taken on Proceeding Order for Name Cancellation Cases
                    </h2>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <a href="<?=base_url().'index.php/home/MutationAst'?>">
                <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
            </div>&nbsp;

            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                    <th class="center"><label class="control-label">Location</label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('due_date'); ?></label></th>
                                    <th class="center"><label class="control-label">&nbsp;</label></th>
                                </thead>
                            <tbody>
                                <?php foreach($cases as $case):?>
                                <tr>
                                    <?php if(ESCALATION_ENABLE == 1){ ?>
                                        <td class="center"><?=$case->escalation_zone;?></td>
                                        <td class="center"><?=$case->escalation_date;?></td>
                                    <?php } ?>
                                    <td><?php 
											echo $case->misc_case_no;					
										?>
                                        <br>
                                        <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                    </td>
                                    <td class="center">
                                        <?php
                                        echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                        echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                        echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td class="center"><p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : <?php echo date('M jS, Y', strtotime($case->next_date_of_hearing)); ?></p></td>
                                    <td class="center">
                                        <a class="btn btn-sm btn-block btn-primary" href="<?php echo base_url(); ?>index.php/NameCancellation/writenote?case_no=<?php echo $case->misc_case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><i class="fa fa-pencil"></i>&nbsp;Write Report</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable({
	"bLengthChange": false,
	"showNEntries" : false,
	"bSort" :	false,
	"bnew" :	false,
	"pageLength": 20
  });
  
});
</script> 


<script type="text/javascript">

    $(document).ready( function () {

        $('#zone_status').change(function(){

            var zone_status = $('#zone_status').val();
            $('#cases').DataTable().destroy();
            load_data(zone_status);
        });

        function load_data(zone_status)
        {
            var work_type = 'action_taken';
            var base_url = "<?php echo base_url();?>";
            var table = $('#cases').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering"  : false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language'  : {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneForDa',
                    type:'POST',
                    data: { zone_status:zone_status, work_type: work_type },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                    }]
            });
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
            
            // button search
            // $('.search_button').on('click', function () {
            //     $('table thead tr th .input_search').each(function(){
            //         $(this).val('');
            //     });
            //     $('#cases').DataTable().destroy();
            //     load_data();
            // });
        }
    });

</script>