<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well dontshow well-sm mis_report">
                    <h2 style="text-align: center;"><!-- <?php echo $this->lang->line('notice_generated_by_asst_misc_cases_name_correction');?> -->
                        
                        List Of Miscellaneous (Name Cancellation) Cases Pending For Notice Generateration

                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <div class="col-lg-10 col-lg-offset-1">
                        <h3 class="text-center"><?php echo $this->lang->line('notice');?></h3>
                        <h4 class="text-center"><?php echo $this->lang->line('before_the_circle_officer_at');?>  <?php echo $namedata[2]->circle; ?></h4>
                        
                        <h5 class="text-center"><?php echo $this->lang->line('case_no');?> : <?php echo $_GET['misc_case_no'];?></h5>
                        <br/>
                        
                        <p class="text-center uni_text"> 
                            <?php 
                            $i=1;
                            $r1=count($Petitioner);
                            foreach ($Petitioner AS $ss){
                                if($r1>1){
                                    if($i==1){
                                        echo $pet1=$ss->petition_pdar_name_old." and others ";
                                    }
                                }
                                else {
                                    echo $pet1=$ss->petition_pdar_name_old;
                                }
                                $i++;
                            }?>
                            <br/> -vs-<br/> 
                            <?php $i1=1;
                            $r2=count($secondparty);
                            foreach ($secondparty AS $ss){
                                if($r2>1){
                                    if($i1==1){
                                        echo $ss->pdar_name." and others ";
                                    }
                                }
                                else {
                                    echo $ss->pdar_name;
                                }
                                $i1++;
                            }?>
                        </p><br/><br/>
                        <p class='uni_text red'>To, <br/>
                        <?php 
                        $r=count($secondparty);
                        $c=1;
                        foreach ($secondparty AS $ss){
                            if($c<$r){
                            echo $ss->pdar_name.", ";
                            }
                            else{
                                echo $ss->pdar_name;
                            }
                            $c++;
                        }?>
                        </p>
                        <br/><br/><br/>
                        <p class='uni_text'>
                            (Notice of the Opposite party No .................................................. ...............................to be served upon the Opposite Party No ...........................................................................)
                        <br/><br/>
                            Whereas the petitioner <?php echo $pet1;?> 
                            
                             (<?php echo $namedata[5]->village; ?>, <?php echo 'Dag no :'. $miscCaseInfo->dag_no; ?>,<?php echo 'Patta no :'. $miscCaseInfo->patta_no; 
                                         if($basundharaApp){ 


                                            echo '  Mobile :'.$basundharaApp->mutation[0]->pat_mobile_no; 

                                         }?>)

                            has filed the petition in my court for deletion/strikeout your name from the record.
							<br>
                            You are hereby given the notice to present in my court at  <?php echo $miscCaseInfo->time_to_present; ?>  on <?php echo date("d-m-Y", strtotime($miscCaseInfo->next_date_of_hearing));?>
                        <br/>
                        
                            Given under my hand and seal of this court on <?php echo date("d-m-Y", strtotime($miscCaseInfo->next_date_of_hearing));?> at <?php echo $namedata[2]->circle; ?>.
                        </p><br/><br/><br/>
                        
                        <p class='uni_text pull-right'>
									চক্র বিষয়া,
                            <br/>
                            <?php echo $namedata[2]->circle; ?> ৰাজহ চক্র</p>
                        
                        <br/><br/><br/><br/><br/><br/><br/><br/>
							<a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-primary uni_text dontshow" onclick="myFunction()"><i class='fa fa-check'></i>&nbsp; Click Here to Print Receipt And Proceed </a>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm dontshow btn-danger">
                            <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        $(".dontshow").hide();
        window.print();
        $(".dontshow").show();
        document.getElementById("close").disabled = false;
    }
</script>

