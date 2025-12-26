<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">জমাবন্দীৰ নকলৰ বাবে আবেদন</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <?php //var_dump($this->session->all_userdata()); ?>
                        <div class="row">
                            <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no'); ?> :<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                            <div class="col-lg-5"><p class="uni_text text-center">
                            <?php
                            if($this->session->userdata('application_ref_no')){
                                echo "অনলাইনত উল্লেখ নং : ".$this->session->userdata('application_ref_no');
                            }
                            ?> 
                            </p></div>
                            <div class="col-lg-3"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date'); ?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date'))); ?> </p></div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                         <!---#START PLB--->
                        <?php
                        $dist_code = $this->session->userdata('dist_code');
                        if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                             <p class="uni_text" style="padding:10px"> যদি আপনি জমাবন্দীটি দেখিয়া মনে করেন যে , ইহাতে সংশোধন করিবার প্রয়োজন আছে , তাহা হইলে প্রথমে জমাবন্দীটি সংশোধন করিয়া নিন |  যদি আপনি জমাবন্দীটি দেখিয়া মনে করেন যে , জমাবন্দীটি ঠিক আছে , সেইটি পরীক্ষা করার জন্য চক্র আধিকারিক কাছে প্রেরণ করুন |<?php //echo $this->lang->line('correct_jamabandi_first'); ?></p>
                            <?php }else{?>
                                <p class="uni_text" style="padding:10px"> যদিহে আপুনি জমাবন্দী খন চাই ভাবে যে , ইয়াৰ সংশোধন কৰিবলগীয়া আছে , তেন্তে প্রথমে জমাবন্দী খন সংশোধন কৰি লওক |  যদিহে আপুনি ভাবে যে , জমাবন্দী খন ঠিক আছে ,সেইখন পৰীক্ষণৰ বাবে চক্র বিষয়ালৈ প্রেৰণ কৰি দিয়ক |<?php //echo $this->lang->line('correct_jamabandi_first'); ?></p>
                            <?php }?>

                            <!--#END PLB-->
                        <form action="<?php echo base_url() . 'index.php/CitizenController/LMJB' ?>" method="POST" >
                            <button type="submit" class="btn btn-danger col-lg-offset-5 uni_text">Forward to Circle Officer</button>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2 class="red">Incase you want to keep this case pending (Please write note for keep pending application)</h2>
                        <form action="<?php echo base_url() . 'index.php/CitizenController/LMJBPending' ?>" method="POST" >
                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">Select Option</label>
                                <div class="col-lg-4">
                                    <label><input type="radio" name="options" checked class='squaredTwo' id="optionsRadios2" value="M">Keep Pending</label>
                                    <label><input type="radio" name="options" class='squaredTwo' id="optionsRadios2" value="X">Reject</label>
                                </div>
                                <label for="select" class="col-lg-2 control-label">&nbsp;</label>
                                <div class="col-lg-5">&nbsp;</div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">Reason for pending</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" rows="5" name='pending_reason' id="textArea"></textarea>
                                    <input type="hidden" value="<?php echo $this->session->userdata('cert_no'); ?>" name="case_no" />
                                    <span class="help-block">Application Number: <?php echo $this->session->userdata('cert_no'); ?></span>
                                </div> 
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                    <button type="submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;Submit as Pending</button>
                                    <button type="reset" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/CitizenController/LMStep1" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



