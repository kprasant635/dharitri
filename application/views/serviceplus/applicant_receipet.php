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
							<p class="uni_text"><?php
                            echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($current_date)));
                            ?>  তাৰিখে <?php echo $case_no; ?> নং গোচৰ <span class='red'> <?php echo $mutation_type_name; ?></span> বাবে পঞ্জীকৰণ প্রক্রিয়া সম্পূর্ণ হ'ল ।</p>
						<hr>
                        <p class="uni_text">The Registration Process for Office Partition By Assistant (to CO) Completed.</p>
                        </div>
                        <br>
                        <div class="hide form-group">
                            <label class="uni_text col-sm-6">Fees Paid :</label>
                        </div>
                        <table class="hide  table table-bordered">
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
                    </div>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <center>
						<a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger uni_text dontshow" style="margin-bottom:20px"><i class='fa fa-arrow-left'></i>&nbsp; <?php echo $this->lang->line('back_to_main_menu');?> </a>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

