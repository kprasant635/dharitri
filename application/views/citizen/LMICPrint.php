<div class="container-fluid form-top login">
    <div class='row'>
         <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                <h2 class="center uni_text"><?php echo $this->lang->line('govt_of_assam');?></h2>
                    <p class="uni_text"><span class="pull-left">চক্র বিষয়াৰ কাৰ্য্যালয়  ::</span>  <span style=" margin-left: 20px">
                            <?php echo $location['cir_name'] ;?>
                            ৰাজহ  চক্ৰ </span><span class="pull-right">
                        <?php echo $location['mouza_name'] ?> </span></p>
                    <hr>
                    <p><span class="pull-left uni_text"> <?php echo $this->lang->line('sr_no');?> :<?php echo $this->session->userdata('cert_no'); ?></span>
                        <span class="pull-right uni_text"><?php echo $this->lang->line('apply_date');?>:<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?></span></p>
                    <hr>
                    <p class="uni_text text-center text-danger">বাৰ্ষিক <?php echo $cername=$this->utilityclass->getCertName($this->session->userdata('cert_codeNo')); ?>  </p>
                    <div class="col-lg-12" style="margin-top: 25px">
                    <p class="uni_text">
                        ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে ,<?php echo $applicant->appln_name; ?> -- <?php echo $applicant->appln_guard; ?>
                                                      
                            <?php echo $location['cir_name'] ;?>  ৰাজহ চক্ৰ ,<?php echo $location['mouza_name'] ?> মৌজা ৰ,
                            <?php echo $location['villname'] ?> গাঁওৰ বাসিন্দা হয় | আবেদনকাৰীৰ পৰিয়ালৰ বাৰ্ষিক  আয় <?php echo $location['totalinc']; ?>.00 টকা হয় | </p>
                    <p class="uni_text">এই প্রমাণ-পত্র লাট-মন্ডলৰ প্রতিবেদনৰ ভিওিত দিয়া হ’ল |</p>
                    </div>
                    <div class="col-lg-offset-8">
                        <p class="uni_text text-center">
                            চক্র বিষয়া<br>
                            <?php echo $location['cir_name'] ;?> ৰাজহ  চক্ৰ ,<?php echo $location['mouza_name'] ?> 
                        </p>
                    </div>
                <hr>
                <form action="<?php echo base_url();?>index.php/citizencontroller/FinalStepIC" method="POST">
                    <button class="btn btn-primary col-lg-offset-4 uni_text " name="FormSubmit" type="submit"><?php echo $this->lang->line('forwardco_necessary_action'); ?></button>
                </form>
               
            </div>
            </div>
        </div>
       
    </div>
</div>
