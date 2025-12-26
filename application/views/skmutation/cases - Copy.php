<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($cases[0]->mut_type == '01'){
                            echo "Pending Field Mutation";
                        }
                        else{
                            echo "Pending Field Partition";
                        }
                        ?>
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
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            </thead>
                            <?php foreach ($cases as $case): ?>
                            <tr>
                                <td><a href="#"><?php echo $case->case_no; ?></a></td>
                                <td class="center"><?php echo ($case->mut_type == 01) ? 'Mutation' : 'Partition'; ?></td>
                                <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->report_date)); ?></td>
                                <td>
                                    <?php if ($case->mut_type == '01'): ?>

                                        <a type="button" data-toggle="modal" data-target="#myModal" id='lmreport' href='<?php echo base_url() . "index.php/skmutation/getLMReport1?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class='lmreportmut btn-xs btn btn-danger'><?php echo $this->lang->line('lm_report'); ?></a>
                                    <?php else: ?>
                                        <a type="button" data-toggle="modal" data-target="#myModal" id='lmreportpart' href='<?php echo base_url() . "index.php/skmutation/getLMReportPartition?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class='lmreportpart btn-xs btn btn-danger'><?php echo $this->lang->line('lm_report'); ?></a>
                                    <?php endif; ?>
                                          <a  href='<?php echo base_url() . "index.php/skmutation/saveReport?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-success btn-xs msg"><?php echo $this->lang->line('write_report'); ?></a>
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
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='myModal'>
        <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
            <div class="modal-content"  style=" overflow-y: auto;">
                
            </div>
        </div>
    </div>
</div>
<script>
     $(function () {
        $('.panel').on('click','.lmreportmut',function (e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                }
            });
            
        });
        $('.panel').on('click','.lmreportpart',function (e) {
            e.preventDefault();
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
	})
    });
</script>   