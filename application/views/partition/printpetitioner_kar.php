<div class="contanier form-top login">
    <div class="pageContent-data">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <?php //print_r($pb);
            // if($pb->complete_partition_yn == 'Y')
            // {
            //     $part_type='সম্পূৰ্ণ ';
            // }
            // else {$part_type='অসম্পূৰ্ণ ';}
            $part_type='সম্পূৰ্ণ ';
            ?>
			<h2 class="center">ৰাজহ আইনৰ ৯৯ নং ধাৰা অনুযায়ী</h2>
            <h4 class="center"><?php echo $part_type; ?> বাটোৱাৰা  গোচৰ নং <?php echo $pb->case_no; ?> </h4>
			<?php
                    if($this->session->flashdata('message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('message'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
            <hr>
            <div class="uni_text">দৰ্খাস্তকাৰী : <?php
             
                foreach ($partition as $part) {
                    echo "&nbsp;&nbsp;" . $part->pdar_name . "," . $part->pdar_guardian . " ( <i class='fa fa-mobile'></i> ". $part->pdar_mobile .")". "<br>";
                }
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
<?php echo $this->utilityclass->cassnum($dag->m_dag_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dag->m_dag_area_k) ?> কঠা <?php echo $this->utilityclass->cassnum($dag->m_dag_area_lc) ?> ছটাক <?php echo $this->utilityclass->cassnum($dag->m_dag_area_g) ?> গগণ্ডা  ভূমিতে নামজারী করার জন্য 
                    দরখাস্তকারীর দাখিল করা দরখাস্তমতে একটি নামজারী কেস নং এই আদালতে রেজিস্টারভূক্ত করা হইয়াছে ৷ 

            </div>
            <div class="uni_text" style="margin-bottom: 10px ;line-height: 150%">এতদ্বারা সর্ব্বসাধারণকে জানানো যাইতেছে যে , উক্ত নামজারী কেস সম্বন্ধে যদি কেহ বা কাহারো কোন আপওি থাকে
                    তাহা হইলে নিজে অথবা উকিল দ্বারা ইং <?php echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($pb->next_date_of_hearing))) ?> সকাল 10 ঘটিকার সময় এই আদালতে হাজির হইয়া উপযুক্ত কারণ দর্শাইবেন৷ অন্যথায়, একতরফাভাবে উক্ত কেস এর বিচার ও নিষ্পত্তি করা হইবে  ৷</div>
            <div class="uni_text" style="margin-bottom: 20px">আজি ইং <?php echo $this->utilityclass->cassnum(date('d/m/Y')); ?> তারিখে আমার সই এবং আদালতের সিল মারিয়া দেওয়া হইল ৷</div>

            <div class="col-sm-4 col-sm-offset-8">
                <p class="uni_text pull-right text-center"> চক্র আধিকারিক ,<br>
                <?php echo $cirname->cirname; ?>, ৰাজহ চক্ৰ 
                </p>

            </div>
			<hr>
			<p class='red uni_text center small'>** Please note this is a system generated certificate and does not need any signature **</p>
            <hr>
			<div class='dontshow'>
			<span class='red'>Note : Print the Notice First then Submit Report</span>
            <form action="<?php echo base_url(); ?>index.php/partition/SaveNotcPetioner" method="POST" style="margin-bottom: 15px">
                <button class="btn btn-primary col-lg-offset-4 uni_text" disabled id='print' type="submit"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
				<input type="hidden" value="<?php echo $pb->case_no; ?>" name="case_no" >
                <input type="hidden" id="pageContent" name="pageContent">
            </form>
			<center><button class='btn btn-danger' onclick="myFunction()">Print this page</button> </center>
			</div>
        </div>
    </div>
    </div>
</div>

<script>
function myFunction() {
    let pageData=document.querySelector(".pageContent-data").outerHTML;
    document.getElementById("pageContent").value=pageData;
    $(".dontshow").hide();
    window.print();
    $(".dontshow").show();
    document.getElementById("print").disabled = false;   
}
</script>                                                       
