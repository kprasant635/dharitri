<style>
    .card-content{
        background-color: #FFF;
    }
</style>
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
        <a href="<?php echo base_url()?>index.php/SettlementKhasCo/printNotice?case_no=<?=$_GET['case']?>" target="GenerateNotice"><button type="button" name="print_notice" type="button" class="m-1 col-1 text-white btn btn-warning btn-sm">Print Notice</button>
        </a>
      </div>
    
    <?php } ?>
      <!-- <h5 class="card-title">
        <u>CO Report</u>
      </h5> -->
      <div class="card-text mt-2 co-report">
        <form
          method="post"
          action="<?php echo base_url()?>index.php/SettlementKhasCo/generatePaymentNoticeCoSave"
          id="formNotice"
        >

        <div class="row">
          
          <?php include(APPPATH."views/SettlementView/include/premiumDetailsView.php"); ?>

     
        </div>
        <hr style="margin-top: 0;">
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



        <div class="row mt-4 justify-content-center">
        <?php if(PAYMENT_NOTICE_BUTTON == 1){ ?>
       
            <?php
                  if($basic->pay_notice_gen_yn == 'Y'){ ?>

                  <button
                  type="submit"
                  name="generate_notice"
                  type="button"
                  class="m-1 col-2 text-white btn btn-danger btn-sm"
                  disabled
                >
                  Print payment notice
                </button>

                <?php }else{ ?>
                  <button
                  type="submit"
                  name="generate_notice"
                  type="button"
                  class="m-1 col-2 text-white btn btn-danger btn-sm"
                  id="btnNotice"
                >
                  Generate payment notice
                </button>
                <?php }?>
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
