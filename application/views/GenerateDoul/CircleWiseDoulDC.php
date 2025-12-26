<?php 
$first_year = (doul_year_no -1) ;
$second_year = doul_year_no ;
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Year Wise Doul For Circle <?php echo $cir_name; ?></h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Doul details
                        </h3>
                    </div>

             
                    <div class="panel-body">
                        <input type="hidden" name="dist_code" id="dist_code" value="<?=$dist_code;?>">
                        <input type="hidden" name="subdiv_code" id="subdiv_code" value="<?=$subdiv_code;?>">
                        <input type="hidden" name="cir_code" id="cir_code" value="<?=$cir_code;?>">

                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $dist_name; ?></td>
                                <td colspan="2">Subdivision : <?php echo $subdiv_name; ?></td>
                                <td colspan="2">Circle : <?php echo $cir_name; ?></td>
                                <td colspan="2">Year : <?php echo $year; ?></td>
                            </tr>

                          
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <table class="table table-bordered">
                            <tr class="hope info">
                                <td class="text-danger">মৌজাৰ নাম</td>
                                <td class="text-danger">মাটি কালি</td>
                                <td class="text-danger">ৰাজহ</td>
                                <td class="text-danger">স্হানীয় কৰ</td>
                                <td class="text-danger">অতিৰিক্ত কৰ</td>
                                <!-- <td class="dontshow">&nbsp;</td> -->
                            </tr>
                            <?php
                            if($result != null){
                            $sum_patta_no = 0;
                            $sum_dag_revenue = 0;
                            $sum_local_tax = 0;
                            $sum_total_lessa = 0;
                            foreach ($result as  $value) {
                                ?>
                                <tr class="hope">
                                    <td class="text-success"><?php echo $value['mouza_name']; ?></td>
                                 
                                    <td>
                                        <?php
                                            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                                echo round($value['bigha'], 2)." বিঃ ".round($value['ktha'], 2)." কঃ ".round($value['lessa'], 2)." চা: ".round($value['gonda'], 2)." গো ";
                                            }else{
                                                echo round($value['bigha'], 2)." বিঃ ".round($value['ktha'], 2)." কঃ ".round($value['lessa'], 2)." লেঃ ";
                                            }
                                            $sum_total_lessa = $sum_total_lessa+$value['total_lessa'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo $value['dag_revenue']; 
                                            $sum_dag_revenue = $sum_dag_revenue+$value['dag_revenue'];
                                            ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo $value['local_tax']; 
                                            $sum_local_tax = $sum_local_tax+$value['local_tax'];
                                        ?>
                                    </td>
                                    
                                </tr>
                                <?php
                            }

                            ?>
                            <tr class="hope info">
                                <td class="text-danger">মুঠ</td>
                                <td class="text-danger">
                                    <?php 
                                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                             $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa2($sum_total_lessa);
                                             echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." চা: ". round($total_b_k_l[3], 2)." গো: ";
                                        }else{
                                             $total_b_k_l = $this->utilityclass->Total_Bigha_Katha_Lessa($sum_total_lessa);
                                             echo round($total_b_k_l[0], 2)." বিঃ ".round($total_b_k_l[1], 2)." কঃ ".round($total_b_k_l[2], 2)." লেঃ "; 
                                        }
                                       
                                    ?>
                                </td>
                                <td class="text-danger"><?php echo $sum_dag_revenue; ?></td>
                                <td class="text-danger"><?php echo $sum_local_tax; ?></td>
                                <td></td>
                           
                            </tr>
                        <?php } ?>
                        </table>
                        
                        <hr style="border-bottom: 2px solid #000;">
                        <span id='loading-image' style="display: none;">Please Wait Doul Approval Is Processing!!!!</span>
                       
                        <?php if($result != null){?>

                            <div class="form-group">    
                            <label for="inputEmail" class="col-lg-4 required control-label " aria-required="true">Remark (Approval/Revert)<span style="color:red">*</span> </label>
                                <div class="col-lg-8">

                                <textarea class="form-control" name="approval_remark" id="approval_remark" required placeholder="Remark"></textarea>
                                </div>      
                            </div>
                             <center>
                            <div class="col-lg-12" style="margin-top:32px">
                                <button id="backButton" class="btn btn-warning"><i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                                <?php if($FinalStatus != "A"):?>
                                    <button class="btn btn-info " id='btn-approve'> <i class="fa fa-check"></i> Approve Doul for the Session (<?=$first_year?>-<?=$second_year?>)</button>
                                    <button class="btn btn-danger " id='btn-reject'> <i class="fa fa-check"></i> Revert Doul for the Session (<?=$first_year?>-<?=$second_year?>)</button>
                                <?php endif;?>
                                <?php if($FinalStatus == "A"):?>
                                    <?php echo "<h4 style='color:green'><i class='fa fa-check'></i> DOUL APPROVED FOR THIS CIRCLE</h4>"?>;
                                <?php endif;?>
                                <?php if($FinalStatus == "P"):?>
                                    <?php echo "<h4 style='color:red'><i class='fa fa-check'></i> DOUL APPROVAL PENDING FOR THIS CIRCLE</h4>"?>;
                                <?php endif;?>
                            </div>
                        </center>
                        <?php }else{
                            if($FinalStatus == "A"){
                                echo "<h4 style='color:green'><i class='fa fa-check'></i> DOUL APPROVED FOR THIS CIRCLE</h4>";
                            }elseif($FinalStatus == "R"){
                                echo "<h4 style='color:red'><i class='fa fa-times'></i> DOUL REVERTED FOR THIS CIRCLE</h4>";
                            }else{
                                echo "<h4 style='color:red'> NO DOUL FOUND FOR THIS CIRCLE</h4>";
                            }
                            
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
    <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/generateDoul/viewDoulInDC' ?>";
        };
        
        function myFunction() {
            $(".dontshow").hide();
            window.print();
            $(".dontshow").show();
                document.getElementById("mainMenu").disabled = false;
        }      
        $('#btn-approve').on('click', function(e) {
            
            var dist_code   = $("#dist_code").val();
            var subdiv_code = $("#subdiv_code").val();
            var cir_code    = $("#cir_code").val();
            var approval_remark  = $("#approval_remark").val();
            Swal.fire({
               title: "Are you sure?",
               text: "Once Approved, you will not be able to cancel!",
               icon: "warning",
               showCancelButton: true,
            })
            .then((response) => {
              if(response.isConfirmed) {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
                $.ajax({
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/doulApproveByDC/",
                    type: "POST",
                    dataType: 'json',
                    data : {subdiv_code: subdiv_code,cir_code:cir_code,dist_code:dist_code,remark : approval_remark},
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
                            Swal.fire({
                              title: "Success",
                              icon: "success",
                              text: data.msg,
                            })
                            .then(function() {
                                location.href = '<?= base_url()?>'+ "index.php/GenerateDoul/viewDoulInDC";
                            });                       
                        }else if(data.success===false){
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: data.msg,
                            });
                        }
                    }
                }); 
                } else {
                  Swal.fire("Not Confirmed Yet");
              }
            });
        });



        $('#btn-reject').on('click', function(e) {
            
            var dist_code   = $("#dist_code").val();
            var subdiv_code = $("#subdiv_code").val();
            var cir_code    = $("#cir_code").val();
            var approval_remark  = $("#approval_remark").val();
            Swal.fire({
               title: "Are you sure want to Revert?",
               text: "It'll revert back to CO Login!",
               icon: "warning",
               showCancelButton: true,
            })
            .then((response) => {
              if(response.isConfirmed) {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
                $.ajax({
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/doulRejectByDC/",
                    type: "POST",
                    dataType: 'json',
                    data : {subdiv_code: subdiv_code,cir_code:cir_code,dist_code:dist_code,remark : approval_remark},
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
                            Swal.fire({
                              title: "Success",
                              icon: "success",
                              text: data.msg,
                            })
                            .then(function() {
                                location.href = '<?= base_url()?>'+ "index.php/GenerateDoul/viewDoulInDC";
                            });                       
                        }else if(data.success===false){
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: data.msg,
                            });
                        }
                    }
                }); 
                } else {
                  Swal.fire("Not Confirmed Yet");
              }
            });
        });
    </script>