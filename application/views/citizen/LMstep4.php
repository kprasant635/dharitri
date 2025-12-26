<div class="container-fluid form-top login">
    <div class='row'>

        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                <h2 class="center uni_text"><?php echo $this->lang->line('govt_of_assam');?></h2>
                    <p class="uni_text"><span class="pull-left">চক্র বিষয়াৰ কাৰ্য্যালয়  ::</span>  <span style=" margin-left: 20px"> <?php echo $location['cirname'] ;?>
                            ৰাজহ  চক্ৰ </span><span class="pull-right">
                        <?php echo $location['mouza_pargona_code'] ?> </span></p>
                    <hr>
                    <p><span class="pull-left uni_text"><?php echo $this->lang->line('sr_no');?> :<?php echo $this->session->userdata('cert_no'); ?></span>
                        <span class="pull-right uni_text"><?php echo $this->lang->line('apply_date');?>:<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?></span></p>
                    <hr>
                    <p class="uni_text text-center text-danger"><?php echo $cername=$this->utilityclass->getCertName($certD->cert_type); ?>  </p>
                    <div class="col-lg-12" style="margin-top: 25px">
                    <p class="uni_text">
                        ইয়াৰ দ্বাৰা প্রমাণ-পত্র দিয়া হয় যে ,<?php echo $location['cirname'] ;?>  ৰাজহ চক্ৰ ,<?php echo $location['mouza_pargona_code'] ?> মৌজা ৰ,
                            <?php echo $location['vill_townprt_code'] ?> গাঁওৰ
                    <?php echo $certD->patta_no; ?> নং <?php echo $this->utilityclass->getPattaName($certD->patta_type_code); ?> ( এজমালি ) পাট্টাৰ অৰ্ন্তগত , তলত দিয়া ধৰণে ,
                    </p>
                    <table class="table">
                        <tr>
                            <th><?php echo $this->lang->line('dag_no');?></th><th><?php echo $this->lang->line('land_type');?></th>
                            <th><?php echo $this->lang->line('bigha');?></th><th><?php echo $this->lang->line('katha');?></th>
                            <th><?php echo $this->lang->line('lesa');?></th>
                            <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
                            {?>
                              <th><?php echo $this->lang->line('ganda');?></th>  
                            <?php }?>
                            
                        </tr>
						<?php //echo sizeof($dags);
							for($i=0;$i<sizeof($dags);$i++){
						?>
                        <tr>
                            <td><?php echo $dags[$i]['dag_no'] ?></td>
                            <td><?php echo $this->utilityclass->getLandClassCode($dags[$i]['land_class_code']); ?></td>
                            <td><?php echo $dags[$i]['bigha'] ?></td>
                            <td><?php echo $dags[$i]['katha'] ?></td>
                            <td><?php echo $dags[$i]['lessa'] ?></td>
                            <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
                            {?>
                            <td><?php echo $dags[$i]['ganda'] ?></td>  
                            <?php }?>
                        </tr>
							<?php } ?>
                    </table>
                    <p class="uni_text">মাটিত <?php echo $certD->appln_name; ?>,<?php echo $certD->appln_guard; ?> ৰ নিজৰ নামত থকা জমি হয় | </p>
                    <p class="uni_text">এই প্রমাণ-পত্র লাট-মন্ডলৰ প্রতিবেদনৰ ভিওিত দিয়া হ’ল |</p>
                    </div>
                    <div class="col-lg-offset-9">
                        <p class="uni_text text-center">
                            চক্র বিষয়া<br>
                            <?php echo $location['cirname'] ;?> ৰাজহ  চক্ৰ  
                        </p>
                    </div>
                <hr>
                <form action="<?php echo base_url();?>index.php/citizencontroller/FinalStepLH">
                    <button class="btn btn-primary uni_text  col-lg-offset-3" name="submit" type="submit"><?php echo $this->lang->line('forwardco_necessary_action');?></button>
                </form>
               
            </div>
            </div>
        </div>
       
    </div>
</div>
