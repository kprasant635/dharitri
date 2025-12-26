<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary">
                <?php
                //var_dump($this->session->all_userdata());
                //var_dump($location);
                ?>
                <form action="<?php echo base_url(); ?>index.php/citizencontroller/SaveCitizenCentric" method="POST">
                    <div class="panel-body">
                        <h2 class="center uni_text">অসম চৰকাৰ</h2>
                        <center><img src="<?php echo base_url(); ?>application/views/images/goa.jpg" width='8%'></center>
                        <h2 class="center uni_text">GOVERNMENT OF ASSAM</h2>
                        <p class="center uni_text"><?php echo $location['cirname']; ?> ৰাজহ  চক্ৰ</p>
                        <p class="center uni_text">Probationary Acknowledgement Reciept</p>
                        <hr>
                        <input type='hidden' name='cert_no' value='<?php echo $cert_no; ?>'>
                        <p><span class="pull-left uni_text">গোচৰ নং : <?php echo $cert_no; ?> </span><span class="pull-right uni_text">তাৰিখ :<?php echo $this->utilityclass->cassnum($this->session->userdata('date_entry')) ?></span></p>
                        <hr>
                        <h2 class="uni_text center" style="margin-top: 20px">নগদ ধনৰ ৰচিদ  </h2>
                        <p class="uni_text"><span class='red'> <?php echo $this->session->userdata('cert_type'); ?> </span>ৰ বাবে  <span class='red'> <?php echo $location['vill_townprt_code'] ?> </span> গাঁওৰ  <span class='red'><?php echo $pdar_name; ?></span>
                            <?php echo $this->utilityclass->get_relation($relation); ?> <?php echo $guard_rel ?> ৰ নগদ  <?php echo $this->utilityclass->cassnum(number_format($this->session->userdata('cert_fees'), 2)); ?> টকা মাচুল গ্রহণ কৰা হ’ল |</p>
                        <p class="uni_text" style="margin-top: 30px"> অহা ইং <?php
                            $nextdate = $this->utilityclass->getDaysAfter($this->session->userdata('delivery_date'));
                            echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($nextdate)));
                            ?>  তাৰিখে আপুনি বিচৰামতে   <span class='red'> <?php echo $this->session->userdata('cert_type'); ?></span>  আপোনাক দিয়া হ’ব |</p>
                        <p class="uni_text pull-right" style="margin-top: 40px" >চক্র বিষয়াৰ দ্বাৰা কতৃত্বপ্রাপ্ত কৰ্মচাৰী <br>
                            <?php echo $location['cirname']; ?> ৰাজহ  চক্র ,<?php echo $location['cirname']; ?>
                        </p>
                        <hr>
                        <p class="bold text-danger">Notice :</p>
                        <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
                        <p class="bold text-danger">2) বিঃদ্রঃ – চৰকাৰী বন্ধৰ দিনত এই সেৱা উপলব্ধ নহ’ব |</p>
                        <p class="bold text-danger">3) In ROR application fee is Rs.20/- for first page and additional Rs.10/- will be charged (per page) at the time of delivery.</p>
                    </div>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <center><button class="btn btn-primary uni_text dontshow"  onclick="myFunction()"  style="margin-bottom:20px" type="submit"><i class='fa fa-check'></i>&nbsp; Click Here to Print Receipt And Submit Report </button></center>
                </form>
                <div class="row dontshow">
                    <div class='col-lg-12'>
                        <center><p class='red uni_text blink_me'>Please Click the button above for print and save the data</p></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function myFunction() {
        $(".dontshow").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("close").disabled = false;
    }
</script>

