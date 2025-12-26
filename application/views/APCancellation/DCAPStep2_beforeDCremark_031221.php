<script>
    function valueChange(abc){
        alert(abc);
        if(abc=='Y'){
            var yesval=document.f1.yesval.value;
            //alert(yesval);
        }
        else if(abc=='N'){
            var yesval=document.f1.noval.value;
            //alert(yesval);
        }
        document.f1.note_on_order.value=yesval;
    }
</script>

<div class="container-fluid login form-top">
    <div class="row " >
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('dc_approval_on_ap_cancellation');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           <?php echo $this->lang->line('case_no');?> : <?php echo $_GET['case_no']; ?>  <span class="pull-right"> <?php echo $this->lang->line('date');?> : 
                                <?php echo date("d-m-Y", strtotime($_GET['submission_date'])); ?>
                            </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" name="f1" method='post' action="<?php echo base_url() . "index.php/APCancellation/SaveDCAPSTep2"; ?>">
                            
                            <input type="hidden" name="yesval" value="যিহেতু <?php echo $namedata[0]->district; ?>   জিলাৰ <?php echo $namedata[3]->mouza; ?> মৌজাৰ <?php echo $namedata[5]->village; ?> গাঁওৰ <?php echo $DCAPCAse->patta_no;?> নং <?php echo $DCAPCAse->patta_type;?> পট্টাৰ <?php echo $DCAPCAse->dag_no;?> নং দাগটো “পট্টা ৰদ” বাবে আবেদন কৰা এই <?php echo $_GET['case_no']; ?> নং গোচৰটো চক্ৰ বিষয়াই প্রস্তাৱ আগবঢ়াইছে জনাইছে, সেয়ে ইয়াৰ লগত সম্বন্ধ থকা সকলো নথি-পত্ৰ সঠিক 
                                    হোৱা বাবে আজি "/>
                            <input type="hidden" name="noval" value="এই গোচৰটোত সন্মতি নাই ।"/>
                            
                            <?php
                            $dist_code = $_GET['dist_code'];
                            $subdiv_code = $_GET['subdiv_code'];
                            $cir_code = $_GET['cir_code'];
                            $lot_no = $_GET['lot_no'];
                            $vill_townprt_code = $_GET['vill_townprt_code'];
                            $year_no = $_GET['year_no'];
                            $petition_no = $_GET['petition_no'];
                            $case_no = $_GET['case_no'];
                            $mouza_pargona_code = $_GET['mouza_pargona_code'];
                            ?>
                            <input type="hidden" name="dist_code" value="<?php echo $dist_code; ?>"/>
                            <input type="hidden" name="subdiv_code" value="<?php echo $subdiv_code; ?>"/>
                            <input type="hidden" name="cir_code" value="<?php echo $cir_code; ?>"/>
                            <input type="hidden" name="lot_no" value="<?php echo $lot_no; ?>"/>
                            <input type="hidden" name="vill_townprt_code" value="<?php echo $vill_townprt_code; ?>"/>
                            <input type="hidden" name="year_no" value="<?php echo $year_no; ?>"/>
                            <input type="hidden" name="petition_no" value="<?php echo $petition_no; ?>"/>
                            <input type="hidden" name="case_no" value="<?php echo $case_no; ?>"/>
                            <input type="hidden" name="mouza_pargona_code" value="<?php echo $mouza_pargona_code; ?>"/>
                            
                           
                            <div class="form-group uni_text">
                                <label for="select" class="col-lg-12 text-warning">
                                    <?php echo $this->lang->line('dc_approval');?>
                                </label>
								<hr>
                                <div class="col-lg-12">
                                    যিহেতু <?php echo $namedata[0]->district; ?>   জিলাৰ <?php echo $namedata[3]->mouza; ?> মৌজাৰ <?php echo $namedata[5]->village; ?> গাঁওৰ <?php echo $DCAPCAse->patta_no;?> নং <?php echo $DCAPCAse->patta_type;?> পট্টাৰ <?php echo $DCAPCAse->dag_no;?> নং দাগটো “পট্টা ৰদ” বাবে আবেদন কৰা এই <?php echo $_GET['case_no']; ?> নং গোচৰটো চক্ৰ বিষয়াই প্রস্তাৱ আগবঢ়াইছে , সেয়ে ইয়াৰ লগত সম্বন্ধ থকা সকলো নথি-পত্ৰ সঠিক 
                                    হোৱা বাবে আজি
                                    
                                </div> 
                            </div>
                            <hr>
                            <input type="hidden" name="t1" value="যিহেতু <?php echo $namedata[0]->district; ?>   জিলাৰ <?php echo $namedata[3]->mouza; ?> মৌজাৰ <?php echo $namedata[5]->village; ?> গাঁওৰ <?php echo $DCAPCAse->patta_no;?> নং <?php echo $DCAPCAse->patta_type;?> পট্টাৰ <?php echo $DCAPCAse->dag_no;?> নং দাগটো “পট্টা ৰদ” বাবে আবেদন কৰা এই <?php echo $_GET['case_no']; ?> নং গোচৰটো চক্ৰ বিষয়াই প্রস্তাৱ আগবঢ়াইছে জনাইছে, সেয়ে ইয়াৰ লগত সম্বন্ধ থকা সকলো নথি-পত্ৰ সঠিক হোৱা বাবে আজি"/>
                                    
                            <input type="hidden" name="t2" value="তাৰিখত মই এই <?php echo $DCAPCAse->dag_no;?> নং দাগটো “পট্টা ৰদ” কৰাৰ বাবে অনুমোদন জনাইছো ।"/>
                            
                            
                            <div class="form-group">
                                
                                <div class="col-lg-2 uni_text">
                                    <input type="text" class="form-control" name="dc_approval_date" value="<?php echo date("d-m-Y", strtotime(date("Y-m-d"))); ?>" readonly="readonly" required id="popupDatepicker"/> 
                                </div> 
                                <div class="col-lg-10 uni_text">তাৰিখত মই এই <?php echo $DCAPCAse->dag_no;?> নং দাগটো “পট্টা ৰদ” কৰাৰ বাবে অনুমোদন জনাইছো ।</div>                            
                            </div>
							<hr>
                            <input type="hidden" name="dc_recommendation" value="Y"/>
							
<!--                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">
                                    DC's Recommendation
                                    (উপায়ুক্তৰ সন্মতি)
                                </label>
                                <div class="col-lg-8">
                                    <input type="radio" name="dc_recommendation" value="Y" checked="checked" onclick="return valueChange(this.value);"/> YES
                                    <input type="radio" name="dc_recommendation" value="N" onclick="return valueChange(this.value);"/> NO
                                </div> 
                            </div>-->
                            
                            <div class="form-group">
                                <div class="col-lg-12 center">
                                    <button type="submit" name="FormSubmit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/SKViewPetition"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>" class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('view_petition');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/LMNoteView_by_SK"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>" class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('lm_report');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/SKNoteView_by_CO"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>" class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('sk_report');?>
                                    </a>
									&nbsp;&nbsp;&nbsp;
                                     <a href="<?php echo base_url() . "index.php/APCancellation/CO1stProceeding"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>" class="btn btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;CO's Order
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                   
                                    <a href="<?php echo base_url() . "index.php/APCancellation/CONoteOfHearing"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>" class="btn hide btn-success">
                                        <i class='fa fa-eye'></i>&nbsp;<?php echo $this->lang->line('co_recommendation_note');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <br/><br/>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-md btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
									<a href="<?php echo base_url() . "index.php/APCancellation/RejectOrder"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $dist_code; ?>&subdiv_code=<?php echo $subdiv_code; ?>&cir_code=<?php echo $cir_code; ?>&mouza_pargona_code=<?php echo $mouza_pargona_code; ?>&lot_no=<?php echo $lot_no; ?>&vill_townprt_code=<?php echo $vill_townprt_code; ?>&year_no=<?php echo $year_no; ?>&petition_no=<?php echo $petition_no; ?>&case_no=<?php echo $case_no; ?>" class="btn btn-md btn-info">
									<i class="fa fa-arrow-right"></i>&nbsp;Click Here to Reject Order
									</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

