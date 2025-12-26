<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAdc/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Mouzadar Account Code Verification)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-primary text-center">
        <h3 class="panel-title">
            <u>
                <b>E-KHAJANA(Mouzadar Account Code Verification )</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">  
                    <form id="mouzadar_list">          
                    <table id="ek_adc_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>ACTION</td>
                                <td>MOUZADAR NAME</td>
                                <td>CIRCLE</td>
                                <td>MOUZA</td>
                                <td>ACCOUNT CODE</td>
                                <td>MOUZADAR VERIFICATION</td>
                                <td>ADC VERIFICATION</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            
                            <?php foreach ($getAllMouzadarDetails as $row):?> 
                                <tr>
                                    <?php if($row->adc_verified_yn =="Y"):?>
                                        <td>
                                            <input type="checkbox" name="account_code[]" class="checkBox" disabled value="<?=$row->account_code.'_'.$row->dist_code.'_'.$row->subdiv_code.'_'.$row->cir_code.'_'.$row->mouza_pargona_code?>" >
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <input type="checkbox" name="account_code[]"class="checkBox"  value="<?=$row->account_code.'_'.$row->dist_code.'_'.$row->subdiv_code.'_'.$row->cir_code.'_'.$row->mouza_pargona_code?>" >
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$this->EkhajanaAdcModel->getMouzadarnameName($row->dist_code,$row->subdiv_code, 
                                            $row->cir_code,$row->mouza_pargona_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$this->utilityclass->getCircleName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getMouzaName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->account_code?>
                                        <span>
                                    </td>
                                    <?php if($row->mouzadar_declare_yn =="" || $row->mouzadar_declare_yn== null){
                                        $declaration = "NOT DECLARED";
                                    }elseif($row->mouzadar_declare_yn =='Y'){
                                        $declaration = "DECLARED CORRECT";
                                    }elseif($row->mouzadar_declare_yn =='N'){
                                        $declaration = "DECLARED WRONG";
                                    }?>
                                    <td>
                                        <span class="font-weight-bold text-success">
                                            <?=$declaration?>
                                        <span>
                                    </td>
                                    <?php if($row->adc_verified_yn =="" || $row->adc_verified_yn== null){
                                            $adc_verify = "NOT VERIFIED";
                                    }elseif($row->adc_verified_yn =='Y'){
                                            $adc_verify = "VERIFIED";
                                    }?>
                                    <td>
                                        <span class="font-weight-bold text-success">
                                            <?=$adc_verify?>
                                        <span>
                                    </td>
                                    
                                </tr>
                            <?php endforeach;?>
                            
                        </tbody>
                    </table>
                    </form>
                    <div class="col-lg-12 mt-3" align="center" id="actionDiv">
                        <button class="btn btn-sm btn-success" onclick="verifyAccount()"><i class="fa fa-credit-card" aria-hidden="true" ></i> VERIFY</button>
                        <a href="<?php echo base_url() . 'index.php/home/index'?>" class="btn btn-sm btn-danger text-white">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function verifyAccount(){
        var val = [];
        $('.checkBox:checked').each(function(i){
            val[i] = $(this).val();
        });

        if(val.length < 1){
            alert("Please Select Atleast One Mouzadar for verification..!");
            return;
        }
        let formData = new FormData(document.getElementById('mouzadar_list'));

        $.ajax({
                url: baseurl + "EkhajanaAdc/MouzadarVerifiedSubmit",
                type: 'POST',
                data: formData,
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
                    if(data.result == 'VALIDATION-ERROR'){
                        $.unblockUI();
                        alert("Validation-Error...!!");
                        $('#coArr_error_div').show();
                        for (let i = 0; i < data.msg.length; i++) {
                            $('#coArr_validation_error_msg').append(data.msg[i]);
                        }
                        return;
                    }else if(data.result == 'SERVER-ERROR'){
                        $.unblockUI();
                        alert(data.msg);
                        return;

                    }else if(data.result == 'SUCCESS'){
                        $.unblockUI();
                        alert(data.msg);
                        location.href =  baseurl + "EkhajanaAdc/verifyMouzadarAccount";
                    }
                },
                error: function (jqXHR, exception) {
                    $.unblockUI();
                    alert('Could not Complete your Request ..!, Please Try Again later..!');
                }
            });
        console.log(val);

    }
</script>
<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script> 
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_adc.js"></script>

