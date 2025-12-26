<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAstController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(Edit Year Wise Arrear)</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark" style="width:100%">                            
                            <tr style="background-color: black; color: #fff;width:100%!important">
                                <td></td>
                                <td>Financial Year</td>
                                <td>Revenue</td>
                                <td>Local Tax</td>
                                <td>Surcharge</td>
                                <td>Arrear</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <form id="arrear_edit_ast">
                            <?php foreach ($year_wise_arrear as $row):?> 
                                <tr class="cal_row">
                                    <td>
                                        <input type="hidden" name="financial_year[]" value="<?=$row->financial_year?>">
                                        <input type="hidden" name="pre_arrear_id" value="<?=$row->pre_arrear_id?>">
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$row->financial_year?>
                                        </span>
                                    </td>
                                    <td>
                                        <input  name="year_revenue[<?=$row->financial_year?>]" type="text" class="form-control sec_a" style="width:80%" value="<?=$row->year_revenue?>">
                                    </td>
                                    <td>
                                        <input  name="year_tax[<?=$row->financial_year?>]"  class="form-control sec_b" style="width:80%" type="text" value="<?=$row->year_tax?>">  
                                    </td>
                                    <td>
                                        <input  name="year_surcharge[<?=$row->financial_year?>]"  class="form-control sec_c" style="width:80%" type="text" value="<?=$row->year_surcharge?>">  
                                    </td>
                                    <td>
                                        <input  name="year_arrear[<?=$row->financial_year?>]" class="form-control cal_sum" style="width:80%" readonly type="text" value="<?=$row->year_arrear?>">  
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            <center>
                            <tr style="background-color: #bbbbbb; font-weight:bold;width:100%">
                                <td></td>
                                <th scope="row">Total Arrear:</th>
                                <td>Rs<span class="testss"><?=$row->total_revenue?></span></td>
                                <input type="hidden" name="total_revenue" value="<?=$row->total_revenue?>" class="testss_inp"></td>
                                <td>Rs<span class="testsb"><?=$row->total_tax?></span></td>
                                <input type="hidden" name="total_tax"  value="<?=$row->total_tax?>" class="testsb_inp"></td>
                                <td>Rs<span class="testsd"><?=$row->total_surcharge?></span></td>
                                <input type="hidden" name="total_surcharge"  value="<?=$row->total_surcharge?>" class="testsd_inp"></td>
                                <td>Rs<span class="testsc"><?=$row->total_arrear?></span></td>
                                <input type="hidden" name="total_arrear" value="<?=$row->total_arrear?>" class="testsc_inp"></td>
                            </tr>
                            </center>
                            </form>
                        </tbody>
                    </table>
                    <center>
                        <div class="col-6">
                            <button class="btn btn-sm btn-success mt-5" onclick="submitPreArrear()">
                                Submit Edit
                            </button>
                            <button class="button btn btn-danger btn-sm mt-5 text-white" a href="<?=base_url('index.php/EkhajanaAstController/viewPreUpdatedArrear')?>">
                                    BACK
                                </a>
                            </button>
                        </div>
                        
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>



<script>
  
    var arrearInsClosest = '';
    $(document).on('click', '.arrear_list_ins_view', function(){
        arrearInsClosest = $(this).closest('.arrear_list_ins');
    });

    $('.sec_a, .sec_b, .sec_c').on('keyup', function(){
        const closest = $(this).closest('.cal_row');
        cal_sum(closest);
    });

function cal_sum(closestEl){
    let a = $('.sec_a', closestEl).val(); 
    let b = $('.sec_b', closestEl).val();
    let c = $('.sec_c', closestEl).val();
    if(a === NaN){
        a = 0;
    }
    if(b === NaN){
        b = 0;
    }
    if(c === NaN){
        c = 0;
    }
    let total = parseFloat(a) + parseFloat(b) + parseFloat(c);
    $('.cal_sum', closestEl).val(total);
    get_total();
}

function get_total(){
    let totalSecA = 0;
    let totalSecB = 0;
    let totalSecC = 0;
    let totalSecD = 0;
    let total = 0;
    $('.sec_a', arrearInsClosest).each(function() {
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecA = totalSecA + parseFloat($(this).val());
        }

    });
    
    $('.sec_b', arrearInsClosest).each(function() {
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecB = totalSecB + parseFloat($(this).val());
        }
    });

    $('.sec_c', arrearInsClosest).each(function() {
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecD = totalSecD + parseFloat($(this).val());
        }
    });  
    $('.cal_sum', arrearInsClosest).each(function() {  
        if($(this).val() != '' && $(this).val() !== NaN){
            totalSecC = totalSecC + parseFloat($(this).val());
        }
    });

    $('.testss', arrearInsClosest).text(totalSecA);
    $('.testsb', arrearInsClosest).text(totalSecB);
    $('.testsd', arrearInsClosest).text(totalSecD);
    $('.testsc', arrearInsClosest).text(totalSecC);
    $('.testss_inp', arrearInsClosest).val(totalSecA);
    $('.testsb_inp', arrearInsClosest).val(totalSecB);
    $('.testsd_inp', arrearInsClosest).val(totalSecD);
    $('.testsc_inp', arrearInsClosest).val(totalSecC);
}

</script>
<script>
    function submitPreArrear()
    {
        event.preventDefault();
        var formdata = new FormData(document.getElementById('arrear_edit_ast'));
        $.ajax({
        url: baseurl + "EkhajanaTn/submitEditArrear",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData:false,
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
            if(data.result == 'VALIDATION-ERROR'){
                $.unblockUI();
                $('#lmArr_error_div').show();
                for (let i = 0; i < data.msg.length; i++) {
                    alert("Validation Error..!")
                    $('#lmArr_validation_error_msg').append(data.msg[i]);
                }
                return;
            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "EkhajanaTn/preArrearIndex";
            }else{
                $.unblockUI();
                alert(data.msg);
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    }
</script>

