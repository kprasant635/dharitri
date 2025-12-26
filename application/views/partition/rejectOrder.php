<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Reject Order</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $this->input->get('case_no'); ?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url() . "index.php/partition/confirmRejectOrder"; ?>" method="post" >
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">Reason of Rejection</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" rows="5" name='remark' id="textArea" placeholder=" Write Reason here.....">চক্ৰ বিষয়াৰ নিৰ্দেশত গোচৰ টো খাৰিজ কৰা হ'ল ।</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="case_no" value="<?=$this->input->get('case_no')?>">
                                <input type="hidden" name="type" value="<?=$this->input->get('type')?>">
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group" style="text-align: center">
                                <a class="btn btn-default uni_text petitionreport" id='myModal' href="<?php echo base_url() . "index.php/officemutation/viewPetition?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View Application</a>
                                <a class="btn btn-default uni_text lmreportmut" id='myModal' href="<?php echo base_url() . "index.php/officemutation/lmreport?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View LM Report</a>
                                <a class="btn btn-default uni_text astreport" id='myModal' href="<?php echo base_url() . "index.php/officemutation/asstReport1?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View Assistant Report</a>
                                <a class="btn btn-default uni_text skreport" id='myModal' href="<?php echo base_url() . "index.php/officemutation/skreport1?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View SK Report</a>
                            </div>
                            <center>
                                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Reject Order</button>
                                <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_home'); ?>
                                </a>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='skmodal'>
        <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
            <div class="modal-content"  style=" overflow-y: auto;">
                
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
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
            
        });
        $('.panel').on('click','.skreport',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
            
        });
        
        $('.panel').on('click','.astreport',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
            
        });
        
        $('.panel').on('click','.petitionreport',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
            
        });
        
        $('#skmodal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
    })
    });
</script> 
