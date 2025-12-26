<div class='container ' style="margin-top:20px">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCFR/tnIndex'?>">index</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">CFR-Details-Update-Form</li>
  </ol>
</nav>
<div class="card col-lg-10 offset-1">        
    <div class="card-body">
        <div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
            <div class="p-2 text-white shadow mt-2 text-center h6 font-weight-bold" style="margin-bottom:0px!important;background-color:#1c666a">
                CFR DETAILS UPDATE FORM
            </div>
            <div class="p-2 text-white shadow text-center h6 font-weight-bold bg-dark text-warning" style="margin-bottom:0px!important;background-color:#1c666a">
                NOTE: FOR EACH CFR BOOK ENTRIES, DETAILS WILL BE FORWARDED TO ADC FOR VERIFICATION
            </div>
            <div class="card-text mt-2 lm-report">
                <form class='form-horizontal' id ="cfr_details_updation_form" method="POST">                    
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            <?php echo "Circle"?>
                            <span class="font-weight-bold text-danger">*</span>
                        </div>
                        <div class="col-sm-6">
                            <select class="js-single js-states form-control" style="width: 85%" onchange="circleOnChangeCFRform()" id="circles" name="circle">
                                <option value="" selected>-ALL-CIRCLES-</option>
                                <?php foreach ($circleList as $circle):?>
                                    <option value="<?=$circle->dist_code?>_<?=$circle->subdiv_code?>_<?=$circle->cir_code?>"><?=$circle->loc_name?></option>
                                <?php endforeach;?>    
                            </select>
                        </div>
                    </div>                            
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            <?php echo "Mouza"?>
                            <span class="font-weight-bold text-danger">*</span>
                        </div>
                        <div class="col-sm-6">
                            <select class="js-single js-states form-control" style="width: 85%" onchange="mouzaOnChange()" id="mouzas" name="mouza">
                                <option value="" selected>-ALL-MOUZAS-</option>
                            </select>
                        </div>
                    </div>           
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            CFR-BOOK-NUMBER
                            <span class="font-weight-bold text-danger">*</span>
                        </div>                            
                        <div class="col-sm-6">
                            <input type="number" class="form-control" style="width: 85%" placeholder="CFR-BOOK-NUMBER"
                            name="cfr_book_number">
                        </div>
                    </div>               
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            TOTAL NO OF CFR <br>PAGES IN THE BOOK
                            <span class="font-weight-bold text-danger">*</span>
                        </div>                            
                        <div class="col-sm-6">
                            <input type="number" class="form-control" style="width: 85%" placeholder="TOTAL-CFR-PAGES"
                            name="no_of_cfr_pages_in_the_book" type="number">
                        </div>
                    </div>               
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            CFR PAGE <br>SERIAL NO-(START) 
                            <span class="font-weight-bold text-danger">*</span>
                        </div>                            
                        <div class="col-sm-6">
                            <input type="number" class="form-control" style="width: 85%" placeholder="SERIAL NO-(START)"
                            name="cfr_page_serial_no_start">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            CFR PAGE <br>SERIAL NO-(END)
                            <span class="font-weight-bold text-danger">*</span>
                        </div>                            
                        <div class="col-sm-6">
                            <input type="number" class="form-control" style="width: 85%" placeholder="SERIAL NO-(END)"
                            name="cfr_page_serial_no_end">
                        </div>
                    </div>               
                    <div class="row mb-3">
                        <div class="col-sm-4" style="text-align:right; font-weight:bold;">
                            REMARK
                            <span class="font-weight-bold text-danger">*</span>
                        </div>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" style="width: 85%" placeholder="REMARK"
                            name="remarks"></textarea>                            
                        </div>
                    </div>      
                    <!-- validation-errors-div -->
                    <div class="col-lg-12" id="cfr_details_updation_validation_error_div" style="display:none;">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong class="text-center" style="color:red !important"
                                id="cfr_details_updation_validation_error_msg">
                            </strong>
                        </div>
                    </div>
                    <!-- validation-error-div-end -->         
                    <hr>
                    <div class="text-center">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4" style="text-align:center">
                                    <div class="col-sm-12" style="display:flex" >
                                        <button type="submit" class="btn btn-sm text-white" onclick="forwardCFRdetailsToADC()"
                                            style="padding: 5px!important;font-size: 14px;font-weight: bold;background-color:#1e5727">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                FORWARD TO ADC
                                        </button>
                                        &nbsp;
                                        <button id="MainIndex" class="btn btn-sm uni_text btn-danger"><i class='fa fa-home'></i>&nbsp;BACK</button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    //function circle on change 
    function circleOnChangeCFRform(){    
        //***************select-reset*************/
        $('#mouzas').empty();
        $('#mouzas').append('<option value="00" selected>-ALL-MOUZAS-</option>');
        //***************************************/
        var location = $('#circles').val();    
        var explodedString = location.split("_");
        var dist_code =explodedString[0];
        var subdiv_code= explodedString[1];
        var cir_code= explodedString[2];
        //***************************************/
        // testing
        // alert("dist_code " + dist_code);
        // alert("subdiv_code " + subdiv_code);
        // alert("cir_code " + cir_code);
        //***************************************/
        $.ajax({ 
            url: baseurl + "EkhajanaCFR/getAllMouzas",
            type: 'POST',
            data: {'dist_code':dist_code, 'subdiv_code':subdiv_code,'cir_code':cir_code},
            dataType: 'json',
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
                for(var i=0; i<data.length; i++) {
                    $('#mouzas').append('<option value="'+data[i].dist_code+'_'+data[i].subdiv_code+'_'+data[i].cir_code+'_'+data[i].mouza_pargona_code+'">'+ data[i].loc_name+'</option>');
                }
                $.unblockUI();
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });
        $.unblockUI(); 
    }

    function forwardCFRdetailsToADC(){
        event.preventDefault();
        var formdata = $('#cfr_details_updation_form').serialize();
        $('#cfr_details_updation_validation_error_msg').empty();
        $('#cfr_details_updation_validation_error_div').hide();
        $.ajax({
            url: baseurl + "EkhajanaCFR/forwardCFRdetailsToADC",
            type: 'POST',
            data:  formdata ,
        
            dataType: 'json',
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
                $.unblockUI();
                //validation_error_handle
                if(data.result == 'VALIDATION-ERROR'){
                    alert("Validation-Error, Please Submit the form correctly!");
                    $('#cfr_details_updation_validation_error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#cfr_details_updation_validation_error_msg').append(data.msg[i]);
                    }
                    return;                
                }else if(data.result == 'SERVER-ERROR'){
                    $.unblockUI();
                    Swal.fire({
                        title: data.msg,
                        icon: 'warning',
                        confirmButtonColor: '#3085D6',
                        confirmButtonText: 'BACK'
                    }).then((result) => {
                    if (result.isConfirmed) {
                            //window.location = baseurl + "EkhajanaCFR/tnIndex";
                        }
                    })
                    return;
                }else if(data.result == 'INPUT-ERROR'){
                    $.unblockUI();
                    alert(data.msg);
                    return;
                }else if(data.result == "SUCCESS"){
                    $.unblockUI();
                    Swal.fire({
                        title: data.msg,
                        icon: 'success',
                        confirmButtonColor: '#3085D6',
                        confirmButtonText: 'Home'
                    }).then((result) => {
                    if (result.isConfirmed) {
                            window.location = baseurl + "EkhajanaCFR/tnIndex";
                        }
                    })
                    return;
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
        
    }
</script>



                        
               
                            
                        
               
                        

    
