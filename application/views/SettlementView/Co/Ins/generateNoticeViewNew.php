<style>
    .card-content{
        background-color: #FFF;
    }
    .enc-area-color{
        background: #FDEBEA!important;
    }
    .settlement-area-color{
        background: #EAFFEA!important;
    }
    .final-area-color{
        background: #cfb5b5!important;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }
</style>
<?php 
if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
else{
    $lessa_chatak='Lessa';
}
?>
  <h5 class="bg-info p-2 text-white shadow">
    Generate Payment Notice for case: (
    <span class="bg-warning"><?=$_GET['case'];?>,<?=$applid;?></span> )
  </h5>
  <div class="card-content shadow-sm">
    <div class="card-body">
      <?php
        if ($this->session->flashdata('message')): ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
        <strong><?php echo $this->session->flashdata('message');?></strong>
      </div>
      <?php endif; ?>
      <?php
      if($basic->pay_notice_gen_yn == 'Y'){ ?>
      <div class="text-right">
        <a href="<?php echo base_url()?>index.php/SettlementInstitutionCo/printNotice?case_no=<?=$_GET['case']?>" target="GenerateNotice"><button type="button" name="print_notice" type="button" class="m-1 col-1 text-white btn btn-warning btn-sm">Print Payment Notice </button>
        </a>
      </div>
    
    <?php } ?>
    <?php
      if($instituteDetails->registration_certificate_notice == 'Y'){ ?>
      <div class="">
        <a class="btn btn-warning" href="<?php echo base_url()?>index.php/SettlementInstitutionCo/printNoticeRegistration?case_no=<?=$_GET['case']?>" target="GenerateNotice">Print Registration Certificate Notice
        </a>
      </div>
    
    <?php } ?>
      <div class="card-text mt-2 co-report">
        <form
          method="post"
          action="<?php echo base_url()?>index.php/SettlementInstitutionCo/generatePaymentNoticeCoSave"
          id="formNotice" enctype="multipart/form-data"
        >

        <div class="row">
            <h5 class="reza-title text-center" style="margin-top: 5px">
                <i class="fa fa-map"></i>  Area Details
            </h5>
            <div class="tableCard">
                <table class="table">
                    <thead class="thead-warning">
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th class="text-center">Bigha</th>
                            <th class="text-center">Katha</th>
                            <th class="text-center"><?=$lessa_chatak?></th>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <th class="text-center">Ganda</th>
                            <th class="text-center">Kranti</th>
                            <?php endif; ?>
                        </tr>

                        <?php foreach ($dags as $all_dags) {?>


                        <tr class="bg-white">
                            <th rowspan="6" style="vertical-align : middle;">
                                <div class="vertical">
                                    DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> | 
                                    PATTA : <span class="text-danger"><?=$all_dags->patta_no?> | <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?></span>
                                </div>
                            </th>
                            <td><strong>Total Land Area in Selected Dag</strong></td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_k" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" >
                            </td>
                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" >
                                </td>
                                <td class="hide" style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_kr?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" >
                                </td>
                            <?php endif ; ?>
                        </tr>

                        <?php                            
                            $enc_area = json_decode($all_dags->encroachement_area);
                            if($enc_area != null) {
                        ?>
                        <!-- encroacher homestead -->
                        <tr class="bg-white">
                            <td class="enc-area-color"><strong>Encroachment Area</strong></td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->homestead->bigha?></strong>
                                <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->homestead->bigha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->homestead->katha?></strong>
                                <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->homestead->katha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->homestead->lessa?></strong>
                                <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->homestead->lessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->homestead->ganda?></strong>
                                    <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->homestead->ganda?>" readonly>
                                </td>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->homestead->kranti?></strong>
                                    <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->homestead->kranti?>" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                        <!-- encroacher agriculture -->
                        <tr class="bg-white" style="display:none">
                            <td class="enc-area-color"><strong>Encroachment Area</strong></td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->agriculture->bigha?></strong>
                                <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->agriculture->bigha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->agriculture->katha?></strong>
                                <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->agriculture->katha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->agriculture->lessa?></strong>
                                <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->agriculture->lessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->agriculture->ganda?></strong>
                                    <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->agriculture->ganda?>" readonly>
                                </td>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->agriculture->kranti?></strong>
                                    <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->agriculture->kranti?>" readonly>
                                </td>
                            <?php endif;?>
                        </tr>  
                        <?php } ?>

                        <!-- area settlement homestead -->
                        <?php $hide = 'area_show';
                            if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                                $hide = 'area_show';
                            } else {
                                $hide = 'area_hide';
                            }
                        ?>
                        <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Area for Allotment/Settlement/Transfer</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_b?></strong>
                                <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_dags->home_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_k?></strong>
                                <input type="hidden" style="text-align: center;" name="home_k" value="<?=$all_dags->home_k?>" class="form-control input-sm home_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$all_dags->home_lc?>" class="form-control input-sm home_lc" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->home_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->home_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->home_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- area settlement agriculture -->
                        <?php 
                            $hide = 'area_show';
                            if ($all_dags->land_type == 2) {
                                $hide = 'area_show';
                            } else {
                                $hide = 'area_hide';
                            }
                        ?>
                        <!-- <tr  class="bg-white" style="display:none">
                            <td class="settlement-area-color"><strong>Area for Settlement</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_b?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_k?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_k" value="<?=$all_dags->agri_k?>" class="form-control input-sm agri_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->agri_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->agri_g?>" class="form-control input-sm agri_g" name="agri_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->agri_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" readonly>
                                </td>
                            <?php endif;?>
                        </tr> -->

                        <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Roadside Reservation Area</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->bigha?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm" value="<?=$all_dags->bigha?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->katha?></strong>
                                <input type="hidden" style="text-align: center;" value="<?=$all_dags->katha?>" class="form-control input-sm katha" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->lessa?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm lessa" value="<?=$all_dags->lessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->ganda?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->ganda?>" class="form-control input-sm ganda" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->kranti?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->kranti?>" class="form-control input-sm kranti" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                        <?php  
                        
                          if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
                            $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($all_dags->total_lessa);
                          }
                          else{
                            $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($all_dags->total_lessa);
                          }
                         ?>

                        <tr class="bg-white">
                            <td class="final-area-color"><strong>Final Area</strong></td>
                            <td class="final-area-color" style="text-align:center">
                                <strong><?=$totalAreaArr[0]?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm" value="<?=$totalAreaArr[0]?>" readonly>
                            </td>
                            <td class="final-area-color" style="text-align:center">
                                <strong><?=$totalAreaArr[1]?></strong>
                                <input type="hidden" style="text-align: center;" value="<?=$totalAreaArr[1]?>" class="form-control input-sm katha" readonly>
                            </td>
                            <td class="final-area-color" style="text-align:center">
                                <strong><?=$totalAreaArr[2]?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm lessa" value="<?=$totalAreaArr[2]?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="final-area-color" style="text-align:center">
                                    <strong><?=$totalAreaArr[3]?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$totalAreaArr[3]?>" class="form-control input-sm ganda" readonly>
                                </td>
                                
                            <?php endif;?>
                        </tr>

                        <tr rowspan="7">
                            <?php if(EDIT_AREA_INS_BEFORE_PAYMENT_NOTICE == 1) {?>
                                <td colspan="5"><button type="button" id="editarea<?=$all_dags->id?>" onclick="editAreaJuridical(<?=$all_dags->id?>,<?=$all_dags->dag_no?>,<?=$all_dags->patta_no?>);" class="btn btn-sm btn-danger">Click here for edit area</button></td>
                            <?php } ?>
                            
                        </tr>
                        
                        <?php } ?>

                    </thead>
                </table>
                
            </div>
          
          <?php include(APPPATH."views/SettlementView/include/premiumDetailsViewIns.php"); ?>



          <input type="hidden" name="ins_cat_type" value="<?=$instituteDetails->ins_cat_type_co;?>">
            <?php if($instituteDetails->ins_cat_type_co == 12 && empty($registration_document)){?>
            
            <div class="row">
                <h5 class="bg-success text-center">
                    <i class="fa fa-history" aria-hidden="true"></i> Registration Details
                </h5>
                <div class="row">
                
                    <!-- <div class="form-group col-md-6 ">
                         <b style="color:#ff681d">  Do you have Acknowledgment Details or Registration Details? If only Acknowledgment Details are available, check Acknowledgment; otherwise, provide Registration Details.</b>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="registration_acknowledge" id="registration_acknowledge1" value="ack">
                            <label class="form-check-label" for="registration_acknowledge1">Acknowledgment.</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="registration_acknowledge" id="registration_acknowledge0" value="reg">
                            <label class="form-check-label" for="registration_acknowledge0">Registration.</label>
                        </div>
                    </div> -->
                    <?php if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d')){ ?>
                        <div class="form-group col-md-6 ">
                         <b style="color:#ff681d">  Do you have Registration Details?</b>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="registration_info" id="registration_1" value="NO">
                                <label class="form-check-label" for="registration_acknowledge1">NO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="registration_info" id="registration_0" value="YES">
                                <label class="form-check-label" for="registration_acknowledge0">YES</label>
                            </div>
                        </div>
                    <?php } ?>
                    

                </div>
                <!-- <div class="row">
                    <div class="form-group col-md-6 ">
                        <span style="color:red">Acknowledgment No.  *</span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" autocomplete="off" class="form-control" id="acknowledgment_no" placeholder="" name="acknowledgment_no" value="<?php if(isset($err_return)){ echo set_value('acknowledgment_no');}else{ echo $apLmnoteDetails->acknowledgment_no;}?>" required="" style="margin-left: 20px;">
                    </div>
                </div> -->

                <div class="row">
                    <div class="form-group col-md-6 ">
                        Whether the entity/organization/institution etc is registered under the Societies Registration Act,1860 or under the Assam Cooperative Societies Act,2007(as amended) or under relevant Central or State government Act/Law:
                    </div>
                    <div class="form-group col-md-6">
                        <select name="co_operative_registered" id="co_operative_registered" class="form-select">
                           <?php 
                            if(trim($apLmnoteDetails->co_operative_registered) == 'N')
                            {
                               echo '<option value="N">No</option><option value="Y">Yes</option>';
                            }else
                            {
                                echo '<option value="Y">Yes</option><option value="N">No</option>';
                            } ?>

                        </select>
                    </div>
                </div>

                <div class="row registration_no_details">
                    <div class="form-group col-md-6 ">
                        <span style="color:red">Registration No.  *</span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" autocomplete="off" class="form-control" id="registration_no" placeholder="" name="registration_no" value="<?php if(isset($err_return)){ echo set_value('registration_no');}else{ echo $apLmnoteDetails->registration_no;}?>" required="" style="margin-left: 20px;">
                    </div>

                    <div class="form-group col-md-6 ">
                          <span style="color:red">Registration Date. *</span>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" autocomplete="off" class="form-control" id="registration_date" placeholder="" name="registration_date" value="<?php if(isset($err_return)){ echo set_value('registration_date');}else{ echo $apLmnoteDetails->registration_date;}?>" required="" style="margin-left: 20px;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="inputEmail4" style="color:red;">Registration Document *</label>
                    </div>
                    <div class="col-8">
                        <input
                                class="form-control <?php if(form_error('registration_document')){echo 'lm_invalid';}?>"
                                type="file"
                                name="registration_document"
                                id="registration_document"
                                accept=".png, .jpg, .jpeg, .pdf"
                        />
                    </div>
                </div>
            </div>
            <?php }?>

     
            </div>
            <hr style="margin-top: 0;">
            <?php
              if($basic->pay_notice_gen_yn != 'Y'){ ?>


                <?php 
                if($instituteDetails->ins_cat_type_co == '12' && RECALCULATE_PREMIUM_FOR_APPROVE_CASES ==1 && 
                   in_array($this->session->userdata("dist_code"), json_decode(RECALCULATE_PREMIUM_FOR_APPROVE_CASES_DIST)))
                {
                ?>
                <div class="row" style="margin-bottom: 38px;">
                    <div class="col-md-8" style="text-align:center;">

                        <label for="inputEmail4" style="color:#ff681d;">Would you like to re-calculate the premium? </label>
                        <p style="font-style:italic;color: red;font-weight: bold;">(Re-calculation is performed only when a chitha dag mismatch is detected!!!)</p>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input <?php if(form_error('recalculate')){echo 'lm_invalid';}?>"
                                    type="radio"
                                    name="recalculate"
                                    id="recalculate1"
                                    value="YES"
                                    onclick="showModal('YES')"
                                <?php if(set_value('recalculate') == 'YES'){ echo "checked";} ?>
                            />
                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                    class="form-check-input <?php if(form_error('recalculate')){echo 'lm_invalid';}?>"
                                    type="radio"
                                    name="recalculate"
                                    id="recalculate2"
                                    value="NO"
                                    onclick="showModal('NO')"
                                <?php if(set_value('recalculate') == 'NO'){ echo "checked";} ?>
                            />
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <?php 
                }
                ?>

                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <label for="inputEmail4"><strong>Remarks(if any)</strong></label>
                    </div>
                    <div class="col-md-6">
                    <textarea
                        placeholder="Remarks  ..."
                        name="remark_co"
                        class="form-control"
                        id="remark_co"
                        cols="30"
                        rows="3"
                    required></textarea>
                    <input type="hidden" name="case_no" id="case_no_re_cal" value="<?=$_GET['case']?>" />
                    </div>
                </div>
        <?php } ?>

        <div class="row mt-4 justify-content-center">
            <?php if(PAYMENT_NOTICE_BUTTON_INS == 1)
            { 
                if($basic->pay_notice_gen_yn != 'Y') 
                {
  
                    if($instituteDetails->ins_cat_type_co == '8')
                    {
                    ?>
                    
                    <button 
                        type="submit"
                        name="generate_notice"
                        type="button"
                        class="m-1 col-3 text-white btn btn-success btn-sm"
                        id="btnNotice">
                        Forward for Chitha Correction
                    </button>
                    <?php 
                    }
                    else if ($instituteDetails->ins_cat_type_co == 12 && $instituteDetails->registration_certificate_notice == null)
                    {
                        ?>
                        <b style="color:#ff681d">Note: To generate the registration notice, click the button below without entering any registration details.</b>
                        <?php echo '<a alt="View application" class="text-white btn btn-md btn-success" target="Application" href="' . base_url() . 'index.php/SettlementInstitutionCo/registrationCertificateNotice?case=' . $_GET['case'] . '">Generate Registration certificate notice</a>'; ?> 
                            
                        <?php }
                        else
                        { ?>
                            <button 
                            type="submit"
                            name="generate_notice"
                            type="button"
                            class="m-1 col-2 text-white btn btn-danger btn-sm"
                            id="btnNotice">
                            Generate payment notice
                        </button>
                        <?php }
                        
                    
                }
                else
                {
                    ?>

                    <span class="alert-warning"><b>**Premium notice already generated. Do you want to re-generate premium notice again?(Note: If Citizen already paid for the previous Premium Notice New Payment notice will not be generated.)</b></span>

                    <div class="row justify-content-center mt-4">
                        <div class="col-md-2">
                            <label for="inputEmail4"><strong>Remarks(if any)</strong></label>
                        </div>
                        <div class="col-md-6">
                        <textarea
                            placeholder="Remarks  ..."
                            name="remark_co"
                            class="form-control"
                            id="remark_co"
                            cols="30"
                            rows="3"
                        required></textarea>
                        <input type="hidden" name="case_no" value="<?=$_GET['case']?>" />
                        </div>
                    </div>
                    <?php 
                    if($instituteDetails->ins_cat_type_co == '8')
                    {
                    ?>
                    <button type="submit"
                            name="generate_notice"
                            type="button"
                            class="m-1 col-2 text-white btn btn-danger btn-sm"
                            id="btnNotice">
                            Forward for Chitha Correction
                        </button>
                    
                    <?php
                    }
                    else
                    {
                        ?>
                        
                        <button 
                        type="submit"
                        name="generate_notice"
                        type="button"
                        class="m-3 col-2 text-white btn btn-danger btn-sm"
                        id="btnNotice">
                        Re-Generate Premium Notice
                    </button>
                    <?php }
                }
            }
            ?>    
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal" role="dialog" id="infoModal" data-backdrop="static" data-keyboard="false" 
  style="z-index:999999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #ffd81d">
        <h5 class="modal-title">Information regarding re-calculation of premium (Approved cases)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

            <p>I. If any changes are made to the Chitha Dag flag, clicking Yes will automatically re-calculate the premium based on the current Chitha Dag mapping and applicable zonal values.</p>

            <p>II. If any changes are made to the area, the premium will be re-calculated using the existing data in the application using edit area in above.</p>
            <div class="form-group">
                <label>Remarks : <span style="color:red">*</span> (Please specify the reason for recalculation)</label>
                <textarea name="reason_for_recalculate" id="reason_for_recalculate" class="form-control"></textarea>
            </div>
            <div style="text-align: center;">

                <button 
                    type="button"
                    name="recalculate"
                    class="btn btn-danger"
                    id="recalculate">
                    Click here for Re-calculate Premium
                </button>
            </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type='text/javascript'>

    $(function () {
        $('#registration_date').datepick({dateFormat: 'dd-mm-yyyy'});
    });
  function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
  //   $(document).ready(function() {
  //     $("form").submit(function(e){
  //       showErrorMessage('This features will be made available soon !!!');
  //         e.preventDefault(e);
  //     });
  // });


  $('#btnNotice').on('click',function(e){
        e.preventDefault();
        var form = $('#formNotice');
        var encData ='';
        var encDataAll =[];

        <?php
        if($premium_data == true)
        {
        foreach($premium_data as $prem){
        ?>
        // $(".clspremdata").each(function () {
            encData += 'Dag No:' + <?=$prem->dag_no?> + "<br> Purpose of Land : "+$( "#premLand<?=$prem->dag_no?>" ).val()+" <hr>";


        // });
        // alert( encData );
        // encDataAll.push(encData);

        <?php } } ?>


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {
                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                    $('#btnNotice').prop('disabled', false);
                    $('#btnNotice').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnNotice').prop('disabled', false);
                $('#btnNotice').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnNotice').prop('disabled', false);
            $('#btnNotice').val('Save and submit');
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                // 'error'
            )
        }
    })
    });
</script>
<?php include(APPPATH."views/Juridical/editAreaJuridicalPn.php"); ?>

<script>
    // function reCalculatePremiumWithOutConcession(case_no, is_concession)
    // {
    //     if(!confirm("Are you sure you want to recalculate premium without concession?"))
    //     {
    //         return false;
    //     }
    //     // $("#overlay").fadeIn(300);
    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });

    //     $.ajax({
    //         url: baseurl + "SettlementCommon/premiumReCalculateCaste",
    //         type: 'POST',
    //         data: {'case_no':case_no, 'is_concession':is_concession},
    //         success: function (data) {
    //             $.unblockUI();
                
    //             arr = JSON.parse(data);

    //             if(arr.responseType != 2)
    //             {
    //                 showErrorMessage(arr.msg);
    //                 return false;
    //             }
    //             else
    //             {
    //                 Swal.fire({
    //                     text: arr.msg,
    //                     icon: 'success',
    //                     confirmButtonText: 'OK',
    //                     customClass: {
    //                         actions: 'my-actions',
    //                         confirmButton: 'order-2',
    //                     }
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         window.location.reload();
    //                     }
    //                     else
    //                     {
    //                         window.location.reload();
    //                     }
    //                 })
    //             }

    //         },
    //         error: function (error) {
    //             console.log(error);
    //             $.unblockUI();
    //             alert("Something went wrong");
    //         }

    //     })
    // }
</script>
<script>
function showModal(val) {
    if(val == 'YES')
    {
        $('#infoModal').modal('show');
        document.getElementById('infoModalLabel').innerText = title;
        document.getElementById('modalContent').innerText = content;
        // var areaModal = document.getElementById("infoModal");
        // areaModal.style.display = "block";
    }
    else
    {
        $('#infoModal').modal('hide');
    }

}
</script>

<script>
$('#recalculate').on('click',function(e){
    // alert('Failed to fetch old premium!!!');
    // return false;
    if(!confirm("Are you sure you want to recalculate the premium? The recalculated amount may differ from the existing premium !!!"))
    {
        return false;
    }
    var case_no_re_cal = $('#case_no_re_cal').val();
    var reason_for_recalculate  = $('#reason_for_recalculate').val();
    if(!reason_for_recalculate)
    {
        alert('Please specify the reason !');
        return false;
    }
    // $("#overlay").fadeIn(300);
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl + "SettlementInstitutionCo/premiumReCalculateForApproveCases",
        type: 'POST',
        data: {'case_no':case_no_re_cal,'reason_for_recalculate' : reason_for_recalculate},
        success: function (data) {
            $('#infoModal').modal('hide');
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2)
            {
                showErrorMessage(arr.msg);
                return false;
            }
            else
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                    else
                    {
                        window.location.reload();
                    }
                })
            }

        },
        error: function (error) {
            $('#infoModal').modal('hide');
            console.log(error);
            $.unblockUI();
            alert("Something went wrong");
        }

    })
});
</script>
