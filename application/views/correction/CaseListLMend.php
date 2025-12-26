<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">List of Legacy (Area/Name Correction) Cases Pending For Lot Mondals Report</h2>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <a href="<?=base_url().'index.php/LegacyDataUpdation/Updation'?>">
                <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
            </div>&nbsp;
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           Legacy (Area/Name Correction) Cases
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('sl_no'); ?></label></th>
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
                            $row = count($legacyCases);
                            if ($row > 0) {
                                $c = 1;
                                foreach ($legacyCases AS $cases) {
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $c; ?></td>

                                        <?php 
                                            if(ESCALATION_ENABLE == 1) { ?>
                                                <td class="center"><?=$cases->escalation_zone;?></td>
                                                <td class="center"><?=$cases->escalation_date;?></td>
                                        <?php } ?>

                                        <td><?php echo $cases->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($cases->basundhara){ echo "Basundhara:". $cases->basundhara ;} ?> </span></td>
                                        <td class="center"><?php
                                            $type = $cases->service_type;
                                            if ($type == 'A') {
                                                echo "ক্ষেত্ৰ সংশোধন ";
                                            } elseif ($type == 'N') {
                                                echo "নাম সংশোধন";
                                            }
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($cases->date_of_reg)); ?></td>
                                        <td class="center">
											<?php if($type=='A'){ ?>
                                          
                                            <a href="<?php echo base_url() . "index.php/LegacyCorrection/LMReportAreaNameCorrection"; ?>?case_no=<?php echo $cases->case_no."&petition_no=".$cases->petition_no; ?>" class="btn btn-primary"><?php echo $this->lang->line('write_report'); ?> </a>
											<?php }elseif ($type == 'N'){?>
											<a href="<?php echo base_url() . "index.php/LegacyCorrection/LMReportAreaNameCorrection"; ?>?case_no=<?php echo $cases->case_no."&petition_no=".$cases->petition_no; ?>" class="btn btn-primary"><?php echo $this->lang->line('write_report'); ?> </a>
											<?php } ?>
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
                    // "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/EscalationController/searchByEscalationZoneAreaDataCorrectionForLm',
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