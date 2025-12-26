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
      <?php
      if($basic->pay_notice_gen_yn == 'Y'){ ?>
      <div class="text-right">
        <a href="<?php echo base_url()?>index.php/BhoodanControllerCo/printNotice?case_no=<?=$_GET['case']?>" target="GenerateNotice"><button type="button" name="print_notice" type="button" class="m-1 col-1 text-white btn btn-warning btn-sm">Print Notice</button>
        </a>
      </div>
    
    <?php } ?>
      <!-- <h5 class="card-title">
        <u>CO Report</u>
      </h5> -->
      <div class="card-text mt-2 co-report">
        <form
          method="post"
          action="<?php echo base_url()?>index.php/BhoodanControllerCo/generatePaymentNoticeCoSave"
          id="formNotice"
        >

        <div class="row">
            <h5 class="reza-title text-center" style="margin-top: 5px">
                <i class="fa fa-map"></i>  Area Details
            </h5>
            <div class="tableCard">
                <table class="table">
                    <thead class="thead-warning">
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th class="text-center">Bigha</th>
                            <th class="text-center">Katha</th>
                            <th class="text-center"><?=$lessa_chatak?></th>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <th class="text-center">Ganda</th>
                            <th class="text-center">Kranti</th>
                            <?php endif; ?>
                        </tr>

                        <?php foreach ($dags as $all_dags) {?>

                        <tr class="bg-white">
                            <th rowspan="7" style="vertical-align : middle;">
                                <div class="vertical">
                                    DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> | 
                                    PATTA : <span class="text-danger"><?=$all_dags->patta_no?> | <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?></span>
                                </div>
                            </th>
                            <td><strong>Total Land Area in Selected Dag</strong></td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_k" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" >
                            </td>
                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" >
                                </td>
                                <td class="hide" style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_kr?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" >
                                </td>
                            <?php endif ; ?>
                        </tr>

                        <?php                            
                            $enc_area = json_decode($all_dags->encroachement_area);
                            if($enc_area != null) {
                        ?>
                        <!-- encroacher homestead -->
                        <tr class="bg-white">
                            <td class="enc-area-color"><strong>Encroachment Area (Homestead)</strong></td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->homestead->bigha?></strong>
                                <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->homestead->bigha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->homestead->katha?></strong>
                                <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->homestead->katha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->homestead->lessa?></strong>
                                <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->homestead->lessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->homestead->ganda?></strong>
                                    <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->homestead->ganda?>" readonly>
                                </td>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->homestead->kranti?></strong>
                                    <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->homestead->kranti?>" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                        <!-- encroacher agriculture -->
                        <tr class="bg-white">
                            <td class="enc-area-color"><strong>Encroachment Area (Agriculture)</strong></td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->agriculture->bigha?></strong>
                                <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->agriculture->bigha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->agriculture->katha?></strong>
                                <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->agriculture->katha?>" readonly>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$enc_area->agriculture->lessa?></strong>
                                <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->agriculture->lessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->agriculture->ganda?></strong>
                                    <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->agriculture->ganda?>" readonly>
                                </td>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$enc_area->agriculture->kranti?></strong>
                                    <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->agriculture->kranti?>" readonly>
                                </td>
                            <?php endif;?>
                        </tr>  
                        <?php } ?>

                        <!-- area settlement homestead -->
                        <?php $hide = 'area_show';
                            if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                                $hide = 'area_show';
                            } else {
                                $hide = 'area_hide';
                            }
                        ?>
                        <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Area for Settlement (Homestead)</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_b?></strong>
                                <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_dags->home_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_k?></strong>
                                <input type="hidden" style="text-align: center;" name="home_k" value="<?=$all_dags->home_k?>" class="form-control input-sm home_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$all_dags->home_lc?>" class="form-control input-sm home_lc" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->home_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->home_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->home_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- area settlement agriculture -->
                        <?php 
                            $hide = 'area_show';
                            if ($all_dags->land_type == 2) {
                                $hide = 'area_show';
                            } else {
                                $hide = 'area_hide';
                            }
                        ?>
                        <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Area for Settlement (Agriculture)</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_b?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_k?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_k" value="<?=$all_dags->agri_k?>" class="form-control input-sm agri_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->agri_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->agri_g?>" class="form-control input-sm agri_g" name="agri_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->agri_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" readonly>
                                </td>
                            <?php endif;?>
                        </tr>

                        <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Roadside Reservation Area</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->bigha?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm" value="<?=$all_dags->bigha?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->katha?></strong>
                                <input type="hidden" style="text-align: center;" value="<?=$all_dags->katha?>" class="form-control input-sm katha" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->lessa?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm lessa" value="<?=$all_dags->lessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->ganda?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->ganda?>" class="form-control input-sm ganda" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->kranti?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->kranti?>" class="form-control input-sm kranti" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                        <?php  
                        
                          if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
                            $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($all_dags->total_lessa);
                          }
                          else{
                            $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($all_dags->total_lessa);
                          }
                         ?>

                        <tr class="bg-white">
                            <td class="final-area-color"><strong>Final Settlement Area</strong></td>
                            <td class="final-area-color" style="text-align:center">
                                <strong><?=$totalAreaArr[0]?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm" value="<?=$totalAreaArr[0]?>" readonly>
                            </td>
                            <td class="final-area-color" style="text-align:center">
                                <strong><?=$totalAreaArr[1]?></strong>
                                <input type="hidden" style="text-align: center;" value="<?=$totalAreaArr[1]?>" class="form-control input-sm katha" readonly>
                            </td>
                            <td class="final-area-color" style="text-align:center">
                                <strong><?=$totalAreaArr[2]?></strong>
                                <input type="hidden" style="text-align: center;" class="form-control input-sm lessa" value="<?=$totalAreaArr[2]?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="final-area-color" style="text-align:center">
                                    <strong><?=$totalAreaArr[3]?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$totalAreaArr[3]?>" class="form-control input-sm ganda" readonly>
                                </td>
                                
                            <?php endif;?>
                        </tr>

                        <tr rowspan="7"><td></td></tr>
                        
                        <?php } ?>

                    </thead>
                </table>
                
            </div>
          
          <?php include(APPPATH."views/SettlementView/include/premiumDetailsView.php"); ?>

     
        </div>
        <hr style="margin-top: 0;">
        <?php
          if($basic->pay_notice_gen_yn != 'Y'){ ?>
                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <label for="inputEmail4"><strong>Remarks(if any)</strong></label>
                    </div>
                    <div class="col-md-6">
                    <textarea
                        placeholder="Remarks  ..."
                        name="remark_co"
                        class="form-control"
                        id="remark_co"
                        cols="30"
                        rows="3"
                    required></textarea>
                    <input type="hidden" name="case_no" value="<?=$_GET['case']?>" />
                    </div>
                </div>
         <?php }?>

        <div class="row mt-4 justify-content-center">
        <center style="color: red; font-weight:bold; font-size:20px">Note: Please verify the area and premium amount before generating the premium notice.</center>
         <?php

         if($basic->pay_notice_gen_yn != 'Y') 
         {
         ?>
         <button 
                                type="submit"
                                name="generate_notice"
                                type="button"
                                class="m-1 col-2 text-white btn btn-danger btn-sm"
                                id="btnNotice">
                                Generate payment notice
                            </button>

                    
         <?php }?>

           
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


  $('#btnNotice').on('click',function(e){
        e.preventDefault();
        var form = $('#formNotice');
        var encData ='';
        var encDataAll =[];

        <?php
        if($premium_data == true)
        {
        foreach($premium_data as $prem){
        ?>
        // $(".clspremdata").each(function () {
            encData += 'Dag No:' + <?=$prem->dag_no?> + '<br> Area Type : '+$( "#premArea<?=$prem->dag_no?>" ).val() + "<br /> Purpose of Land : "+$( "#premLand<?=$prem->dag_no?>" ).val()+" <hr>";


        // });
        // alert( encData );
        // encDataAll.push(encData);

        <?php } } ?>


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: encData + "Total Amount : "+$( "#premAmount" ).val()+"<br><br> <span class='text-danger'> After confirmation notice will generate and on clicking payment notice button, this will be available at citizen end.</span>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {
                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                    $('#btnNotice').prop('disabled', false);
                    $('#btnNotice').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnNotice').prop('disabled', false);
                $('#btnNotice').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnNotice').prop('disabled', false);
            $('#btnNotice').val('Save and submit');
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                // 'error'
            )
        }
    })
    });
</script>


<script>
    function reCalculatePremiumWithOutConcession(case_no, is_concession)
    {
        if(!confirm("Are you sure you want to recalculate premium without concession?"))
        {
            return false;
        }
        // $("#overlay").fadeIn(300);
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl + "BhoodanControllerCo/premiumReCalculateCaste",
            type: 'POST',
            data: {'case_no':case_no, 'is_concession':is_concession},
            success: function (data) {
                $.unblockUI();
                
                arr = JSON.parse(data);

                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }
                else
                {
                    Swal.fire({
                        text: arr.msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                        else
                        {
                            window.location.reload();
                        }
                    })
                }

            },
            error: function (error) {
                console.log(error);
                $.unblockUI();
                alert("Something went wrong");
            }

        })
    }
</script>