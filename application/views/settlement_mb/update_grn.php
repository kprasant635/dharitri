<script>
    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>
<style type="text/css">
    .datepick-popup{
        position: fixed;
        left:0 px;
        right:0 px;
        z-index:10000;
    }
</style>

<div class="row bg-white m-3 p-4">
    <table class="table" id="dataTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Case No</th>
                <th>Application No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sl = 1;
                foreach($cases_list as $case){
                    ?>
                    <tr>
                        <td><?=$sl++?></td>
                        <td><?=$case->case_no?></td>
                        <td><?=$case->applid?></td>
                        <td>
                            <button type="button" onclick="challenModel('<?=$case->case_no?>')" class="btn btn-primary">Update Grn</button>
                        </td>
                    </tr>
                    <?php
                }
            ?>

        </tbody>
    </table>
</div>

<div class="modal" id="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> UPDATE GRN NO <br><small class="text-danger fw-bold"><span id="case_span"></span></small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
            <form method="post" id="update_grn_form" enctype="multipart/form-data">
                <input type="hidden" name="case_no" id="case_no">
                <tr>
                    <td width="50%">GRN No</td>
                    <td>
                        <input type="text" name="grn_no" class="form-control" placeholder="Enter GRN no">
                    </td>
                </tr>
                <tr>
                    <td width="50%">Date of payment</td>
                    <td>
                        <input type="text" readonly name="payment_date" class="form-control ymd" placeholder="Date of payment">
                    </td>
                </tr>
                <tr>
                    <td width="50%">Amount</td>
                    <td>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount">
                    </td>
                </tr>
                <tr>
                    <td width="50%">Challen</td>
                    <td>
                        <input type="file" name="challen" class="form-control">
                    </td>
                </tr>
            </form>
          
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="UpdateChanges">Update changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="Close">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
    });
</script>

<script>
    $(document).on('click', '#Close', function (e) {
        $('#modal').hide();
    });
</script>

<script>
    function challenModel(case_no){
        $('#modal').show();
        $('#case_no').val(case_no);
        $('#case_span').html(case_no);
    }

    $(document).on('click', '#UpdateChanges', function (e) {
        var case_no =  $('#case_no').val();
        var formElement = document.getElementById('update_grn_form');
        var formData = new FormData(formElement);
        if (!confirm("Are you sure you want to change your password!")) {
            return false;
        }
        //update here
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        
        $.ajax({
            type: "POST",
            url: baseurl+'SettlementMbCo/updateGRN',
            data: formData, // Use FormData object to serialize the form's elements
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type
            beforeSend: function() {
                $('#modal').hide();
            },
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0){
                    Swal.fire({
                            text: arr.msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                    })
                }
                else{
                    // modal.style.display = "none";
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
                            window.location = window.location;
                        }
                    })

                }
            },
        });

    });
</script>