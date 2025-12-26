<style>
    .basu-app-view {
        font-family:  Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
    }

    .table-js {
        font-family:  Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
        font-weight: 500;
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }

    .table-js th,
    .table-js td {
        padding-top: 0;
        padding-bottom: 0;
        padding-left: 2rem;
        padding-right: 2rem;
        /* vertical-align: top; */
        /* border-top: 1px solid #eceeef; */
        /* border-top: 1px solid #4B555F; */

    }

    .table-js thead th {
        vertical-align: bottom;
        /* border-bottom: 1px solid #4B555F; */
    }

    /* .table-js tbody + tbody {
        border-top: 1px solid #4B555F;
    } */

    .table-js .table-js {
        background-color: #fff;
    }
    .table-bordered-js {
        border: 1px solid #4B555F;
    }

    .table-bordered-js th,
    .table-bordered-js td {
        border: 1px solid #4B555F!important;
    }

    .table-bordered-js thead th,
    .table-bordered-js thead td {
        border-bottom-width: 1px;
    }

</style>

<div class="container basu-app-view bg-white p-5">
    <div class="row">
        <div class="col-md-12 text-center">
            Application for the case number - <b><?=$_GET['app']?><b>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <strong>Self declaration details</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered mt-2">
                <?php
                if(isset($selfDeclarationDetails[0])){
                    foreach($selfDeclarationDetails[0] as $key=>$self){
                        ?>
                        <tr>
                            <th><?=$self->name ?></th>
                            <td class="text-center">
                                    <?php if ($self->status == "1"){ echo "Yes"; }?>
                                    <?php if ($self->status == "0"){ echo "No"; }?>
                            </td>
                        </tr>
                    <?php }}?>

            </table>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <strong>Address Information</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered mt-2">
                <tr>
                    <th style="width: 40%;">District name</th>
                    <td>
                        <?=$this->utilityclass->getDistrictName($application->dist_code)?>
                    </td>
                </tr>
                <tr>
                    <th>Subdivision Name</th>
                    <td>
                        <?=$this->utilityclass->getSubDivName($application->dist_code,$application->subdiv_code)?>
                    </td>
                </tr>
                <tr>
                    <th>Circle Name</th>
                    <td>
                        <?=$this->utilityclass->getCircleName($application->dist_code,$application->subdiv_code,$application->cir_code)?>
                    </td>
                </tr>
                <tr>
                    <th>Mouza Name</th>
                    <td>
                        <?=$this->utilityclass->getMouzaName($application->dist_code,$application->subdiv_code,$application->cir_code,$application->mouza_code)?>
                    </td>
                </tr>
                <tr>
                    <th>Village Name</th>
                    <td>
                    <?=$this->utilityclass->getVillageName($application->dist_code,$application->subdiv_code,$application->cir_code,$application->mouza_code,$application->lot_no,$application->village_code)?>
                    </td>
                </tr>
            </table>
        </div>
   
    </div>


    <?php $applicatn_details_count=1; if(isset($applicant) && $applicant){
        ?>
    <div class="row mt-2">
        <div class="col-md-12">
            <strong>Applicant details</strong>
        </div>
    </div>
    <table class="table table-bordered">
        <?php
        
        foreach($applicant as $settlement): ?>
        <tr>
            <th rowspan="7" style="vertical-align : middle;text-align:center;"><?=$applicatn_details_count;?></th>
            <th style="width: 40%;">Name of the applicant</th>
            <td>
                <?=$settlement->name_ass;?>
            </td>
        </tr>
        <tr>
            <th>Guardian name</th>
            <td>
                <?=$settlement->gurdian_name_ass;?>
            </td>
        </tr>
        <tr>
            <th>Relation</th>
            <td>
                <?php if ($settlement->gurdian_relation_id == "1"){ echo "Mother"; }?>
                <?php if ($settlement->gurdian_relation_id == "2"){ echo "Father"; }?>
                <?php if ($settlement->gurdian_relation_id == "3"){ echo "Husband"; }?>
                <?php if ($settlement->gurdian_relation_id == "4"){ echo "Wife"; }?>
                <?php if ($settlement->gurdian_relation_id == "5"){ echo "Guardian"; }?>
                <?php if ($settlement->gurdian_relation_id == "6"){ echo "Supdt"; }?>
                <?php if ($settlement->gurdian_relation_id == "7"){ echo "Guardian"; }?>
            </td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>
                <?php if ($settlement->gender == "1"){ echo "Male"; }?>
                <?php if ($settlement->gender == "2"){ echo "Female"; }?>
                <?php if ($settlement->gender == "3"){ echo "Others"; }?>
            </td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td>
                <?=$settlement->mobile?>
            </td>
        </tr>
        <tr>
            <th>
                Permanent address
            </th>
            <td>
                <?=$settlement->per_add?>
            </td>
        </tr>
        <tr>
            <th>Present address</th>
            <td>
                <?=$settlement->pre_add?>
            </td>

        </tr>
    <?php $applicatn_details_count++; endforeach;
    ?>
    </table>
    <?php
    }
    ?>


        <?php
        if(isset($owner) && $owner){
            ?>
    <div class="row mt-2">
        <div class="col-md-12">
            <strong>Owner/Landlord details</strong>
        </div>
    </div>
        <table class="table table-bordered">

            <?php
            $landlord_count = 1;
            foreach($owner as $owners){
                ?>
    
                <tr>
                    <th rowspan="3" style="vertical-align : middle;text-align:center;"><?=$landlord_count;?></th>
                    <th style="width: 40%;">Owner/Landlord Name</th>
                    <td>
                        <?=$owners[0]->pdar_name;?>
                    </td>
                </tr>
                <tr>
                    <th>Father's name</th>
                    <td>
                        <?=$owners[0]->pdar_father;?>
                    </td>
                </tr>
                <tr>
                    <th>Mobile Number</th>
                    <td>
                        <?=$owners[0]->mobile?>
                    </td>
                </tr>
                <?php
                $landlord_count++;
            }
            ?>
        </table>
            <?php
        }

    if(isset($encroachers) && $encroachers){ 
        if($application->service_code == 13){
        ?>
    <div class="row mt-2">
        <div class="col-md-12">

            <strong>Riotee Details</strong>
        </div>
    </div>

    <table class="table table-bordered">
        <?php
        $riotee_count = 1;
        foreach($riotee as $riotee){
        ?>
        <tr>
            <th rowspan="3" style="vertical-align : middle;text-align:center;"><?=$riotee_count;?></th>
            <th style="width: 40%;">Khatian Number</th>
            <td>
                <?=$riotee[0]->khatian_no;?>
            </td>
        </tr>
        <tr>
            <th>Name</th>
            <td>
                <?=$riotee[0]->tenant_name;?>
            </td>
        </tr>
        <tr>
            <th>Father's name</th>
            <td>
                <?=$riotee[0]->tenants_father;?>
            </td>
        </tr>
        <?php 
        $riotee_count++;
        }
        ?>
    </table>
    <?php
    if(isset($riotee_noks) && $riotee_noks){ 
        ?>
     <div class="row mt-2">
        <div class="col-md-12">
            <strong>Riotee's NOK(This would be added to the Riotee khatian)</strong>
        </div>
    </div>
     <table class="table table-bordered">
        <?php
           foreach($riotee_nok as $riotee_nok){
           ?>
        <tr>
           <th rowspan="4" style="vertical-align : middle;text-align:center;"><?=$riotee_count;?></th>
           <th style="width: 40%;">Khatian Number</th>
           <td>
              <?=$khatian_no;?>
           </td>
        </tr>
        <tr>
           <th>Name</th>
           <td>
              <?=$riotee_nok->name_ass;?>
           </td>
        </tr>
        <tr>
           <th>Father's name</th>
           <td>
              <?=$riotee_nok->gurdian_name_ass;?>
           </td>
        </tr>
        <tr>
           <th>Relationship with Riotee</th>
           <td>
              <?php
                 if($riotee_nok->pdar_type == 'GP'){
                    echo "Grand Son/ Daughter";
                 }
                 if($riotee_nok->pdar_type == 'GGP'){
                   echo "Great Grand Son/ Daughter";
                 }
                 if($riotee_nok->pdar_type == 'P'){
                   echo "Son";
                 }
                 ?>
           </td>
        </tr>
        <?php 
           }
               ?>
     </table>
     <?php 
        }
          ?>

    <?php
        }else{
            ?>
            <div class="row mt-2">
                <div class="col-md-12">
                    <strong>Encroachers Details</strong>
                </div>
            </div>
            <table class="table table-bordered">
                <?php
                $enc_count = 1;

                foreach($encroachers as $riotee){

                    ?>

                    <tr>
                        <th rowspan="4" style="vertical-align : middle;text-align:center;"><?=$enc_count++;?></th>
                        <th>Dag No</th>
                        <td>
                            <?=$riotee->dag_no;?>
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>

                            <?php
                            if(isset($vlb_enc_details) && $vlb_enc_details){
                            foreach($vlb_enc_details as $enc){
                                foreach($enc as $e){
                                    ?>
                                        <?php
                                        if($e->id == $riotee->encroacher_id){
                                            echo $e->name;
                                        } ?>
                                <?php  }}}?>
                        </td>
                    </tr>
                    <tr>

                        <th>Father's Name</th>
                        <td>
                            <?=$this->utilityclass->getEncroacherDetails($riotee->encroacher_id);?>
                        </td>
                    </tr>
                    <tr>

                        <th>Possession From</th>
                        <td>
                            <?=$riotee->possession_date;?>
                        </td>


                    </tr>

                    <?php
                }
                ?>
            </table>
                <?php
        }
    }
  
    if(!empty($bhumi)){
    if($bhumi[0]->bhumi_cert_available || $bhumi[0]->is_bhumi_applied){?>
    <div class="row mt-2">
        <div class="col-md-12">
            <strong>Bhumiputra Certificate/Ack Details</strong>
        </div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th>Bhumiputra certificate/Ack verified?</th>
            <td>
                <?php if($bhumi[0]->is_valid == 'Yes'){echo "Yes";} ?>
                <?php if($bhumi[0]->is_valid == 'No'){echo "No";} ?>
            </td>
        </tr>
        <tr>
            <th>Certificate/Acknowledgement No</th>
            <td>
                <span class="alert-warning"><?=$bhumi[0]->bhumi_ack_no?></span>
            </td>
        </tr>
    </table>
    <?php } }?>


    <div class="row mt-2">
        <div class="col-md-12">
            <strong>Application Details</strong>
        </div>
    </div>
     <table class="table table-bordered">
        <?php if(isset($aadhar->is_aadhaar_verify)){ ?>
        <tr>
           <th>Aadhaar Verified</th>
           <td>
              <?php if ($aadhar->is_aadhaar_verify == '1') { echo 'Yes';}else{echo "No";}?>
           </td>
        </tr>
        <?php } ?>
        <?php 
        if($applicant == true){
            foreach($applicant as $applicant_details){
                if($applicant_details->is_applicant == '1'){
                    if(isset($applicant_details->possession_date) && $applicant_details->possession_date){
                    ?>
        <tr>
           <th>Period of Possession</th>
           <td>
                <?php echo $applicant_details->possession_date; ?>
           </td>
        </tr>
        <?php
           }}
           if($applicant_details->is_applicant == '1'){
               ?>
        <tr>
           <th>Occupation or Profession of the applicant</th>
           <td>
              <?=$applicant_details->applicant_occupation?>
           </td>
        </tr>
        <?php
           }
           if($applicant_details->is_applicant == '1'){
             ?>
        <tr>
           <th>Caste</th>
           <td>
              <?php
                 foreach(json_decode(CASTE) as $caste){
                     if($caste->CODE == $applicant_details->caste_category){
                       echo $caste->NAME;
                     }
                   }
                 ?>
           </td>
        </tr>
        <?php
           }
            if($applicant_details->is_applicant == '1'){
               if($applicant_details->tribe_category){
               ?>
               <tr>
                  <th>Select if you fall under protected category?</th>
                  <td>

                    <?php
                    foreach(json_decode(PROTECTED_CLASS) as $class){
                        ?>
                        <?php if($class->CODE == $applicant_details->tribe_category){echo $class->NAME;} ?>
                    <?php } ?>

                  </td>
               </tr>
               <?php
               }}
               if($applicant_details->is_applicant == '1'){

                  ?>
                  <tr>
                     <th>Whether land prayed for is within tribal belt/block ?</th>
                     <td>
                        <?php if($applicant_details->under_tribe_belts == '1'){echo "Yes";}?>
                        <?php if($applicant_details->under_tribe_belts != '1'){echo "No";}?>
                     </td>
                  </tr>
                  <?php
            }
           }
        }
        ?>
     </table>

    <div class="row mt-2">
        <div class="col-md-12">
            <strong>Area Details</strong>
        </div>
    </div>

    <?php
     if($application->service_code == 13){ 
        ?>
        <table class="table table-bordered">
        <?php 
        $dag_count_sl = 1;
        foreach($settlements as $settlementapp): 
           if ($settlementapp->is_applicant==1){?>
           <tr>
                <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$dag_count_sl++;?></th>
                <th>Dag Number</th>
                <td colspan="3">
                    <?=$settlementapp->dag_no?>
                </td>
            </tr>
            <tr>
                <th>Patta Number</th>
                <td colspan="3">
                    <?=$settlementapp->patta_no;?>
                </td>
            </tr>
            <tr>
                <th>Patta type</th>
                <td colspan="3">
                    <?=$settlementapp->patta_type?>
                </td>

            </tr>



           <?php } endforeach; ?>
           <tr>
              <th>Total Land Area in Selected Dag</th>
              <td>
                    Bigha : <?=$application->area_b?>
              </td>
              <td>
                 Katha : <?=$application->area_k?>
              </td>
              <td>
                 Lessa : <?=$application->area_l?>
              </td>
              <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
              <td>
                 Ganda : <?=$application->area_g?>
              </td>
              <td>
                 Kranti : <?=$application->area_kr?>
              </td>
              <?php endif ; ?>
           </tr>
           <?php $i=1; foreach($settlements as $settlement): 
           if ($settlement->is_applicant==1){?>
           <tr>
              <th>Total applied area</th>
              <td>
                 Bigha : <?=$settlement->mbigha?>
              </td>
              <td>
                 Katha : <?=$settlement->mkatha?>
              </td>
              <td>
                 Lessa : <?=$settlement->mlessa?>
              </td>
              <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
              <td>
                 Ganda : <?=$settlement->mganda?>
              </td>
              <td>
                 Kranti : <?=$settlement->mkranti?>
              </td>
              <?php endif ; ?>
           </tr>
           <?php $i++?>
           <?php } endforeach; ?>
        </table>
    <?php    
     }elseif($application->service_code == 14)
     {
        if(isset($applicant) && $applicant){
            ?>
        <table class="table table-bordered">
        <?php
        $dag_count_sl_ap = 1;
        foreach($applicant as $dags){
            if($dags->is_applicant==1){
            ?>
            <tr>
                <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$dag_count_sl_ap++;?></th>
                <th>Dag Number</th>
                <td colspan="3">
                    <?=$dags->dag_no?>
                </td>
            </tr>
            <tr>
                <th>Patta Number</th>
                <td colspan="3">
                    <?=$dags->patta_no;?>
                </td>
            </tr>
            <tr>
                <th>Patta type</th>
                <td colspan="3">
                    <?=$dags->patta_type?>
                </td>

            </tr>


                <tr>
                    <th>Total Land Area in Selected Dag</th>
                    <td>
                        Bigha : <?=$dags->applied_bigha?>
                    </td>
                    <td>
                        Katha : <?=$dags->applied_katha?>
                    </td>
                    <td>
                        Lessa : <?=$dags->applied_lessa?>
                    </td>
                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                            Ganda : <?=$dags->applied_ganda?>
                        </td>
                        <td>
                            Kranti : <?=$dags->applied_kranti?>
                        </td>
                    <?php endif ; ?>
                </tr>

                <tr>
                    <th class="text-danger">Total applied area</th>
                    <td>
                        Bigha : <?=$dags->mbigha?>
                    </td>
                    <td>
                        Katha : <?=$dags->mkatha?>
                    </td>
                    <td>
                        Lessa : <?=$dags->mlessa?>
                    </td>
                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                            Ganda : <?=$dags->mganda?>
                        </td>
                        <td>
                            Kranti : <?=$dags->mkranti?>
                        </td>
                    <?php endif ; ?>
                </tr>

                <?php } }}  ?>
            </table>
    <?php
     }
     else{

    $i=1;
    $total_home_bigha=0;
    $total_home_katha=0;
    $total_home_lessa=0;
    $total_home_ganda=0;
    $total_home_kranti=0;

    $total_agri_bigha=0;
    $total_agri_katha=0;
    $total_agri_lessa=0;
    $total_agri_ganda=0;
    $total_agri_kranti=0;

    $total_area_bigha = 1;
    $total_area_katha = 1;
    $total_area_lessa = 1;
    $total_area_ganda = 1;
    $total_area_kranti = 1;

    $total_area_agri_bigha = 1;
    $total_area_agri_katha = 1;
    $total_area_agri_lessa = 1;
    $total_area_agri_ganda = 1;
    $total_area_agri_kranti = 1;

    $dag_count_sl2 = 1;
    ?>
    <table class="table table-bordered">

    <?php
    foreach($encroachers as $dags){

        $total_home_bigha=$total_home_bigha+$dags->mbigha;
        $total_home_katha=$total_home_katha+$dags->mkatha;
        $total_home_lessa=$total_home_lessa+$dags->mlessa;
        $total_home_ganda=$total_home_ganda+$dags->mganda;
        $total_home_kranti=$total_home_kranti+$dags->mkranti;

        $total_agri_bigha=$total_agri_bigha+$dags->agri_bigha;
        $total_agri_katha=$total_agri_katha+$dags->agri_katha;
        $total_agri_lessa=$total_agri_lessa+$dags->agri_lessa;
        $total_agri_ganda=$total_agri_ganda+$dags->agri_ganda;
        $total_agri_kranti=$total_agri_kranti+$dags->agri_kranti;

        ?>
        <tr>
            <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$dag_count_sl2++;?></th>
            <th>Dag Number</th>
            <td colspan="3">
                <?=$dags->dag_no?>
            </td>
        </tr>
        <tr>
            <th>Patta Number</th>
            <td colspan="3">
                <?=$dags->patta_no;?>
            </td>
        </tr>
        <tr>
            <th>Patta type</th>
            <td colspan="3">
                <?=$dags->patta_type?>
            </td>

        </tr>

        <tr>
            <th>Total Land Area in Selected Dag</th>
            <td>
                Bigha: <?=$dags->applied_bigha?>
            </td>
            <td>
                Katha : <?=$dags->applied_katha?>
            </td>
            <td>
                Lessa : <?=$dags->applied_lessa?>
            </td>
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                <td>
                    Ganda : <?=$dags->applied_ganda?>
                </td>
                <td>
                    Kranti : <?=$dags->applied_kranti?>
                </td>
            <?php endif ; ?>
        </tr>
        <?php 
            if($dags->land_type == HOMESTEAD){
                ?>
            <tr>
        <?php
            }else{
        ?>
            <tr class="hide">
        <?php
            }
        ?>
            <th class="text-primary">Applied area (Homestead)</th>
            <td>
                Bigha : <?=$dags->mbigha?>
            </td>
            <td>
                Katha : <?=$dags->mkatha?>
            </td>
            <td>
                Lessa : <?=$dags->mlessa?>
            </td>
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                <td>
                    Ganda : <?=$dags->mganda?>
                </td>
                <td>
                    Kranti : <?=$dags->mkranti?>
                </td>
            <?php endif ; ?>
        </tr>

        <?php 
            if($dags->land_type == AGRICULTURAL){
                ?>
            <tr>
        <?php
            }else{
        ?>
            <tr class="hide">
        <?php
            }
        ?>
            <th class="text-primary">Applied area (Agricultural)</th>
            <td>
                Bigha : <?=$dags->agri_bigha?>
            </td>
            <td>
                Katha : <?=$dags->agri_katha?>
            </td>
            <td>
                Lessa : <?=$dags->agri_lessa?>
            </td>
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                <td>
                    Ganda : <?=$dags->agri_ganda?>
                </td>
                <td>
                    Kranti : <?=$dags->agri_kranti?>
                </td>
            <?php endif ; ?>
        </tr>


        <?php  }  ?>
    </table>
    <table class="table table-bordered">

        <?php 
            foreach($encroachers as $dags){
            if($dags->land_type == HOMESTEAD){
                ?>
            <tr>
        <?php
            }else{
        ?>
            <tr class="hide">
        <?php
            }}
        ?>
            <th class="text-danger">Total applied area (Homestead)</th>
            <td>
                Bigha : <?=$total_home_bigha?>
            </td>
            <td>
                Katha : <?=$total_home_katha?>
            </td>
            <td>
                Lessa : <?=$total_home_lessa?>
            </td>
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                <td>
                    Ganda : <?=$total_home_ganda?>
                </td>
                <td>
                    Kranti : <?=$total_home_kranti?>
                </td>
            <?php endif ; ?>
        </tr>

        <?php 
            foreach($encroachers as $dags){
            if($dags->land_type == AGRICULTURAL){
                ?>
            <tr>
        <?php
            }else{
        ?>
            <tr class="hide">
        <?php
            }}
        ?>
            <th class="text-danger">Total applied area (Agricultural)</th>
            <td>
                Bigha : <?=$total_agri_bigha?>
            </td>
            <td>
                Katha : <?=$total_agri_katha?>
            </td>
            <td>
                Lessa : <?=$total_agri_lessa?>
            </td>
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                <td>
                    Ganda : <?=$total_agri_ganda?>
                </td>
                <td>
                    Kranti : <?=$total_agri_kranti?>
                </td>
            <?php endif ; ?>
        </tr>

    </table>    
    <?php }?>

     <!-- additional property -->
     <?php if(isset($property) && !empty($property)) { ?>
     <div class="row mt-2">
        <div class="col-md-12">
            <strong>Additional Property Details</strong>
        </div>
     </div>

     <table class="table table-bordered">
        <?php $property_count=1; foreach($property as $adp): 
           ?>
        <tr>
           <th rowspan="7" style="vertical-align : middle;text-align:center;"><?=$property_count++;?></th>
           <th rowspan="5">
              Address of additional property
           </th>
           <th colspan="1">
              District -
           </th>
           <td colspan="2">
                <?=$adp->dist_name?>
           </td>
         </tr>
         <tr>
            <th colspan="1">
              Sub-division -
            </th>
            <td colspan="2">
              <?=$this->utilityclass->getSubDivName($adp->dist_code,$adp->subdiv_code)?>
            </td>
          </tr>
          <tr>
            <th colspan="1">
                Circle Name -
            </th>
            <td colspan="2">
              <?=$adp->cir_name?>
            </td>
          </tr>
          <tr>
            <th colspan="1">
                Mouza Name - 
            </th>
            <td colspan="2">
              <?=$this->utilityclass->getMouzaName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code)?>
            </td>
          </tr>
          <tr>
            <th colspan="1">
                Village Name - 
            </th>
            <td colspan="2">
              <?=$adp->vill_name?>
            </td>
          </tr>
        <tr>
           <th>Dag Number:</th>
           <td>
               <?=$adp->dag_no?>
           </td>
           <th>Patta Number:</th>
           <td>
                <?=$adp->patta_no;?>
           </td>
        </tr>
        <tr>
           <th>Total Additional Land Details</th>
           <td>
                Bigha : <?=$adp->bigha?>
           </td>
           <td>
                Katha : <?=$adp->katha?>
           </td>
           <td>
                Lessa : <?=$adp->lessa?>
           </td>
           <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
           <td>
                Ganda : <?=$adp->ganda?>
           </td>
           <td>
                Kranti : <?=$adp->kranti?>
           </td>
           <?php endif ; ?>
        </tr>
        
        <?php endforeach; 
    ?>
    </table>
    <?php
    } ?>

    <!-- additional property end -->
    <?php if(isset($nextKin) && $nextKin){ ?>
     <div class="row mt-2">
        <div class="col-md-12">
            <strong>Family details</strong>
        </div>
     </div>
     <table class="table table-bordered">
     <?php $kin_count=1; foreach($nextKin as $kin): ?>
        <tr>
           <th rowspan="4" style="vertical-align : middle;text-align:center;"><?=$kin_count++;?></th>
           <th>Name</th>
           <td>
              <?=$kin->next_of_kin_name?>
           </td>
        </tr>
        <tr>
           <th>Relation</th>
           <td>
              <?=$this->utilityclass->appRelationbyIDMB2($kin->relation_with_kin)
              ?>
           </td>
        </tr>
        <tr>
           <th>Address</th>
           <td>
              <?=$kin->address?>
           </td>
        </tr>
        <tr>
           <th>Mobile number</th>
           <td>
              <?=$kin->mobile_no?>
           </td>
        </tr>
        <?php endforeach;?>
     </table>
     <?php } ?>


     <?php
     if(isset($document) && $document){
     ?>
     <div class="row mt-2">
        <div class="col-md-12">
            <strong>Supporting Documents</strong>
        </div>
     </div>
     <table class="table">
        <?php foreach($document as $d): ?>
        <tr>
           <th>
              <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
           </th>
        </tr>
        <?php endforeach; ?>
     </table>
    <?php }?>


  
</div>