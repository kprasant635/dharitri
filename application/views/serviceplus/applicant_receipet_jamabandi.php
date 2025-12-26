<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary">
                <?php
                //var_dump($this->session->all_userdata());
                //var_dump($location);
                ?>
                <form action="" method="POST">
                    <div class="panel-body">
                        <input type='hidden' name='cert_no' value='<?php echo $cert_no; ?>'>
                        <table width="100%">
                            <tr>
                                <td width="45%">গোচৰ নং : <?php echo $cert_no; ?></td>
                                <td width="10%"></td>
                                <td width="45%">প্রস্তাবিত তাৰিখ :<?php echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($next_due_date))) ?></td>
                            </tr>
                            <tr>
                                <td width="45%">Applicant Name : <span class='red'><?php echo $applicant_name; ?></span></td>
                                <td width="10%"></td>
                                <td width="45%">Service name : <span class='red'> <?php echo $cert_type; ?> </span></td>
                            </tr>
                            <tr>
                                <td width="45%">Mobile Number : 
                                <?php
                                if(!empty($mobile_no)){
                                    echo $mobile_no;
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
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $circle; ?> ৰাজহ  চক্র ,<?php echo $district; ?></span></td>
                            </tr>
                        </table>
                        <hr>
                        <div class="form-group">
                            <label class="uni_text col-sm-12">Delivery Date : ইং <?php
                            echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($current_date)));
                            ?>  তাৰিখে আপুনি বিচৰামতে   <span class='red'> <?php echo $cert_type; ?></span> দিয়া হ’ল |
                            </label>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="uni_text col-sm-6">Fees Paid :</label>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td class="center">Charges</td>
                                <td class="center">Amount (in Rs.)</td>
                                <td class="center">Total (in Rs.)</td>
                            </tr>
                            <tr>
                                <td>Service Charge (Online Payment)</td>
                                <td class="center">20 টকা</td>
                                <td class="center">20 টকা</td>
                            </tr>
                            <tr>
                                <td colspan="2">Total</td>
                                <td class="center">20 টকা</td>
                            </tr>
                        </table>
                        <hr>
                        <p class="bold text-danger">Notice :</p>
                        <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
                    </div>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <center>
                        <a href="<?php echo base_url();?>index.php/CitizenController/UpdateJamabandiFinal?cert_no=<?php echo $cert_no; ?>&fee_amt=<?php echo $total_fee_amt; ?>" class="btn btn-primary uni_text dontshow" onclick="myFunction()"><i class='fa fa-check'></i>&nbsp; Click Here to Print Receipt And Submit Report </a>
                    </center>
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

