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
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Generate Doul / Year Wise Doul For Mouza's </h2>
                </div>
            </div>               
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading dontshow">
                        <h3 class="panel-title">
                            Auto Generated Doul of each Mouza's
                        </h3>
                    </div>
                    <div class="panel-body">

                                       <!--  <a href="<?php echo base_url(); ?>index.php/GenerateDoul/ChangeInLand?mouza_code=<?php echo $mouza_code;?>" class="btn btn-success">
                                            &nbsp;View Details&nbsp;<i class=""></i>
                                        </a> -->
                                    
                                         <!--  <a href="<?php echo base_url(); ?>index.php/GenerateDoul/ChangeInRev?mouza_code=<?php echo $mouza_code;?>" class="btn btn-success">
                                            &nbsp;View Change in Revenue&nbsp;<i class=""></i>
                                        </a> --><br><br>
                                    
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
                                <td class="text-danger">পট্টাৰ প্ৰকাৰ</td>
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
                                if($value['status'] == 'False'){
                                    $attrib = 'danger';
                                } else {
                                    $attrib = '';
                                }
                                ?>
                                <tr class="hope <?php echo $attrib; ?>">
                                    <td class="text-success"><?php echo $value['mouza_name']; ?></td>
                                    <td ><?php echo $value['patta_name']; ?></td>
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
                                        <a href="<?php echo base_url(); ?>index.php/GenerateDoul/VillagePattaWiseDoulGenerate?mouza_code=<?php echo $value['mouza_code']."&patta_type=".$value['patta_type_code'];?>" class="btn btn-success">
                                            &nbsp;View Village Patta Doul&nbsp;<i class="fa fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr class="hope info">
                                <td class="text-danger" colspan="2">মুঠ</td>
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
                        <center>
                            <button id="backButton" class="btn btn-danger  dontshow"><i class="fa fa-arrow-left"></i>&nbsp;Back To Circle Wise Doul</button>
                            <a onclick="return myFunction()" href="#" class="btn btn-success uni_text dontshow" ><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</a><br>
                            
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url().'index.php/GenerateDoul/CircleWiseDoulGenerate' ?>";
        };
        
        function myFunction() {
            $(".dontshow").hide();
            window.print();
            $(".dontshow").show();
                document.getElementById("mainMenu").disabled = false;
        }
        $('#btn-final').on('click', function(e) {
            Swal.fire({
              title: "Are you sure?",
              text: "Once Approved, you will not be able to edit the data!",
              icon: "warning",
              showCancelButton: true,
            })
            .then((response) => {
              if(response.isConfirmed) {
                $.ajax({
                    url: '<?= base_url()?>'+ "index.php/GenerateDoul/portDoul/",
                    type: "POST",
                    dataType: 'json',
                    error: function() {
                        Swal.fire({
                            title: "Failed",
                            text: "Error",
                            icon: "warning",
                            timer: 50000
                        });
                    },
                    success: function(data) {
                        if(data.success===true){
                            Swal.fire("Success! Your data has been Approved", {
                              title: "Success",
                              icon: "success",
                            });
                            window.location.assign(data.redirect + '/home');
                        }else if(data.success===false){
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!',
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