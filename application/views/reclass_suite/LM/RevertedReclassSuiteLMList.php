<div class="col-md-12 text-right text-cyan">
    Process > 
    Settlement MB3 > 
    <a href="<?php echo base_url(); ?>index.php/Home/TeaGrantLandLm?service=<?=RECLASS_ID?>" style="text-decoration: none;">Reclass Suite</a> > 
    <b>View</b>
</div>
<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Reverted case(s)
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
                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                </thead>
                <?php foreach ($cases as $case) : ?>
                    <tr>
                        <td><a href="#"><?php echo $case->case_no; ?></a><br>
                            <span class='small font-italic red'><?php if ($case->basundhara) {
                                                                    echo "Basundhara:" . $case->basundhara;
                                                                } ?> </span>
                        </td>
                        <td class="center">

                            <?php
                            echo "Mouza : " . $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                            echo "<br>Lot : " . $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                            echo "<br>Village : " . $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                            ?>
                        </td>
                        <td class="center">
                            <i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_update)); ?>

                        </td>
                        <td>
                            
                            <a type="button" href="<?php echo base_url() . "index.php/ReclassSuiteControllerLm/secondProceeding?case=" . $this->utilityclass->encryptJwtCase($case->case_no); ?>" class='lmreportpart btn-sm btn btn-primary' id='myModal'><i class="fa fa-envelope-open" aria-hidden="true"></i> <?php echo $this->lang->line('submit_report'); ?></a>
                            
                            <div style="height:5px;">&nbsp;</div>
                            <a type="button" data-toggle="modal" data-target="#myModal" href="<?php echo base_url() . "index.php/lmmutation/proreport?case_no=" . $case->case_no ?>" class='skreport btn-sm btn btn-success'><i class="fa fa-envelope-open" aria-hidden="true"></i> <?php echo $this->lang->line('query_to_applicant'); ?></a>
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

<script>
    $(function() {
        $('.panel').on('click', '.lmreportmut', function(e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                url: $(this).attr('href'),
                success: function(data) {
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                }
            });
        });
        $('.panel').on('click', '.skreport', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function(data) {
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                }
            });
        });
        $('#myModal').on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
        })
    });
</script>