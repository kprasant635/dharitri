<div class="container-fluid form-top login">
    <div class='row' id="printdiv">
        <div class="container-fluid form-top">
            <div class='row' id="printdiv">
                <?php
                //var_dump($this->session->all_userdata());
                // var_dump($certDtls);
                //var_dump($dagDtls);
                ?>
                <div class='col-lg-10' style="margin: 0 auto;float: none;">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <h2 class="center uni_text">অসম চৰকাৰ</h2>
                            <center><img src="<?php echo base_url(); ?>application/views/images/goa.jpg" width='8%'></center>
                            <h2 class="center uni_text">GOVERNMENT OF ASSAM</h2>
                            <p class="uni_text text-center"> <?php echo $location['distname'] ?> জিলাৰ উপায়ুক্তৰ কাৰ্য্যালয় <br>ভূমি অধিগ্রহণ শাখা </p>
                            <hr>
                            <p class="uni_text">
                                ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে, <?php echo $location['mouza_pargona_code'] ?> মৌজাৰ <?php echo $location['vill_townprt_code'] ?> গাঁওৰ ,
                                <?php echo $certDtls->appln_name; ?> আবেদন ক্ৰমে ,তপশীলভুক্ত মাটিৰ কঠাই প্রতি <?php echo round($certDtls->lv_katha_price, 2); ?> টকা হিচাপে মুঠ <?php echo $dagDtls->a_dag_area_b; ?> বিঘা <?php echo $dagDtls->a_dag_area_k; ?> কঠা <?php echo $dagDtls->a_dag_area_lc; ?>
                                লেছা মাটিৰ মুল্য <?php echo $location['tot_price']; ?> টকা ধাৰ্য্য কৰা হ’ল |
                            </p> 
                            <p class="uni_text">এই প্রমাণ-পত্ৰ চক্ৰ বিষয়াৰ <?php
							//echo $certDtls->lv_co_ord_date;
							if(($certDtls->lv_co_ord_date!="1970-01-01 00:00:00") and (!empty($certDtls->lv_co_ord_date)) )
							{
							echo date('d/m/Y', strtotime($certDtls->lv_co_ord_date));
							}else{
								echo "----------------------------";
							} ?> তাৰিখৰ <?php
							if(!empty(trim($certDtls->lv_co_ord_no))){
							echo $certDtls->lv_co_ord_no;
							}
							else{
								echo "-----------------------------";
							}
							?> নং প্রতিবেদনৰ ভিওিত দিয়া হল |</p>
                            <p class="uni_text">এই প্রমাণ-পত্ৰ কেৱল <?php echo $certDtls->lv_purpose; ?> ৰ বাবেহে প্রযোজ্য |</p>
                            <hr>
                            <p class="text-center uni_text">তপশীল</p>
                            <table class="table">
                                <tr class="uni_text text-center active">
                                    <td>মৌজা </td><td>গাঁও </td><td>পাট্টা নং</td><td>দাগ নং </td><td>কালি (বি-ক-লে)</td>
                                </tr>
                                <tr class="uni_text text-center">
                                    <td><?php echo $location['cirname'] ?></td><td><?php echo $location['vill_townprt_code'] ?> </td><td><?php echo $certDtls->patta_no; ?></td><td><?php echo $dagDtls->dag_no; ?></td><td><?php echo $dagDtls->a_dag_area_b . "-" . $dagDtls->a_dag_area_k . "-" . $dagDtls->a_dag_area_lc; ?></td>
                                </tr>
                            </table>
                            <hr>
                            <p class="uni_text">স্মাৰক নং  : H.R.A.<?php echo $certDtls->lv_memo_no; ?></p>
                            <p class="uni_text">প্রতিলিপি  : 
                                <?php
                                $str = $certDtls->lv_copies_to;
                                $st = (explode('-', $str));
                                foreach ($st as $s) {
                                    echo "<span>" . $s . "," . "<br/>" . "</span>";
                                }
                                ?>
                            </p>
                            <p class="uni_text">ক বিহিত ব্যৱহাৰ ৰ কাৰণে দিয়া হ’ল |</p>
                            <div class="col-lg-offset-9">
                                <p class="uni_text text-right">
                                    উপায়ুক্তৰ হৈ (<?php echo $location['distname']; ?>)<br>
                                    তাং : <?php echo date('d/m/Y', strtotime($certDtls->comment_date)); ?>
                                </p>
                            </div>
                            <div class="col-lg-offset-9">
                                <p class="uni_text text-right">
                                    <?php
                                    $coname = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $certDtls->user_code);
                                    echo $coname->username . ", চক্র বিষয়া"; ?><br>
                                    <?php echo $location['cirname']; ?> ৰাজহ  চক্ৰ <br>
                                    তাং : <?php echo date('d/m/Y', strtotime($certDtls->comment_date)); ?>				 
                                </p>

                            </div>
                            <hr>
                            <p class="bold text-danger">Notice :</p>
                            <p class="bold text-danger">1) Please note this is a system generated certificate and does not need any signature.</p>
                            <?php
                            $data = explode(",", $qrcode)[1];
                            echo '<img src="data:image/png;base64,' . $data . '" />';
                            ?> 
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
    </div>
</div>
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
