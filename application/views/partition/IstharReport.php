<div class="container-fluid form-top login">
    <div class='row'>
        <div class="col-lg-12">
            <?php //var_dump($this->session->all_userdata()) ?>
            <div class="panel">
                <div class="panel-body">
                    <p class="uni_text text-center">ইস্তাহাৰ </p>
                    <p class="uni_text text-center"><?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?> জিলাৰ উপায়ুক্ত মহোদয়ৰ / <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?> ৰাজহ চক্ৰৰ চক্ৰ বিষয়াৰ হুকুম </p>
                    <p class="uni_text ">পঞ্জীকৰণৰ চন : <?php echo $pb->year_no; ?></p>
                    <p class="uni_text "> গোচৰ নং : <?php echo $pb->case_no; ?></p>
                    <p class="uni_text ">দৰ্খাস্তকাৰীৰ নাম :
                    <?php 
                        foreach($pp as $p)
                        {
                            echo $p->pdar_name."<br>";
                        }
                    ?>
                    </p>
                    <p class="uni_text ">বনাম :  </p>
                    <p class="uni_text ">অপৰপক্ষ :  </p>
                    <h2 class="uni_text text-center">ইস্তাহাৰ </h2>
                    <p class="uni_text">ইয়াৰ দ্বাৰা সৰ্বসাধাৰণক জনোৱা যায় যে , ওপৰোক্ত দৰ্খাস্তকাৰীয়ে <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?> জিলাৰ <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ?> মহকুমাৰ , <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?>  চক্ৰৰ , <?php echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$pb->mouza_pargona_code) ?>  মৌজাৰ / পাৰগণাৰ , 
                        <?php echo $pb->lot_no; ?> নং লাটৰ ,  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?>  চক্ৰৰ , <?php echo $this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$pb->mouza_pargona_code,$pb->lot_no,$pb->vill_townprt_code) ?> গাঁৱৰ ম্যাদী <?php echo $pd->patta_no; ?> পট্টাৰ তেওঁৰ অংশ <?php echo $pd->m_dag_area_b; ?> বি , <?php echo $pd->m_dag_area_k; ?> ক , <?php echo $pd->m_dag_area_lc; ?> লে মাটিৰ বাটোৱাৰা হ’বৰ কাৰণে প্রাৰ্থনা কৰাত , 
                        সেই পট্টাৰ মাটি ইং <?php echo date('d/m/Y',  strtotime($pb->submission_date))  ;?> তাৰিখৰ হুকুম মতে তলত লিখা অংশ মতে বাটোৱাৰা মঞ্জুৰ কৰা হৈছে | সেই বাটোৱাৰা আগত ,
                        ইং <?php echo date('d/m/Y',  strtotime($pb->date_of_order))  ;?> তাৰিখৰ পৰা বলবত হ’ৱ | ভূমি আৰু ৰাজহ আইনৰ 166 ধাৰা মতে এই ইস্তাহাৰ জাৰী কৰা হ’ল | </p>
                    <table class="table table-responsive table-bordered">
                        <thead class="uni_text">
                        <td>পট্টা নং</td><td>পট্টাদাৰৰ নাম </td><td> জমি </td><td>খাজনা </td><td> স্থানীয় কৰ </td>
                        </thead>
                        <tbody>
                        <td>
                           <?php
                            $size=  sizeof($isdata);
                            if($size>0)
                            {
                            echo $isdata->new_patta_no; }
                            else
                            {
                                echo "No data Found";
                            }?>
                         
                        </td><td>
                             <?php 
                        foreach($pp as $p)
                        {
                            echo $p->pdar_name."<br>";
                        }
                    ?>
                        </td><td>
                            ইয়াৰ দ্বাৰা সৰ্বসাধাৰণক জনোৱা যায় যে , ওপৰোক্ত দৰ্খাস্তকাৰীয়ে <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?> জিলাৰ <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ?> মহকুমাৰ , <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?>  চক্ৰৰ , <?php echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$pb->mouza_pargona_code) ?>  মৌজাৰ / পাৰগণাৰ , 
                        <?php echo $pb->lot_no; ?> নং লাটৰ ,  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?>  চক্ৰৰ , <?php echo $this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$pb->mouza_pargona_code,$pb->lot_no,$pb->vill_townprt_code) ?> গাঁৱৰ ম্যাদী <?php echo $pd->patta_no; ?> পট্টাৰ তেওঁৰ অংশ <?php echo $pd->m_dag_area_b; ?> বি , <?php echo $pd->m_dag_area_k; ?> ক , <?php echo $pd->m_dag_area_lc; ?> লে মাটিৰ বাটোৱাৰা হ’বৰ কাৰণে প্রাৰ্থনা কৰাত , 
                        সেই পট্টাৰ মাটি ইং <?php echo date('d/m/Y',  strtotime($pb->date_of_order))  ;?> তাৰিখৰ হুকুম মতে 
                        <?php
                        if($size > 0)
                        {
                             echo $isdata->new_patta_no; 
                        }else{ echo "No data Found";}
                        ?>
                        নং পট্টাৰ আৰু 
                        <?php
                        if($size > 0)
                        {
                             echo $isdata->new_dag_no; 
                        }else{ echo "No data Found";}
                        ?>
                        নং দাগত ('
                       <?php
                        if($size > 0)
                        {
                             echo $this->utilityclass->getPattaName($isdata->patta_type_code); 
                        }else{ echo "No data Found";}
                        ?>
                        
                        ' শ্রেণীৰ ) বাটোৱাৰা মঞ্জুৰ কৰা হৈছে |
                        </td><td>
                             <?php
                        if($size > 0)
                        {
                             echo round($isdata->revenue,2); 
                        }else{ echo "0";}
                        ?>
                            
                        </td><td>
                             <?php
                        if($size > 0)
                        {   
                            $ltax=$isdata->revenue;
                             echo round($ltax/4,2); 
                        }else{ echo "0";}
                        ?>
                            
                        </td>
                        </tbody>
                    </table>
                    <div class="col-lg-6">
                        <p class="uni_text ">
                            স্বাক্ষৰ : <br>
                            পদবী : <br>
                            তাং : 
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="uni_text text-center">কৰ্ত্তৃত্ব প্রাপ্ত বিষয়াৰ চহী <br>
                            পদবী : <br>
                            তাং : 
                        </p>
                    </div>
					<form class="form-horizontal col-lg-offset-5" action="<?php echo base_url();?>index.php/partition/IstharReportUpdate" method="POST">
							<button type="submit" class='btn btn-info' name="btn" value="Submit and Print"><?php echo $this->lang->line('submit_print') ?></button>
							<input type="hidden" value="<?php echo $pb->case_no; ?>" name="case_no" />
							<input type="hidden" value="<?php echo $pb->petition_no; ?>" name="petition_no" />
					</form>
                </div>
            </div>
        </div>
    </div>
</div>