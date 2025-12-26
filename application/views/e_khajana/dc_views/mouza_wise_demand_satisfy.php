<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>">E-Khajana(Mouza-wise-demand-satify)</a></li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-danger panel-form">
            <div class="panel-heading">
                <h3 class="panel-title" style="text-align: center; font-weight: bold;">
                    <span>E-Khajana(Demand-Satisfy-Info)</span>                                
                </h3>
            </div>
        </div>
        <div class="panel panel-dark panel-form" style="margin-top:-20px;">            
            <div class="panel-heading">
                <h6 class="panel-title" style="text-align: center; font-weight: bold;">
                    <span>District Name: <?=$this->utilityclass->getDistrictName($dist_code)?></span>                                
                </h6>
            </div>
        </div>
        <div class="panel-body" style="font-size:18px!important;margin-top:-20px;">
            <div class="panel-heading bg-info text-white">
                <h6 class="panel-title text-white" style="text-align: center; font-weight: bold;font-size:15px">
                    ADD DEMAND SATISFACTION YEAR MOUZA WISE
                </h6>
            </div>
            <table class="table table-striped table-bordered">
                <tr class="bg-secondary">
                    <td>Subdivison</td>
                    <td>Circle</td>
                    <td>Mouza</td> 
                    <td>Up To Which Year Demand Satisfied</td>
                    <td>Demand Satisfied Certificate</td>
                    <td>Action</td>
                </tr>
                <tr class="" style="font-size:12px">
                    <td>
                        <select class="form-control" name="" id="subdiv_code_dsm" onchange="getCircleListInDSM()">
                            <option value="" selected>--SELECT-SUBDIVISON--</option>
                            <?php foreach ($subdiv_list as $subdiv_details):?>   
                                <option value="<?=$subdiv_details->subdiv_code?>"><?=$subdiv_details->loc_name?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="" id="circle_code_dsm" onchange=getMouzaListDSM()>
                            <option value="" selected>--SELECT-CIRCLE--</option>                            
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="" id="mouza_code_dsm">
                            <option value="" selected>--SELECT-MOUZA--</option>                            
                        </select>
                    </td>
                    <td>
                        <select class="form-control"name="" id="year_dsm">
                            <option value="">--SELECT-UP-WHICH-DEMAND-IS-SATISFIED--</option>
                            <option value="2000-2001">--UP-TO-YEAR-(2000-2001)--</option>
                            <option value="2001-2002">--UP-TO-YEAR-(2001-2002)-</option>
                            <option value="2002-2003">--UP-TO-YEAR-(2002-2003)-</option>
                            <option value="2003-2004">--UP-TO-YEAR-(2003-2004)-</option>
                            <option value="2004-2005">--UP-TO-YEAR-(2004-2005)--</option>
                            <option value="2005-2006">--UP-TO-YEAR-(2005-2006)-</option>
                            <option value="2006-2007">--UP-TO-YEAR-(2006-2007)-</option>
                            <option value="2007-2008">--UP-TO-YEAR-(2007-2008)-</option>
                            <option value="2008-2009">--UP-TO-YEAR-(2008-2009)-</option>
                            <option value="2009-2010">--UP-TO-YEAR-(2009-2010)-</option>
                            <option value="2010-2011">--UP-TO-YEAR-(2010-2011)-</option>
                            <option value="2011-2012">--UP-TO-YEAR-(2011-2012)-</option>
                            <option value="2012-2013">--UP-TO-YEAR-(2012-2013)-</option>
                            <option value="2013-2014">--UP-TO-YEAR-(2013-2014)-</option>
                            <option value="2014-2015">--UP-TO-YEAR-(2014-2015)-</option>
                            <option value="2015-2016">--UP-TO-YEAR-(2015-2016)-</option>
                            <option value="2016-2017">--UP-TO-YEAR-(2016-2017)-</option>
                            <option value="2017-2018">--UP-TO-YEAR-(2017-2018)-</option>
                            <option value="2018-2019">--UP-TO-YEAR-(2018-2019)-</option>
                            <option value="2019-2020">--UP-TO-YEAR-(2019-2020)-</option>
                            <option value="2020-2021">--UP-TO-YEAR-(2020-2021)-</option>
                            <option value="2021-2022">--UP-TO-YEAR-(2021-2022)-</option>
                            <option value="2022-2023">--UP-TO-YEAR-(2022-2023)-</option>
                            <option value="2023-2024">--UP-TO-YEAR-(2023-2024)-</option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control" id='demand_satisfied_certificate' name='demand_satisfied_certificate'
                        type="file" placeholder="demand_satisfied_certificate"/> 
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick=submitDSM()>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            SUBMIT
                        </button>
                    </td>
                </tr>
            </table>
        </div>
        <!-- validation-errors-div -->
        <div class="panel-body" id="dsm_error_div" style="display:none;">
            <div class="card-header h5 bg-danger text-white text-center">
                VALIDATION ERRORS
            </div>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <strong class="text-center" style="color:red !important"
                    id="dsm_validation_error_msg">
                </strong>
            </div>
        </div>
        <!-- validation-error-div-end -->
        <div class="panel-body" style="font-size:18px!important;margin-top:-20px;">
            <div class="panel-heading bg-success text-white">
                <h6 class="panel-title text-white" style="text-align: center; font-weight: bold;font-size:15px">
                    MOUZA WISE DEMAND SATISFIED DETAILS SUBMITED LIST
                </h6>
            </div>
            <table class="table table-striped table-bordered">
                <tr class="bg-secondary">
                    <td>Subdivison</td>
                    <td>Circle</td>
                    <td>Mouza</td>
                    <td>Demand Satisfaction Year</td>
                    <td>Submitted Time</td>
                    <td>Action</td>
                </tr>
                <?php foreach ($demand_satisfied_list as $demand_satified_details):?>   
                    <tr class="">
                        <td><?=$this->utilityclass->getSubDivName($dist_code,$demand_satified_details->subdiv_code)?></td>
                        <td><?=$this->utilityclass->getCircleName($dist_code,$demand_satified_details->subdiv_code,$demand_satified_details->cir_code)?></td>
                        <td><?=$this->utilityclass->getMouzaName($dist_code,$demand_satified_details->subdiv_code,$demand_satified_details->cir_code,$demand_satified_details->mouza_pargona_code)?></td>
                        <td><?=$demand_satified_details->upto_demand_satisfied_year?></td>
                        <td><?=$demand_satified_details->created_at?></td>
                        <td>
                            <?php if($dist_code == EKHAJANA_DEMAND_SATISFIED_DELETE_DIST_CODE &&
                                $demand_satified_details->subdiv_code == EKHAJANA_DEMAND_SATISFIED_DELETE_SUBDIV_CODE &&
                                $demand_satified_details->cir_code == EKHAJANA_DEMAND_SATISFIED_DELETE_CIR_CODE &&
                                $demand_satified_details->mouza_pargona_code == EKHAJANA_DEMAND_SATISFIED_DELETE_MOUZA_PARGONA_CODE
                            ):?>
                                <button class="btn btn-sm btn-danger" onclick="deleteDSM('<?=$demand_satified_details->id?>')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    DELETE
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    DELETE
                            <?php endif ?>
                        </button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>    
</div>
<script>

    function deleteDSM(id){
        //alert("in the delete method id is " + id);
        var ekhajana_dsm_form = new FormData();
        ekhajana_dsm_form.append("dsm_id", id);
        $.ajax({
            url: baseurl + "EkhajanaDcController/deleteDSMHandle",
            type: 'POST',
            data: ekhajana_dsm_form,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {
                if(data.result == 'validation_error'){
                    $.unblockUI();
                    alert("Validation-Error...!!");
                    $('#dsm_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#dsm_validation_error_msg').append(data.msg[i]);
                    }
                    return;
                }
                if(data.result){
                    alert(data.msg);
                    $.unblockUI();
                    location.reload();
                }else{
                    alert(data.msg);
                    $.unblockUI();
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }


    function submitDSM(){
        $('#dsm_error_div').hide();
        $('#dsm_validation_error_msg').empty();
        var subdiv_code = $('#subdiv_code_dsm').val();
        var circle_code = $('#circle_code_dsm').val();
        var mouza_code = $('#mouza_code_dsm').val();
        var year = $('#year_dsm').val();
        if(subdiv_code == '' || subdiv_code == null){
            alert("Please Select Sub-Division..!");
            return;
        }
        if(circle_code == '' || circle_code == null){
            alert("Please Select Circle..!");
            return;
        }
        if(mouza_code == '' || mouza_code == null){
            alert("Please Select Mouza..!");
            return;
        }
        if(year == '' || year == null){
            alert("Please Select Year..!");
            return;
        }
        var ekhajana_dsm_form = new FormData();
        ekhajana_dsm_form.append("subdiv_code", subdiv_code);
        ekhajana_dsm_form.append("cir_code", circle_code);
        ekhajana_dsm_form.append("mouza_code", mouza_code);
        ekhajana_dsm_form.append("year", year);
        ekhajana_dsm_form.append("demand_satisfied_certificate", demand_satisfied_certificate.files[0]);
        $.ajax({
            url: baseurl + "EkhajanaDcController/submitDSMHandle",
            type: 'POST',
            data: ekhajana_dsm_form,
            dataType: 'json',
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {
                if(data.result == 'validation_error'){
                    $.unblockUI();
                    alert("Validation-Error...!!");
                    $('#dsm_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#dsm_validation_error_msg').append(data.msg[i]);
                    }
                    return;
                }

                if(data.result == 'FILE-VALIDATION-ERROR'){
                    alert(data.msg);
                    $.unblockUI();
                    return;
                }

                if(data.result){
                    alert(data.msg);
                    $.unblockUI();
                    location.reload();
                }else{
                    alert(data.msg);
                    $.unblockUI();
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }

    function getMouzaListDSM(){
        event.preventDefault();
        $('#mouza_code_dsm').empty();
        $('#mouza_code_dsm').append('<option value="">--SELECT-MOUZA--</option>');
        var subdiv_code = $('#subdiv_code_dsm').val();
        var circle_code = $('#circle_code_dsm').val();
        if(circle_code == '' || circle_code == null){
            return;
        }
        var ekhajana_dsm_form = new FormData();
        ekhajana_dsm_form.append("subdiv_code", subdiv_code);
        ekhajana_dsm_form.append("cir_code", circle_code);
        $.ajax({
            url: baseurl + "EkhajanaDcController/getMouzaList",
            type: 'POST',
            data: ekhajana_dsm_form,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {
                if(data.length === 0){
                    alert("No Mouza Found ..!, Please Select Different Circle!");
                    $.unblockUI();  
                    return;
                }else{
                    for(var i=0; i<data.length; i++) {
                        $('#mouza_code_dsm').append('<option value="'+data[i].mouza_pargona_code+'">'+data[i].loc_name+'</option>');
                    }
                    $.unblockUI();  
                } 
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }

    function getCircleListInDSM(){
        event.preventDefault();
        $('#circle_code_dsm').empty();
        $('#circle_code_dsm').append('<option value="">--SELECT-CIRCLE--</option>');
        $('#mouza_code_dsm').empty();
        $('#mouza_code_dsm').append('<option value="">--SELECT-MOUZA--</option>');
        var subdiv_code = $('#subdiv_code_dsm').val();
        var ekhajana_dsm_form = new FormData();
        ekhajana_dsm_form.append("subdiv_code", subdiv_code);
        $.ajax({
            url: baseurl + "EkhajanaDcController/getCircleList",
            type: 'POST',
            data: ekhajana_dsm_form,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {
                if(data.length === 0){
                    alert("No Circle Found ..!, Please Select Different Subdiv!");
                    $.unblockUI();  
                    return;
                }else{
                    for(var i=0; i<data.length; i++) {
                        $('#circle_code_dsm').append('<option value="'+data[i].cir_code+'">'+data[i].loc_name+'</option>');
                    }
                    $.unblockUI();  
                } 
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }


</script>