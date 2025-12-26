<?php

echo $base64_decoded_notice_file;

?>
<div class="container">
  <div class="row mt-4 mb-5 justify-content-center text-center">
    <div class="col-6">
      <button
        type="button"
        onclick="updateNoticeAst()"
        id="print"
        class="btn btn-success text-white"
      >
        Print Notice
      </button>
    </div>
  </div>
</div>

<!-- Encroacher modal -->
<script src="<?php echo base_url();?>js/jAlert-v3.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jAlert-v3.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- css for datatable -->
<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>
<script>
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
</script>

<script>
  // -js-to print notice
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML
    var originalContents = document.body.innerHTML

    document.body.innerHTML = printContents

    window.print()

    document.body.innerHTML = originalContents
  }

  function updateNoticeAst(){

        // var notice_case_no = $.trim($('#area_update_case_no').val());
        var notice_case_no = '<?php echo $case_no;?>';
      
       
        // prepare for updation
        var postData = {
            'notice_case_no' : notice_case_no
        };

        // $.blockUI({
        //     message: $('#displayBox'),
        //     css: {
        //         border:'none',
        //         backgroundColor:'transparent'
        //     }
        // });

        $.ajax({
            url: baseurl+'SettlementCommon/updateNoticeDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                // $.unblockUI();
                if(arr.responseType == 0){
                    Swal.fire({
                            text: arr.msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                    })
                    // alert("Something went wrong in notice generate!!!");
                }
                else if(arr.responseType == 2){ 
                  printDiv('print_direct');
                }
            }
        });

    }
</script>
