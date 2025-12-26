<?php 
$first_year = (doul_year_no -1) ;
$second_year = doul_year_no ;
?>
<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: landscape; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }
    
</style>
<style type="text/css">
    .alt{
        color: #0f5132 !important;
        background-color: #ffda52 !important;
        border-color: #194e36 !important;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Generate Doul / Year Wise Doul For Circle's </h2>
                </div>
            </div>
                     

            <div class="col-lg-12">
                <div class="alert alt" role="alert">
                    <b style="font-size: 24px;"><?=$FinalStatus == "A" ? "<span style='color:green'> <i class='fas fa-check-double'></i></span> Doul Approved" : ($FinalStatus == "P" ? "<i class='fa fa-spinner fa-spin'></i>Warning : Doul Forwarded to DC !!!" : ($FinalStatus == "R" ? "<span style='color:red'><i class='fas fa-times'></i></span> Doul Reverted by DC !!!" : "<i class='fa fa-spinner fa-spin'></i>Warning : Doul not generated"));?></b>
                    <hr>
                    <?php if($remarks != null){ ?>
                        <h6 class="mb-0"><kbd>DC REMARKS</kbd> : <?=$remarks;?></h6>
                    <?php } ?>
                    
                </div>  
                <div class="alert alt" role="alert">
                    <b style="font-size: 24px;"><?=$FinalStatusDp == "A" ? "<span style='color:green'> <i class='fas fa-check-double'></i></span>Direct Paying Doul Approved" : ($FinalStatusDp == "P" ? "<i class='fa fa-spinner fa-spin'></i>Warning : Direct Paying Doul Forwarded to DC !!!" : ($FinalStatusDp == "R" ? "<span style='color:red'><i class='fas fa-times'></i></span>Direct Paying Doul Reverted by DC !!!" : "<i class='fa fa-spinner fa-spin'></i>Warning : Direct Paying Doul not generated"));?></b>
                    <hr>
                    <?php if($remarksDp != null){ ?>
                        <h6 class="mb-0"><kbd>DC REMARKS</kbd> : <?=$remarksDp;?></h6>
                    <?php } ?>
                    
                </div>  
                <div class="panel panel-info">
                    <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Auto Generated Doul of each Circle's
                        </h3>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $dist_name; ?></td>
                                <td colspan="2">Subdivision : <?php echo $subdiv_name; ?></td>
                                <td colspan="2">Circle : <?php echo $cir_name; ?></td>
                                <td colspan="2">Year : <?php echo doul_year_no; ?></td>
                            </tr>

                          
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <table class="table table-bordered">
                            <tr class="hope info">
                                <td class="text-danger">মৌজাৰ নাম</td>
                                <td class="text-danger">পট্টাৰ সংখ্যা</td>
                                <td class="text-danger">মাটি কালি</td>
                                <td class="text-danger">ৰাজহ</td>
                                <td class="text-danger">স্হানীয় কৰ</td>
                                <td class="text-danger">অতিৰিক্ত কৰ</td>
                                <td class="dontshow">&nbsp;</td>
                            </tr>
                            <?php
                            $sum_patta_no = 0;
                            $sum_dag_revenue = 0;
                            $sum_local_tax = 0;
                            $sum_total_lessa = 0;
                            foreach ($result as  $value) {
                                ?>
                                <tr class="hope">
                                    <td class="text-success"><?php echo $value['mouza_name']; ?></td>
                                    <td >
                                        <?php 
                                        echo $value['total_patta']; 
                                        $sum_patta_no = $sum_patta_no+$value['total_patta'];
                                        ?>
                                    </td>
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
                                    <td></td>
                                    <td class="dontshow">
                                        <a href="<?php echo base_url(); ?>index.php/GenerateDoul/MouzaWiseDoulGenerate?mouza_code=<?php echo $value['mouza_code'];?>" class="btn btn-success">
                                            &nbsp;View Mouza Doul&nbsp;<i class="fa fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }

                            ?>
                            <tr class="hope info">
                                <td class="text-danger">মুঠ</td>
                                <td class="text-danger"><?php echo $sum_patta_no; ?></td>
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
                                <td class="dontshow"></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <span id='loading-image' style="display: none;">Please Wait !!!!</span>
                        <center>
                            
                            <button id="backButton" class="btn btn-danger dontshow"><i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                            <button id="specialPatta" class="btn btn-success">&nbsp;Special Patta</button>
                            <button id="directPay" class="btn btn-success">&nbsp;Direct Paying Estate Patta</button>
                            <a onclick="return myFunction()" href="#" class="btn btn-success uni_text dontshow" ><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</a>
                            
                                <?php if($FinalStatus == "R"): ?>
                                    <button class="btn btn-primary regenerate"  id='btn-regenerate'> <i class="fa fa-refresh"></i> Regenerate Doul for the Session (<?=$first_year?>-<?=$second_year?>)</button>
                                <?php else:?>
                                    <?php if($FinalStatus == null): ?>
                                        <button class="btn btn-info uni_text"  id='btn-final'>Submit Doul for Verification (<?=$first_year?>-<?=$second_year?>)</button>                                        
                                        <?php endif;?>
                                <?php endif; ?>

                                <?php if($FinalStatusDp == null): ?>
                                        <button class="btn btn-info uni_text btn-warning"  id='btn-final-dp'>Submit DP Doul for the Session (<?=$first_year?>-<?=$second_year?>)</button>
                                <?php elseif ($FinalStatusDp == 'R'): ?>
                                    <button class="btn btn-primary regenerate"  id='btn-regenerate-dp'> <i class="fa fa-refresh"></i> Regenerate DP Doul for the Session (<?=$first_year?>-<?=$second_year?>)</button>
                                <?php endif;?>
                            
                        </center>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
    <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/home' ?>";
        };
        document.getElementById("directPay").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/GenerateDoul/directPayTaxUpdate' ?>";
        };

        document.getElementById("specialPatta").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/GenerateDoul/specialPattaRevenue' ?>";
        };
        
        function myFunction() {
            $(".dontshow").hide();
            window.print();
            $(".dontshow").show();
                document.getElementById("mainMenu").disabled = false;
        }
        // $('#btn-final').on('click', function(e) {


        //         Swal.fire({
        //           title: "Direct Paying Estate Tax Update already ?",
        //           text: "Once submitted, you will not be able to edit the data!",
        //           icon: "warning",
        //           showCancelButton: true,
        //         })
        //         .then((response) => {
        //           if(response.isConfirmed) {
        //             $.blockUI({
        //                 message: $('#displayBox'),
        //                 css: {
        //                     border:'none',
        //                     backgroundColor:'transparent'
        //                 }
        //             });
        //             $.ajax({
        //                 url: '<?= base_url()?>'+ "index.php/GenerateDoul/portDoul/",
        //                 type: "POST",
        //                 dataType: 'json',
        //                 error: function() {
        //                     $.unblockUI();
        //                     Swal.fire({
        //                         title: "Failed",
        //                         text: "Error",
        //                         icon: "warning",
        //                         timer: 50000
        //                     });
        //                 },
                        
        //                 success: function(data) {
        //                     $.unblockUI();
        //                     if(data.val == 1){
        //                        Swal.fire({
        //                           title: "Sorry!",
        //                           text: "Before submit Please update the Zero Revenue(Dags)",
        //                           width: 600,
        //                           padding: '3em',
        //                           color: '#ff681d',
        //                           backdrop: `
        //                             rgb(255 104 58 / 4%)
        //                             left top
        //                             no-repeat
        //                           `
        //                         })
        //                         .then(function() {
        //                             location.href = '<?= base_url()?>'+ "index.php/GenerateDoul/getAllZeroDags";
        //                         });
        //                     }
        //                     if(data.success===true){
        //                         Swal.fire("Success! Your data has been submitted", {
        //                           title: "Success",
        //                           icon: "success",
        //                         }); 
        //                         window.location.reload();
                                
        //                     }else if(data.success===false){
        //                         Swal.fire({
        //                           icon: 'error',
        //                           title: 'Oops...',
        //                           text: data.msg,
        //                         });
        //                     }
        //                 }
        //             }); 
        //             } else {
        //               Swal.fire("Not Confirmed Yet");
        //           }
        //         });
            
        // });


        $('#btn-final').on('click', function(e) {
            Swal.fire({
                title: "Submitting Doul for Current Revenue Year",
                text: "Once submitted, you will not be able to edit the data!",
                icon: "warning",
                showCancelButton: true,
            }).then((response) => {
                if (response.isConfirmed) {

                    // Show progress bar modal
                    Swal.fire({
                        title: 'Submitting Doul For The Revenue Year <?= $second_year ?>...',
                        html: `
                            <div style="width: 100%; background-color: #ddd; border-radius: 5px; overflow: hidden;">
                                <div id="progress-bar" style="width: 1%; height: 20px; background-color:rgb(9, 73, 143);"></div>
                            </div>
                            <p id="progress-text" style="margin-top: 10px;">1%</p>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            // Simulate the progress while waiting for response
                            let progress = 1;
                            const interval = setInterval(() => {
                                if (progress < 95) { // Don't reach 100% until success
                                    progress++;
                                    $('#progress-bar').css('width', progress + '%');
                                    $('#progress-text').text(progress + '%');
                                }
                            }, 100); // Adjust speed here

                            // Save to clear later
                            Swal._progressInterval = interval;
                        }
                    });

                    $.ajax({
                        url: '<?= base_url()?>index.php/GenerateDoul/portDoul/',
                        type: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            clearInterval(Swal._progressInterval);
                            $('#progress-bar').css('width', '100%');
                            $('#progress-text').text('100%');

                            setTimeout(() => {
                                Swal.close();

                                if (data.val == 1) {
                                    Swal.fire({
                                        title: "Sorry!",
                                        text: "Before submit Please update the Zero Revenue(Dags)",
                                        icon: "warning"
                                    }).then(() => {
                                        location.href = '<?= base_url()?>index.php/GenerateDoul/getAllZeroDags';
                                    });
                                } else if (data.success === true) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Your data has been submitted successfully.",
                                        icon: "success"
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data.msg,
                                    });
                                }
                            }, 300); // slight delay to show 100%
                        },
                        error: function() {
                            clearInterval(Swal._progressInterval);
                            Swal.fire({
                                title: "Error",
                                text: "Something went wrong!",
                                icon: "error"
                            });
                        }
                    });

                } else {
                    Swal.fire("Submission Cancelled");
                }
            });
        });





        //method for executing dp doul 
        $('#btn-final-dp').on('click', function(e) {
            Swal.fire({
            title: "Are You Sure To Submit Dp Doul?",
            text: "Once submitted, you will not be able to edit the data!",
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
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/portDpDoul/",
                    type: "POST",
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
                        if(data.val == 1){
                        Swal.fire({
                            title: "Sorry!",
                            text: "Before submit Please update the Zero Revenue(Dags)",
                            width: 600,
                            padding: '3em',
                            color: '#ff681d',
                            backdrop: `
                                rgb(255 104 58 / 4%)
                                left top
                                no-repeat
                            `
                            })
                            .then(function() {
                                location.href = '<?= base_url()?>'+ "index.php/GenerateDoul/getAllZeroDagsDpEstate";
                            });
                        }
                        if(data.success===true){
                            Swal.fire("Success! Your data has been submitted", {
                            title: "Success",
                            icon: "success",
                            }); 
                            window.location.reload();                           
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



        $('#btn-regenerate').on('click', function(e) {

            Swal.fire({
              title: "Are you sure?",
              text: "Once submitted, you will not be able to edit the data!",
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
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/regenerateDoul/",
                    type: "POST",
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
                        if(data.val == 1){
                           Swal.fire({
                              title: "Sorry!",
                              text: "Before submit Please update the Zero Revenue(Dags)",
                              width: 600,
                              padding: '3em',
                              color: '#ff681d',
                              backdrop: `
                                rgb(255 104 58 / 4%)
                                left top
                                no-repeat
                              `
                            })
                            .then(function() {
                                location.href = '<?= base_url()?>'+ "index.php/GenerateDoul/getAllZeroDags";
                            });
                        }
                        if(data.success===true){
                            Swal.fire("Success! Doul has been submitted successfully", {
                              title: "Success",
                              icon: "success",
                            });     
                            $(".regenerate").hide(); 
                            window.location.reload();                    
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

        $('#btn-regenerate-dp').on('click', function(e) {

            Swal.fire({
            title: "Are you sure?",
            text: "Once submitted, you will not be able to edit the data!",
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
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/regenerateDpDoul/",
                    type: "POST",
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
                        if(data.val == 1){
                        Swal.fire({
                            title: "Sorry!",
                            text: "Before submit Please update the Zero Revenue(Dags)",
                            width: 600,
                            padding: '3em',
                            color: '#ff681d',
                            backdrop: `
                                rgb(255 104 58 / 4%)
                                left top
                                no-repeat
                            `
                            })
                            .then(function() {
                                location.href = '<?= base_url()?>'+ "index.php/GenerateDoul/getAllZeroDagsDpEstate";
                            });
                        }
                        if(data.success===true){
                            Swal.fire("Success! DP Doul has been submitted successfully", {
                            title: "Success",
                            icon: "success",
                            });       
                            $(".regenerate").hide();                     
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

    