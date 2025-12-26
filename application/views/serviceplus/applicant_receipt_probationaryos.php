<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary">
                <form action="<?php echo base_url(); ?>index.php/serviceplus/save_citizen_centric" method="POST">
                    <div class="panel-body">
                        <input type='hidden' name='cert_no' value='<?php echo $cert_no; ?>'>
                        <p>
						<div class="col-lg-4 uni_text"><span class="uni_text">গোচৰ নং : <?php echo $cert_no; ?> </span></div>
						<div class="col-lg-6 uni_text"><span class="uni_text">অনলাইনত উল্লেখ নং : <?php echo $location['application_ref_no']; ?> </span></div>
						<div class="col-lg-2 uni_text"><span class="uni_text">তাৰিখ :<?php echo date('d/m/Y', strtotime($location['date_entry'] ))?></span></div>
						</p>
                        <hr>
						<div class="col-lg-12">
						<br>
                        <p class="uni_text"><?php echo $location['vill_townprt_code'] ?> </span> গাঁওৰ  <span class='red'><?php echo $pdar_name; ?></span>
                            <?php echo $this->utilityclass->get_relation($relation); ?> <?php echo $guard_rel ?>'ৰ নামত Mutation Order Sheet নকল ৰ বাবে পঞ্জীকৰণ প্রক্রিয়া সম্পূর্ণ হ'ল ।</p>
						<hr>
                        <p class="uni_text">The Registration Process for Issuance of Certified Copy of Mutation Order By Assistant (to CO) Completed.</p>
						</div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <center><button class="btn btn-danger uni_text dontshow"  style="margin-bottom:20px" type="submit"><i class='fa fa-arrow-left'></i>&nbsp; <?php echo $this->lang->line('back_to_main_menu');?> </button></center>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

