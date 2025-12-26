<div class="row p-2">
    <h5>CO Primary Information (Updation)</h5>
    <b style="color: red;">Note : asterisk marks are mandatory !!! </b>
</div>
<div class="row p-2">
    <div class="col-lg-4">
      <span><strong><i class="fa fa-angle-double-right"></i></strong> Category of non individual juridical entities <span style="color: red;">*</span></span>
    </div>
    <div class="col-lg-8">
        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="under_govt" id="under_govt1" value="cent">
            <label class="form-check-label" for="under_govt1">Central Govt.</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="under_govt" id="under_govt0" value="state">
            <label class="form-check-label" for="under_govt0">State Govt.</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="under_govt" id="under_govt0" value="pvt">
            <label class="form-check-label" for="under_govt0">Non Govt. Entity</label>
        </div>
                   
    </div>
</div> 
<div class="row p-2">
    <div class="col-lg-4">
        <span><strong><i class="fa fa-angle-double-right"></i></strong> Select Application for <span style="color: red;">*</span></span>
    </div>
    <div class="col-lg-8">
        <select class="form-select" name="application_type_state_central" id="application_type_state_central">
            <option></option>
        </select>
    </div>
</div>
<div class="row p-2" >
    <div class="col-lg-4">
        <strong><i class="fa fa-angle-double-right"></i></strong> Name of the institution <span style="color: red;">*</span>
    </div>
    <div class="col-lg-8">
        <input type="text" name="name_ins_co" id="name_ins_co" value="" class="form-control">
    </div>
</div>
<div class="row p-2" >
    <div class="col-lg-4">
        <label><strong><i class="fa fa-angle-double-right"></i></strong> Name of the institution (assamese) <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-8">
        <input type="text" name="name_ins_co_ass" id="name_ins_co_ass" value="" class="form-control">
    </div>
</div>
<div class="row p-2" id="ministry_department_checking" style="display: none;">
    <div class="col-lg-4" id="ministry_department_name_change">
    
        <label><strong><i class='fa fa-angle-double-right'></i></strong> Ministry <span style="color: red;">*</span></label>

    </div>
    <div class="col-lg-8">
        <!-- <input type="text" name="ministry_department_name_change" value="" class="form-control"> -->
        <select name="ministry_department_name_change" class="form-control" id="">
            <option value= "">--SELECT MINISTRY--</option>
            <?php $ministry = MINISTRY; foreach ($ministry as $key => $value) { ?>
                <option value="<?=$value;?>"><?=$value?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="row p-2" id="ins_checking" style="display: none;">
    <div class="col-lg-4" id="dept_name_change">
        <label><strong><i class='fa fa-angle-double-right'></i></strong> Department <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-8">

        <select name="dept_name_co" class="form-control" id="">
            <option value= "">--SELECT DEPARTMENT--</option>
            <?php $departmenet = DEPARTMENT; foreach ($departmenet as $key => $value) { ?>
                <option value="<?=$value;?>"><?=$value?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="row p-2" id="ins_checking_ass" style="display: none;">
    <div class="col-lg-4" id="dept_name_change_ass">
        <label><strong><i class='fa fa-angle-double-right'></i></strong> Department (Assamese) <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-8">
        <input type="text" name="dept_name_ass_co" value="" class="form-control">
    </div>
</div>



<div class="row p-2" id="directorate_checking" style="display: none;">
    <div class="col-lg-4" id="directorate_name_change">
        <label><strong><i class='fa fa-angle-double-right'></i></strong> Directorate/Commissionerate</label>
    </div>
    <div class="col-lg-8">
        <input type="text" name="directorate_name_change" value="" class="form-control">
    </div>
</div>

<div class="row p-2" id="state_dept_undertaking_checking" style="display: none;">
    <div class="col-lg-4" id="state_undertaking_name_change">
        <strong><i class="fa fa-angle-double-right"></i></strong> Undertaking Board name <span style="color: red;">*</span>
    </div>
    <div class="col-lg-8">
        <input type="text" name="state_dept_undertaking_name" value="" class="form-control">
    </div>
</div>




<div class="row p-2">
    <div class="col-lg-4" id="">
        <span><strong><i class="fa fa-angle-double-right"></i></strong> Purpose of which land applied for <span style="color: red;">*</span></span>
    </div>
    <div class="col-lg-8">

        <select class="form-control" name="purpose_co" id="purpose_co">

        </select>
    </div>
</div>


<div class="row p-2" id="other_subtype_details_div" style="display: none;">
    <div class="col-lg-4" id="">
        <span><strong><i class="fa fa-angle-double-right"></i></strong>Enter the subtype (i:e for Religious (Temple/Namghar/Kirtan Ghar etc.) for socio culture (youth club/sanmilan sangha/mahila samittee etc.)) <span style="color: red;">*</span></span>
    </div>
    <div class="col-lg-8">
 
        <select name="other_subtype_details_co" id="other_subtype_details_co" class="form-select">
            <option>--SELECT--</option>
            <?php $list = SUB_CAT;
             foreach ($list as $key => $value) { ?>
                <option value="<?=$value['id']?>"><?=$value['category_name']?></option>

            <?php } 
            ?>
        </select>
    </div>
</div>
<div class="row p-2" id="other_details_div" style="display: none;">
    <div class="col-lg-4" id="">
        <span><strong><i class="fa fa-angle-double-right"></i></strong>Enter other details <span style="color: red;">*</span></span>
    </div>
    <div class="col-lg-8">
        <input type="text" name="other_details_co" value="" class="form-control">
    </div>
</div>


<div class="row p-2" id="state_govt_undertaking" style="display: none;">
    <div class="col-lg-8" id="dept_name_change_ass">
        <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals etc. like State Warehousing corporation(SWHC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022  <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-4">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="state_warehousing_corporation"  id="inlineRadio1" value="Y">
            <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="state_warehousing_corporation" id="inlineRadio2" value="N">
            <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
        </div>
    </div>
</div>

<div class="row p-2" id="central_govt" style="display: none;">
    <div class="col-lg-8" id="dept_name_change_ass">
        <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development, within the meaning of DoR&DM Office Memorandum  No.ECF.106184/2019/9 dated 07-07-2021 <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-4">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="central_health_education_skill_sector"  id="inlineRadio1" value="Y">
            <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="central_health_education_skill_sector" id="inlineRadio2" value="N">
            <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
        </div>
    </div>
</div>

<div class="row p-2" id="central_govt_undertaking" style="display: none;">
    <div class="col-lg-8" id="dept_name_change_ass">
        <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals etc. like Food Corporation of India(FCI),Central Warehousing Corporation(CWC) etc which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022  <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-4">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="central_cwc_sector"  id="inlineRadio1" value="Y">
            <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="central_cwc_sector" id="inlineRadio2" value="N">
            <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
        </div>
    </div>
</div>

<div class="row p-2" id="non_govt_profit_making" style="display: none;">


    <div class="row p-2">
        <div class="col-md-6" style="color:#ff681d;font-weight: bold;">
            <i class="fa fa-arrow-circle-right"></i> Is the educational institution is venture school ?
        </div>
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input
                        class="form-check-input <?php if(form_error('under_venture_school_primary_info')){echo 'lm_invalid';}?>"
                        type="radio"
                        name="under_venture_school_primary_info"
                        id="under_venture_school_primary_info1"
                        value="YES"
                    <?php if(set_value('under_venture_school_primary_info') == 'YES'){ echo "checked";} ?>

                />
                <label class="form-check-label" for="inlineRadio1">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                        class="form-check-input <?php if(form_error('under_venture_school_primary_info')){echo 'lm_invalid';}?>"
                        type="radio"
                        name="under_venture_school_primary_info"
                        id="under_venture_school_primary_info2"
                        value="NO"
                    <?php if(set_value('under_venture_school_primary_info') == 'NO'){ echo "checked";} ?>
                />
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </div>  
    </div>
    <div class="row p-2 school_type_venture_govt_aided_primary_info" style="background: antiquewhite;border: 1px solid;">
        <div class="col-md-12">
            <div class="form-group">
               
                <label class="col-sm-3 checkbox-inline">
                    <input id="unrecognised_venture_primary_info"  name="unrecognised_venture_primary_info" type="checkbox" value="unrecognised_venture">unrecognised venture school</label>
                <label class="col-sm-6 checkbox-inline">
                    <input id="govt_aided_venture_primary_info" name="govt_aided_venture_primary_info"  type="checkbox" value="govt_aided_venture">Govt aided venture school which have recieved grants in aid for paying salary/wages for teachers from the state government for each of the last 3 financial years only will be provided with <span style="color:red">Allotment only</span></label>
            </div>
        </div>
    </div>

    <div id="non_profit_div">
        <div class="col-lg-8" id="dept_name_change_ass">
            <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Non Govt. Educational Institution of public nature which is devoted to public purposes and which yield no return to private individuals (non profit making) within the meaning of DoR&DM letter No RSR.9/88/Pt.II/64 dated 25-05-1999. <span style="color: red;">*</span></label>
        </div>
        <div class="col-lg-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="non_govt_profit_making_yes_no"  id="inlineRadio1" value="Y">
                <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="non_govt_profit_making_yes_no" id="inlineRadio2" value="N">
                <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
            </div>
        </div>
    </div>
</div>

<div class="row p-2 govt_entitites" style="display:none;">
    <div class="col-lg-8" id="">
        <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the  land applied for, is or will be used or  transferred for commercial purposes- please refer to section 16(b) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015 .<span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-4">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="transferred_for_commercial_purposes_reclassification_govt"  id="inlineRadio1" value="Y">
            <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="transferred_for_commercial_purposes_reclassification_govt" id="inlineRadio2" value="N">
            <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
        </div>
    </div>
</div>

<div class="row p-2 non_govt_entitites" style="display:none;">
    <div class="col-lg-8" id="">
        <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Land applied for used for religious or charitable purposes and other public utilities or amenities - please refer to section 16(e) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015 <span style="color: red;">*</span></label>
    </div>
    <div class="col-lg-4">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="religious_or_charitable_purposes_reclassification"  id="inlineRadio1" value="Y">
            <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="religious_or_charitable_purposes_reclassification" id="inlineRadio2" value="N">
            <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
        </div>
      
    </div>
    <div class="row p-2">
        <div class="col-md-6" style="color:#ff681d;font-weight: bold;">
            <i class="fa fa-arrow-circle-right"></i> Does the Institution fall under category of NGOs, Trusts, Local Bodies, Associations, Societies ?
        </div>
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input
                        class="form-check-input <?php if(form_error('under_ngo_trust_localbodies_primary_info')){echo 'lm_invalid';}?>"
                        type="radio"
                        name="under_ngo_trust_localbodies_primary_info"
                        id="under_ngo_trust_localbodies_primary_info1"
                        value="YES"
                    <?php if(set_value('under_ngo_trust_localbodies_primary_info') == 'YES'){ echo "checked";}?>

                />
                <label class="form-check-label" for="inlineRadio1">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                        class="form-check-input <?php if(form_error('under_ngo_trust_localbodies_primary_info')){echo 'lm_invalid';}?>"
                        type="radio"
                        name="under_ngo_trust_localbodies_primary_info"
                        id="under_ngo_trust_localbodies_primary_info2"
                        value="NO"
                    <?php if(set_value('under_ngo_trust_localbodies_primary_info') == 'NO'){ echo "checked";}?>
                />
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </div>  
    </div>
    <div class="row p-2 charter_activities_primary_info" style="display:none">
        <div class="col-md-6" style="color:#ff681d;font-weight: bold;">
            <i class="fa fa-arrow-circle-right"></i> Is the charter of activities are such that the institution considered as educational,religious and socioculture institution ?
        </div>
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input
                        class="form-check-input <?php if(form_error('under_charter_activities_primary_info')){echo 'lm_invalid';}?>"
                        type="radio"
                        name="under_charter_activities_primary_info"
                        id="under_charter_activities_primary_info1"
                        value="YES"
                    <?php if(set_value('under_charter_activities_primary_info') == 'YES'){ echo "checked";} ?>

                />
                <label class="form-check-label" for="inlineRadio1">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                        class="form-check-input <?php if(form_error('under_charter_activities_primary_info')){echo 'lm_invalid';}?>"
                        type="radio"
                        name="under_charter_activities_primary_info"
                        id="under_charter_activities_primary_info2"
                        value="NO"
                    <?php if(set_value('under_charter_activities_primary_info') == 'NO'){ echo "checked";} ?>
                />
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </div>  
    </div>
</div>
<script type="text/javascript">
    $('#ins_checking').hide();
    $('#ins_checking_ass').hide();
    $('#state_govt_undertaking').hide();
    $('#central_govt_undertaking').hide();

    $('.charter_activities_primary_info').hide();
    $("input:radio[name=under_ngo_trust_localbodies_primary_info]").click(function() {
        $('input:radio[name=under_charter_activities_primary_info]').prop('checked', false);
        var checkVal = $('input:radio[name=under_ngo_trust_localbodies_primary_info]:checked').val();
        if(checkVal == 'YES')
        {
            $('.charter_activities_primary_info').show();
        }
        else
        {
            $('.charter_activities_primary_info').hide();
        }
        
    });


    $('.school_type_venture_govt_aided_primary_info').hide();
    $('#non_profit_div').hide();
    $("input:radio[name=under_venture_school_primary_info]").click(function() {
        $('#unrecognised_venture_primary_info').prop('checked', false);
        $('#govt_aided_venture_primary_info').prop('checked', false);
        $('input:radio[name=non_govt_profit_making_yes_no]').prop('checked', false);
        var checkVal = $('input:radio[name=under_venture_school_primary_info]:checked').val();
        if(checkVal == 'YES')
        {
            $('.school_type_venture_govt_aided_primary_info').show();
            $('#non_profit_div').hide();
        }
        else
        {
            $('.school_type_venture_govt_aided_primary_info').hide();
            $('#non_profit_div').show();
        }
        
    });

    $(document).on('click', 'input[type="checkbox"]', function() {      
        $('input[type="checkbox"]').not(this).prop('checked', false);      
    });
    
    $('#application_type_state_central').change(function (e) {
        e.preventDefault()
        $('#ins_checking').show();
        $('#ins_checking_ass').show();
        $('#ministry_department_checking').hide();
        $('#directorate_checking').hide();
        $('.govt_entitites').hide();
        $('.non_govt_entitites').hide();
        var ins_id = $(this).val();
        if(ins_id == 8)
        {
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#directorate_checking').show();
            $('#state_dept_undertaking_checking').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#non_govt_profit_making').hide();
            $('#central_govt').hide();
            var allotment_purpose = <?php echo json_encode(STATE_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);



        }
        else if(ins_id == 9)
        {
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#state_dept_undertaking_checking').show();
            $('#state_govt_undertaking').show();
            $('#central_govt_undertaking').hide();
            $('#non_govt_profit_making').hide();
            $('#central_govt').hide();
            var allotment_purpose = <?php echo json_encode(STATE_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else if(ins_id == 10)
        {
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#ministry_department_checking').show();
            $('#state_dept_undertaking_checking').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#central_govt').show();
            $('#non_govt_profit_making').hide();
            var allotment_purpose = <?php echo json_encode(CENTRAL_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);

        }
        else if(ins_id == 11)
        {
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').show();
            $('#central_govt').hide();
            $('#non_govt_profit_making').hide();
            $('#state_dept_undertaking_checking').show();
            $('#ministry_department_checking').show();
            var allotment_purpose = <?php echo json_encode(CENTRAL_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else if(ins_id == 12)
        {
            $('.non_govt_entitites').show();
            $('#state_dept_undertaking_checking').hide();
            $('#ins_checking').hide();
            $('#ins_checking_ass').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#central_govt').hide();
            // $('#non_govt_profit_making').show();
            var allotment_purpose = <?php echo json_encode(NON_GOVT_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else
        {
            $('#ins_checking').hide();
            $('#ins_checking_ass').hide();
        }
    });

    $('#purpose_co').change(function (e) {
        $('#non_govt_profit_making').hide();
        $('#other_subtype_details_div').hide();
        $('#other_details_div').hide();
        $('input:radio[name=non_govt_profit_making_yes_no]').prop('checked', false);
        $('input:radio[name=under_venture_school_primary_info]').prop('checked', false);
        $('input:radio[name=under_ngo_trust_localbodies_primary_info]').prop('checked', false);
        $('input:radio[name=under_charter_activities_primary_info]').prop('checked', false);
        $('#unrecognised_venture_primary_info').prop('checked', false);
        $('#govt_aided_venture_primary_info').prop('checked', false);
        var purpose = $(this).val();
        if(purpose == 'other')
        {
            $('#other_details_div').show();
        }
        else if(purpose == 'education' && $('#application_type_state_central').val() == 12) 
        {
            $('#non_govt_profit_making').show();
            $('#other_details_div').hide();
        }
        else if(purpose == 'religious' || purpose=='socioculture')
        {
            $('#other_subtype_details_div').show();
        }
        else
        {
            $('#other_details_div').hide();
        }
    });

    

    $('#other_subtype_details_co').change(function (e) {
        $('#other_details_div').hide();
        var purpose = $(this).val();
        if(purpose == 50)
        {
            $('#other_details_div').show();
        }
        else
        {
            $('#other_details_div').hide();
        }
    });


    $("input:radio[name=under_govt]").click(function() {
        $('#ins_checking').hide();
        $('#ins_checking_ass').hide();
        var checkVal = $('input:radio[name=under_govt]:checked').val();
        var service  = $('#service_code_lm').val();
        const application = {
            checkVal     : checkVal,
            service : service
        };
        $.ajax({
            url: '<?=base_url()?>index.php/SettlementInstitutionCo/getProjectDetails',
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                console.log(data);

                var html = "<option value='-1'>Select application details</option>";
                for (var i = 0; i < data.result.length; i++) {
                    html =
                        html +
                        "<option value='" +
                        data.result[i].id +
                        "'>" +
                        data.result[i].category_name +"</option>";
                }
                $("#application_type_state_central").html(html);
            },
            data: JSON.stringify(application)
        });
    });
</script>