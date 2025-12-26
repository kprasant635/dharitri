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
                <a href="<?php echo base_url()?>index.php/SettlementTenantCo/printNotice?case_no=<?=$_GET['case']?>" target="GenerateNotice"><button type="button" name="print_notice" type="button" class="m-1 col-1 text-white btn btn-warning btn-sm">Print Notice</button>
                </a>
            </div>

        <?php } ?>
        <!-- <h5 class="card-title">
          <u>CO Report</u>
        </h5> -->
        <div class="card-text mt-2 co-report">
            <form
                    method="post"
                    action="<?php echo base_url()?>index.php/SettlementTeaCo/generatePaymentNoticeCoSave"
            >
                <div class="row ml-3 mr-3 justify-content-end">
                    <button onclick="premiumReCalculte('<?=$_GET['case']?>')" title="This will calculate the premium on the latest zonal value." class="btn btn-sm col-4 btn-warning" type="button">
                        <small>Zonal value might have changed! Do you want to refresh?</small>
                        <br>
                        <b><u>Click to refresh</u></b>
                    </button>
                </div>
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

                    <?php if(PAYMENT_NOTICE_BUTTON == 1): ?>

                        <?php if($basic->pay_notice_gen_yn == 'Y'){ ?>

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
                            >
                                Generate payment notice
                            </button>
                        <?php }?>

                    <?php endif; ?>


                </div>

            </form>
        </div>
    </div>
</div>
<!-- <ul class="list-inline pull-right">
  <li>
    <button type="button" class="btn btn-default prev-step">
      Previous
    </button>
  </li>
  <li>
    <button type="button" class="btn btn-default next-step">
      Skip
    </button>
  </li>
  <li>

  </li>
</ul> -->
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

    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }
    //   $(document).ready(function() {
    //     $("form").submit(function(e){
    //       showErrorMessage('This features will be made available soon !!!');
    //         e.preventDefault(e);
    //     });
    // });
</script>


<script>
    function premiumReCalculte()
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to refresh the zonal value?',
            // html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Refresh',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed)
        {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            var postData = {
                'case_no' : "<?php echo $_GET['case']?>"
            }

            $.ajax({
                url: baseurl+'SettlementTeaCo/premiumReCalculateTea',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                    if(arr.responseType != 2){
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
                            if (result.isConfirmed)
                        {
                            window.location = window.location;
                        }
                    })
                    }
                }
            });

        }
    })
    }
</script>