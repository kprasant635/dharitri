<div class="row mt-2">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-between">
                
                    <p>Case No: <?php echo $petition_basic->case_no; ?></p>
                    <p>Circle Officer's Conversion Order</p>
                    <p>Date: <?php echo date('d-m-Y', strtotime($petition_basic->date_entry)); ?></p>
                
            </div>
            <div class="card-body">
                    <!-- <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>"> -->
                    <table class="rasid-t">
                        <tr>
                            <td>
                                আবেদনকাৰীৰ ম্যাদীকৰণ আৱেদন চোৱা হল । আবেদনকাৰী
                                <?php
                                $count = 1;
                                $howmany = sizeof($pattadars) - 1;
                                foreach ($pattadars as $p):
                                ?>
                                    <span style="color:red;">
                                        <?php echo $p->pdar_name; ?>
                                    </span>
                                <?php
                                    if(isset($p->pdar_guardian)){
                                        echo "( " . $p->pdar_guardian. " )";
                                    }
                                    if ($count < sizeof($pattadars) - 1) {
                                        echo " , ";
                                        $count++;
                                    } elseif ($count == sizeof($pattadars) - 1) {
                                        echo " আৰু ";
                                        $count++;
                                    } else {
                                        echo " ";
                                    }
                                ?>
                                <?php endforeach; ?>য়ে <?php echo $location_details->mouza_pargona_name; ?> মৌজাৰ <?php echo $location_details->vill_townprt_name; ?> গাঁৱৰ <?php echo $petition_dag_details->patta_no; ?> নং <?php echo $patta_type_details->patta_type; ?> পট্টাৰ  <?php echo $petition_dag_details->dag_no; ?> নং দাগৰ <?php echo $petition_dag_details->m_dag_area_b; ?> বিঘা <?php echo $petition_dag_details->m_dag_area_k; ?> কঠা <?php echo $petition_dag_details->m_dag_area_lc; ?> 
                                <?php if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) { ?>
                                    লেছা
                                <?php } else {?>
                                    ছটাক <?php echo $petition_dag_details->m_dag_area_g; ?> গোণ্ডা
                                <?php } ?>
                                
                                    মাটিৰ ম্যাদীকৰণৰ বাবে আবেদন কৰিছে  |
                            </td>
                        </tr>
                        <tr>
                            <td>ভূমিলেখ্য সহায়কে ভূমি-লেক্ষ্য নিয়মাৱলীৰ ১০৫ নং ধাৰা  ও অসম চৰকাৰে সময়ে সময়ে দিয়া চাৰ্কোলাৰ নিৰ্দেশ মতে ভূমিলেখ্য পৰ্যবেক্ষকৰ জৰিয়তে প্রতিবেদন দিব । 
                                <br>
                                কাৰ্যালয় সহায়কে সহ পাট্টাদাৰক জাননি জাৰি কৰোৱাই ধাৰ্য্য তাৰিখৰ পূৰ্বে প্ৰতিবেদন দিব আৰু জাৰী কৰাৰ জাননীৰ কপি আপলোড কৰিব । 
                            </td>
                        </tr>
                        <!-- <tr>
                            <td style="text-align: right; padding-right: 40px;">
                                
                            </td>
                        </tr> -->
                    </table>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-2" style="margin-left:20px;">
                                <!-- <input type="text" class="form-control" id="popupDatepicker" readonly="" autocomplete="off" placeholder="" name="hearing_date" required style="margin-left: 20px;"> -->
                                <input type="date" class="form-control" id="hearing_date" name="hearing_date" value="<?php echo date('Y-m-d', strtotime($petition_basic->next_date_of_hearing)); ?>" required disabled>
                            </div>
                            <label class="col-sm-8 uni_text">তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য হ'ল ।</label>
                        </div>
                        <br>
                        <label class="control-label uni_text pull-right" style="float:right; font-size: 22px; text-align: right"><?php echo $add_to; ?><br>চক্র বিষয়া, <?php echo $location_details->cir_name; ?></label>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <!-- <div class="col-sm-12">
                        <label class="rasid col-sm-4">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" disabled> <?php echo $this->lang->line('final_order'); ?>
                        </label>
                        <label class="rasid col-sm-4">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked> <?php echo $this->lang->line('continue_hearings'); ?>
                        </label>
                    </div> -->
                    <!-- <hr> -->
                    <!-- <div class="col-lg-12">
                        <center>
                            <input type="hidden" id="application_no" name="application_no" value="<?php echo $application_details->application_no; ?>" required>
                            <button type="button" name="submit" id="first_proceeding_btn"  class="btn btn-success uni_text"><i class='fa fa-check'></i>  <?php echo $this->lang->line('submit_button'); ?> Proceed</button>
                        </center>
                        <hr>
                    </div> -->
                    <!-- <br> -->
                    <!-- <hr style="border-bottom: 2px solid #000;"> -->
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

