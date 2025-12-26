
<style>
@media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
</style>

<style>
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #printSection,
        #printSection * {
            visibility: visible;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
    .label-style{
      font-size: 20px; 
      font-family:calibri; 
      color:green; 
      font-style: italic;
    }
</style>

<div class="contanier form-top login">
    <div class="row" id="printThis">
        <?php
foreach($dag as $dag_row){
?>

        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <?php //print_r($pb);
            // if($pb->complete_partition_yn == 'Y')
            // {
            //     $part_type='সম্পূৰ্ণ ';
            // }
            // else {$part_type='অসম্পূৰ্ণ ';}
            $part_type='সম্পূৰ্ণ ';
            ?>
			<h2 class="center bold">Notice Under Section 99 of ALRR 1886 read with Section 3/4/8 of ARRRTL  Act 2015</h2>
            <h4 class="center">বাটোৱাৰা গোচৰ (শ্ৰেণী পৰিৱৰ্তন মৰ্মে) নং  <?php echo $dag_row->case_no; ?> </h4>
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
                //echo "<span class='font-italic'>Mobile Number: ". $mobile_no ."</span>";
                ?>
            </div>
            <div class="uni_text" style="margin-top: 10px">ৰেকৰ্ড ভুক্ত পট্টাদ্বাৰ :
                <ol>
                    <?php
	       //var_dump($pattadar);
                    // var_dump($dag_row);
                    $count = 1;

                    foreach ($dag_row->pattadar_array as $patt) {
		          echo "<li>".$count.".&nbsp;&nbsp;" . $patt->pdar_name . ",&nbsp;&nbsp;&nbsp;" . $patt->pdar_father . "<br></li>";
                  $count++;
                    }
                    ?><li><?php echo $count ?>.&nbsp; সংশ্লিষ্ট সৰ্বসাধাৰণ জ্ঞাতাৰ্থে ও বিহীতাৰ্থে (নটিছ বৰ্ডৰ মাধ্যমেৰে) </li></ol></div>

                    <div class="uni_text" style="margin-bottom: 10px; margin-top: 30px; line-height: 150%; ">

                যিহেতুকে <?php echo $mouza->mouza ?> মৌজাৰ <?php echo $vill->vill ?> গাৱঁৰ <?php echo $this->utilityclass->cassnum($dag_row->patta_no) ?> নং <?php echo $dag_row->patta_name ?> পাট্টাৰ <?php echo $this->utilityclass->cassnum($dag_row->dag_no) ?> নং দাগৰ অংশ
                <?php echo $this->utilityclass->cassnum($dag_row->co_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dag_row->co_area_k) ?> কঠা <?php echo $this->utilityclass->cassnum(number_format($dag_row->co_area_lc,2)) ?> লেছা মাটিত <?php echo $dag_row->exist_land_class_name;?> ৰ পৰা  <?php echo $dag_row->proposed_land_class_name;?> লৈ শ্ৰেণী পৰিৱৰ্তন ও সম্পূৰ্ণ বাটোৱাৰা বাবে আবেদন কৰিছে আৰু সেই পৰিপ্ৰেক্ষিতত  উক্ত মাটিত শ্ৰেণী পৰিৱৰ্তন মৰ্মে সম্পূৰ্ণ বাটোৱাৰা কৰাৰ প্ৰয়োজন হৈছে আৰু সেইবাবে ওপৰত উল্লেখিত গোচৰ এই আদালতত ৰেজিস্টাৰ ভূক্ত হৈছে ৷

            </div>
            <div class="uni_text" style="margin-bottom: 10px ;line-height: 150%">এতেকে আপোনালোক /সৰ্বসাধাৰণক জনোৱা যায় যে , উক্ত শ্ৰেণী পৰিৱৰ্তন  ও  সম্পূৰ্ণ বাটোৱাৰা গোচৰ সম্বন্ধে যদিহে কাৰোবাৰ কিবা আপওি থাকে তেনেহ’লে নিজে কিম্বা অধিবক্তাৰ দ্বাৰা ইং <?php echo $this->utilityclass->cassnum(date('d/m/Y', strtotime($dag_row->next_date_of_hearing))) ?> পুৱা  ১০.০০ বজাত এই আদালতত হাজিৰ হৈ লিখিত ভাবে তথ্য সহকাৰে দৰ্শাবহি ৷ অন্যথাই গোচৰ একপক্ষীয় ভাবে শুনানি লৈ নিস্পত্তি কৰা হ’ৱ |</div>
            <div class="uni_text" style="margin-bottom: 20px">আজি ইং <?php echo $this->utilityclass->cassnum(date('d/m/Y')); ?> তাৰিখে মোৰ চহী আৰু আদালতৰ মোহৰ দিয়া হ’ল ৷</div>





            <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center">
                            <b><?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></b><br>
                            অতিৰিক্ত উপায়ুক্ত <br>
                        </div>
            </div>
			<hr>
			<p class='red uni_text center small'>** Please note this is a system generated certificate and does not need any signature **</p>
            <hr>
	
        </div>
        <br><br>

    <div class="pagebreak">
        <hr>
    </div>

<?php
}

?>

    </div>

            <div class='dontshow'>
            <!-- <span class='red'>Note : Print the Notice First then Submit Report</span>
            <form action="<?php echo base_url(); ?>index.php/ReclassSuiteControllerAst/SaveNotcPetionerReclass" method="POST" style="margin-bottom: 15px">
                <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                <button class="btn btn-primary col-lg-offset-4 uni_text" disabled id='print' type="submit"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit'); ?></button>
                <input type="hidden" value="<?php echo $pb->case_no; ?>" name="case_no" >
            </form> -->
            <center><button class='btn btn-danger' id="print">Print this page</button> </center>
            </div>
</div>

<script>


               $(document).on('click', '#print', function(){
    printElement(document.getElementById("printThis"));
});

               function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
 </script>                                                       

