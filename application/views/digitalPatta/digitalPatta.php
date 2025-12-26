<style>
    .bg-cross{
        background-image:url('<?php echo base_url(); ?>application/views/images/crossword.png');
    }
    .logo{
        height : 15%!important; 
        width : 15%!important;
        text-align :center!important;
    }
    .logoEmblem{
        height:100%!important;
        width:100%!important;
    }
    .logoBorder{
        border:0px;
    }
</style>

<div class="modal" id="digital_patta_modal">
<div class="col-lg-10 offset-1">
    
    <div class="bg-cross" id="print_div" style="font-size:10px">                        
        <div class="panel-body mt-5">  
            
            <!-- heading row(logo) -->
            <table>
                <tbody>
                    <tr>                            
                        <td class="logo logoBorder" style="text-align:center">
                            <img src='<?php echo base_url(); ?>assets/digital_patta/basundhara_white_logo.png'height="100" width="100">
                        </td>
                        <td class="logoBorder logoEmblem" style="text-align:center">
                            <img src='<?php echo base_url(); ?>assets/digital_patta/emblem.png' height="100" width="100"> 
                        </td>
                        <td class="logo logoBorder" style="text-align:center">
                            <!-- <img src='<?php echo base_url(); ?>assets/digital_patta/dummy_qr.png' height="100" width="100"> -->
                            <img src="<?php echo $base_64_qr ?>" height="100px" width="100px">                    
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="himanxu-margin-top">
                <tbody style="table-width:100%;text-align:right">
                    <tr class="logoBorder" style="table-width:100%;text-align:right"> 
                        <td class="logoBorder" style="width:80%">&nbsp;</td>
                        <td class="logoBorder" style="width:30px"> &nbsp;</td>
                        <td class="logoBorder">DATE OF ISSUE: <?=DIGITAL_PATTA_PATTA_INFO_DATE_OF_ISSUE?></td>
                    </tr>
                <tbody>
            </table>
            
            <!-- header 1  -->
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 text-center " style="text-align:center">
                    <span class="text-danger">
                        OFFICE OF THE DISTRICT COMMISSIONER,&nbsp;<b><?=$this->digitalPattaLocationModel->getDistrictNameEng($patta_info['settlement_basic_details']->dist_code)?></b>
                    </span>
                </div>                
                <div class="col-lg-2"></div>
            </div>
            <!-- header 2  -->
            <div class="row mt-3 ">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div class="text-black p-1 text-center " style="text-align:center">
                        <span class="font-weight-bold digital_patta_heading">
                            <u><?=$this->digitalPattaLocationModel->getPattaType($patta_info['chitha_basic'][0]->patta_type_code)?> PATTA</u>
                        </span>
                        <br>(Issued under Section 40 of Assam Land and Revenue Regulation, 1886)
                    </div>                    
                </div>                
            </div>  
            
            <!-- primary land holder details -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered himanxu-table-width-100  himanxu-heading-weight">
                        <tr>
                            <td colspan='9' style="text-align:center " class="himanxu_header_red himanxu_font_bold_heading" >
                                <b>PRIMARY LAND HOLDER DETAILS</b>  
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <b>Name</b>
                            </td>
                            <td>
                                <b>Address</b>
                            </td>
                            <td>
                                <b>Gender</b>
                            </td>
                            <td>
                                <b>Father/Mother/Spouse/Guardian Name</b>
                            </td>
                            <td>
                                <b>Category</b>
                            </td>
                            <td>
                                <b>Date of Birth</b>
                            </td>
                            <td>
                                <b>Current Occupation</b>
                            </td>
                            <td>
                                <b>Aadhaar No.</b>
                            </td>
                            <td>
                                <b>Remarks</b>
                            </td>
                        </tr>
                        
                        <tbody>
                            
                            <tr>
                                <td><?=$patta_info['chitha_pattadar_applicant_data']->pdar_name_eng?></td>
                                <td><?=$patta_info['chitha_pattadar_applicant_data']->pdar_add1?></td>
                                <td>
                                    <?php 
                                        if($patta_info['applicant_data']->settlement_gender == 1){
                                            $gender = "MALE";
                                        }elseif($patta_info['applicant_data']->settlement_gender == 2){
                                            $gender = "FEMALE";
                                        }elseif($patta_info['applicant_data']->settlement_gender == 3){
                                            $gender = "OTHERS";
                                        }else{
                                            $gender = "--";
                                        }
                                    ?>
                                    <?= $gender?>
                                </td>
                                <td><?=$patta_info['applicant_data']->settlement_guardian_eng?></td>
                                <!-- <td>
                                    <?php
                                        $maritial_status_arr = json_decode(MARITAL_STATUS);                                       
                                        foreach($maritial_status_arr as $maritial_status){
                                            if($maritial_status->CODE == $patta_info['applicant_data']->marital_status){
                                                $maritial_status_str = $maritial_status->NAME;
                                            }
                                        }
                                    ?>
                                    <?=$maritial_status_str?>
                                </td> -->
                                
                                <td>
                                    <?php
                                        $caste_arr = json_decode(CASTE);
                                        foreach($caste_arr as $caste){
                                            if($caste->CODE == $patta_info['chitha_pattadar_applicant_data']->pdar_caste){
                                                $caste_str = $caste->NAME;
                                            }
                                        }
                                    ?>
                                    <?=$caste_str?>
                                </td>
                                <td><?=date('d-m-Y',strtotime($patta_info['applicant_data']->settlement_dob))?></td>
                                <td><?=$patta_info['settlement_basic_details']->occupation_applicant?></td>
                                <?php if(!isset($patta_info['chitha_pattadar_applicant_data']->mask_id) || $patta_info['chitha_pattadar_applicant_data']->mask_id == null): ?>
                                    <td>--</td>
                                <?php else : ?>                          
                                    <td>********<?=$patta_info['chitha_pattadar_applicant_data']->mask_id?></td>
                                <?php endif ?>
                                
                                <td>--</td>
                            </tr>
                        </tbody>
                    </table>                  
                </div>
            </div>

            <!-- joint land holder details -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                     <!-- joint land holder heading -->
                    <table class="table table-bordered  himanxu-heading-weight himanxu-table-width-100">
                        <tr>
                            <td colspan='9' style="text-align:center" class="himanxu_header_red">
                                <b>JOINT LAND HOLDER DETAILS</b>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <b>Name</b>
                            </td>
                            <td>
                                <b>Gender</b>
                            </td>
                            <td>
                                <b>Father/Mother/Spouse/Guardian Name</b>
                            </td>
                            <td>
                                <b>Category</b>
                            </td>
                            <td>
                                <b>Date of Birth</b>
                            </td>
                            <td>
                                <b>Current Occupation</b>
                            </th>
                            <td>
                                <b>Relationship with <br>
                                primary land holder <br>
                                </b>
                            </td>
                            <td>
                                <b>Aadhaar No</b>
                            </td>
                            <td>
                                <b>Remarks</b>
                            </td>
                        </tr>
                        
                        <tbody>
                            <?php foreach ($patta_info['joint_applicant_data'] as $joint_applicant):?>
                                <tr>
                                    <td><?=$joint_applicant->pdar_name_eng?></td>
                                    <td>
                                        <?php 
                                            if(trim($joint_applicant->pdar_gender) == 'm'){
                                                $gender = "MALE";
                                            }elseif(trim($joint_applicant->pdar_gender) == 'f'){
                                                $gender = "FEMALE";
                                            }else{
                                                $gender = "--";
                                            }
                                        ?>
                                        <?= $gender?>
                                    </td>
                                    <td><?=$joint_applicant->pdar_guard_eng?></td> 
                                    <td>
                                        <?php 
                                            if(isset($joint_applicant->pdar_caste) && trim($joint_applicant->pdar_caste) !=""){
                                                $caste_arr = json_decode(CASTE);
                                                foreach($caste_arr as $caste){
                                                    if($caste->CODE == $joint_applicant->pdar_caste){
                                                        $caste_str = $caste->NAME;
                                                    }
                                                }
                                            }else{
                                                $caste_str = "--";
                                            }
                                        ?>
                                        <?=$caste_str;?>
                                    </td> 
                                    <td><?=date('d-m-Y',strtotime($joint_applicant->dob))?></td>                                    
                                    
                                    <td>--</td>
                                    
                                    <td>
                                    <?php 
                                        $relation ='';
                                        if($joint_applicant->pdar_guard_reln == 'h'){
                                            $relation = "SPOUSE";
                                        }elseif($joint_applicant->pdar_guard_reln == 'm'){
                                            $relation = "MOTHER";
                                        }elseif($joint_applicant->pdar_guard_reln == 'f'){
                                            $relation = "FATHER";
                                        }elseif($joint_applicant->pdar_guard_reln == 'w'){
                                            $relation = "SPOUSE";
                                        }elseif($joint_applicant->pdar_guard_reln == 'a'){
                                            $relation = "SUPDT. MOTHER";
                                        }else{
                                            $relation = "GUARDIAN";
                                        }
                                    ?>
                                        <?=$relation?>
                                    </td>
                                    <td><?=DIGITAL_PATTA_AADHAAR_NO?></td>
                                    <td>--</td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>                  
                </div>
            </div>
            
            <!-- family details -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered himanxu-table-width-100  himanxu-heading-weight himanxu_body_color_green">
                        <!-- family heading -->
                        <tr>
                            <td colspan='6' style="text-align:center" class="himanxu_header_red">
                                <b>FAMILY DETAILS</b>
                            </td>
                        </tr>
                        
                            <tr class="himanxu_color_blue">
                                <td class="himanxu_color_blue">
                                    <b>Name</b>
                                </td>
                                <td class="himanxu_color_blue">
                                    <b>DOB</b>
                                </td>
                                <td class="himanxu_color_blue">
                                    <b>Gender</b>
                                </td>                        
                                <td class="himanxu_color_blue">
                                    <b>Relationship with <br>
                                        primary land holder <br>
                                    </b>
                                </td>
                                <td class="himanxu_color_blue">
                                    <b>Aadhaar No.</b>
                                </td>
                                <td class="himanxu_color_blue">
                                    <b>Remarks</b>
                                </td>
                            </tr>
                        
                        <tbody>
                            <?php foreach ($patta_info['family_details'] as $family_details):

                                $rel = $family_details->nominee_relation;
                                if($rel == 1){ 
                                    $relation = 'Mother';
                                }else if($rel == 2){
                                    $relation = 'Father'; 
                                }else if($rel == 3){
                                    $relation = 'Husband'; 
                                }else if($rel == 4){
                                    $relation = 'Wife'; 
                                }else if($rel == 5){
                                    $relation = 'Guardian';
                                }else if($rel == 6){
                                    $relation = 'Supdt.Mother'; 
                                }else if($rel == 7){
                                    $relation = 'Guardian'; 
                                }
                            ?>
                                <tr>
                                    <td><?=$family_details->nominee_name?></td>                                    
                                    <td><?='--'?></td> 
                                    <td><?='--'?></td>
                                    <td><?=$relation?></td>
                                    <td><?=DIGITAL_PATTA_AADHAAR_NO?></td> 
                                    <td>--</td> 
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>                  
                </div>
            </div>
            <!-- Land Description -->
            
            <!-- LAND SCHEDULE DETAILS  -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered himanxu_body_color_purple himanxu-table-width-100">
                        <tr>
                            <td colspan='6' style="text-align:center " class="himanxu_header_red">
                                <b>LAND DESCRIPTION</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='6' style="text-align:center " class="himanxu_header_red">
                                <b>LAND SCHEDULE DETAILS</b> 
                            </td>
                        </tr>
                        <tbody>
                            <tr>
                                <td><b>District</b></td>
                                <td><?=$this->digitalPattaLocationModel->getDistrictNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code)?></td>
                                <td><b>Sub-Division</b></td>
                                <td>
                                    <?=$this->digitalPattaLocationModel->getSubDivNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                    $patta_info['chitha_pattadar_applicant_data']->subdiv_code)?>
                                </td>
                                <td><b>Circle</b></td>
                                <td>
                                    <?=$this->digitalPattaLocationModel->getCircleNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                    $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code)?>
                                </td>                                
                            </tr>
                            <tr>
                                <td><b>Mouza</b></td>
                                <td>
                                    <?=$this->digitalPattaLocationModel->getMouzaNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                    $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code,
                                    $patta_info['chitha_pattadar_applicant_data']->mouza_pargona_code)?>
                                </td>
                                <td><b>Lot</b></td>
                                <td>
                                    <?=$this->digitalPattaLocationModel->getLotNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                    $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code,
                                    $patta_info['chitha_pattadar_applicant_data']->mouza_pargona_code, $patta_info['chitha_pattadar_applicant_data']->lot_no)?>
                                </td>
                                <td><b>Village</b></td>
                                <td>
                                    <?=$this->digitalPattaLocationModel->getVillageNameEng($patta_info['chitha_pattadar_applicant_data']->dist_code,
                                    $patta_info['chitha_pattadar_applicant_data']->subdiv_code, $patta_info['chitha_pattadar_applicant_data']->cir_code,
                                    $patta_info['chitha_pattadar_applicant_data']->mouza_pargona_code, $patta_info['chitha_pattadar_applicant_data']->lot_no,
                                    $patta_info['chitha_pattadar_applicant_data']->vill_townprt_code)?>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <b>Dag No. (old)</b>
                                </td>
                                <td rowspan="2">
                                    <b>Dag No. (New)</b>
                                </td>
                                <td rowspan="2">
                                    <b>Land Class</b>
                                </td>
                                <td colspan="3" style="text-align:center">
                                    <b>Area</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>B-K-L /B-K-C-G</b>
                                </td>
                                <td colspan="2">
                                    <b>Hec-Are-Cen</b>
                                </td>
                            </tr>
                            <?php foreach ($patta_info['chitha_basic'] as $chitha_basic):?>
                            <tr>
                            
                                <td>
                                    <?=$chitha_basic->old_dag_no?>
                                </td>
                                <td>
                                    <?=$chitha_basic->dag_no?>
                                </td>
                                <td>
                                    <?=$this->digitalPattaLocationModel->getLandClassCode($chitha_basic->land_class_code);?>
                                </td>
                                <?php 
                                $bigha = $chitha_basic->dag_area_b;
                                $kotha = $chitha_basic->dag_area_k;
                                $lessa = $chitha_basic->dag_area_lc;
                                ?>
                                <td><?=$bigha?> Bigha <?=$kotha?> Katha <?=$lessa?> lessa</td>
                                <?php 
                                $location_data = $this->digitalPattaLocationModel->get_Hec_Are_CAre($bigha,$kotha,$lessa)
                                ?>
                                <td colspan="2"><?=$location_data['hec']?> Hec <?=$location_data['are']?> Are <?=$location_data['Care']?> Cen</td>
                                
                            </tr>
                            <?php endforeach;?>
                            
                            <tr>
                                <td></td>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                                <td></td>
                                <td></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>                  
                </div>
            </div>

            <!-- LAND ATTRIBUTES -->
            <div class="row ">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered himanxu-table-width-100 himanxu_body_color_purple">
                    <?php foreach ($patta_info['chitha_basic'] as $chitha_basic):?>    
                    <tr>
                            <td colspan='5' style="text-align:center " class="himanxu_header_red">
                                <b>LAND ATTRIBUTES</b>
                            </td>
                        </tr>
                        <tr>                       
                            <td rowspan="2">Patta No</td>
                            <td>Old</td>
                            <td>New</td>
                            <td>Land Revenue</td>
                            <td><?=$chitha_basic->dag_revenue?></td>
                        </tr>
                        <tr>
                            <td><?=$chitha_basic->old_patta_no?></td>
                            <td><?=$chitha_basic->patta_no?></td>
                            <td>Local Rate</td>
                            <td><?=$chitha_basic->dag_local_tax?></td>
                        </tr>
                        <tr>
                            <td>Patta Type</td>
                            <td colspan="2"><?=$this->digitalPattaLocationModel->getPattaType($chitha_basic->patta_type_code)?></td>
                            <td>Total</td>
                            <td><?=$chitha_basic->dag_revenue + $chitha_basic->dag_local_tax?></td>
                        </tr>
                        <?php endforeach;?>
                        <tr>
                            <b><td class="himanxu_header_red">Tenure</td></b>
                            <td colspan="4">The terminal date of settlement will be <?=DIGITAL_PATTA_TERMINAL_DATE?>, or as modified by Govt. of Assam.</td>                                                             
                        </tr>
                    </table>                  
                </div>
            </div>
            <!-- property Details -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered himanxu_body_color_blue himanxu-table-width-100">
                        <tr>
                            <td colspan='6' style="text-align:center " class="himanxu_header_red">
                                <b>LAND LOCATION DETAILS</b>
                            </td>
                        </tr>                        
                        <tbody> 
                        <?php foreach ($patta_info['chitha_basic'] as $chitha_basic):?>                           
                            <tr>
                                 
                                <td rowspan="3">Boundary Description</td>
                                <td rowspan="3">Dag No (New) <?=$chitha_basic->dag_no?></td>
                                <td>North</td>
                                <td>South</td>
                                <td>East</td>
                                <td>West</td>
                            </tr>
                            <tr>
                                <td><?=$chitha_basic->dag_n_desc?></td>
                                <td><?=$chitha_basic->dag_s_desc?></td>
                                <td><?=$chitha_basic->dag_e_desc?></td>
                                <td><?=$chitha_basic->dag_w_desc?></td>
                            </tr>
                            <tr>
                                <td><?=$chitha_basic->dag_n_dag_no?></td>
                                <td><?=$chitha_basic->dag_s_dag_no?></td>
                                <td><?=$chitha_basic->dag_e_dag_no?></td>
                                <td><?=$chitha_basic->dag_w_dag_no?></td>
                            </tr>
                            <?php endforeach;?>
                            <tr>
                                <td colspan="3">
                                    ULPIN*/Geo-coordinates
                                </td>
                                <td colspan="3">
                                    Land Schedule Sketch (Link)
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="3">
                                Latitude: <?=$patta_info['co_ordinates']->lat?>
                                &nbsp;<br>
                                Longitude: <?=$patta_info['co_ordinates']->long?>
                                </td>
                                <td colspan="3" style="text-align:center">
                                    <img src=" <?php echo $dag_sketch_qr_code ?>" alt="qr_code" height="100px" width="100px">                                
                                    <!-- <img src="<?php echo base_url(); ?>assets/digital_patta/dummy_qr.png" class="img-thumbnail" width="50" height="50"> -->
                                </td>
                            </tr>
                            
                            <tr class="himanxu_body_color_maroon">
                                <td>
                                    <b>Encumbrance Details<br> (If any)</b>
                                </td>
                                <td colspan="6">
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>            
                </div>                
            </div>
            
            <!-- Photo -->
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered himanxu-table-width-100 himanxu_body_color_maroon">
                        <tbody> 
                            <tr class="text-center " style="text-align:center">
                                <th colspan="6">Photo</th>
                            </tr>
                            <?php
                                $all_photo_datas = [];
                                $primary_applicant_data = $patta_info['chitha_pattadar_applicant_data'];
                                $join_applicants = $patta_info['joint_applicant_data'];
                                if($patta_info['applicant_data']->identity_type == 'AADHAAR'){
                                    $all_photo_datas[] = [
                                        'name' => $primary_applicant_data->pdar_name_eng,
                                        'case_no' => $primary_applicant_data->o1_case_no,
                                        'photo' => $this->digitalPattaPhotoModel->getPrimaryLandHolderImg($patta_info['settlement_applicant'],$patta_info['applicant_data']->ord_no),
                                        'is_primary_applicant' => true
                                    ];
                                }else{
                                    $all_photo_datas[] = [
                                        'name' => $primary_applicant_data->pdar_name_eng,
                                        'case_no' => $primary_applicant_data->o1_case_no,
                                        'photo' => 'Photo will be available only through AADHAAR authentication',
                                        'is_primary_applicant' => true
                                    ];
                                }
                                

                                if(count($join_applicants) > 0){
                                    foreach($join_applicants as $join_applicant){
                                        $all_photo_datas[] = [
                                            'name' => $join_applicant->pdar_name_eng,
                                            'case_no' => $primary_applicant_data->o1_case_no,
                                            'photo' => '<img src="'. base_url('assets/digital_patta/dummy.png') .'" class="img-thumbnail" width="100" height="80">',
                                            'is_primary_applicant' => false
                                        ];
                                    }
                                }

                                $photosByGroup =[];
                                $array_key = 0;
                                foreach($all_photo_datas as $key => $photo){
                                    if($key != 0 && $key % 5 == 0){
                                        $array_key++;
                                    }
                                    $photosByGroup[$array_key][] = $photo;
                                }
                            ?>
                            <?php
                                foreach($photosByGroup as $photoDatas):
                            ?>
                                <tr>
                                    <?php
                                        foreach($photoDatas as $photo):
                                    ?>

                                        <td>
                                            <?=$photo['name']?> <br>
                                            <?php if($photo['is_primary_applicant']):?>
                                                (Primary Land Holder)
                                            <?php else: ?>
                                                (Joint Land Holder)
                                            <?php endif; ?>
                                            <?=$photo['photo']?>
                                        </td>
                                        
                                    <?php
                                        endforeach;
                                    ?>
                                </tr>
                            <?php
                                endforeach;
                            ?>   
                            <tr>                                
                                <td colspan="6" class="text-center " style="text-align:left">(Once AADHAR authentication is done, photo will be auto-fetched)</td>                                
                            </tr>
                        </tbody>
                    </table>            
                </div>                
            </div>
            <!-- signature heading  -->
            <div class="row mt-5 himanxu-margin-top">
                <div class="col-lg-6"></div>
                <div class="col-lg-6 text-center "style="text-align:right">
                    <b>Issuing Authority : </b> <b>District Commissioner/ Settlement Officer</b><br>
                    <!-- <?php $soName = $this->DigitalPattaCommonModel->getDscSignAuthorName($patta_info['chitha_basic'][0]->dist_code);?> -->
                    <?php $iAName = $this->DigitalPattaCommonModel->getIssuingAuthName($patta_info['chitha_basic'][0]->dist_code);?>
                    <b><?=$iAName?></b>
                </div>
            </div>
            <!-- note -->
            <div class="row mt-5 himanxu-margin-top">
                <div class="col-lg-1"></div>
                <div class="col-lg-9" style="font-size:12px;text-align:center">
                <span style="font-style: italic;">Note: This is a digitally generated document and does not require to be signed as per section 3(1) of IT Act, 2000.</span>              
                </div>                
            </div>
            <!-- Terms and conditions -->
            <div class="row himanxu-margin-top">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <h3 style="text-align:center"><b>TERMS AND CONDITIONS</b></h3>
                    <table class="table table-bordered himanxu-table-width-100">
                        <tr>
                            <td>
                                <b style="text-align:center">Sl. NO</b>
                            </td>
                            <td>
                                <b style="text-align:center">Terms And Conditions</b>
                            </td>
                            <!-- <td>
                                <b style="text-align:center">Categories to<br> which the Terms and <br>Conditions are Common</b>
                            </td> -->
                        </tr>
                        
                        <!-- To get the terms and condition data -->
                        <?php
                            $terms_and_condition = $this->digitalPattaTACModel->getTermsAndConditions($patta_info['settlement_basic_details']->service_code);
                        ?>
                        <?php 
                        $count= 1;
                        $simCount = 1;
                        $cat_name = null;
                        $cat_sim ='';

                        foreach ($terms_and_condition as $row):
                            $cat_name = $this->digitalPattaTACModel->getCatergoryNamesFromId($row->cat_id);
                            $cat_spn = $this->digitalPattaTACModel->rowSpanCC($row->cat_id);

                            if($cat_name == $cat_sim)
                            {
                                $simCount++;
                            }
                            else
                            {
                                $simCount = 1;
                            }
                            ?>
                            <tr>
                                <td><?=$count++ ?></td>
                                <td><?=$row->terms_and_conditions?></td>

                                <?php
                                    if($simCount == 1)
                                    {
                                        ?>  
                                            <td rowspan="<?=$cat_spn?>"><?=$cat_name?></td>
                                        <?php
                                    }

                                ?>

                            </tr>
                            <!-- <br> -->
                            <?php 
                            $cat_sim = $cat_name;
                            endforeach;
                            ?>
                    </table>                  
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="col-md-12 mt-3" style="text-align:center">
    <button type="button" class="btn btn-danger himanxuNotShowButton" id="modal-close">Close &times; </button>
</div>

<script>
    //function to close modal 
    $(document).on('click', '#modal-close', function () {
        $('#digital_patta_modal').hide('300');
    });
</script>




