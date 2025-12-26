<script>
    $(function () {
        $('#vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });

        });
    });
</script>
<style>
    textarea{
        font-weight: bold;
        line-height: 2em !important;
        padding:2px !important;
        height: 100px !important;
    }
</style>
<?php var_dump($data);?>
<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10 col-lg-offset-1'>
            <div class='panel panel-info'>
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('cos_order') ?>
                            <span class='pull-right'>
                                <?php echo $this->lang->line('case_no') ?><?php echo $case_no . "  <span class='badge'>Date:" . date('d-m-y') . "</span>"; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class='panel-body'>
                    <div class='row regular'>
                        
                        
                    </div>
                    <hr>
                    <div class="form-group" style="text-align: center">
                        <a id='vp' href="<?php echo base_url() . 'index.php/officemutation/viewpetition?case_no=' . $case_no ?>" class="btn btn-danger regular">View Peition</a>
                    </div>
                    <div class='row'>
                        <div class='col-lg-12 center-col'>
<?php $action = base_url() . "index.php/coofficemutation/proceeding1"; ?>
                            <form class='form-horizontal' action="<?php echo $action; ?>" method="post">
                                <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label uni_text" id='applicant_name_label'><?php echo $this->lang->line('order') ?></label>
                                    <div class="col-sm-9">
                                        <textarea class='form-control' rows="10" name='co_order' style="text-align: left;margin: 0;padding: 0"><?php
                                            echo "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল । আবেদনকাৰীয়ে " .
                                            $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                                            . " " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                                            " গাৱৰ " . $dag->patta_no . " নং পট্টাৰ " . $dag->dag_no . " নং দাগৰ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "মাটিৰ নামজাৰী বিচাৰিছে |"
                                            . "লাট মণ্ডল আৰু চু:কা: ই চৰজমিন জোখ মাখ কৰি চিঠা আৰু জমাবন্দীৰ এক কপিকৈ প্র-পত্রমতে দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব পাৰে |"
                                            ?>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label uni_text" id='applicant_name_label'><?php echo $this->lang->line('next_date_of_hearing') ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" required=""   class="form-control dating" name="next_hearing_date" id="applicantNam" placeholder="">
                                    </div>
                                </div>
                                <div class='form-group '>
                                    <div class=" col-sm-12">
                                        <center><button type="submit" class="btn btn-info  btn-md regular" ><?php echo $this->lang->line('submit_button') ?></button></center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            Modal
        </div>
    </div>
</div>
</div>