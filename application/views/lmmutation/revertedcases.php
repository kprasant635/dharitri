        <div class="col-lg-12 ">
                <div class="well well-sm mis_report">
                    <h4 style="text-align: center;">
                        Reverted Field Mutation/ Partition case(s)
                    </h4>
                </div>
            </div>
            <div class="col-lg-12 ">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Reverted <?php echo $this->lang->line('pending_cases');  ?> 
                        </h3>
                    </div>
                    <div class="panel-body">
                         <table class='table table-striped' id='cases' width="100%">
                            <thead>

                                <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>

                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>

                            </thead>
                            <?php foreach ($cases as $case): ?>
                            <tr>
                                <?php if(ESCALATION_ENABLE == 1){ ?>
                                    <td class="center"><?=$case->escalation_zone;?></td>
                                    <td class="center"><?=$case->escalation_date;?></td>
                                <?php } ?>

                                <td><a href="#"><?php echo $case->case_no; ?></a><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                </td>
                                <td class="center">
                                    <?php //echo ($case->mut_type == 01) ? $this->lang->line('mutation') :$this->lang->line('partition'); ?>
                                    <?php
                                    echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                    echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                    echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                    ?>
                                </td>
                                <td class="center">
                                    <i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->report_date)); ?>
                                   
                                </td>
                                <td>
                                    <?php if ($case->mut_type == '01'): ?>

                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/skmutation/getLMReport1?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='skreport btn-sm btn btn-success '>
                                            <i class="fa fa-envelope-open" aria-hidden="true"></i> <?php echo $this->lang->line('lm_report'); ?>
                                        </a>
                                         <?php else: ?> 
                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/skmutation/getLMReportPartition?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='skreport btn-sm btn btn-success'  ><i class="fa fa-envelope-open" aria-hidden="true"></i> <?php echo $this->lang->line('lm_report'); ?></a>
                                    <?php endif; ?>
                                    <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/cofieldmutation/getSkNote?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='skreport btn-sm btn btn-success'  ><i class="fa fa-envelope-open" aria-hidden="true"></i> <?php echo $this->lang->line('sk_report'); ?></a> 
                                      <div style="height:5px;">&nbsp;</div>
                                    <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/lmmutation/proreport?case_no=" . $case->case_no ?>" class='skreport btn-sm btn btn-success'  ><i class="fa fa-envelope-open" aria-hidden="true"></i> All Note(s)</a>
                                    <?php if($this->session->userdata('user_desig_code')=='LM'){

                                        if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                        {
                                            echo "Escalated to Appellate Authority";
                                        }
                                        else
                                        {
                                            ?>

                                            <a type="button" href='<?php echo base_url() . "index.php/lmmutation/freshLmReport?case_no=" . enc_param('case_no', $case->case_no, 600) ?>' class="btn btn-sm btn-danger"> <i class="fa fa-reply-all" aria-hidden="true"></i> Fresh Report</a>
                                    <?php }

                                     ?>
                                  
                                  <?php }else{?>

                                        <?php if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                        {
                                            echo "Escalated to Appellate Authority";
                                        }
                                        else
                                        {
                                            ?>
                                            <a type="button" href='<?php echo base_url() . "index.php/lmmutation/freshskReport?case_no=" . enc_param('case_no', $case->case_no, 600) ?>' class="btn btn-sm btn-danger"> <i class="fa fa-reply-all" aria-hidden="true"></i> Fresh Report</a>
                                        <?php } ?>
                                  <?php } ?> 
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table> 
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div> 
                </div>
</div> 
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
        <div class="modal-content"  style=" overflow-y: auto;">
            
        </div>
    </div>
</div>
<script>


    <?php if(ESCALATION_ENABLE == 1){ ?>

        $(document).ready( function () 
        {
            $('#zone_status').change(function()
            {
                var zone_status = $('#zone_status').val();
                $('#cases').DataTable().destroy();
                load_data(zone_status);
            });

            function load_data(zone_status)
            {
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
                        url: base_url+'index.php/EscRevertController/searchByEscalationZoneRevertedForLm',
                        type:'POST',
                        data: { zone_status:zone_status },
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
            }
        });

    <?php } ?>

    $(function () {
        $('.panel').on('click','.lmreportmut',function (e) {
            e.preventDefault();
            console.log($(this));
            $('#myModal .modal-content').html("");
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                }
            }); 
        });
        $('.panel').on('click','.skreport',function (e) {
            e.preventDefault();
            $('#myModal .modal-content').html("");
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                }
            });    
        });
        $('#myModal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
    	});
    });

</script>  