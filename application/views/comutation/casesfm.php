        <div class="col-lg-12 ">
                <div class="well well-sm mis_report">
                    <h4 style="text-align: center;">
                        Pending Field Mutation
                    </h4>
                </div>
                <div class="error_container">
                        <?php
                            if($this->session->flashdata('message')){
                        ?>
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
            </div>
            <div class="col-lg-12 ">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                         <form class="searchfrm" method="post">
                            <div class="input-group">
                                <input type="text" name="searchKeyword" class="form-control col-sm-6 pull-right" placeholder="Search by keyword..." value="<?php echo $searchKeyword; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                            </div>
                        </form>
                         <table class='table table-striped' id='casess' width="100%">
                            <thead>
                                <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            </thead>
                            <?php foreach ($cases as $case): ?>
                            <tr>
                                <?php if(ESCALATION_ENABLE == 1)
                                {
                                    ?>
                                    <td><?=$case->escalation_zone?></td>
                                    <td><?=$case->escalation_date?></td>
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
                                    <?php if ($case->consent != 0): ?>
                                        <p class='text-info'> <i class='fa fa-exclamation-triangle red'></i><?php echo $this->lang->line('copattadar_consent_not_obtained');?>.</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($case->mut_type == '01'): ?>

                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/skmutation/getLMReport1?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='lmreportmut btn-sm btn btn-success '>
                                            <?php echo $this->lang->line('lm_report'); ?>
                                        </a>
                                         <?php else: ?> 
                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/skmutation/getLMReportPartition?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='lmreportpart btn-sm btn btn-success' id='myModal' ><?php echo $this->lang->line('lm_report'); ?></a>
                                    <?php endif; ?>

                                     <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/cofieldmutation/getSkNote?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='skreport btn-sm btn btn-success'  ><?php echo $this->lang->line('sk_report'); ?></a> 
                                    <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($case->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){?>  
                                            <!--////////////////// property chain report ///////////////////-->
                                        <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReport btn-sm btn btn-success'>View Property Chain</button>

                                        <!-- ///////////////////////////////////////////////// -->
                                    <?php }?>

                                  <a type="button" data-toggle="modal" data-target="#myModal" href='<?php echo base_url() . "index.php/cofieldmutation/freshLmReport?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="hide btn btn-sm btn-danger"><?php echo $this->lang->line('fresh_lm_report'); ?></a>
                                        <div style="height:5px;">&nbsp;</div>
                                        <!-- <a  type="button"  href='<?php //echo base_url() . "index.php/cofieldmutation/saveReport?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-danger"><?php //echo $this->lang->line('reject'); ?></a> -->
                                        <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$case->case_no?>','<?=SERVICE_FIELD_MUTATION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                        <!-- <a type="button"  id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/coorder?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-success" <?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?></a> -->
                                       <?php if($case->basundhara){



                                        if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                        {
                                            echo "Escalated to Upper Officer";
                                        }
                                        else
                                        {
                                            // --multigeneration flag checking---
                                            if(MULTIGENERATION_ACTIVE == 1){
                                                if($case->is_multigeneration == 'M' || $case->is_multigeneration =='S'){ ?>
                                                <a type="button"  id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/mutationInheritanceProfile?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-info"<?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>1</a>


                                                <?php }else{ ?>
                                                        <?php if($case->is_multidag == 'Y'): ?>
                                                            <a type="button"  id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/onePage_mutd?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-info"<?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>2</a>
                                                        <?php else: ?>
                                                            <a type="button"  id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/onePage?case_no=" . enc_param('case_no', $case->case_no, 600) . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-info"<?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>3</a>
                                                        <?php endif; ?>
                                               <?php  }
                                            }else{ ?>
                                                <?php if($case->is_multidag == 'Y'): ?>
                                                    <a type="button"  id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/onePage_mutd?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-info"<?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>4</a>
                                                <?php else: ?>
                                                    <a type="button"  id='co-order' href='<?php echo base_url() . "index.php/COFieldMutation/onePage?case_no=" .  enc_param('case_no', $case->case_no, 600) . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-sm btn-info"<?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>5</a>
                                                <?php endif; ?>
                                            <?php } ?>
                                        <?php } ?>
                                        


                                        
                                        
                                        <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/lmmutation/proreport?case_no=" . $case->case_no ?>" class='skreport btn-sm btn btn-success'  ><i class="fa fa-envelope-open" aria-hidden="true"></i> All Note(s)</a>  <br>

                                        <?php if($case->is_escalated == 0)
                                        {
                                            ?>
                                            <a href="<?php echo base_url() . "index.php/COFieldMutation/revertback?case_no=" . enc_param('case_no', $case->case_no, 600) . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>" class='text-small font-italic text-danger'>Click Here to Revert Back for Report</a>
                                        <?php } ?>
                                        

                                        
                                        <?php } else { ?>
                                        <a id='co-order'  href='<?php echo base_url() . "index.php/COFieldMutation/viewcasedetails?case_no=" . enc_param('case_no', $case->case_no, 600) . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' 
                                            class="btn btn-sm btn-success" <?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>
                                            </a>
                                        <?php }?><br>
                                       
                                       
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="pagination_links">
                            <?php echo $links; ?></div>
                        </div> 
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div> 
                </div>
</div> 
    
    
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='myModal'>
        <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
            <div class="modal-content"  style=" overflow-y: auto;">
                
            </div>
        </div>
    </div>

<script>
$(function() {
    let btnNameAttr;
    let btnValAttr;
    $('.btn').click(function(){
        btnNameAttr = $(this).attr('name');
        btnValAttr = $(this).attr('value');
    });
    $('.searchfrm').on('submit', function(){
        $('.btn').remove();
        $('form').append('<input type="hidden" class="submit_input" name="'+btnNameAttr+'" value="'+btnValAttr+'">');
    });
        $('.panel').on('click','.lmreportmut',function (e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });
            
        });
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
        
        $('#myModal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
        })
    

    // property chain modal


        $('#myModal').on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
            $('.modal-content').css('background-color', 'white');
            $('.modal-content').css('color', 'black');
        })
    });

    $(document).ready( function () {
        $('#zone_status').change(function(){
            var zone_status = $('#zone_status').val();
            $('#casess').DataTable().destroy();
            load_data(zone_status);
        });
        function load_data(zone_status)
        {
            var base_url = "<?php echo base_url();?>";
            var table = $('#casess').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering"  : false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language'  : {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneFieldMutationCo',
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

