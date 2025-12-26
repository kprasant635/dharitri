<style>
  .card {
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      border-radius: 12px;
      margin-bottom: 25px;
  }
  .card-header {
      background: linear-gradient(90deg, #136a8a, #267871);
      color: #fff !important;
      border-top-left-radius: 12px !important;
      border-top-right-radius: 12px !important;
  }
  h4.mb-0 i {
      color: #fff;
  }
  .table th, .table td {
      vertical-align: middle !important;
  }
  #dagCompTable thead th {
      position: sticky;
      top: 0;
      background-color: #e9ecef;
      z-index: 10;
  }
  .form-control:focus {
      border-color: #136a8a;
      box-shadow: 0 0 0 0.2rem rgba(19,106,138,0.25);
  }
  .btn-primary {
      background: linear-gradient(to right, #136a8a, #267871);
      border: none;
      border-radius: 30px;
      transition: 0.3s;
  }
  .btn-primary:hover {
      transform: scale(1.05);
      background: linear-gradient(to right, #267871, #136a8a);
  }
  .success-msg, .alert {
      border-radius: 8px;
  }
  .fw-semibold {
      font-weight: 600;
  }
  .floating-submit {
      position: sticky;
      bottom: 10px;
      text-align: right;
  }
</style>

<div class="container py-3">
    <div class="row">
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')) { ?>
          <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
              <i class="fa fa-check-circle me-2"></i>
              <strong><?= $this->session->flashdata('success') ?></strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
          <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
              <i class="fa fa-times-circle me-2"></i>
              <strong><?= $this->session->flashdata('error') ?></strong><br>
              <small><?= $this->session->flashdata('error_code') ?></small>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>
        <?php } ?>

        <section>
          <form id="dcFinalForm">
            <!-- HEADER -->
            <div class="card">
              <h4 class="text-center my-3 text-primary">
                <i class="fa fa-leaf"></i> Acquisition of Tea Garden Dags under Section 7-A of the Assam Ceiling Act, 1956
              </h4>
            </div>

            <!-- TEA GARDEN INFORMATION -->
            <div class="card">
              <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-info-circle me-2"></i>Tea Garden Information</h4>
              </div>
              <div class="card-body">
                <?php 
                  $info = [
                    "Case no." => $basicD->case_no,
                    "Name of the tea garden" => $basicD->tea_estate_name,
                    "Mobile no." => $basicD->mobile_no,
                    "Notice No." => $basicD->notice_no,
                    "Download Notice" => $noticeLink
                  ];
                  foreach($info as $label => $val): ?>
                    <div class="row py-2 border-bottom">
                      <div class="col-lg-4 fw-semibold"><i class="fa fa-angle-double-right"></i> <?= $label ?></div>
                      <div class="col-lg-8"><?= $val ?></div>
                    </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- LAND AREA INFORMATION -->
            <div class="card">
              <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-map me-2"></i>Land Area Information</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead class="table-secondary text-center">
                    <tr>
                      <th>#</th>
                      <th>Circle</th>
                      <th>Mouza</th>
                      <th>lot no</th>
                      <th>Village</th>
                      <th>Patta No</th>
                      <th>Patta Type</th>
                      <th>Dag No</th>
                      <th>Proposed Area</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($basicDags)): $i=1; foreach($basicDags as $c): ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?=$this->utilityclass->getCircleName($c->dist_code, $c->subdiv_code, $c->cir_code, $c->mouza_pargona_code);?></td>
                        <td><?=$this->utilityclass->getMouzaName($c->dist_code, $c->subdiv_code, $c->cir_code, $c->mouza_pargona_code);?></td>

                        <td><?=$this->utilityclass->getLotName($c->dist_code, $c->subdiv_code, $c->cir_code, $c->mouza_pargona_code, $c->lot_no)?></td>

                        <td><?=$this->utilityclass->getVillageName($c->dist_code, $c->subdiv_code, $c->cir_code, $c->mouza_pargona_code, $c->lot_no, $c->vill_townprt_code)?></td>
                        <td><?= $c->patta_no; ?></td>
                        <td><?= $this->utilityclass->getPattaName($c->patta_type_code); ?></td>
                        <td><?= $c->dag_no; ?></td>
                        <td><?= $c->bigha."B-".$c->katha."K-".$c->lessa."L"; ?></td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr><td colspan="4" class="text-center text-muted">No data submitted yet.</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- CLAIMS AND OBJECTIONS -->
            <div class="card">
              <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-file-text me-2"></i>Claims and Objections</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-secondary text-center">
                    <tr>
                      <th>#</th>
                      <th>Applicant Name</th>
                      <th>Address</th>
                      <th>Nature of Interest</th>
                      <th>Grounds</th>
                      <th>Date of Submission</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($claims)): $i=1; foreach($claims as $c): ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $c->applicant_name; ?></td>
                        <td><?= $c->address; ?></td>
                        <td><?= $c->interest; ?></td>
                        <td><?= $c->grounds; ?></td>
                        <td><?= date('d-M-Y', strtotime($c->date_of_submission)); ?></td>
                        <td><a href="<?= base_url('formyadmin/view/'.$c->id); ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> View</a></td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr><td colspan="7" class="text-center text-muted">No claims submitted.</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- COMPENSATION DETAILS -->
            <div class="card">
              <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-rupee-sign me-2"></i>Compensation Details (50× Revenue)</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover text-center align-middle" id="dagCompTable">
                  <thead class="table-secondary">
                    <tr>
                      <td colspan="10" class="text-start">
                        <label class="fw-semibold me-3">Whether the area in the preceding columns is occupied by the owner under personal cultivation or by tenants:</label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="acq_tenants" id="acq_tenants1" value="YES">
                          <label class="form-check-label" for="acq_tenants1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="acq_tenants" id="acq_tenants0" value="NO" checked>
                          <label class="form-check-label" for="acq_tenants0">No</label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>#</th>
                      <th>Patta No</th>
                      <th>Dag No</th>
                      <th style="color:red">Revenue (₹)</th>
                      <th>Fallow Land</th>
                      <th>Non-Fallow Land</th>
                      <th>Building</th>
                      <th>Improvement</th>
                      <th>Fruit Trees</th>
                      <th>Total (₹)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($basicDags)): $i=1; foreach($basicDags as $d): ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $d->patta_no; ?></td>
                        <td><?= $d->dag_no; ?></td>
                        <td><input type="number" readonly name="revenue[<?= $d->dag_no; ?>]" class="form-control text-center comp-revenue" value="<?= number_format($d->revenue ?? 0, 2, '.', ''); ?>"></td>
                        <td><input type="number" step="0.01" name="comp_fallow[<?= $d->dag_no; ?>]" class="form-control comp-field" value="0"></td>
                        <td><input type="number" step="0.01" name="comp_non_fallow[<?= $d->dag_no; ?>]" class="form-control comp-field" value="0"></td>
                        <td><input type="number" step="0.01" name="comp_building[<?= $d->dag_no; ?>]" class="form-control comp-field" value="0"></td>
                        <td><input type="number" step="0.01" name="comp_improvement[<?= $d->dag_no; ?>]" class="form-control comp-field" value="0"></td>
                        <td><input type="number" step="0.01" name="comp_fruit_trees[<?= $d->dag_no; ?>]" class="form-control comp-field" value="0"></td>
                        <td><input type="text" readonly class="form-control text-center dag-total" name="dag_total[<?= $d->dag_no; ?>]" value="<?= number_format($d->revenue ?? 0, 2, '.', ''); ?>"></td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr><td colspan="10" class="text-center text-muted">No DAGs available.</td></tr>
                    <?php endif; ?>
                  </tbody>
                  <tfoot class="table-light">
                    <tr>
                      <th colspan="9" class="text-end">Grand Total (₹)</th>
                      <th><input type="text" readonly class="form-control text-center fw-bold" id="grand_total" name="comp_total" value="0"></th>
                    </tr>
                  </tfoot>
                </table>

                <div class="mt-3 col-md-4">
                  <label><strong>Number of Installments:</strong></label>
                  <input type="number" class="form-control" name="installments" min="1" value="1">
                </div>
              </div>
            </div>

            <!-- FINAL REMARKS -->
            <div class="card">
              <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-gavel me-2"></i>Final Remarks of DC</h4>
              </div>
              <div class="card-body">
                <input type="hidden" name="case_no" id="case_no" value="<?=$basicD->case_no;?>">
                <textarea placeholder="Enter final remarks..." name="remark_dc_note" id="remark_dc_note" class="form-control mb-3" rows="3"></textarea>
                <div class="floating-submit">
                  <button type="submit" name="dc_final_order" class="btn btn-primary px-4" id="dc_final_order">
                    <i class="fa fa-save me-2"></i>Final Order
                  </button>
                </div>
              </div>
            </div>
          </form>
        </section>
    </div>
</div>


<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>

$(document).on('input', '.comp-field', function(){
  calculateTotals();
});

function calculateTotals(){
  let grand = 0;

  $('#dagCompTable tbody tr').each(function(){
    let row = $(this);
    let revenue = parseFloat(row.find('.comp-revenue').val()) || 0;
    let total = revenue;

    // Add all compensation input fields
    row.find('.comp-field').each(function(){
      total += parseFloat($(this).val()) || 0;
    });

    // Update row total
    row.find('.dag-total').val(total.toFixed(2));
    grand += total;
  });

  // Update grand total
  $('#grand_total').val(grand.toFixed(2));
}
$(document).ready(function(){
    calculateTotals();

  $('#dc_final_order').on('click', function(e){
    e.preventDefault();
    if(!confirm("Are you sure you want to submit the Final Order?")){
      return false; // cancel submission if user clicks "Cancel"
    }

    let formData = $('#dcFinalForm').serialize();

    $.ajax({
      url: baseurl + 'Acquisition/finalOrderPass', 
      type: "POST",
      data: formData,
      dataType: "json",
      beforeSend: function(){
        $('#dc_final_order').prop('disabled', true).text('Saving...');
      },
      success: function(response){
        $('#dc_final_order').prop('disabled', false).text('Final Order');

        if(response.status === 'success'){
          alert('Success: ' + response.message);
          // optionally redirect or reload
          // location.reload();
        } else {
          alert('Error: ' + response.message);
        }
      },
      error: function(xhr, status, error){
        $('#dc_final_order').prop('disabled', false).text('Final Order');
        console.error(error);
        alert('Something went wrong while submitting the form.');
      }
    });
  });

});
</script>


<script>
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

