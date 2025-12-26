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
                        <p class="center uni_text">Acknowledgement Reciept / নগদ ধনৰ ৰচিদ</p>
                        <hr>
                        <input type='hidden' name='cert_no' value='<?php echo $cert_no; ?>'>
                        <table width="100%">
                            <tr>
                                <td width="45%">গোচৰ নং : <?php echo $cert_no; ?></td>
                                <td width="10%"></td>
                                <td width="45%">তাৰিখ :<?php echo $this->utilityclass->cassnum($this->session->userdata('date_entry')) ?></td>
                            </tr>
                            <tr>
                                <td width="45%">Applicant Name : <span class='red'><?php echo $pdar_name; ?></span></td>
                                <td width="10%"></td>
                                <td width="45%">Service name : <span class='red'> <?php echo $this->session->userdata('cert_type'); ?> </span></td>
                            </tr>
                            <tr>
                                <td width="45%">Mobile Number : 
                                <?php
                                if(!empty($pdar_mobile)){
                                    echo $pdar_mobile;
                                }
                                else {
                                    echo " - NA - ";
                                }
                                ?></td>
                                <td width="10%"></td>
                                <td width="45%">Status : Case Registered Successfully.</td>
                            </tr>
                            <tr>
                                <td colspan="3">Designated Officer : <span class='red'>চক্র বিষয়াৰ দ্বাৰা কতৃত্বপ্রাপ্ত কৰ্মচাৰী <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $location['cirname']; ?> ৰাজহ  চক্র ,<?php echo $location['distname']; ?></span></td>
                            </tr>
                        </table>
                        <hr>
                        <div class="form-group">
                            <label class="uni_text col-sm-12">Proposed Delivery Date : অহা ইং <?php
                            $nextdate = $this->utilityclass->getDaysAfter($this->session->userdata('delivery_date'));
                            echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($nextdate)));
                            ?>  তাৰিখে আপুনি বিচৰামতে   <span class='red'> <?php echo $this->session->userdata('cert_type'); ?></span>  আপোনাক দিয়া হ’ব |
                            </label>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="uni_text col-sm-6">Fees Paid :</label>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td class="center">Charges</td>
                                <td class="center">No. Of Pages (in No.)</td>
                                <td class="center">Amount (in Rs.)</td>
                                <td class="center">Total (in Rs.)</td>
                            </tr>
                            <tr>
                                <td>Service Charge</td>
                                <td class="center">NA</td>
                                <td class="center"><?php echo $this->utilityclass->cassnum(number_format($this->session->userdata('cert_fees'), 2)); ?> টকা</td>
                                <td class="center"><?php echo $this->utilityclass->cassnum(number_format($this->session->userdata('cert_fees'), 2)); ?> টকা</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total</td>
                                <td class="center"><?php echo $this->utilityclass->cassnum(number_format($this->session->userdata('cert_fees'), 2)); ?> টকা</td>
                            </tr>
                        </table>
                        <hr>
                        <p class="bold text-danger">Notice :</p>
                        <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
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

<script>
    function myFunction() {
        $(".dontshow").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("close").disabled = false;
    }
</script>

