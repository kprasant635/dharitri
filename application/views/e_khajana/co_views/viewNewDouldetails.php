<style>
    .casedisplay_new {
        min-height: 395px !important;
        background-color: #B192E6;
    }
    .thead_color{
        background-color:#292409!important;
        color:white!important;
    }

</style>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active"  aria-current="page">Revenue Collection Report</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel casedisplay_new shadow-lg p-3 mb-5">                        
            <div class="panel-body">
                <div class="row">
                    <div class="" style="background-color:#907E17">
                        <div class="text-center text-white">
                            <h5><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                Total New MB 2.0 Pattas in the Circle: <span style="color:yellow"><?=$this->utilityclass->getCircleName($dist_code, $subdiv_code,$cir_code)?></span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <form id="new_pattas_in_doul_form">          
            <table id="new_pattas_doul" class="table table-hover text-center" style="width:100%">            
                <thead class="thead-dark">                            
                    <tr style="background-color: black; color: #fff;">
                        <td><input type="checkbox" id="checkAll" name="check_all[]"class="checkBox">CheckAll</td>
                        <td>Village</td>
                        <td>Patta Type</td>
                        <td>Patta No</td>
                        <td>Revenue</td>
                        <td>Local Tax</td>
                    </tr>                                                        
                </thead>
                <tbody>
                    <?php foreach ($all_new_mb2_patta as $row):?> 
                        <tr>
                            <td>
                                <input type="checkbox" name="patta_data[]"class="checkBox"  value="<?=$row->dist_code.'_'.$row->subdiv_code.'_'.$row->cir_code.'_'.$row->mouza_pargona_code.'_'.$row->lot_no.'_'.$row->vill_townprt_code.'_'.$row->patta_type_code.'_'.$row->patta_no.'_'.$row->total_dag_revenue.'_'.$row->total_dag_local_tax.'_'.$row->total_lessa?>" >
                            </td>
                            <td>
                                <span class="font-weight-bolder text-success">
                                    <?=$this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code, 
                                    $row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code)?>
                                <span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-primary">
                                    <?=$this->utilityclass->getPattaType($row->patta_type_code)?>
                                <span>
                            </td>
                            <td>
                                <span class="font-weight-bolder text-danger">
                                    <?=$row->patta_no?>
                                <span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-success">
                                    <?=$row->total_dag_revenue?>
                                <span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-success">
                                    <?=$row->total_dag_local_tax?>
                                <span>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            </form>
            <div class="col-lg-12 mt-3" align="center" id="actionDiv">
                <button class="btn btn-sm btn-success" onclick="add_to_doul()"><i class="fa fa-credit-card" aria-hidden="true" ></i> ADD TO DOUL</button>
                <a href="<?php echo base_url() . 'index.php/home/index'?>" class="btn btn-sm btn-danger text-white">Cancel</a>
            </div>
        </div>
    </div>               
</div>

<script>
    // JavaScript for "Check All" functionality
    document.getElementById('checkAll').addEventListener('click', function() {
        let isChecked = this.checked;
        let checkboxes = document.querySelectorAll('.checkBox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });
</script>
<script>
$(document).ready( function () {
    $('#new_pattas_doul').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 12,
        "autoWidth":true,
    });
});
</script>

<script>
    function add_to_doul()
    {
        var val = [];
        $('.checkBox:checked').each(function(i){
            val[i] = $(this).val();
        });

        if(val.length < 1){
            alert("Please Select Atleast One Patta For Adding into the doul..!");
            return;
        }
        let formData = new FormData(document.getElementById('new_pattas_in_doul_form'));
        $.ajax({
                url: baseurl + "EkhajanaCoController/insertNewMb2PattasToDoul",
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
                        location.href =  baseurl + "EkhajanaCoController/updateDoul";
                    }
                },
                error: function (jqXHR, exception) {
                    $.unblockUI();
                    alert('Could not Complete your Request ..!, Please Try Again later..!');
                }
            });
    }
</script>


