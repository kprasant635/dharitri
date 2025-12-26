
 <?php 
  
    $dist_code = $this->session->userdata('dcodenew');
//  echo  'hii'.$dist_code;
         $subdiv_code = $this->session->userdata('scodenew');
        $cir_code = $this->session->userdata('ccodenew');
        $mouza_pargona_code = $this->session->userdata('mcodenew');
        $lot_no = $this->session->userdata('lcodenew');
        $vill_code = $this->session->userdata('vcodenew');
        $dag_no = $this->session->userdata('dag_no');
        $patta_no = $this->session->userdata('patta_no');
        $patta_type_code =$this->session->userdata('patta_type_code');
       $cron_no= $this->session->userdata('cron_no') ;
     $pdar_id   = $this->session->userdata('pdar_id');  
        $pdar_name = $this->session->set_userdata('pdar_name');
        $pdar_guard_name = $this->session->set_userdata('pdar_guard_name'); 
    $pdar_rel_guar =  $this->session->set_userdata('pdar_rel_guar');
    $pdar_add1 =    $this->session->set_userdata('pdar_add1');
        
    $pdar_add2 = $this->session->set_userdata('pdar_add2');
         $gender  = $this->session->set_userdata('gender'); 
        $mothers_name = $this->session->set_userdata('mothers_name');
    $mobile_no =    $this->session->set_userdata('mobile_no');  
    $aadhar_no =    $this->session->set_userdata('aadhar_no');
    $nrc_no =   $this->session->set_userdata('nrc_no');
         $pan_no = $this->session->set_userdata('pan_no');
    $voter_id=  $this->session->set_userdata('voter_id');
    
    
    $mbigha =   $this->session->userdata('mbigha');
    $mkatha =   $this->session->userdata('mkatha'); 
    $mlessa =   $this->session->userdata('mlessa');
    $petitioner =   $this->session->userdata('petitioner'); 
    $date_entry =   $this->session->userdata('date_entry');
    $add_of_name =  $this->session->userdata('add_of_name');
    $add_of_desig   = $this->session->userdata('add_of_desig');
     $availibility = $this->session->userdata('availibility');
        
   $add_of_co = $this->session->userdata('add_of_co');
   

   
   
  $dag_area_bigha=  $this->session->userdata('dag_area_bigha');
     $dag_area_katha=    $this->session->userdata('dag_area_katha');
    $dag_area_lessa=     $this->session->userdata('dag_area_lessa');
     $mbigha_p=    $this->session->userdata('mbigha_p');
      $mkatha_p =   $this->session->userdata('mkatha_p');
      $mlc_p =   $this->session->userdata('mlc_p');
    $lbigha =   $this->session->userdata('lbigha');
      $lkatha =  $this->session->userdata('lkatha');
      $llc=   $this->session->userdata('llc');
    $lbigha_p=  $this->session->userdata('lbigha_p');
     $lkatha_p = $this->session->userdata('lkatha_p');
      $llc_p =$this->session->userdata('llc_p');
  $this->session->userdata('pattadar_d');
  
    $mut_type=$this->session->userdata('mut_type');
  
    $user_code=$this->session->userdata('user_code');
  
  $user_desig_code=$this->session->userdata('user_desig_code');
  
  
  
 ?>



<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('application_detail_description'); ?></h2>
                     <input type="hidden" readonly class="form-control" name="dist_code" value="<?php echo $dist_code ?>">
                                        <input type="hidden" readonly class="form-control" name="subdiv_code" value="<?php echo $subdiv_code; ?>">
                                         <input type="hidden" readonly class="form-control" name="cir_code" value="<?php echo $cir_code ?>">
                                        <input type="hidden" readonly class="form-control" name="mouza_pargona_code" value="<?php echo $mouza_pargona_code; ?>">
                                         <input type="hidden" readonly class="form-control" name="lot_no" value="<?php echo $lot_no ?>">
                                        <input type="hidden" readonly class="form-control" name="vill_code" value="<?php echo $vill_code; ?>">
                                             <input type="hidden" readonly class="form-control" name="patta_no" value="<?php echo $patta_no ?>">
                                        <input type="hidden" readonly class="form-control" name="patta_type_code" value="<?php echo $patta_type_code; ?>">
                                         <input type="hidden" readonly class="form-control" name="dag_no" value="<?php echo $dag_no ?>">
                                         
                                   
                                    
                                        
                                             <input type="hidden" readonly class="form-control" name="pdar_guard_name" value="<?php echo $pdar_guard_name ?>">
                                        <input type="hidden" readonly class="form-control" name="pdar_rel_guar" value="<?php echo $pdar_rel_guar; ?>">
                                         <input type="hidden" readonly class="form-control" name="pdar_add1" value="<?php echo $pdar_add1 ?>">
                                        <input type="hidden" readonly class="form-control" name="pdar_add2" value="<?php echo $pdar_add2; ?>">
                                         <input type="hidden" readonly class="form-control" name="gender" value="<?php echo $gender ?>">
                                        <input type="hidden" readonly class="form-control" name="mothers_name" value="<?php echo $mothers_name; ?>">
                                        
                                             <input type="hidden" readonly class="form-control" name="mobile_no" value="<?php echo $mobile_no ?>">
                                        <input type="hidden" readonly class="form-control" name="aadhar_no" value="<?php echo $aadhar_no; ?>">
                                         <input type="hidden" readonly class="form-control" name="nrc_no" value="<?php echo $nrc_no ?>">
                                        <input type="hidden" readonly class="form-control" name="pan_no" value="<?php echo $pan_no; ?>">
                                             <input type="hidden" readonly class="form-control" name="voter_id" value="<?php echo $voter_id ?>">
                                             
                                             
                                                 <input type="hidden" readonly class="form-control" name="mbigha" value="<?php echo $mbigha ?>">
                                        <input type="hidden" readonly class="form-control" name="mkatha" value="<?php echo $mkatha; ?>">
                                         <input type="hidden" readonly class="form-control" name="mlessa" value="<?php echo $mlessa ?>">
                                        <input type="hidden" readonly class="form-control" name="petitioner" value="<?php echo $petitioner; ?>">
                                             <input type="hidden" readonly class="form-control" name="date_entry" value="<?php echo $date_entry ?>"> 
                                             
                                             
                                                <input type="hidden" readonly class="form-control" name="add_of_name" value="<?php echo $add_of_name; ?>">
                                         <input type="hidden" readonly class="form-control" name="add_of_desig" value="<?php echo $add_of_desig ?>">
                                        <input type="hidden" readonly class="form-control" name="petitioner" value="<?php echo $petitioner; ?>">
                                             <input type="hidden" readonly class="form-control" name="availibility" value="<?php echo $availibility ?>"> 
                                              <input type="hidden" readonly class="form-control" name="add_of_co" value="<?php echo $add_of_co ?>"> 
                                              
                                              
                                        <input type="hidden" readonly class="form-control" name="dag_area_bigha" value="<?php echo $dag_area_bigha ?>">
                                        <input type="hidden" readonly class="form-control" name="dag_area_katha" value="<?php echo $dag_area_katha; ?>">
                                         <input type="hidden" readonly class="form-control" name="dag_area_lessa" value="<?php echo $dag_area_lessa ?>">
                                        <input type="hidden" readonly class="form-control" name="mbigha_p" value="<?php echo $mbigha_p ?>">
                                        <input type="hidden" readonly class="form-control" name="mkatha_p" value="<?php echo $mkatha_p; ?>">
                                         <input type="hidden" readonly class="form-control" name="mlc_p" value="<?php echo $mlc_p ?>">
                                        <input type="hidden" readonly class="form-control" name="lbigha" value="<?php echo $lbigha ?>">
                                        <input type="hidden" readonly class="form-control" name="lkatha" value="<?php echo $lkatha; ?>">
                                         <input type="hidden" readonly class="form-control" name="llc" value="<?php echo $llc ?>">
                                           <input type="hidden" readonly class="form-control" name="lbigha_p" value="<?php echo $lbigha_p ?>">
                                        <input type="hidden" readonly class="form-control" name="lkatha_p" value="<?php echo $lkatha_p; ?>">
                                         <input type="hidden" readonly class="form-control" name="llc_p" value="<?php echo $llc_p ?>">  
                                         <input type="hidden" readonly class="form-control" name="mut_type" value="<?php echo $mut_type ?>">    
                                             <input type="hidden" readonly class="form-control" name="user_code" value="<?php echo $user_code ?>">  
                                              
                                              
                                             
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                            <table class='table table-bordered unicode'>
                                <tr>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                    <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $conv_type; ?></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to_the_officer'); ?> : <?php echo $addressed_to; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($date_entry)); ?></label></td>
                                </tr>
                            </table>
                        </fieldset>
    

                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                            <table class="table table-bordered  unicode">
                                <thead>
                                    <tr>
                                        <th><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></label></th>
                                        <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td><label class="control-label"><?php echo $dag_no; ?></label></td>
                                    <td><label class="control-label"><?php echo $m_dag_area_b . " বিঘা " . $m_dag_area_k . " কঠা " . $m_dag_area_lc . " লেছা " ?></label></td>
                                    <td class="center"><label class="control-label"><?php echo $patta_no; ?></label></td>
                                    <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                                    <td class="center">
                                        <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=0"; ?>" target="_blank">
                                            <button type="submit" class="btn btn-md uni_text"><span class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></span></button>
                                        </a>
                                    </td>
                                    <td class="center">
                                        <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=0"; ?>" target="_blank">
                                            <button type="submit" class="btn btn-md uni_text"><span class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></span></button>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                            <table class='table table-bordered  unicode'>
                                <thead>
                                    <tr>
                                        <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                    </tr>
                                </thead>
                                <?php
                                foreach ($pattadarx as $p):
                                    ?>
                                    <tr>
                                        <td><label class="control-label"><?php echo $p['pdar_cron_no']; ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pdar_name']; ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pdar_guardian']; ?></label></td>
                                        <td><label class="control-label"><?php echo $this->ASTofficeConversionModel->getRelationName($p['pdar_rel_guar']); ?></label></td>
                                        <td><label class="control-label"><?php echo $p['pdar_add1'] . " " . $p['pdar_add2']; ?></label></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-sm-6" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                <p class="uni_text" style="color: #990000;">পুৰণা দাগত আবেদনকাৰীৰ মাটি বাকী থাকিব নেকি ? : <?php echo $availibility; ?></p>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/save_create_rasid"; ?>" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;তথ্য গ্ৰহণ কৰক আৰ ৰচিদ জাৰি কৰক |</a>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>