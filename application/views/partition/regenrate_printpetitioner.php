<div class="contanier form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <?php //print_r($pb);
            if($pb->complete_partition_yn == 'Y')
            {
                $part_type='সম্পূৰ্ণ ';
            }
            else {$part_type='অসম্পূৰ্ণ ';}
            ?>
			<h2 class="center">ৰাজহ আইনৰ ৯৯ নং ধাৰা অনুযায়ী</h2>
            <h4 class="center"><?php echo $part_type; ?> বাটোৱাৰা  গোচৰ নং <?php echo $pb->case_no; ?> </h4>
            <hr>
            <div class="uni_text">দৰ্খাস্তকাৰী : <?php
                foreach ($partition as $part) {
                   echo "&nbsp;&nbsp;" . $part->pdar_name . "," . $part->pdar_guardian . " ( <i class='fa fa-mobile'></i> ". $part->pdar_mobile .")". "<br>";
                }
                echo "<span class='font-italic'>Mobile Number: ". $mobile_no ."</span>";
                ?>
            </div>
            <div class="uni_text" style="margin-top: 10px">পট্টাদ্বাৰ :
                <ol>
                    <?php
	//var_dump($pattadar);
                    foreach ($pattadar as $patt) {
		echo "<li>&nbsp;&nbsp;" . $patt[0]->pdar_name . ",&nbsp;&nbsp;&nbsp;" . $patt[0]->pdar_father . "<br></li>";
                    }
                    ?></ol></div>

            <div class="uni_text" style="margin-bottom: 10px; margin-top: 30px; line-height: 150%; ">

                যিহেতুকে <?php echo $mouza->mouza ?> মৌজাৰ <?php echo $vill->vill ?> গাৱঁৰ <?php echo $this->utilityclass->cassnum($dag->patta_no) ?> নং <?php echo $PName->name ?> পাট্টাৰ <?php echo $this->utilityclass->cassnum($dag->dag_no) ?> নং দাগৰ অংশ
<?php echo $this->utilityclass->cassnum($dag->m_dag_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dag->m_dag_area_k) ?> কঠা <?php echo $this->utilityclass->cassnum($dag->m_dag_area_lc) ?> লেছা মাটিত সম্পূৰ্ণ  বাটোৱাৰা বিচাৰি দৰ্খাস্ত দাখিল কৰিছে আৰু সেই মৰ্মে এক বাটোৱাৰা গোচৰ এই আদালতত ৰেজিস্টাৰভূক্ত হৈছে ৷

            </div>
            <div class="uni_text" style="margin-bottom: 10px ;line-height: 150%">এতেকে সৰ্বসাধাৰণক জনোৱা যায় যে , উক্ত বাটোৱাৰা গোচৰ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপওি থাকে তেনেহ’লে নিজে কিম্বা অধিবক্তাৰ দ্বাৰা ইং <?php echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($pb->next_date_of_hearing))) ?> পুৱা  ১০.০০ বজাত এই আদালতত হাজিৰ হৈ দৰ্শাবহি ৷ অন্যথাই বিচাৰ কৰি নিস্পত্তি কৰা হ’ৱ ৷</div>
            <div class="uni_text" style="margin-bottom: 20px">আজি ইং <?php echo $this->utilityclass->cassnum(date('d/m/Y')); ?> তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ দিয়া হ’ল ৷</div>

            <div class="col-sm-4 col-sm-offset-8">
                <p class="uni_text pull-right text-center">  চক্র বিষয়া ,<br>
                <?php echo $cirname->cirname; ?>, ৰাজহ চক্ৰ 
                </p>

            </div>
			<hr>
			<p class='red uni_text center small'>** Please note this is a system generated certificate and does not need any signature **</p>
            <hr>
			<div class='dontshow'>
			<span class='hide red'>Note : Print the Notice First then Submit Report</span>
			<a href='<?php echo base_url(); ?>index.php/home' class='btn btn-info center'>Go Back to Home</a>
			<center><button class='btn btn-danger' onclick="myFunction()">Print this page</button> </center>
			</div>
        </div>
    </div>
</div>

<script>
                                                        function myFunction() {
															
															$(".dontshow").hide();
                                                            window.print();
															$(".dontshow").show();
															document.getElementById("print").disabled = false;
															
                                                        }
 </script>                                                       
