<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
         
            <div class="">
                <div class="panel-heading">
                    <h4> Updated Direct Paying Estate Tax List </h4>
                    <h3 class="panel-title">Patta List of &nbsp;&nbsp;&nbsp; Mouza: <kbd><?=$mouza_name;?></kbd> &nbsp;&nbsp;&nbsp; Lot : <kbd><?=$lot_name;?></kbd> &nbsp;&nbsp;&nbsp; Village : <kbd><?=$vill_name?></kbd><h3>
                </div>


                <div class="" >
                    
                    <form id="myFormRevert" method="post">
                        <div style="max-height: 350px;overflow-x: scroll;">
                        <input type="hidden" class="" name="dist_code" id="dist_code" value="<?php echo $dist_code; ?>">
                        <input type="hidden" class="" name="subdiv_code" id="subdiv_code" value="<?php echo $subdiv_code; ?>">
                        <input type="hidden" class="" name="cir_code" id="cir_code" value="<?php echo $cir_code; ?>">
                        <input type="hidden" class="" name="mouza_code" id="mouza_code" value="<?php echo $mouza_pargona_code; ?>">
                        <input type="hidden" class="" name="lot_no" id="lot_no" value="<?php echo $lot_no; ?>">
                        <input type="hidden" class="" name="vill_code" id="vill_code" value="<?php echo $vill_code; ?>">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr style="background-color:#f2ff2f">
                                    <th>Sl no</th>
                                    <th>Patta No.</th>
                                    <th>Patta Type</th>
                                    <th>Direct Paying Estate (Select Patta)</th>
                                    <th >Dag No.</th>
                                </tr>
                                <?php $cnt = 1; foreach ($allPatta as $key => $value) {?>
                                   <tr>
                                       <td class="bg bg-warning" ><?=$cnt++;?></td>
                                       <td  ><?=$value->patta_no;?></td>
                                       <td  ><?=$value->patta_type_name;?></td>
                                       <td><input type="checkbox" name="checkPattaNo[]" value="<?=$value->patta_no.",".$value->patta_type_code;?>" ></td>
                                       <td >
                                           <?php
                                                                                     
                                            $array = str_split($value->dags, 55); 
                                            echo implode("<br>",$array);

                                           ?>
                                       </td>
                                   </tr>
                                <?php } ?>
                            </table>
                        </div>
                        
                        
                    </div>
                    <div class="text-center">
                        <button type="button" id="btn-update-revert-patta" class="btn btn-warning"><i class='fa fa-refresh'></i> Revert Previous Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<script type="text/javascript">
    $('#btn-update-revert-patta').on('click', function(e) {
                var formData = $('#myFormRevert').serialize();
                $.ajax({
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/updatePattaNoRevert",
                    type: "POST",
                    data : formData,
                    dataType: 'json',
                    error: function() {
                        $.unblockUI();
                        Swal.fire({
                            title: "Failed",
                            text: "Error",
                            icon: "warning",
                            timer: 50000
                        });
                    },
                    success: function(data) {
                        $.unblockUI();   
                        if(data.success===true){
                            Swal.fire("Success! Updated Direct Tax", {
                              title: "Success",
                              icon: "success",
                            }); 


                        }else if(data.success===false){
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: data.msg,
                            });
                            $("#errorPattaTitle").html("<i class='fa fa-exclamation-triangle'></i> " + data.msg);
                            $("#errorPattaList").html(data.patta);
                        }                  
                    }
                });
            }); 
</script>
