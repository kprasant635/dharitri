<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        //border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
        
    }
    .unicode{
        font-size: 5px !important;
    }
</style>
<div class="container-fluid form-top">
    <div class="pageContent-data">
    <div class="row">
        <div class="col-lg-12 panel-body ">
            <h2 class="bold" style="text-align: center;margin-top: 20px;">NOTICE UNDER SECTION 52 of the LAND AND REVENUE REGULATION</h2>
            <h2 class="bold"  style="text-align: center">Case no- <?php echo $case_no; ?> date:<?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?></h2>
            <?php
            if($this->session->flashdata('message1')){
            ?>
            <div class="error_container">
	            <div class="alert alert-warning alert-dismissible show" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	            </button>
	            <strong class="text-danger">
	            <?= $this->session->flashdata('message1'); ?>
	            </strong>
	            </div>
            </div>
            <?php
            }
            ?>
            <?php
            if($this->session->flashdata('success1'))
            {
            ?>
			<div class="error_container">
				<div class="alert alert-success alert-dismissible show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<strong class="text-danger">
				<?= $this->session->flashdata('success1'); ?>
				</strong>
				</div>
			</div>
			<?php
			}
			$dist_code = $this->session->userdata('dist_code');
            ?>
            <div style="line-height: 30px;margin-top: 30px;margin-bottom: 30px;">
                <p class='uni_text' style="font-size:1em;">যিহেতু <?php
                    echo $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code) . " ";
                    echo $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code) . " ";
                    ?>গাৱঁৰ <?php echo $this->utilityclass->cassnum($details->patta_no); ?> নং খেৰাজ ম্যাদী পাট্টাৰ <?php echo $this->utilityclass->cassnum($details->dag_no); ?> 
                    নং দাগৰ অংশ <?php echo $this->utilityclass->cassnum($details->m_dag_area_b); ?> বিঘা <?php echo $this->utilityclass->cassnum($details->m_dag_area_k); ?> কঠা <?php echo $this->utilityclass->cassnum(number_format($details->m_dag_area_lc, 2)); ?>
                    লেছা মাটিত নামজাৰী 
                    বিচাৰি দৰ্খাস্ত দাখিল কৰিছে আৰু সেই মৰ্মে এক নামজাৰী গোচৰ এই আদালতত ৰেজিস্টাৰভূক্ত হৈছে ৷
                    এতেকে সৰ্বসাধাৰণক জনোৱা যায় যে , উক্ত নামজাৰী গোচৰ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপওি থাকে 
                    তেনেহ’লে নিজে কিম্বা অধিবক্তাৰ দ্বাৰা ইং <?php echo $this->utilityclass->cassnum(date('d-m-y', strtotime($details->next_date_of_hearing))); ?> পুৱা ১০ বজাত এই আদালতত হাজিৰ হৈ দৰ্শাবহি ৷ অন্যথাই বিচাৰি আৰু নিস্পত্তি কৰা হ’ৱ ৷
                <p class='uni_text' style="font-size:1em;">আজি ইং <?php echo $this->utilityclass->cassnum(date('d-m-Y')); ?>  তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ দিয়া হ’ল ৷</p></p>
            </div>
            <table class="table table-bordered table_black" style="font-size:1em;">
                <tr>
                    <td>মৌজা / গাঁও</td>
                    <td>স্বত্বাধিকাৰী / গৰাকী</td>
                    <td>আবেদনকাৰী</td>
                    <td>বিৱৰণ</td>
                    <td>বাকী বিৱৰণ</td>
                </tr>
                <tr>
                    <td>
                        <?php
                        echo
                        $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code) . ",<br>";
                        echo $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
                        ?>
                    </td>
                    <td>
                        <?php foreach ($pattadars as $p): ?>
                            <?php echo $p->pdar_name . "<br>"; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($applicants as $p): ?>
                            <?php echo $p->pet_name . "<br>"; echo "<i class='fa fa-phone'></i> ". $p->pdar_mobile; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php
                        echo "পাট্টা  নং:" . $this->utilityclass->cassnum($details->patta_no) . "," . "<br>";
                        echo "দাগ  নং :" . $this->utilityclass->cassnum($details->dag_no) . "," . "<br>";
                        echo "মাটিৰ কালি : " . $this->utilityclass->cassnum($details->m_dag_area_b) . " বি: " . $this->utilityclass->cassnum($details->m_dag_area_k) . " ক: " .
                        $this->utilityclass->cassnum(number_format($details->m_dag_area_lc, 2)) . " লে: ";
                        ?>
                    </td>
                    <td></td>
                </tr>
            </table>
            <?php
              $dist_code = $this->session->userdata('dist_code');
              if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
              <p class='uni_text'> বিজ্ঞপ্তি গ্রহণ করা ব্যক্তি/সর্বসাধারণ : 
              <?php }else{?>
              <p class='uni_text' style="font-size:1em;">জাননী পাবলগীয়া গৰাকী /সৰ্বসাধাৰণ : 
              <?php }?>
              <?php
                foreach ($notifyname as $np) {
                    if(!empty($np->notified_name)){
                        echo $np->notified_id . ")" . $np->notified_name . "&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                }
                ?>
            </p>
            <hr>
            <p class='pull-right uni_text' style="font-size:1em;">
                <?php
                $coname = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->add_off_name);
                echo $coname->username;
                ?> <br> 
                চক্র বিষয়া ,<?php
                echo $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
                ?>
            </p>
            <hr>
            <?php
            $link = base_url() . "index.php/officemutation/issueNotice";
            ?>
            <form method="post" action="<?php echo $link; ?>">
                <?php if(ESCALATION_ENABLE == 1){?>
                    <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                <?php } ?>
                
                <div class="form-group no-print" style="text-align: center;">
                    <button type="submit" class="btn btn-primary" onclick="return myfunction1()" >Proceed</button>
                    <?php
                        if($this->session->flashdata('success1')){
                    ?>
                    <button type="submit" class="btn btn-primary" onclick="return myFunction()"><i class="fa fa-print"></i>&nbsp;Print Notice</button>
                   <?php } ?>
                    <a href="<?php echo base_url(); ?>index.php/officemutation/getPendingNoticeGeneration" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                    </a>
                </div>
                
                <input type="hidden" name="case_no" value="<?php echo $case_no; ?>"/>  
                <input type="hidden" name="mouza_pargona_code" value="<?php echo $details->mouza_pargona_code; ?>"/>
                <input type="hidden" name="lot_no" value="<?php echo $details->lot_no; ?>"/>
                <input type="hidden" name="vill_townprt_code" value="<?php echo $details->vill_townprt_code; ?>"/>
                <input type="hidden" id="pageContent" name="pageContent">
            </form>
        </div>
    </div>
    </div>
</div>
<script>
    function myfunction1(){
     let pageData=document.querySelector(".pageContent-data").outerHTML;
     document.getElementById("pageContent").value=pageData;
    }
    function myFunction() {
        $(".dontshow").hide();		
        window.print();
        $(".dontshow").show();
        document.getElementById("mainMenu").disabled = false;
    }
</script>