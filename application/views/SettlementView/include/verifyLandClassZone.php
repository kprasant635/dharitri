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
    <span class="bg-warning"><?=$_GET['case']?></span> )
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
      <div class="card-text mt-2 co-report">
        <form method="post" action="<?php echo base_url()?>index.php/SettlementCommon/verifyLandClassZoneSave" id="formzonal" enctype="multipart">
        <div class="row">
            <h5 class="reza-title text-center" style="margin-top: 5px"><i class="fa fa-map"></i> Zonal Value Information </h5>
            <div class="container">
                <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">
                <input type="hidden" name="selectedArrayCount" value="<?=sizeof($selectedArray);?>">
            <?php $count =0; foreach ($selectedArray as $key2 => $value2) { ?>
                <div class="row">
                    <h5 class="text-center" style="background-color: #ffbd9c;padding:7px">Dag No : <?=$value2['dag_no']?></h5>
                    <input type="hidden" class="form-control" name="dag_no[]" id="dag_no_<?=$count?>" value="<?=$value2['dag_no']?>">
                    <div class="form-group col-4">
                        <label>Zone</label>
                        <select class="form-select" name="zonal[]" id="zone<?=$count?>" onchange="zonalValueCheck('<?=$count?>')">
                            <?php $selected = null;
                            foreach ($zonal_list as $key => $value) {
                                if($value->zone_code == $value2['zone_code']){
                                    $selected = 'selected';
                                }else{
                                    $selected = null;
                                }
                            ?>
                                <option value="<?=$value->zone_code?>" <?=$selected?>><?=$value->zone_name?></option>
                            <?php }

                            ?>
                        </select>
                    </div>
                    <input type="hidden" class="form-control" name="zonal_value_[]" id="zonal_value_<?=$count?>" value="<?=$value2['zonal_valuation']?>">
                    <div class="form-group col-4">
                        <label>Sub class</label>
                        <select class="form-select" name="subclass[]" id="subclass<?=$count?>" onchange="zonalValueCheckBySubclass('<?=$count?>')">
                            <?php
                            $selectedSubClass = null;
                            foreach ($subclassData as $key1 => $value1) {
                                if($value1->subclass_code == $value2['subclass_code']){
                                    $selected = 'selected';
                                }else{
                                    $selected = null;
                                }

                            ?>
                                <option value="<?=$value1->subclass_code?>" <?=$selected?>><?=$value1->subclass_name?></option>
                            <?php }

                            ?>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label>Zonal Value</label>
                        
                        <input type="text" class="form-control" name="zonal_value_htm[]" id="zonal_value_htm<?=$count?>" value="<?=$value2['zonal_valuation']?>" readonly>
                    </div>
                </div>
            <?php $count++; } ?>
            <div class="container text-center">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit & Procced">   
            </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type='text/javascript'>

 
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

function zonalValueCheck(str){
   $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    var zone      = $("#zone"+str).val();
    var subclass  = $("#subclass"+str).val();
    var case_no   = $('#case_no').val();
    var dag_no    = $('#dag_no_'+str).val();
    $.ajax({
        url: baseurl + "SettlementKhasCo/getZonalValueBySubclass",
        type: 'POST',
        data: {case_no : case_no,dag_no : dag_no,zone : zone,subclass : subclass},
        dataType: 'json',
        success: function (data) {
            $.unblockUI();
            // console.log(data);
            if(data.responseType == 2){
                $('#zonal_value_'+str).val(data.land_rate);
                $('#zonal_value_htm'+str).val(data.land_rate);
            }else if(data.responseType == 0){
                swal.fire({
                        backdrop:false,
                        title: 'Warning',
                        html: data.msg,
                        icon: 'warning',
                        showCancelButton: false,
                        // cancelButtonText: 'No, cancel!',
                        // reverseButtons: true

                    }).then((result3) => {
                        if (result3.isConfirmed) {
                                location.reload();
                        }
                });
                // location.reload();
            }
            
        },error: function (error) {
            $.unblockUI();
            showErrorMessage('Something went wrong.');
        }
    });
}


function zonalValueCheckBySubclass(str){
   $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });


    var zone      = $("#zone"+str).val();
    var subclass  = $("#subclass"+str).val();
    var case_no   = $('#case_no').val();
    var dag_no    = $('#dag_no_'+str).val();
    $.ajax({
        url: baseurl + "SettlementKhasCo/getZonalValueBySubclass",
        type: 'POST',
        data: {case_no : case_no,dag_no : dag_no,zone : zone,subclass : subclass},
        dataType: 'json',
        success: function (data) {
            $.unblockUI();
            // console.log(data);
            if(data.responseType == 2){
                $('#zonal_value_'+str).val(data.land_rate);
                $('#zonal_value_htm'+str).val(data.land_rate);
            }else if(data.responseType == 0){
                swal.fire({
                        backdrop:false,
                        title: 'Warning',
                        html: data.msg,
                        icon: 'warning',
                        showCancelButton: false,
                        // cancelButtonText: 'No, cancel!',
                        reverseButtons: true

                    }).then((result3) => {
                        if (result3.isConfirmed) {
                            location.reload();
                    }
                });
                // location.reload();
            }
            
        },error: function (error) {
            $.unblockUI();
            showErrorMessage('Something went wrong.');
        }
    });
}


</script>
