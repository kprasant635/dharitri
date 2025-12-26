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
                                <p class="uni_text">
                                    ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে ,<?php echo $location['cirname']; ?>  ৰাজহ চক্ৰ ,<?php echo $location['mouza_pargona_code'] ?> মৌজা ৰ,
                                    <?php echo $location['vill_townprt_code'] ?> গাঁওৰ
                                    <?php
									$pp=$certDtls->patta_no;
									if(is_numeric($pp)){
										echo $this->utilityclass->cassnum($pp);
									}else {
										echo $pp;
									}
									 ?> নং <?php echo $this->utilityclass->getPattaName($certDtls->patta_type_code); ?> ( এজমালি )  পাট্টাৰ অৰ্ন্তগত , তলত দিয়া ধৰণে ,
                                </p>
                                <table class="table table_black center">
                                    <tr>
                                        <td>দাগ নং<?php //echo $this->lang->line('dag_no');    ?></td>
                                        <td>মাটিৰ প্রকাৰ <?php //echo $this->lang->line('land_type');    ?></td>
                                        <td>বিঘা <?php //echo $this->lang->line('bigha');    ?></td>
                                        <td>কঠা <?php //echo $this->lang->line('katha');    ?></td>
                                        <td>লেছা <?php //echo $this->lang->line('lesa');    ?></td>
                                        <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                                        <td>গান্ডা <?php //echo $this->lang->line('lesa');    ?></td>
                                    <?php }?>

                                    </tr>
                                    <?php foreach ($dagDtls as $dagDtls) { ?>
                                        <tr>
                                            <td><?php echo $this->utilityclass->cassnum($dagDtls->dag_no); ?></td>
                                            <td><?php echo $this->utilityclass->getLandClassCode($dagDtls->land_class_code); ?></td>
                                            <td><?php echo $this->utilityclass->cassnum($dagDtls->a_dag_area_b); ?></td>
                                            <td><?php echo $this->utilityclass->cassnum($dagDtls->a_dag_area_k); ?></td>
                                            <td><?php echo $this->utilityclass->cassnum($dagDtls->a_dag_area_lc); ?></td>
                                            <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                                            <td><?php echo $this->utilityclass->cassnum($dagDtls->a_dag_area_g); ?></td>
                                            <?php }?>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <?php // Added by Bijoy Mazumder, DIO, Bongaigaon on 27/04/2017?>
                                <?php if ($location['tot_pdar'] == 1) { ?>
                                    <?php echo "<p class=uni_text> মাটিত "; ?> <?php echo $certDtls->appln_name; ?>,( <?php
                                    echo $this->utilityclass->get_relation($certDtls->guard_reln) . "&nbsp;&nbsp;";
                                    echo $certDtls->appln_guard;
                                    ?> ) ৰ নিজৰ নামত থকা মাটি হয় | <?php echo "</p>"; ?>
                                <?php } elseif ($location['tot_pdar'] > 1) { ?>
                                    <?php echo "<p class=uni_text>মাটিত "; ?> <?php echo $certDtls->appln_name; ?> ( <?php
                                    echo $this->utilityclass->get_relation($certDtls->guard_reln) . "&nbsp;&nbsp;";
                                    echo $certDtls->appln_guard;
                                    ?> )  ৰ তথা, অন্যান্য <?php echo $location['tot_pdar'] - 1; ?> জনৰ নামত থকা মাটি হয় |<?php
                                    echo "</p>";
                                }
                                ?>
                                <p class="uni_text">এই প্রমাণ-পত্র লাট-মন্ডলৰ প্রতিবেদনৰ ভিওিত দিয়া হ’ল |</p>
                            </div>
                            <div class='col-lg-3'>
                                <p class='pull-left'><?php
                                    $data = explode(",", $qrcode)[1];
                                    echo '<img src="data:image/png;base64,' . $data . '" />';
                                    ?> 
                                </p>
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
