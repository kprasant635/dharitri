<script>
    $(function () {
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal('show');
                    $('body').addClass('bodytest');
                }
            });
        });
    })
</script>

<style>
    .custom-table th, td
    {
        padding-left : 8px;
        padding-right : 8px;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1);
    }
</style>




  <div class="container shadow bg-white">
    <div class="row mb-3">
      <h5 class="p-4 shadow" style="background: #1b707f">
        <span class="text-white p-2 shadow-sm">
          <i class="fa fa-hand-o-right" aria-hidden="true"></i>
          Payment confirmation for the case (<?=$case_no;?>)
        </span>
      </h5>

      <?php if ($this->session->flashdata('message')) : ?>
      <div class="alert alert-success">
        <strong><?= $this->session->flashdata('message'); ?></strong>
      </div>
      <?php endif; ?>
    </div>
    <!-- <input type="text" name="case_no" id='case_no' value="<?=$case_no;?>" />
 -->
    <div class="row px-4 justify-content-center">
      <div class="col-md-5 shadow m-2 border">
        <div class="row p-2 m-1" style="background: #1a6f81">
          <div class="col-12 text-white">
            <h5>Application Details</h5>
            <small>
              <strong>
                Case No:
                <?=$case_no;?>
              </strong>
            </small>
          </div>
        </div>
        <div class="row bg-white p-3">
          <div class="col-12 text-center">
            <h6>
              APPLICANT CASE NUMBER
              <i class="fa fa-level-down" aria-hidden="true"></i>
            </h6>
            <h5><?=$case_no_rtps;?></h5>
          </div>
        </div>
      </div>

      <div class="col-md-5 shadow m-2 border">
        <div class="row p-2 m-1" style="background: #1a6f81">
          <div class="col-12 text-white">
            <h5>Payment Status</h5>
            <small>
              <strong>
              
              </strong>
            </small>
            <!-- <a class="btn btn-danger btn-sm ml-2" id="btnCancelPremium">Cancelled Premium Notice</a> -->
          </div>
        </div>

        <div class="row p-3">
          <div class="row">
            NOT REQUIRED
          </div>
      </div>
  </div>
 <form action="<?php echo base_url()?>index.php/ReclassSuiteControllerCO/updateRevenueLoctax" method="post">
   

  <div class="container-fluid px-2 px-md-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8"> <!-- Responsive width -->
      <div class="card w-100 shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="mb-0">Update DAG Details</h4>
        </div>

        <input type="hidden" name="case_no" id="case_no" value="<?= $case_no; ?>" />

        <div class="container-fluid mt-3">
          <?php foreach ($get_dags as $index => $dag): ?>
            <div class="card mb-4 shadow-sm">
              <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                  <h5 class="card-title mb-2 mb-md-0">DAG No: <?= $dag->dag_no ?? ($index + 1) ?></h5>

                   <strong class="text-danger">PROPOSED CLASS: <?= $dag->proposed_land_class_name ?></strong>

                  
                  <strong class="text-danger">
                    <?php
                      if ($dag->co_is_full_partition == 'N' && $dag->co_is_partition == 'Y') {
                        echo 'Partial area Partition (' . $dag->co_area_b . 'B-' . $dag->co_area_k . 'K-' . $dag->co_area_lc . 'L)';
                      } elseif ($dag->co_is_full_partition == 'Y' && $dag->co_is_partition == 'Y') {
                        echo 'Full area with Partition <br>';
                        $data = $this->reclassModel->fecthArea($dag->dist_code, $dag->subdiv_code, $dag->cir_code, $dag->mouza_pargona_code, $dag->lot_no, $dag->vill_townprt_code, $dag->dag_no);
                        echo 'Area (' . $data->dag_area_b . 'B-' . $data->dag_area_k . 'K-' . $data->dag_area_lc . 'L)';
                      } else {
                        echo 'FULL DAG RECLASS <br>';
                        $data = $this->reclassModel->fecthArea($dag->dist_code, $dag->subdiv_code, $dag->cir_code, $dag->mouza_pargona_code, $dag->lot_no, $dag->vill_townprt_code, $dag->dag_no);
                        echo 'Area (' . $data->dag_area_b . 'B-' . $data->dag_area_k . 'K-' . $data->dag_area_lc . 'L)';
                      }
                    ?>
                  </strong>
                </div><br><br>

                <div class="row">

                  <div class="form-group col-12 col-md-6">
                    <label><?= $this->lang->line('proposed_land_revenue'); ?></label>
                    <input type="text" class="form-control P_land_recl"
                           id="P_land_recl<?= $index ?>" name="P_land_rev[<?= $index ?>]"
                           placeholder="Enter revenue">
                  </div>

                  <div class="form-group col-12 col-md-6">
                    <label><?= $this->lang->line('proposed_local_tax'); ?></label>
                    <input type="text" class="form-control p_loc_tax_recl"
                           id="p_loc_tax_recl<?= $index ?>" name="p_local_tax[<?= $index ?>]" readonly>
                  </div>

                  <div class="form-group col-12 col-md-6 d-none">
                    <label>Rev Difference</label>
                    <input type="text" class="form-control rev_diff"
                           id="rev_diff<?= $index ?>" name="rev_diff[<?= $index ?>]" readonly>
                  </div>
                </div>
              </div>

              <input type="hidden" name="tot_rev[<?= $index ?>]" class="tot_rev" value="<?= $dag->total_revenue ?? 0 ?>">
              <input type="hidden" name="dag_no[<?= $index ?>]" value="<?= $dag->dag_no ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <div class="card-footer text-center">
          <button type="submit" class="btn btn-success btn-lg">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>

</form>

<div class="container mt-4">
  <h4 class="mb-3 text-center">DAG Details Summary</h4>
  
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>DAG No</th>
          <th>Proposed Land Revenue</th>
          <th>Local Tax</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($get_dags as $index => $row):
            ?>
          <tr>
            <td><?= ($index + 1) ?></td>
            <td><?= htmlspecialchars($row->dag_no) ?></td>
            <td><?= number_format($row->proposed_land_rev, 2) ?></td>
            <td><?= number_format($row->proposed_local_tax, 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

    <input type="hidden" name="case_no" id="case_no" value="<?= $case_no; ?>" />

    <div class="row px-4 justify-content-center">
          <div class="card-footer text-center">
            <button type="button" id="chithaUpdate" class="btn btn-success btn-lg mx-auto">Update Chitha</button>
          </div>
    </div>

</div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
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
<style>
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 80%;
            margin: 1.75rem auto;
        }
    }
</style>




<script type="text/javascript">
    $(document).ready(function () {
        $('.P_land_recl').on('keyup', function () {
            let row = $(this).closest('.card-body');

            let P_land_rev = parseFloat($(this).val());
            let loc_tax = 0;
            let total = 0;

            if (!isNaN(P_land_rev) && P_land_rev >= 0) {
                loc_tax = P_land_rev / 4;
                total = P_land_rev + loc_tax;

                // Update fields in the same row
                row.find('.p_loc_tax_recl').val(loc_tax.toFixed(2));

                let tot_rev = parseFloat(row.find('.tot_rev').val()) || 0;
                let rev_diff = total - tot_rev;

                row.find('.rev_diff').val(rev_diff.toFixed(2));
            } else {
                // Clear if invalid
                row.find('.p_loc_tax_recl').val('');
                row.find('.rev_diff').val('');
            }
        });
    });
</script>


<script type="text/javascript">
    $('#chithaUpdate').on('click', function(event){
        event.preventDefault();

        var case_no = $.trim($('#case_no').val());
        $('.error').html('');
         var postData = {
            'case_no' : case_no,
        };
        //console.log(formData);
        $.ajax({
            type        : 'POST',
            url         : baseurl+'ReclassSuiteControllerCO/updateChitha',
            data        : postData,
            // dataType    : 'json',
            // encode      : true,
            beforeSend: function(){
                $("#loading").html("Validating ...Please wait...");
                $('.alert').hide();
            },
            success: function(data){
                $.unblockUI();
                arr = JSON.parse(data);
                // console.log(arr.success);return;
                if(arr.success != null){
                        //showSuccessMessage(arr.success);
                        showSuccessMessage(arr.success).then(() => {
                         window.location.reload();
                        });
                }
                else if(arr.error!=null){
                    showErrorMessage(arr.error);
                    return false;
                }
            },
            error: function(errorData){
                $("#loading").hide();
                $('.btn-block').show();
                if(errorData.status == 403){
                    const errorInJson = errorData.responseJSON.errors;
                    if(Object.keys(errorInJson).length){
                        $.each(errorInJson, function(index, value){
                            $(`.${index}_error`).html(value);
                        });
                    }else{
                        $('.error_container').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
                    }
                }else{
                    $('.error_container').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
                }
            }
        });
    });
</script>