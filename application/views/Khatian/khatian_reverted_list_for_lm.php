<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Khatian Reverted List For LM
        </h4>
    </div>
</div>
<div class="col-lg-12 ">
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">
                Reverted List
            </h3>
        </div>
        <div class="panel-body">
            <table class='table table-striped' id='cases' width="100%">
                <thead>
                <th><label class="control-label">Khatian No.</label></th>
                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                <!--                <th class="center"><label class="control-label">--><?php //echo $this->lang->line('submission_date'); ?><!--</label></th>-->
                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                </thead>
                <?php if($khatian): ?>
                <?php foreach ($khatian as $case): ?>
                    <tr>
                        <td class="center"><b><?php echo $case->khatian_no; ?></b></td>
                        <td class="center">
                            <?php
                            echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                            ?>
                        </td>
                        <!--                        <td class="center">-->
                        <!--                            <i class='fa fa-calendar'></i> Submited On --><?php //echo date('d-m-Y', strtotime($case->created_date)); ?>
                        <!--                        </td>-->
                        <td>
                            <a type="button" href="<?php echo base_url() . "index.php/khatian/proreport?khatian=" . $case->khatian_no."&uuid=". $case->uuid."&app_id=".$case->app_id ?>" class='lm btn-sm btn btn-success'><i class="fa fa-envelope-open" aria-hidden="true"></i> All Note(s)</a>
                            <a type="button"  href="<?php echo base_url() . "index.php/khatian/khatianRevertedViewTenantForm?khatian=" . $case->khatian_no."&uuid=". $case->uuid."&app_id=".$case->app_id."&vill_code=". $case->vill_townprt_code ?>" class='btn-sm btn btn-primary'><i class="fa fa-envelope-open" aria-hidden="true"></i> Write Report</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
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
    $(function () {
        $('.panel').on('click','.lm',function (e) {
            e.preventDefault();
            $('#myModal .modal-content').html("");
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    console.log(data)
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                    $('#myModal').modal('show');
                }
            });
        });
        $('#myModal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
        })
    });
</script>