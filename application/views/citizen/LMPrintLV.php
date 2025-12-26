<div class="container-fluid form-top login">
    <div class='row'>
        <?php //var_dump($this->session->all_userdata());
              //var_dump($location);
              //var_dump($sendValue);
        ?>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                <h2 class="center uni_text">অসম চৰকাৰ </h2>
                <p class="uni_text text-center"> <?php echo $location['distname'] ?> জিলাৰ উপায়ুক্তৰ কাৰ্য্যালয় <br>ভূমি অধিগ্রহণ শাখা </p>
                <hr>
                <p class="uni_text">
                   ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে, <?php echo $location['mouza_pargona_code'] ?> মৌজাৰ <?php echo $location['vill_townprt_code'] ?> গাঁওৰ ,
                   <?php echo $certD->appln_name; ?> আবেদন ক্ৰমে ,তপশীলভুক্ত মাটিৰ কঠাই প্রতি <?php echo round($sendValue['lv_katha_price'],2); ?> টকা হিচাপে মুঠ <?php echo $certDag->a_dag_area_b; ?> বিঘা <?php echo $certDag->a_dag_area_k ;?> কঠা <?php echo $certDag->a_dag_area_lc; ?>
                   লেছা মাটিৰ মুল্য <?php echo $location['tot_price']; ?> টকা ধাৰ্য্য কৰা হ’ল |
                </p> 
                <!---<p class="uni_text">এই প্রমাণ-পত্ৰ চক্ৰ বিষয়াৰ <?php echo date('d/m/Y',  strtotime($sendValue['lv_co_ord_date'])) ?> তাৰিখৰ <?php echo $sendValue['lv_co_ord_no'] ?> নং প্রতিবেদনৰ ভিওিত দিয়া হল |</p> --->
                <p class="uni_text">এই প্রমাণ-পত্ৰ চক্ৰ বিষয়াৰ <?php
							//echo $certDtls->lv_co_ord_date;
							if(($sendValue['lv_co_ord_date']!="1970-01-01 00:00:00") and (!empty($sendValue['lv_co_ord_date'])) )
							{
							echo date('d/m/Y', strtotime($sendValue['lv_co_ord_date']));
							}else{
								echo "----------------------------";
							} ?> তাৰিখৰ <?php
							if(!empty(trim($sendValue['lv_co_ord_no']))){
							echo $sendValue['lv_co_ord_no'];
							}
							else{
								echo "-----------------------------";
							}
							?> নং প্রতিবেদনৰ ভিওিত দিয়া হল |</p>
				<p class="uni_text">এই প্রমাণ-পত্ৰ কেৱল <?php echo $sendValue['lv_purpose']; ?> ৰ বাবেহে প্রযোজ্য |</p>
                <hr>
                <p class="text-center uni_text">তপশীল</p>
                <table class="table">
                    <tr class="uni_text text-center active">
                        <td>মৌজা </td><td>গাঁও </td><td>পাট্টা নং</td><td>দাগ নং </td><td>কালি (বি-ক-লে)</td>
                    </tr>
                    <tr class="uni_text text-center">
                        <td><?php echo $location['cirname'] ?></td><td><?php echo $location['vill_townprt_code'] ?> </td><td><?php echo $certD->patta_no; ?></td><td><?php echo $certDag->dag_no; ?></td><td><?php echo $certDag->a_dag_area_b."-".$certDag->a_dag_area_k."-".$certDag->a_dag_area_lc; ?></td>
                    </tr>
                </table>
                <hr>
                <p class="uni_text">স্মাৰক নং  : H.R.A.<?php echo $sendValue['lv_memo_no']; ?></p>
                <p class="uni_text">প্রতিলিপি  : 
                    <?php
                    $str=$sendValue['lv_copies_to'];
                    $st=(explode('-', $str));
                    foreach($st as $s)
                    {
                        echo "<span>".$s.","."<br/>"."</span>";
                    }
                    ?>
                </p>
                <p class="uni_text">ক বিহিত ব্যৱহাৰ ৰ কাৰণে দিয়া হ’ল |</p>
                <div class="col-lg-offset-9">
                        <p class="uni_text text-center">
                           উপায়ুক্তৰ হৈ (<?php echo $location['distname']; ?>)<br>
                           তাং : <?php echo date('d/m/Y'); ?>
                        </p>
                </div>
                <hr>
                <form action="<?php echo base_url();?>index.php/citizencontroller/FinalStepLV" method="POST">
                    <button class="btn btn-primary col-lg-offset-4" name="FormSubmit" type="submit"><?php echo $this->lang->line('forwardco_necessary_action');?></button>
                </form>
               
            </div>
            </div>
        </div>
       
    </div>
</div>
