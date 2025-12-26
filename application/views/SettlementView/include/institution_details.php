<h5 class="reza-title">
    Institution Details (Filled by Citizen)
</h5>
<style type="text/css">
    .hide
    {
        display: none;
    }
</style>
<div class="tableCard">
    <?php
        if($ins_data == null){
            echo "No data found";
        }else{
            ?>
            <!-- <h5 class="reza-title" style="margin-top: 15px"><i class="fa fa-check"></i> Primary Information Entered by CO (চক্ৰ বিষয়া.-ৰ দ্বাৰা প্ৰবিষ্ট কৰা প্ৰাথমিক তথ্য)</h5>
            <div class="row p-2">
                
                <div class="col-md-6">
                    Category
                </div>
                <div class="col-md-6">
                    <b><?php if(isset($instituteDetails->category_name))
                    {
                        echo $instituteDetails->category_name;
                    } 
                    ?></b>
                </div>
                    
            </div>
            <div class="row p-2">
                <div class="col-md-6">
                    Name of the institution (English)
                </div>
                <div class="col-md-6">
                    <b><?php if(isset($instituteDetails->ins_name_co))
                    {
                        echo $instituteDetails->ins_name_co;
                    } 
                    ?>
                </b>
                </div>
                    
            </div>
            <div class="row p-2">
                <div class="col-md-6">
                    Name of the institution (অসমীয়া)
                </div>
                <div class="col-md-6">
                    <b><?php if(isset($instituteDetails->ins_name_assamese))
                    {
                        echo $instituteDetails->ins_name_assamese;
                    } 

                    ?>
                </b>
                </div>
                    
            </div>
            <?php 
                $stName = '';
                $stNameShowHide = "show";
                if($instituteDetails->ins_cat_type_co == 8 || $instituteDetails->ins_cat_type_co == 9)
                {
                    $stName = "State";
                    $stNameShowHide = "show";
                }
                else if($instituteDetails->ins_cat_type_co == 10 || $instituteDetails->ins_cat_type_co == 11)
                {
                    $stName = "Central";
                    $stNameShowHide = "show";
                }
                else
                {
                    $stNameShowHide = "hide";
                }
            ?>
            <div class="row p-2 <?=$stNameShowHide?>">
                <div class="col-md-6">
                    
                    <?=$stName?> Department/Undertaking Board (English)
                </div>
                <div class="col-md-6">
                    <b><?php if(isset($instituteDetails->dept_ministry_of_co) && $instituteDetails->dept_ministry_of_co != null)
                    {
                        echo $instituteDetails->dept_ministry_of_co;
                    }
                    else
                    {
                        echo "N/A";
                    }
                    ?>
                </b>
                </div>
            </div>
                    
          
            <div class="row p-2 <?=$stNameShowHide?>">
                <div class="col-md-6">
                   <?=$stName?> Department/Undertaking Board (অসমীয়া)
                </div>
                <div class="col-md-6">
                    <b><?php if(isset($instituteDetails->dept_ministry_of_co_assamese) && $instituteDetails->dept_ministry_of_co_assamese != null)
                    {
                        echo $instituteDetails->dept_ministry_of_co_assamese;
                    }
                    else
                    {
                        echo "N/A";
                    }
                    ?>
                </b>
                </div>
                    
            </div>
            <div class="row p-2">
                <div class="col-md-6">
                    Purpose of which land applied for
                </div>
                <div class="col-md-6">
                    <b><?php if(isset($instituteDetails->purpose_land_allot_co))
                    {
                        echo $instituteDetails->purpose_land_allot_co;
                    } 
                    else
                    {
                        echo "NA";
                    }
                    ?>
                    </b>
                </div>  
            </div> -->
            <table class="table table-bordered">
                <?php
                foreach($ins_data as $ins){
                    $hideSt = '';
                    $hideNs = '';
                    if($ins->ins_cat_type == '8' || $ins->ins_cat_type == '9' || $ins->ins_cat_type == '10' || $ins->ins_cat_type == '11')
                    {
                        $hideSt = "hide";
                    }
                    else
                    {
                        $hideNs = "hide";
                    }
                    ?>
                    <tr >
                        <th>Name of the institution applied for</th>
                        <td><b><?=$ins->ins_name?></b></td>
                    </tr>

                    <tr>
                        <th>Institution Category</th>
                        <td><b><?=$ins->category_name?></b></td>
                    </tr>
                    <tr>
                        <th>Purpose of Allotment /Land Transfer</th>
                        <td><b><?=$ins->purpose_land_allot?></b></td>
                    </tr>
                    <tr class="<?=$hideNs?>">
                        <th>Central/State/Non Govt</th>
                        <td><?=$ins->is_central_state=='cent' ? "Central Government" : ($ins->is_central_state=="pvt" ? "Non govt." : "State Government")?></td>
                    </tr>
                    <tr class="<?=$hideNs?>">
                        <th>Ministry of</th>
                        <td><?=$ins->ministry_of == null ? "N/A" : $ins->ministry_of?></td>
                    </tr>
                    <tr class="<?=$hideNs?>">
                        <th>Department of</th>
                        <td><?=$ins->dept_of == null ? "N/A" : $ins->dept_of?></td>
                    </tr>
                    <tr class="<?=$hideNs?>">
                        <th>Directorate of</th>
                        <td><?=$ins->director_of == null ? "N/A" : $ins->director_of?></td>
                    </tr>
                    <?php if($ins->ins_cat_type == 12){ ?>
                    <tr class="">
                        <th>Whether the entity/organization/institution etc is registered under the Societies Registration Act,1860 or under the Assam Cooperative Societies Act,2007(as amended) or under relevant Central or State government Act/Law:</th>
                        <td><?=$ins->justification_land_area == null ? "N/A" : $ins->justification_land_area?></td>
                    </tr>
                    <?php } ?>
                    <?php if($ins->ins_cat_type == 9){ ?>
                        <tr>
                            <th>Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals etc. like State Warehousing corporation(SWHC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme</th>
                            <td><?=$ins->is_under_state == 'Y' ? "Yes" : "No";?></td>
                        </tr>
                    <?php }else if($ins->ins_cat_type == 10){ ?>
                        <tr>
                            <th>Is the project/infrastructure under Central Govt Ministry/Department related to Health,Education & Skill Development</th>
                            <td><?=$ins->is_under_state == 'Y' ? "Yes" : "No";?></td>
                        </tr>
                    <?php }else if($ins->ins_cat_type == 11){ ?>
                        <tr>
                            <th>Is the Project/Infrastructure under Central Government Undertakings/Statutory Bodies/Parastatals etc. like Food Corporation of India(FCI), Central Warehousing corporation(CWC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme</th>
                            <td><?=$ins->is_under_state == 'Y' ? "Yes" : "No";?></td>
                        </tr>
                    <?php } ?>
                
                    <tr>
                        <th>Authorised Applicant Name</th>
                        <td><?=$ins->authorised_applicant_name?></td>
                    </tr>
                    <tr>
                        <th>Authorised Applicant Designation</th>
                        <td><?=$ins->authorised_applicant_desig?></td>
                    </tr>
                    <tr>
                        <th>Authorised Applicant Phone Number</th>
                        <td><?=$ins->authorised_applicant_phone_no?></td>
                    </tr>
                    <tr>
                        <th>Authorised Applicant Email</th>
                        <td><?=$ins->authorised_applicant_emailid?></td>
                    </tr>
                    <tr>
                        <th>Justification for the required area and location of the Project</th>
                        <td><?=$ins->justification_land_area?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Outcome of Project</th>
                        <td><?=$ins->outcomes_of_project?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>When and why is the Entity/ Organization/Institution formed ?</th>
                        <td><?=$ins->when_why?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Type of Entity/Organization/Institution</th>
                        <td><b><?=$ins->type_of_entity?></b></td>
                    </tr>
                    
                    <tr class="<?=$hideSt?>">
                        <th>Time frame for execution of the project</th>
                        <td><?=$ins->time_frame?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Source of funding</th>
                        <td><?=$ins->source_funding?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Activity for the last Three years</th>
                        <td><?=$ins->activity_three_years?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Whether the entity is a Profit Making Organization ?</th>
                        <td><?=$ins->profit_making?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Why the organization should not arrange land for its use on its own and government land, which is getting scarcer, be given to it</th>
                        <td><?=$ins->scarcer_land?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Name of the board of Director/Committee</th>
                        <td><?=$ins->board_of_members?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Justification for the required area and location of the Project/Infrastructure-Private Entities</th>
                        <td><?=$ins->justification_land_area_required?></td>
                    </tr>
                    
                    <tr class="<?=$hideSt?>">
                        <th>e-Kyc Name</th>
                        <td><?=$ins->ekyc_name?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Authentication Type</th>
                        <td><?=$ins->auth_type?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Present Address</th>
                        <td><?=$ins->pre_add?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>District</th>
                        <td><?=$ins->pre_dist_code?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>City</th>
                        <td><?=$ins->pre_city?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>PIN Number</th>
                        <td><?=$ins->pre_pin?></td>
                    </tr>
                    <tr>
                        <th>Other purpose of land alloted</th>
                        <td><?=$ins->other_purpose_land_allot?></td>
                    </tr>
                    
                    <tr class="<?=$hideSt?>">
                        <th>type_of_entity_description</th>
                        <td><?=$ins->type_of_entity_description?></td>
                    </tr>
                    <tr class="<?=$hideSt?>">
                        <th>Briefly provide description on the purpose</th>
                        <td><?=$ins->purpose_description?></td>
                    </tr>
                    <tr>
                        <th>Is the Institute Govt funded?</th>
                        <td><?=$ins->govt_funded?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        <?php
        }
    ?>
</div>