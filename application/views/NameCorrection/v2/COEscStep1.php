<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('pending_miscellaneous_cases');?>(Escalated)</h2>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="col-lg-10 col-lg-offset-1">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                       <h3 class="panel-title">
                            <?php echo $this->lang->line('pattadar_name_correction'); ?>
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
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' width="100%" id="cases">
                            <thead>

                                <th><label class="control-label"><?php echo $this->lang->line('sl_no');?></label></th>

                                <?php
                                    if(ESCALATION_ENABLE == 1) {
                                        include(APPPATH."views/common/esc_table_head.php");
                                    }
                                ?>

                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            </thead>
                            <?php
                            $row = count($MisCases);
                            if ($row > 0) {
                            $c = 1;
                            foreach ($MisCases AS $cases) 
                            {
                                $type=$cases->misc_case_type;
                                ?>
                                <tr>
                                    <td class="center"><?php echo $c; ?></td>

                                    <?php if(ESCALATION_ENABLE == 1) { ?>
                                        <td class="center"><?=$cases->escalation_zone;?></td>
                                        <td class="center"><?=$cases->escalation_date;?></td>
                                    <?php } ?>

                                    <td><?php echo $cases->misc_case_no; ?><br>
                                    <span class='small font-italic red'><?php if($cases->basundhara){ echo "Basundhara:". $cases->basundhara ;} ?> </span></td>
                                    <td class="center"><?php 
                                        if($type==06){
                                            echo "নাম সংশোধন";
                                            $url=base_url() . "index.php/NameCorrectionV2/finalOrderCONameCorrection";
                                        }
                                        elseif ($type==07) {
                                            echo "নাম কৰ্ত্তন";
                                            $url=base_url() . "index.php/NameCancellation/COStep2";
                                        }
                                        ?></td>
                                    <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($cases->submission_date)); ?></td>
                                    <td class="center">
                                    <?php if(ESCALATION_ENABLE == 1 && $cases->is_escalated == 1 && $cases->out_of_esc==0){ 
                                                echo "Escalated to Appellate Authority";
                                             } else { ?>

                                                <a href="<?=$url?>?misc_case_no=<?php echo enc_param('misc_case_no', $cases->misc_case_no, 600)."&petition_no=".$cases->misc_case_petition_no; ?>" class="btn btn-sm btn-primary"> <?php echo $this->lang->line('pass_order');?></a>

                                            <!--////////////////// property chain report ///////////////////-->

                                            <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){?>
                                                <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $cases->misc_case_no ?>" dist_code="<?= $cases->dist_code ?>" subdiv_code="<?= $cases->subdiv_code ?>" cir_code="<?= $cases->cir_code ?>" mouza_pargona_code="<?= $cases->mouza_pargona_code ?>" lot_no="<?= $cases->lot_no ?>" vill_townprt_code="<?= $cases->vill_townprt_code ?>" class='chainReportMisc btn-sm btn btn-success'>View Property Chain</button>
                                            <?php }?>

                                                <!-- ///////////////////////////////////////////////// -->
                                            
                                        <?php } ?>
                                        </td>
                                </tr>
                                <?php
                                $c++;
                            }
                            } 
                            ?>
                        </table>
                        <div class="pagination_links"> 
                             <?php echo $links; ?> </div> 
                         </div>
                        <center>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){?>

<!-- hidden fields -->
    <input type="hidden" name="mut_type" id="mut_type" value="<?= MUT_TYPE_MISC ?>">
</div>
</div>
<!-- property chain modal -->
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>
<!--  -->
<?php }?>

<script type="text/javascript">
    // property chain modal

    $('.panel').on('click', '.chainReportMisc', function(e) {
        e.preventDefault();
        // console.log($(this).attr("case_no"))
        // call modal function
        case_no = $(this).attr("case_no");
        dist_code = $(this).attr("dist_code");
        subdiv_code = $(this).attr("subdiv_code");
        circle_code = $(this).attr("cir_code");
        mouza_code = $(this).attr("mouza_pargona_code");
        lot_no = $(this).attr("lot_no");
        vill_code = $(this).attr("vill_townprt_code");
        propChainModal(case_no, dist_code, subdiv_code, circle_code, mouza_code, lot_no, vill_code);
    });
</script>


<?php if(ESCALATION_ENABLE == 1) { ?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#zone_status').change(function(){
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
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneNameCorrectionForCo',
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
</script>
<?php } ?>



    

