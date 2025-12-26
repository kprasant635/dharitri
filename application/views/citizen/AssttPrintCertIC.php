<div class="container-fluid form-top login">
    <div class='row' id="printdiv">
        <?php
        //var_dump($this->session->all_userdata());
        //var_dump($certDtls);
        //var_dump($dagDtls);
        ?>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <h2 class="center uni_text">অসম চৰকাৰ</h2>
                    <center><img src="<?php echo base_url(); ?>application/views/images/goa.jpg" width='8%'></center>
                    <h2 class="center uni_text">GOVERNMENT OF ASSAM</h2>
                    <p class="uni_text"><span class="pull-left">চক্র বিষয়াৰ কাৰ্য্যালয়  ::</span>  <span style=" margin-left: 20px">
                            <?php echo $location['cirname']; ?>
                            ৰাজহ  চক্ৰ </span><span class="pull-right">
                            মৌজা :<?php echo $location['mouza_pargona_code'] ?> </span></p>
                    <hr>
                    <p><span class="pull-left uni_text"> আবেদন নং<?php //echo $this->lang->line('sr_no');       ?>:<?php echo $certDtls->cert_no; ?></span>
                        <span class="pull-right uni_text">তাং <?php //echo $this->lang->line('apply_date');       ?> :<?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($certDtls->apply_date))); ?></span></p>
                    <hr>
                    <p class="uni_text text-center text-danger">বাৰ্ষিক <?php echo $cername = $this->utilityclass->getCertName($certDtls->cert_type); ?>  </p>
                    <div class="col-lg-12" style="margin-top: 25px">
                        <p class="uni_text">
                            ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে ,<?php echo $certDtls->appln_name; ?> -- <?php echo $certDtls->appln_guard; ?>

                            <?php echo $location['cirname']; ?>  ৰাজহ চক্ৰ ,<?php echo $location['mouza_pargona_code'] ?> মৌজা ৰ,
                            <?php echo $location['vill_townprt_code'] ?> গাঁওৰ বাসিন্দা হয় | আবেদনকাৰীৰ পৰিয়ালৰ বাৰ্ষিক  আয় <?php echo $this->utilityclass->cassnum(number_format($certDtls->inc_total, 2)); ?> টকা হয় | </p>
                        <p class="uni_text">এই প্রমাণ-পত্র লাট-মন্ডলৰ প্রতিবেদনৰ ভিওিত দিয়া হ’ল |</p>
                    </div>
                    <div class='col-sm-3'>
                        <?php
                        $data = explode(",", $qrcode)[1];
                        echo '<img src="data:image/png;base64,' . $data . '" />';
                        ?> 
                    </div>
                    <div class="col-lg-offset-9">
                        <p class="uni_text text-right">
                            <?php
                            $coname = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $certDtls->user_code);
                            echo $coname->username . ", চক্র বিষয়া";
                            ?><br>
                            <?php echo $location['cirname']; ?> ৰাজহ  চক্ৰ 
                        </p>

                    </div>
                    <hr>
                    <p class="bold text-danger">Notice :</p>
                    <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">			
                    <div class="row dontshow">
                        <center>
                            <form action="<?php echo base_url(); ?>index.php/CitizenController/CaseDelivered" method="POST">
                                <div class="btn btn-primary uni_text" id="openBtn"><i class="fa fa-arrow-circle-down"></i> Keep Pending</div>
                                <div class="btn btn-sm btn-danger uni_text printlink" onclick="myFunction()" ><i class="fa fa-print"></i> &nbsp;Print Report</div>
                                <button class="btn btn-info" disabled type="submit" id='close'>Certificate is Delivered</button>
                                <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="case_no" >
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        //document.getElementById("print").disabled = false;
        //document.getElementById("close").disabled = false;
        $(".dontshow").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("close").disabled = false;
    }
</script>
