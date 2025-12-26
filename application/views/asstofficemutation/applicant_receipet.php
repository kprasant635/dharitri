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
                        <h2 class="center uni_text">অসম চৰকাৰ</h2>
                        <center><img src="<?php echo base_url(); ?>application/views/images/goa.jpg" width='5%'></center>
                        <h2 class="center uni_text">GOVERNMENT OF ASSAM</h2>
                        <p class="center uni_text" style='margin-top:-15px' ><?php echo $circle; ?> ৰাজহ  চক্ৰ</p>
                        <p class="center uni_text" style='margin-top:-15px'>Acknowledgement Reciept / নগদ ধনৰ ৰচিদ</p>
                        <hr>
                        <input type='hidden' name='cert_no' value='<?php echo $case_no; ?>'>
                        <table width="100%">
                            <tr>
                                <td width="45%">গোচৰ নং : <?php echo $case_no; ?></td>
                                <td width="10%"></td>
                                <td width="45%">প্রস্তাবিত তাৰিখ :<?php echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($next_due_date))) ?></td>
                            </tr>
                            <tr>
                                <td width="45%">Applicant Name : <span class='red'>
                                    <?php
                                    $count = 1;
                                    $howmany = sizeof($applicant_name) - 1;
                                    foreach ($applicant_name as $pa): {
                                            if($mut_type=='03'){
                                                $petname = $pa->pet_name;
                                            }
                                            else{
                                                $petname = $pa->pdar_name;
                                            }
                                            echo $petname;
                                            if ($count < sizeof($applicant_name) - 1) {
                                                echo "<span style='color:red;'> , </span>";
                                                $count++;
                                            } elseif ($count == sizeof($applicant_name) - 1) {
                                                echo "<span style='color:red;'> আৰু </span>";
                                                $count++;
                                            } else {
                                                echo " ";
                                            }
                                        }
                                    endforeach;
                                    ?>
                                    </span></td>
                                <td width="10%"></td>
                                <td width="45%">Service name : <span class='red'> <?php echo $mutation_type_name; ?> </span></td>
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
                            <label class="uni_text col-sm-12">Note : ইং <?php
                            echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($current_date)));
                            ?>  তাৰিখে আপুনি বিচৰামতে  <?php echo $case_no; ?> নং গোচৰ <span class='red'> <?php echo $mutation_type_name; ?></span> পঞ্জীকৰণ প্রক্রিয়া সম্পূর্ণ হ'ল ।
                            </label>
                        </div>
                        <br>
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
                                <td>Statutory Charges</td>
                                <td class="center">NA</td>
                                <td class="center"><?php echo $this->utilityclass->cassnum(number_format($total_fee_amt, 2)); ?> টকা</td>
                                <td class="center"><?php echo $this->utilityclass->cassnum(number_format($total_fee_amt, 2)); ?> টকা</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total</td>
                                <td class="center"><?php echo $this->utilityclass->cassnum(number_format($total_fee_amt, 2)); ?> টকা</td>
                            </tr>
                        </table>
                        <br>
                        <p class="bold text-danger">Notice :</p>
                        <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
                    </div>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <center>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-primary uni_text dontshow" onclick="myFunction()"><i class='fa fa-check'></i>&nbsp; Click Here to Print Receipt And Proceed </a>
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
<script>
    function myFunction() {
        $(".dontshow").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("close").disabled = false;
    }
</script>

