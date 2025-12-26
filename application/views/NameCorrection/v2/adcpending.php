<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">ADC's final order on Name Correction cases</h2>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                       <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('sl_no');?></label></th>
                                <?php
                                    if(ESCALATION_ENABLE == 1) {
                                        include(APPPATH."views/common/esc_table_head.php");
                                    }
                                ?>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            </thead>
                            <?php
                            $row = count($getADCpending);
                            if ($row > 0) {
                            $c = 1;
                            foreach ($getADCpending AS $cases) 
                            {
                                ?>
                                <tr>
                                    <td class="center"><?php echo $c; ?></td>


                                    <?php if(ESCALATION_ENABLE == 1) { ?>
                                        <td class="center"><?=$cases->escalation_zone;?></td>
                                        <td class="center"><?=$cases->escalation_date;?></td>
                                    <?php } ?>

                                    <td><?php echo $cases->misc_case_no; ?>
                                        <span class='small font-italic red'><?php if($cases->basundhara){ echo "Basundhara:". $cases->basundhara ;} ?> </span>
                                    </td>
                                    <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($cases->submission_date)); ?></td>
                                    <td class="center">

                                        <?php if(ESCALATION_ENABLE == 1 && $cases->is_escalated == 1 && $cases->out_of_esc==0){ 
                                                echo "Escalated to Appellate Authority";
                                             } else { ?>
                                                <a href="<?php echo base_url() . "index.php/NameCorrectionV2/finalOrderADCNameCorrection"; ?>?submission_date=<?php echo $cases->submission_date; ?>&dist_code=<?php echo $cases->dist_code; ?>&subdiv_code=<?php echo $cases->subdiv_code; ?>&cir_code=<?php echo $cases->cir_code; ?>&mouza_pargona_code=<?php echo $cases->mouza_pargona_code; ?>&lot_no=<?php echo $cases->lot_no; ?>&vill_townprt_code=<?php echo $cases->vill_townprt_code; ?>&year_no=<?php echo $cases->year_no; ?>&petition_no=<?php echo $cases->misc_case_petition_no; ?>&misc_case_no=<?php echo enc_param('misc_case_no', $cases->misc_case_no, 600); ?>" class="btn btn-primary"><?php echo $this->lang->line('pass_order');?></a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            }
                            } 
                            ?>
                        </table>
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
                    url: base_url+'index.php/EscalationController/searchByEscalationZoneNameCorrectionForAdc',
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