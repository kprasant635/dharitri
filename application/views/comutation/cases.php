<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Pending Field Partition
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" name="searchKeyword" class="form-control col-sm-6 pull-right" placeholder="Search by keyword..." value="<?php echo $searchKeyword; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                            </div>
                        </form>
                        <table class='table table-striped table-bordered' id='casesp' width="100%">
                            <thead>
                                <?php 
                                if(ESCALATION_ENABLE == 1)
                                    {include(APPPATH."views/common/esc_table_head.php");}
                                 ?>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            </thead>
                            <?php 
                             foreach ($cases as $case): ?>
                            <tr>
                                <?php if(ESCALATION_ENABLE == 1){?>
                                    <td><?=$case->escalation_zone?></td>
                                    <td><?=$case->escalation_date?></td>
                               <?php  } ?>
                                
                                <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                <td class="center">
                                    <?php //echo ($case->mut_type == 01) ? 'Mutation' : 'Partition'; ?>
                                    <?php
                                    echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                    echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                    echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                    ?>
                                </td>
                                <td class="center">
                                    <p class='text-success'> <i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->date_entry)); ?></p>
                                    <?php if ($case->consent != 0): ?>
                                        <p class='text-info'> <i class='fa fa-exclamation-triangle red'></i><?php echo $this->lang->line('copattadar_consent_not_obtained');?>.</p>
                                    <?php endif; ?>
                                </td>
                                <td>

                                    <?php if($case->basundhara && $case->es_flag == 0){
                                     ?>
                                        <br><a href="<?php echo base_url() . "index.php/COFieldMutation/revertback?case_no=" . enc_param('case_no', $case->case_no, 600). "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='text-small font-italic text-danger'>Click Here to Revert Back for Report</a>


                                        <?php }else if($case->basundhara && $case->es_flag == 1)
                                        { ?>

                                            <?php if(ESCALATION_ENABLE ==1 && $case->is_escalated == 1)
                                            {
                                                echo "Escalated to Upper Officer";
                                            }else
                                            {
                                            ?>
                                            <br><a href="<?php echo base_url() . "index.php/COFieldMutation/revertbackNew?case_no=" . enc_param('case_no', $case->case_no, 600). "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='text-small font-italic text-danger'>Click Here to Revert Back</a>
                                            <?php } ?>
                                  <?php } ?>
                                        <br>
                                    <?php if ($case->mut_type == '01'): ?>
                                        

                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/skmutation/getLMReport1?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='lmreportmut btn-sm btn btn-success '>
                                            <?php echo $this->lang->line('lm_report'); ?>
                                        </a>

                                    <?php else: ?>
                                    

                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/skmutation/getLMReportPartition?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='lmreportpart btn-sm btn btn-success' ><?php echo $this->lang->line('lm_report'); ?></a>



                                    <?php endif; ?>

                                     <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/cofieldmutation/getSkNote?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='skreport btn-sm btn btn-success'  ><?php echo $this->lang->line('sk_report'); ?></a>
                                     <!-- //-------------INTEGRATION BLOCKCHAIN------------ -->
                                     <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($case->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){?>  
                                            <!--////////////////// property chain report ///////////////////-->
                                        <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReport btn-sm btn btn-success'>View Property Chain</button>

                                        <!-- ///////////////////////////////////////////////// -->
                                    <?php }?>

                                    <a disabled href='<?php echo base_url() . "index.php/skmutation/saveReport?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm hide btn-danger"><?php echo $this->lang->line('fresh_lm_report'); ?></a>

                                    <div style="height:5px;">&nbsp;</div>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$case->case_no?>','<?=SERVICE_FIELD_PARTITION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                    <!-- <a type="button" href='<?php //echo base_url() . "index.php/COFieldMutation/saveReport?reject=y&case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-danger"><?php //echo $this->lang->line('reject'); ?></a> -->
                                    
                                    <!-- <a type="button" id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/viewcasedetails?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-primary" <?php if($case->consent!=0) echo "disabled";?>><?php //echo $this->lang->line('pass_order');?></a> -->

                                    <?php if(ESCALATION_ENABLE ==1 && $case->is_escalated == 1)
                                    {
                                        echo "Escalated to Upper Officer";
                                    }else
                                    {
                                        ?>
                                        <a type="button" id='co-order' href='<?=base_url()."index.php/Partition/finalOrderFieldPartitionCO?case_no=".enc_param('case_no', $case->case_no, 600)."&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-primary" <?php if($case->consent!=0) echo "disabled";?>>Pass Order New</a>
                                    <?php } ?> <br>

                                    <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/lmmutation/proreport?case_no=" . $case->case_no ?>" class='skreport btn-sm btn btn-success'  ><i class="fa fa-envelope-open" aria-hidden="true"></i> All Note(s)</a>  <br>
                                    
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="pagination_links"> 

                             <?php echo $links; ?> </div> 

                         </div> 
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
    <div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='myModal'>
        <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
            <div class="modal-content"  style=" overflow-y: auto;">
                
            </div>
        </div>
    </div>
</div>


<script>
    
    $(function () {
        $('.panel').on('click','.skreport',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });
            
        });


        $('.panel').on('click','.lmreportpart',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });
            
        });
		
        $('#myModal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
	    });
    });
</script>
<script type="text/javascript">
    $(document).ready( function () {

        $('#myModal').on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
            $('.modal-content').css('background-color', 'white');
            $('.modal-content').css('color', 'black');
        })
    $('#zone_status').change(function(){
        var zone_status = $('#zone_status').val();
        $('#casesp').DataTable().destroy();
        load_data(zone_status);
    });

    function load_data(zone_status)
    {
        var base_url = "<?php echo base_url();?>";
        var table = $('#casesp').DataTable({
            'pageLength': 10,
            "processing": true,
            "serverSide": true,
            "ordering"  : false,
            "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language'  : {
                        "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                    },
            'ajax':{
                url: base_url+'index.php/EscalationController/searchByEscalationZoneFieldPartitionCo',
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
