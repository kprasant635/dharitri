        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <h2 class="text-center"><?php echo $this->lang->line('cos_order');?></h2>
                    <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/CitizenController/COStep3" method="POST">
                        <div class="form-inline">
                        <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                          <div class="radio-inline">
                                <input type="radio" value="approved" name="COApprove" checked="" id="approved"><span class="uni_text">সহকারী লাট-মণ্ডলের রিপোর্টের প্রিন্ট নেয় এবং আমার স্বাক্ষর নেয় | দ্বিতীয়ত, সহকারী প্রয়োজনীয় নথিতে পরিষেবা প্রদানকারী আবেদনকারীর তথ্য রেকর্ড করবে | <?php //echo $this->lang->line('asstt_print_report_asstt_taken_docs')?></span>
                            </div>

                          <?php }else{?>
                            <div class="radio-inline">
                                <input type="radio" value="approved" name="COApprove" checked="" id="approved"><span class="uni_text">সহায়কে লাট-মন্ডলৰ ৰিৰ্পটৰ প্রিন্ট ল’ৱ আৰু মোৰ স্বাক্ষৰ ল’ৱ | দ্বিতীয়তে সহায়কে আবেদনকাৰীৰ প্রয়োজনীয় নথিৰ সেৱা দিয়াৰ তথ্য ৰেকৰ্ড কৰিৱ | <?php //echo $this->lang->line('asstt_print_report_asstt_taken_docs')?></span>
                            </div>
                          <?php }?>
                            <div class="radio-inline">
                                <input type="radio" value="resubmit" name="COApprove" id="resubmit"><span class="uni_text"><?php echo $this->lang->line('lot_mondal_reprt_as_assign')?> </span>
                            </div>
                        
							<div class="radio-inline">
                                <input type="radio" value="reject" name="COApprove" id="reject"><span class="uni_text">Reject Application</span>
                            </div>               
                        </div>
                        <div class="form-group col-lg-11 txt_box" style="margin-top: 12px; display: none">
                            <textarea class="form-control" rows="5" cols="4" name="co_comment"></textarea>
                        </div>
                        <div class="form-group col-lg-offset-4 col-lg-12" style="margin-top: 30px">
							
							<button type="submit" id="FwdAst" name="FwdAst" value="true" class="btn btn-primary" ><?php echo $this->lang->line('forward_asstt_print')?><i class="fa fa-arrow-up"></i></button>
							<button type="submit" id="FwdCO" name="FwdLM" value="true" style="display: none" class="btn btn-success" >Re-submit Mandal's report <i class="fa fa-arrow-down"></i></button>
						
                            <button type="submit" id="RejCO" name="RejCO" value="true" style="display: none" class="btn btn-danger" >Reject Application <i class="fa fa-power-off"></i></button>
                            
                        </div>
                    </form>
					<?php  if($certApp->cert_type!=='01')
								{   
								?>	
								<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('see_mondal_rpt');?></button>
								<?php
								}else{
								?>
								<a href="<?php echo base_url().'index.php/CitizenController/saveJamabandiByPattano?'  ?>case_no=<?php echo $certApp->cert_no; ?>" target="_blank"><button type="" class="btn btn-success btn">See Jama Bandi of the Applicant </button></a>
								<?php
								}
								?>
					<button id="MainIndex" class="btn btn-info" >Home<i class="fa fa-home"></i></button>
                </div>
                <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="panel-footer">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>
            </div>
        </div>
   
</div>
<!--Modal Start-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
<!--        LH Start-->
        <?php
       if($certApp->cert_type=='02')
        {   
        ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center text-success" id="myModalLabel"><?php echo $this->utilityclass->getCertName($certApp->cert_type); ?></h3>
        <hr>
      </div>
      <div class="modal-body">
        
        <h2 class="center uni_text">অসম চৰকাৰ </h2>
                    <p class="uni_text"><span class="pull-left">চক্র বিষয়াৰ কাৰ্য্যালয়  ::</span>  <span style=" margin-left: 20px"> <?php echo $location['cirname'] ;?>
                            ৰাজহ  চক্ৰ </span><span class="pull-right">
                        <?php echo $location['mouzaname'] ?> </span></p>
                    <hr>
                    <p><span class="pull-left uni_text">আবেদন নং :<?php echo $certApp->cert_no; ?></span>
                        <span class="pull-right uni_text">আবেদনৰ তাং :<?php echo date('d-m-Y', strtotime($certApp->apply_date));  ?></span></p>
                    <hr>
                    <p class="uni_text text-center text-danger"><?php echo $cername=$this->utilityclass->getCertName($certApp->cert_type); ?>  </p>
                    <div class="col-lg-12" style="margin-top: 25px">
                    <p class="uni_text">
                        ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে ,<?php echo $location['cirname'] ;?>  ৰাজহ চক্ৰ ,<?php echo $location['mouzaname'] ?> মৌজা ৰ,
                            <?php echo $location['villname'] ?> গাঁওৰ
                    <?php echo $certApp->patta_no; ?> নং <?php echo $this->utilityclass->getPattaName($certApp->patta_type_code); ?> () পাট্টাৰ অৰ্ন্তগত , তলত দিয়া ধৰণে ,
                    </p>
                    <table class="table">
                        <tr>
                            <th>দাগ নং</th><th>Class</th><th>Bigha</th><th>Katha</th><th>Lessa</th>
                        </tr>
						<?php foreach($certDag as $certDag){?>
                        <tr>
                            <td><?php echo $certDag->dag_no; ?></td>
                            <td><?php echo $this->utilityclass->getLandClassCode($certDag->land_class_code); ?></td>
                            <td><?php echo $certDag->a_dag_area_b; ?></td>
                            <td><?php echo $certDag->a_dag_area_k; ?></td>
                            <td><?php echo $certDag->a_dag_area_lc ?></td>
                        </tr>
						<?php } ?>
                    </table>
                    <p class="uni_text">মাটিত <?php echo $certApp->appln_name; ?>,<?php echo $certApp->appln_guard; ?> ৰ নিজৰ নামত থকা জমি হয় | </p>
                    <p class="uni_text">এই প্রমাণ-পত্র লাট-মন্ডলৰ প্রতিবেদনৰ ভিওিত দিয়া হ’ল |</p>
                    </div>
                    <div class="col-lg-offset-9">
                        <p class="uni_text text-center">
                            চক্র বিষয়া<br>
                            <?php echo $location['cirname'] ;?> ৰাজহ  চক্ৰ 
                        </p>
                    </div>   
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
        <?php }?>
<!--        LH End-->



<!--        IC Start-->
        <?php
       if($certApp->cert_type=='03')
        {   
        ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center text-success" id="myModalLabel"><?php echo $this->utilityclass->getCertName($certApp->cert_type); ?></h3>
        <hr>
      </div>
      <div class="modal-body">
      <h2 class="center uni_text">অসম চৰকাৰ </h2>
                    <p class="uni_text"><span class="pull-left">চক্র বিষয়াৰ কাৰ্য্যালয়  ::</span>  <span style=" margin-left: 20px"> <?php echo $location['cirname'] ;?>
                            ৰাজহ  চক্ৰ </span><span class="pull-right">
                        <?php echo $location['mouzaname'] ?> </span></p>
                    <hr>
                    <p><span class="pull-left uni_text"><?php echo $this->lang->line('sr_no')?> :<?php echo $certApp->cert_no; ?></span>
                        <span class="pull-right uni_text"><?php echo $this->lang->line('apply_date')?> :<?php echo date('d-m-Y', strtotime($certApp->apply_date));  ?></span></p>
                    <hr>
                    <p class="uni_text text-center text-danger"><?php echo $cername=$this->utilityclass->getCertName($certApp->cert_type); ?>  </p>
                   
                    <div class="col-lg-12" style="margin-top: 25px">
                    <p class="uni_text">
                        ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে ,<?php echo $certApp->appln_name; ?> -- <?php echo $certApp->appln_guard; ?>
                                                      
                            <?php echo $location['cirname'] ;?>  ৰাজহ চক্ৰ ,<?php echo $location['mouzaname'] ?> মৌজা ৰ,
                            <?php echo $location['villname'] ?> গাঁওৰ বাসিন্দা হয় | আবেদনকাৰীৰ পৰিয়ালৰ বাৰ্ষিক  আয় <?php echo number_format($certApp->inc_total,2) ; ?> টকা হয় | </p>
                    <p class="uni_text">এই প্রমাণ-পত্র লাট-মন্ডলৰ প্রতিবেদনৰ ভিওিত দিয়া হ’ল |</p>
                    </div>
                    <div class="col-lg-offset-9">
                        <p class="uni_text text-center">
                            চক্র বিষয়া<br>
                            <?php echo $location['cirname'] ;?> ৰাজহ  চক্ৰ 
                        </p>
                    </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
        <?php }?>
<!--       IC End-->


<!--        JB Start-->
        <?php
       if($certApp->cert_type=='01')
        {   
        ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center text-success" id="myModalLabel"><?php echo $this->utilityclass->getCertName($certApp->cert_type); ?></h3>
        <hr>
      </div>
	  
      <div class="modal-body">
          <p class="uni_text"><?php echo $this->lang->line('sr_no')?>: <?php echo $certApp->cert_no; ?></p>
		  <p class='uni_text text-danger'><?php
			if($jamapenreason){
				echo "Reason given By Mondal : -".$jamapenreason->reason_pending;
			}
			?>
		</p>
		  
          <a href="<?php echo base_url().'index.php/CitizenController/saveJamabandiByPattano?'  ?>case_no=<?php echo $certApp->cert_no; ?>" target="_blank"><button type="" class="btn btn-success btn-lg">See Jama Bandi of the Applicant </button></a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
        <?php }?>
<!--       JB End-->

<!--        LV Start-->
        <?php
       if($certApp->cert_type=='04')
		  
        { 
			//var_dump($certDag);
        ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center text-success" id="myModalLabel"><?php echo $this->utilityclass->getCertName($certApp->cert_type); ?></h3>
        <hr>
      </div>
      <div class="modal-body">
          
          <h2 class="center uni_text">অসম চৰকাৰ </h2>
                <p class="uni_text text-center"> <?php echo $location['distname'] ?> জিলাৰ উপায়ুক্তৰ কাৰ্য্যালয় <br>ভূমি অধিগ্রহণ শাখা </p>
                <hr>
                <p class="uni_text">
                   ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে, <?php echo $location['cirname'] ?> মৌজাৰ <?php echo $location['villname'] ?> গাঁওৰ ,
                   <?php echo $certApp->appln_name; ?> আবেদন ক্ৰমে ,তপশীলভুক্ত মাটিৰ কঠাই প্রতি <?php echo round($certApp->lv_katha_price,2); ?> টকা হিচাপে মুঠ <?php echo $certDag->a_dag_area_b; ?> বিঘা <?php echo $certDag->a_dag_area_k ;?> কঠা <?php echo $certDag->a_dag_area_lc; ?>
                   লেছা মাটিৰ মুল্য <?php echo $location['tot_price']; ?> টকা ধাৰ্য্য কৰা হ’ল |
                </p> 
                <p class="uni_text">এই প্রমাণ-পত্ৰ চক্ৰ বিষয়াৰ <?php echo date('d/m/Y',  strtotime($certApp->lv_co_ord_date))  ?> তাৰিখৰ <?php echo $certApp->lv_co_ord_no; ?> নং প্রতিবেদনৰ ভিওিত দিয়া হল |</p>
                <p class="uni_text">এই প্রমাণ-পত্ৰ কেৱল <?php echo $certApp->lv_purpose; ?> ৰ বাবেহে প্রযোজ্য |</p>
                <hr>
                <p class="text-center uni_text">তপশীল</p>
                <table class="table">
                    <tr class="uni_text text-center active">
                        <td>মৌজা </td><td>গাঁও </td><td>পাট্টা নং</td><td>দাগ নং </td><td>কালি (বি-ক-লে)</td>
                    </tr>
                    <tr class="uni_text text-center">
                        <td><?php echo $location['cirname'] ?></td><td><?php echo $location['villname'] ?> </td><td><?php echo $certApp->patta_no; ?></td><td><?php echo $certDag->dag_no; ?></td><td><?php echo $certDag->a_dag_area_b."-".$certDag->a_dag_area_k."-".$certDag->a_dag_area_lc; ?></td>
                    </tr>
                </table>
                <hr>
                <p class="uni_text">স্মাৰক নং  : H.R.A.<?php echo $certApp->lv_memo_no; ?></p>
                <p class="uni_text">প্রতিলিপি  : 
                    <?php
                    $str=$certApp->lv_copies_to;
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
                           তাং : <?php echo date('d/m/Y',  strtotime($certApp->date_entry)); ?>
                        </p>
                </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
        <?php }?>
<!--       LV End-->


<!--        AP Start-->
        <?php
       if($certApp->cert_type=='05')
        {   
        ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center text-success" id="myModalLabel"><?php echo $this->utilityclass->getCertName($certApp->cert_type); ?></h3>
        <hr>
      </div>
      <div class="modal-body">
          
          
           <h1 class="text-center uni_text">ANNUAL KHIRAJ PATTA</h1>
        <p class="uni_text text-center">
            <?php
                echo $this->utilityclass->getCertName($certApp->cert_type) ;
                echo " নং ".$certDag->patta_no;
            ?> 
            
        </p>
        <hr>
        <div class="col-lg-4">জিলা :<?php echo $location['distname'] ?></div>
        <div class="col-lg-4">মৌজা :<?php echo $location['mouzaname']  ?></div>
        <div class="col-lg-4">গাঁও :<?php echo $location['villname'] ?></div>
       
        <div style="margin-top: 50px; border: 1px solid #000"></div>
        <p class="uni_text">
            প্রতি , <?php echo $certApp->appln_name; ?> <br>
            
            যিহেতু অসমৰ ভূমি আৰু ৰাজস্ব বিধি ব্যবস্থা সময়ে সময়ে কৰা তাৰ নিয়মৰ বশবৰ্তী হৈ ইয়াৰ লগত দিয়া তপচিলত লিখা মাটি আপুনি দখল কৰিছে , 
            তলত লিখা স্বৰ্ওমতে আপোনাক ইং <?php echo $certApp->year_no; ?> ৰাজহ বছৰৰ এই পাট্টা দিয়া হ’ল –
        </p>
        <p class="uni_text">
            1)	ইয়াৰ লগত দিয়া তপচিলত দেখুৱা পুৰা খজনা আৰু স্থানীয় কৰ আপুনি নিৰ্ধাৰিত তাৰিখ কিস্তিমতে আদায় কৰিব | 
        </p>
        <p class="uni_text">
           2)	এই বছৰৰ কাৰণে তপচিলত লিখিত মাটিত আপোনাৰ ব্যবহাৰ ও দখলীস্বও থাকিব কিণ্তু হস্তান্তৰ কৰিবৰ কোনো ক্ষমতা নাথাকিব |
        </p>
        <p class="uni_text">
           3)	কথিত  বছৰৰ বাহিৰে তপচিলত লিখা মাটিত আপোনাৰ কোনো প্রকাৰৰ স্বত্ব বা হক নাথাকিব আৰু এই প্রকাৰৰ ম্যাদ
           উকলি যোবাৰ সময়ত এই মাটিৰ ওপৰত থকা বাঢ়ি অহা শষ্য , গুটিলগা গছ নাইবা ঘৰৰ বাবে , ৫ দফাত উল্লেখ কৰা ব্যবস্থাৰ 
           বাহিৰে আপুনি কোনো লোকচানি দাবী কৰিব নোবাৰিব | কিণ্তু আপুনি নাইবা গভৰ্ণমেন্টে <?php echo $certApp->to_date;?> তাৰিখে বা তাৰ পূৰ্বে ,
           অৰ্থৰ পক্ষক লিখিত নটিচৰ দ্বাৰা  তপচিলত লিখিত নাইবা কোনো মাটিৰ পুনৰ পাট্টা দিব নালাগে বুলি নজনালে , 
           চৰকাৰে যি ৰাজহ ধাৰ্য্য কৰে সেই ৰাজহত এই পাট্টা পুনৰ এবছৰৰ কাৰণে আপুনাক দিয়া হব |ব |
        </p>
        <p class="uni_text">
          4)	তিনি দফাত কোবা লিখা নটিচ আপুনি দিবলৈ হলে নটিচৰ আগেয়ে সমুদায় ৰাজহ ও স্থানীয় কৰ আদায় কৰিব লাগিব 
          আৰু যদি কথিত তাৰিখৰ কিম্বা তাৰ পূৰ্ব্বে আপুনি ৰাজহ স্থানীয় কৰ আদায় কৰি এনে নটিচ নিদিয়ে তেনেহলে 
          ( ওপৰত কোবা মতে যদি চৰকাৰে আপোনাৰ ওচৰত নটিচ নিদিয়ে ) আপুনি তপচিলত লিখা  মাটিত ৰাজহ আৰু স্থানীয় 
          কৰ পুনৰ এবছৰৰ কাৰণে দিবলৈ দায়ী থাকিব |
        </p>
        <p class="uni_text">
          5)	এই পাট্টাৰ ম্যাদ চলি থাকোতেই যদি তপচিলত লিখা সমুদায় মাটি নাইবা তাৰ কোনো অংশ চৰকাৰী কামৰ 
          কাৰণে প্রয়োজন হয় তেনেহলে সেই মাটি আপোনাৰ পৰা এৰোবাই লোবা হব | এইদৰে মাটি এৰোবাই ললে এৰোবাই 
          লোবা মাটিৰ বাঢ়ি অহা শষ্য , গুটি লগা গছ আৰু ঘৰৰ বাবে হে আপুনি গভৰ্ণমেন্টৰ পৰা লোকচানি পাব | কিণ্তু 
          মাটি দোখৰৰ বাবে আপুনি কোনো লোকচানি নাপাব কিয়নো মাটি দোখৰ অকল চৰকাৰহে সম্পওি – আপোনাৰ নহয় |
        </p>
        <p class="uni_text">
           6)	তপচিলত লিখিত  মাটিৰ খেতিৰ নিমিওে উপযোগী কৰিবলৈ আপুনি তাত থকা জঙ্গল চাফা কৰিব পাৰিব ,কিণ্তু 
           বেৰে এফুটতকৈ ডাঙৰ শিমলু গছ কিম্বা তাৰ ডাৰ কাটিব নোবাৰিব আৰু পুৰা কাঠৰ মাচুল আগেয়ে আদায় নকৰাকৈ 
           কোনো কাঠ বিক্ৰী ৰ কাৰণে স্থান্তাতৰ কৰিব নোবাৰিব |ব |
        </p>
        <p class="uni_text">
           7)	আপোনাৰ ঘৰৰ বাহিৰৰ অতিৰক্ত যি খেৰ তপচিলত দেখুওবা মাটিৰ পৰা কাটি আনিব , সেই খেৰৰ বহুতে সময়ে 
           ডিভিচনেল ফৰেস্ট অফিচাৰৰ দ্বাৰা নিৰ্দ্ধাৰিত  হোবা মূল্যত তপচিলৰ যি মাটি থাকে সেই ঠাইৰ খেৰ মহলদাৰৰ ওচৰত বিক্ৰী কৰিব লাগিব |ব |
        </p>
        <p class="uni_text">
          8)	এই পাট্টাৰ ম্যাদ চলি থাকোতেই যদি আপোনাৰ মৃত্যু হয় আপোনাৰ উওৰাধিকাৰী বিলাকে সেই বছৰৰ আৰু সেই সময়ৰ কাৰণে স্বত্ব পাব |ব |
        </p>
        
        <hr>
        <p class="pull-left">
            তাৰিখ : <?php echo date('d/m/Y'); ?>
        </p>
        <p class="pull-right">
            ডেপুটি কমিচনাৰ,<br><br> চেটেলমেণ্ট অফিচাৰ 
        </p>
        
        <hr>
        <p class="uni_text">* টোকা ১৯৩১ চনৰ অসমৰ ভূমি আৰু ৰাজহ আইনৰ বিষয়ৰ মেনুবেলৰ ৬৭ পৃস্ঠাত থকা বন্দোবস্ত সম্পৰ্কীয় নিয়মাবলীৰ ২১ (চ) 
            নিয়মৰ অধীনত বিজ্ঞাপিত ঠাইত যি পট্টা দিয়া হব কেবল সেই ঠাইৰ শিমলু গছৰ ক্ষেএসম্বেন্ধেহে ব্যৱস্তা খাটিব |</p>
        <p class="uni_text">** ৭ম দফা ৰাজহুবা খেৰ বছৰৰ ভিতৰত থকা মাটিৰ বাবেহে খাটিব অথবা কাটি পেলাব |</p>
        <hr>
        
        
        
        
        
        
        
        
        
        
        
        
        <table class="table-bordered table " width="100%" border="1">
            <tr>
                <td>দাগৰ ক্ৰমিক নং </td>
                <td>প্রত্যেক দাগৰ শ্রেণী  </td>
                <td>বিঘামতে প্রত্যেক দাগৰ মাটিৰ পৰিমাণ </td>
                <td>প্রত্যেক দাগৰ লগোৱা ৰাজহ </td>
                <td>মন্তব্য </td>
            </tr>
            <tr>
                <td><?php echo $certDag->dag_no; ?></td>
                <td><?php echo $this->utilityclass->getLandClassCode($certDag->land_class_code); ?></td>
                <td><?php echo $certDag->a_dag_area_b."B-".$certDag->a_dag_area_k."K-".$certDag->a_dag_area_lc."L"; ?></td>
                <td>0</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <p class="uni_text text-center">মুঠ : .......................</p>
                    <p class="uni_text text-center">স্থানীয় কৰ যোগ দিয়া : ...................</p>
                    <p class="uni_text text-center">সৰ্ব্বমুঠ :......................</p>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
        <?php }?>
<!--       AP End-->

<!--        PP Start-->
        <?php
       if($certApp->cert_type=='06')
        {   
        ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center text-success" id="myModalLabel"><?php echo $this->utilityclass->getCertName($certApp->cert_type); ?></h3>
        <hr>
      </div>
      <div class="modal-body">
          
         <div class="col-lg-12">
        <P class="pull-left uni_text">Assam Schedule XXXVII, Form No.23 A</p>
    </div>
    <div class="col-lg-12">
        <h2 class="text-center uni_text ">PERIODIC KHIRAJ LEASE AND TOWN LANDS</h2>
        <p class="text-center uni_text "> চহৰৰ মাটিৰ মিয়াদী খেৰাজ পাট্টা </p>
    </div>
    <div class="col-lg-12">
        <p class="uni_text">
            কিয়নো ,<br>
            (যাক ইয়াৰ তলত পাট্টাদাৰ বোলা হৈছে) ইয়াৰ লগত দিয়া তপচিলত উল্লেখ কৰা চহৰৰ মালিকে পাট্টাৰ কাৰণে প্রৰ্থনা কৰিছে এতেকে ইয়াৰ তলত লিখা 
            নিয়মাবিলাকৰ অধীন কৰি এই পাট্টাদাৰক তেওঁৰ উওৰাধিকাৰী , প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকক ইয়াৰ দ্বাৰা অসমৰ ভূমি আৰু ৰাজহ  বিধিৰ
            ব্যবস্থা আৰু সময়ে সময়ে কৰা তাৰ নিয়মৰ বশৱৰ্ওী সেই মাটিৰ ওপৰত চিৰস্থায়ী উওৰাধিকাৰীত্বৰ আৰু হস্তান্তৰ কৰিব পৰা ভোগ দখলৰ স্বত্ব দিয়া 
            যায় আৰু সেই মাটিৰ স্বত্ব লিখা নিয়ম বিলাক অধীন কৰি <?php echo $certApp->no_of_years; ?> বছৰৰ কাৰণে অৰ্থাৎ <?php echo date('d/m/Y', strtotime($certApp->to_date)); ?> তাৰিখলৈকে <?php echo $certApp->appln_name; ?> পাট্টাদাৰক তেওঁৰ উওৰাধিকাৰী
            প্রতিনিধি আৰু স্থলাভিষিত্ত  বিলাকক পাট্টা দিয়া যায় | সেই মাটিৰ নিৰুপিত ৰাজহ তলত লিখা কিস্তিত বা গৱৰ্ণমেন্টে সময়মতে আন যি যি  কিস্তিৰ সময় 
            ধাৰ্য্য কৰে সেই কিস্তিমতে বছৰে বছৰে শোধাৱ লাগিৱ |
       
        </p>
        <table class="table">
            <tr>
                <td></td><td>কিস্তিৰ তাৰিখ </td><td>দিবলগীয়া ৰাজহ </td>
            </tr>
            <tr>
                <td>প্রথম কিস্তি : </td><td><?php echo date('d/m/Y', strtotime($certApp->first_installment_date)); ?></td><td><?php echo number_format($certApp->first_installment,2)  ?></td>
            </tr>
            <tr>
                <td>দ্বিতীয়  কিস্তি : </td><td><?php echo date('d/m/Y', strtotime($certApp->second_installment_date)); ?></td><td><?php echo number_format($certApp->second_installment,2) ; ?></td>
            </tr>
        </table>
        <p class="uni_text">
            2 | পট্টাৰ নিয়মবোৰ এই :-<//P>
        <ul style="list-style: none">
            <li class="uni_text">
                 (১) ওপৰৰ লিখামতে বা প্রাদেশিক গৱৰ্ণমেন্টে সময়মতে ধাৰ্য্য কৰা কিস্তিমতে পাট্টাদাৰে তেওঁৰ উওৰাধিকাৰী প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকে ওপৰত উল্লেখ কৰা ৰাজহ পুৰাকৈ শুধাৱ লাগিব ; আৰু সেই মাটি সম্বন্ধে যিকোনো টেক্স , চেচ বা স্থানীয় কৰ যিটো সময়ত গৰাকীয়ে বা দখলকাৰে শোধাৱ লগাত পৰে তেনেকৈ নিয়মিত ৰুপে শোধাৱ লাগিৱ |
            </li>
            <li class="uni_text">
               (২) বন্দোবস্ত চলি থাকোতে যদি কেতিয়াবা খেতি সম্পৰ্কীয় বস্তি আৰু খেতিৰ বাবে ৰখা গৰাবাদ মাটিও বুজিব লাগিৱ , 
                বা  “ ব্যবহাৰত নলগোবা ” মাটি খেতিৰ সম্পৰ্ক নথকা বস্তিলৈ বা বেপাৰৰ ঠাইলৈ পৰিবৰ্তন কৰা হয় বা কোনো কোনো 
                খেতিৰ সম্পৰ্ক নথকা বস্তিলৈ বা বেপাৰৰ ঠাইলৈ পৰিৱৰ্তন কৰা হয় তেণ্তে খেতিৰ সম্পৰ্ক নথকা বস্তিলৈ বা বেপাৰৰ ঠাইৰ বাবে 
                প্রাদেশিক গৱৰ্ণমেন্টে আসাম লেন্দ ৰেভিনিউ ৰেগুলেচন অনুসৰি ব্যবস্থা কৰা নিৰিখমতে সেই মাটিৰ ৰাজহ বঢ়াব পাৰিৱ আৰু 
                পাট্টাদাৰে তেওঁৰ উওৰাধিকাৰী প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকে  সেই বঢ়োবা ৰাজহ নিয়মিত  সময়ত শোধাৱ |<br>
                খেতিৰ সম্পৰ্ক নথকা বস্তি বুলিলে খেতি সম্পৰ্কীয় বাদে আন বাৱে বসৱাস কৰিবৰ নিমিত্তে দখল কৰা মাটিক বুজায় |
            </li>
            <li class="uni_text">
                (৩) এই পট্টাৰ মিয়াদ উকিল গলে পাট্টাদাৰক তেওঁৰ উওৰাধিকাৰী , প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকক সেই মাটিৰ নতুন পট্টা লবলৈ সুবিধা দিয়া যাব , তেওঁ বা তেওঁবিলাকে সেই সুবিধা লব নুখুজিলে পাট্টাদাৰে তেওঁৰ উওৰাধিকাৰী প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকৰ স্বত্ব আৰু তেওঁৰ উওৰাধিকাৰী,  প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকৰ হাতেদি বা তেওঁবিলাকৰ অধীনে সেই মাটিতে কাৰোৱাৰ প্রজা বা বন্ধকসূত্রে ভোগ কৰিব পৰা স্বত্ব থাকিলেও সেই  স্বত্ব সম্পূৰ্ণ ৰুপে ৰহিত আৰু শেষ হ’ৱ |
            </li>
            <li class="uni_text">
                 (৪)আলি মেৰামত কৰিবৰ নিমিওে প্রাদেশিক গৱৰ্ণমেন্টে বা গৱৰ্ণমেন্টেৰ কাৰ্য্যকাৰকসকলে কোনো লোকচানি নিদিয়াকৈ সকলো প্রাদেশীয় বা লোকেল বোৰ্ড আলিৰ কাষৰ বা ওখ আলিৰ পৰা নামনিৰ পৰা ৩৫ ফুটৰ ভিতৰত খেতি সম্পৰ্কীয় মাটিৰ পৰা কটাই আনিব পাৰিব  আৰু সেই মাটি বা তাৰ কোনো অংশ , তাত থকা শস্য , লাগনী গছ বা ঘৰৰ মূল্যত বাজে আন কোনো লোকচানি নিদিয়াকৈ লব পাৰিৱ |<br>
                কিণ্তু এই পট্টাৰ কোনো নিয়মে পাট্টাদাৰে ইতিপূৰ্ব্বে পোবা কোনো স্বত্বৰ বা আগৰ পট্টা অনুসৰি প্রাদেশিক গৱৰ্ণমেন্টে ৰখা কোনো স্বত্বৰ অন্যথা কৰিব নোবাৰিৱ | 
            </li>
            <li class="uni_text">
                (৫) সেই মাটিত বা তাৰ তলত থকা শিলৰ খনি খনিজ বস্তু  বা মাটিৰ তলত পোত গৈ থকা সকলো বহুমলীয়া বস্তু ৰ ওপৰত প্রাদেশিক গৱৰ্ণমেন্টেস্বত্ব ৰখা গ’ল | সেই বিলাক বিচাৰিবলৈ বা খানি উলিয়াবলৈ যাওতে মাটিৰ ওপৰভাগত কোনো লোকচান হ’লে সেই নিমিত্তে তৎকালীন ডেপুটি কমিচনাৰ চাহাবে হিচাবকৰি ক্ষতিপূৰণৰ টকা ধাৰ্য্য কৰে , সেই টকা পাট্টাদাৰক তেওঁৰ উওৰাধিকাৰী , প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকক দি সেই শিলৰ খনি ইত্যাদি বিচাৰিবলৈ বা খনি উলিয়াবলৈ প্রাদেশিক গৱৰ্ণমেন্টেৰ সকলো সময়তে সম্পূৰ্ণ ক্ষমতা থাকিব |
            </li>
            <li class="uni_text">
                (৬)    উক্ত মাটিৰ সীমাই বা তাৰ ওপৰেদি বৈ যোবা নৈ আৰু জান বিলাকত য’ত বছৰৰ কোনো সময়ত নাও চলাব পাৰি বা কাঠ উটাই নিব পাৰি , সেই বিলাকত  চলাচল কৰিবৰ নিমিত্তে সৰ্ব সাধাৰণৰ স্বত্ত থাকিব আৰু সেই বিলাকক নৈ বা জানৰ দুয়োকাষে ২০ ফুট বহল একদোষৰ মাটি সৰ্বসাধাৰণে নাও টানিবৰ বা বান্ধিবৰ নিমিত্তে , বস্তু – বাহানি তোলা পাৰা কৰিবৰ নিমিত্তে আৰু পানী চলাচল কৰোঁতে , কাঠ উঠাই আনোঁতে আৰু মাছ মাৰোতে যি বিলাক কাম কৰিবৰ আবশ্যক হয় সেইবিলাকৰ নিমিত্তে সকলো সময়তে ব্যবহাৰ কৰিব পাৰিৱ | 
                <br>
                কিণ্তু যি মাটিত এনে বিলাক স্বত্ব ইতিপূৰ্ব্বে ৰখা নহৈছিল সেই মাটিত এই নিয়ম নাখাটিব |
            </li>
            <li class="uni_text">
                (৭)পাট্টাদাৰে তেওঁৰ উওৰাধিকাৰী , প্রতিনিধি আৰু স্থলাভিষিত্ত বিলাকে , এই পাট্টাৰ তলত দখল কৰা মাটিৰ পাছত কেতিয়াবা জোখোতে পাট্টাত লিখা মাটিতকৈ বঢ়া বা কম পালে তেতিয়াৰ পৰা , সেই পৰিমাণ এতিয়া ধাৰ্য্য কৰা ৰাজহ ও বেচি বা কম নিৰুপিত কৰিব পৰা যাব | 
            </li>
        </ul>    
        <div class="col-lg-12">
            <div class="col-lg-3">
                <span class="uni_text"> তাৰিখ : <?php echo date('d/m/Y'); ?></span>
            </div>
            <div class="col-lg-5 col-lg-offset-4">
              <span class="uni_text">  পাট্টাদাৰাৰ চহী <br>
                  জিলাৰ ডেপুটি কমিচনাৰ বা ক্ষমতা পোবা আন কোনো হাকিমৰ চহী  </span>
            </div>
        </div>
        <p class="text-center uni_text">তপচিল</p>
        <hr>
        <p class="uni_text pull-left">চহৰ :<?php echo $location['villname']; ?> </p>
        <p class="uni_text pull-right"> পাট্টা নং  :<?php echo $certDag->patta_no; ?></p>
        <table class="table" border="1">
            <tr>
                <td>মাটিৰ বিৱৰণ </td>
                <td>মাটিৰ পৰিমাণ </td>
                <td>নিৰুপিত ৰাজহ </td>
                <td>মন্তব্য </td>
            </tr>
            <tr>
                <td>দাগ নং <?php echo $certDag->dag_no; ?></td>
                <td><?php echo $certDag->a_dag_area_b."B&nbsp;&nbsp;&nbsp;".$certDag->a_dag_area_k."K&nbsp;&nbsp;&nbsp;".$certDag->a_dag_area_lc."L" ?></td>
                <td>0</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>মুঠ ৰাজহ </td>
                <td>&nbsp;</td>
                <td>0</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>স্থানীয় কৰ </td>
                <td>&nbsp;</td>
                <td>0</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>সৰ্ববমুঠ</td>
                <td>&nbsp;</td>
                <td>0</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <div class="row">
            <p class="pull-left uni_text">DLR & SURVEY (XXXVII)F No.23-A</p>
            <div class="col-lg-5 col-lg-offset-7">
              <span class="uni_text">  পাট্টাদাৰাৰ চহী <br>
                  জিলাৰ ডেপুটি কমিচনাৰ বা ক্ষমতা পোবা আন কোনো হাকিমৰ চহী  </span>
            </div>
        </div>
        
    </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
      <?php }?>
<!--       PP End-->

    </div>
  </div>



<!--Modal End-->
<script>
$(document).ready(function(){
    $("#approved").click(function(){
        $(".txt_box").hide();
        $("#FwdCO").hide();
        $("#RejCO").hide();
        $("#FwdAst").show();
    });
    $("#resubmit").click(function(){
        $(".txt_box").show();
        $("#FwdAst").hide();
        $("#RejCO").hide();
        $("#FwdCO").show();
    });
	$("#reject").click(function(){
        $(".txt_box").show();
        $("#FwdAst").hide();
        $("#FwdCO").hide();
        $("#RejCO").show();
    });

    let btnNameAttr;
    let btnValAttr;

    $('button').click(function(){
        btnNameAttr = $(this).attr('name');
        btnValAttr = $(this).attr('value');
    });

    $('form').on('submit', function(){
        $('.submit_input').remove();
        $('form').append(`<input type="hidden" class="submit_input" name="${btnNameAttr}" value="${btnValAttr}">`);
    });   
});
</script>
