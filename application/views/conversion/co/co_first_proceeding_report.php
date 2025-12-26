<div class="row mt-2">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-between">
                
                    <p>Application No: <?php echo $application_details->application_no; ?></p>
                    <p>Circle Officer's Conversion Order</p>
                    <p>Date: <?php echo date('d-m-Y'); ?></p>
                
            </div>
            <div class="card-body">
                <form class="" id="first_proceeding_form" method='post' action="<?php echo base_url("index.php/co_first_proceeding_post"); ?>">
                    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                    <input type="hidden" id="application_no" name="application_no" value="<?php echo $application_details->application_no; ?>" required>
                    <table class="rasid-t">
                        <tr>
                            <td>
                                আবেদনকাৰীৰ ম্যাদীকৰণ আৱেদন চোৱা হল । আবেদনকাৰী
                                <?php
                                $count = 1;
                                $howmany = sizeof($pattadar) - 1;
                                foreach ($pattadar as $p):
                                ?>
                                    <span style="color:red;">
                                        <?php echo $p->name_ass; ?>
                                    </span>
                                <?php
                                    if(isset($p->gurdian_name_ass)){
                                        echo "( " . $p->gurdian_name_ass. " )";
                                    }
                                    if ($count < sizeof($pattadar) - 1) {
                                        echo " , ";
                                        $count++;
                                    } elseif ($count == sizeof($pattadar) - 1) {
                                        echo " আৰু ";
                                        $count++;
                                    } else {
                                        echo " ";
                                    }
                                ?>
                                <?php endforeach; ?>য়ে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাঁৱৰ <?php echo $location['patta_no']; ?> নং একচনা পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> 
                                <?php if(!in_array($location['dist_code'], json_decode(BARAK_VALLEY))) { ?>
                                    লেছা
                                <?php } else {?>
                                    ছটাক <?php echo $location['m_dag_area_g']; ?> গোণ্ডা
                                <?php } ?>
                                
                                ম্যাদীকৰণৰ বাবে আবেদন কৰিছে |
                            </td>
                        </tr>
                        <tr>
                            <td>ভূমিলেখ্য সহায়কে ভূমি-লেক্ষ্য নিয়মাৱলীৰ ১০৫ নং ধাৰা ও অসম চৰকাৰে সময়ে সময়ে দিয়া চাৰ্কোলাৰ জৰিয়টে দিয়া নিৰ্দেশ মতে ভূমিলেখ্য পৰ্যবেক্ষকৰ জৰিয়টে প্রতিবেদন দিব ।
                                <br>
                                কাৰ্যালয় সহায়কে সহ পাট্টাদাৰক জাননি জাৰি কৰোৱাই ধাৰ্য্য তাৰিখৰ পূৰ্বে প্ৰতিবেদন দিব আৰু জাৰী কৰাৰ জাননীৰ কপি আপলোড কৰিব ।
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-right: 40px;">
                                <input type="hidden" id="co_order" name="co_order" value="আবেদনকাৰীৰ ম্যাদীকৰণ আৱেদন চোৱা হল । আবেদনকাৰী
                                <?php
                                    $count = 1;
                                    $howmany = sizeof($pattadar) - 1;
                                    foreach ($pattadar as $p):
                                    ?>
                                    <span style='color:red;'>
                                        <?php echo $p->name_ass; ?>
                                    </span>
                                    <?php
                                        if(isset($p->gurdian_name_ass)) {
                                            echo '( ' . $p->gurdian_name_ass. ' )';
                                        }
                                        if ($count < sizeof($pattadar) - 1) {
                                            echo ' , ';
                                            $count++;
                                        } elseif ($count == sizeof($pattadar) - 1) {
                                            echo ' আৰু ';
                                            $count++;
                                        } else {
                                            echo ' ';
                                        }
                                    ?>
                                    <?php endforeach; ?>য়ে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাঁৱৰ <?php echo $location['patta_no']; ?> নং একচনা পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা
                                    মাটিৰ ম্যাদীকৰণৰ বাবে আবেদন কৰিছে |<br>ভূমিলেখ্য সহায়কে ভূমি-লেক্ষ্য নিয়মাৱলীৰ ১০৫ নং ধাৰা ও অসম চৰকাৰে সময়ে সময়ে দিয়া চাৰ্কোলাৰ জৰিয়টে দিয়া নিৰ্দেশ মতে এল.আৰ.এছৰ জৰিয়টে প্রতিবেদন দিব ।
                                    <br> কাৰ্যালয় সহায়কে সহ পাট্টাদাৰক জাননি জাৰি কৰোৱাই ধাৰ্য্য তাৰিখৰ পূৰ্বে প্ৰতিবেদন দিব আৰু জাৰী কৰাৰ জাননীৰ কপি আপলোড কৰিব ।
                                    <br><label class='control-label rasid' style='float:right;margin-right:50px;'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></label>">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-2" style="margin-left:20px;">
                                <!-- <input type="text" class="form-control" id="popupDatepicker" readonly="" autocomplete="off" placeholder="" name="hearing_date" required style="margin-left: 20px;"> -->
                                <input type="date" class="form-control" id="hearing_date" name="hearing_date" required>
                            </div>
                            <label class="col-sm-8 uni_text">তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য হ'ল ।</label>
                        </div>
                        <br>
                        <label class="control-label uni_text pull-right" style="float:right; font-size: 22px; text-align: right"><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></label>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="col-sm-12">
                        <label class="rasid col-sm-4">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" disabled> <?php echo $this->lang->line('final_order'); ?>
                        </label>
                        <label class="rasid col-sm-4">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked> <?php echo $this->lang->line('continue_hearings'); ?>
                        </label>
                    </div>
                    <!-- <hr>
                    <div class="col-lg-12">
                        <center>
                            
                        </center>
                        <hr>
                    </div>
                    <br>
                    <hr style="border-bottom: 2px solid #000;"> -->
                </form>

                <?php 
                $basuCase= $application_details->application_no;
                include(APPPATH.'views\query\queryModel.php');
                ?>

                
            </div>
            <div class="card-footer d-flex justify-content-center">
                <button type="button" name="submit" id="first_proceeding_btn"  class="btn btn-success uni_text"><i class='fa fa-check'></i>  <?php echo $this->lang->line('submit_button'); ?> Proceed</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#first_proceeding_btn', (e) => {
        var baseurl = $('#baseurl').val();
        var application_no = $('#application_no').val();
        var hearing_date = $('#hearing_date').val();
        var co_order = $('#co_order').val();
        var radio = $("input[name='inlineRadioOptions']:checked").val();

        if(application_no != '' && hearing_date != '' && co_order != '' && radio != '') {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: baseurl + 'index.php/co_first_proceeding_post',
                method: 'POST',
                dataType: 'JSON',
                data: {application_no:application_no, hearing_date:hearing_date, co_order:co_order, radio:radio},
                success: function(response) {
                    $.unblockUI();
                    if(response.status == 'SUCCESS') {
                        swal.fire("", response.msg, "success")
                        .then((value) => {
                            window.location.href = baseurl + 'index.php/home';
                        });
                    }
                    else if (response.status == 'FAILED') {
                        swal.fire("", response.msg, "error;")
                        .then((value) => {
                            
                        });
                    }
                },
                error: function(err) {
                    $.unblockUI();
                    console.log(err);
                }
            });
        }
        else {
            alert("The required fields are empty");
        }
        
    });
</script>