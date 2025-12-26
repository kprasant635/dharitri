<div class="container-fluid form-top login">
    <div class='row' id="printdiv">
        <div class="container-fluid form-top">
            <div class='row' id="printdiv">
                <?php //var_dump($dagDtls);?>
                <div class='col-lg-10' style="margin: 0 auto;float: none;">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <h2 class="center uni_text">অসম চৰকাৰ</h2>
                            <center><img src="<?php echo base_url(); ?>application/views/images/goa.jpg" width='8%'></center>
                            <h2 class="center uni_text">GOVERNMENT OF ASSAM</h2>
                            <p class="uni_text">
                                <span class="pull-left">চক্র বিষয়াৰ কাৰ্য্যালয়  ::</span>&nbsp;<?php echo $location['cirname']; ?>
                                ৰাজহ  চক্ৰ <span class="pull-right">মৌজা :
                                    <?php echo $location['mouza_pargona_code'] ?> </span></p>
                            <hr>
                            <p><span class="pull-left uni_text">আবেদন নং :<?php echo $certDtls->cert_no; ?></span>
                                <span class="pull-right uni_text">তাং :<?php echo $this->utilityclass->cassnum(date('d-m-Y', strtotime($certDtls->apply_date))); ?></span></p>
                            <hr>
                            <p class="uni_text text-center text-danger"><?php echo $cername = $this->utilityclass->getCertName($certDtls->cert_type); ?>  </p>
                            <div class="col-lg-12" style="margin-top: 25px">
							<p align="left" class="uni_text"> অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ </p><br>
                            <p class='center bold uni_text'><u>ORDER SHEET</u></p>
                            <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                            <br>
                            <table class="table table-bordered" style="font-size: 16px;">
                                    <tr style="color:#0000cc; text-align: center;">
                                        <td>Serial No and Date of Order</td>
                                        <td width="40%">Order and Signature of Officer</td>
                                        <td width="40%">Note Of Action Taken on Order</td>
                                    </tr>
                                    <tr style="color:#0000cc; text-align: center;">
                                        <td>১</td>
                                        <td>২</td>
                                        <td>৩</td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($cases as $case):
                                        ?>
                                        <tr>
                                            <td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                            <td>
                                                <?php echo $case->co_order; ?></td>
                                            <td>
                                                <?php echo $case->note_on_order; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </table>   
                                
                               
                            </div>
                            
                            <div class="col-lg-offset-9">

                                <p class="uni_text text-right">
                                    <?php
                                    //var_dump($certDtls);
                                    //var_dump($this->session->all_userdata($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$certDtls->user_code));
                                    $coname = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $certDtls->user_code);
                                    //var_dump($coname);
                                    echo $coname->username . ", চক্র বিষয়া";
                                    ?>
                                    <br>
                                    <?php echo $location['cirname']; ?> ৰাজহ  চক্ৰ
                                </p>
                            </div>
                            <hr>
                            <p class="bold text-danger">Notice :</p>
                            <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
                        </div>
                        <hr style="border-bottom: 2px solid #000;" class="dontshow">
                        <div class="row dontshow">
                            <center>
                                <form action="<?php echo base_url(); ?>index.php/CitizenController/CaseDelivered" method="POST">
                                    <div class="btn btn-primary uni_text" id="openBtn"><i class="fa fa-arrow-circle-down"></i> Keep Pending</div>
                                    <div class="btn btn-sm btn-danger uni_text printlink" onclick="myFunction()" ><i class="fa fa-print"></i> &nbsp;Print Report</div>
                                    <button class="btn btn-info uni_text" id='close' disabled type="submit" ><i class="fa fa-thumbs-o-up"></i> Certificate is Delivered</button>
                                    <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="case_no" >
                                </form>
                            </center>
                        </div>
                        <br>
                    </div>
                </div>
            </div>


        </div>

    </div></div>
<style>
    .table_black tr  td {
        border:1px solid #000;
    }
</style>
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
