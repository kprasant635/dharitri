<style>
    /* The Close Button */
    .close-edit-area {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-edit-area:hover,
    .close-edit-area:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<!-- <div id="editAreaDetails" class="modal"> -->
<div class="modal" role="dialog" id="editAreaDetails" >
  <div class="modal-dialog" role="document"  style="max-width: 80%; ">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="row text-right">
          <span class="close-edit-area-adc px-4">&times;</span>
      </div>
      <p>
          <div class="row">
              <div class="col-md-12 text-center">
                  <h5>Edit Area Details DAG - 
                      <span id="edit_area_span_dag_no"></span> 
                  </h5>
              </div>
          </div>

          <table class="table">
              <thead class="thead-warning">
                  <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Bigha</th>
                      <th class="text-center">Katha</th>
                      <th class="text-center">Lessa</th>
                      <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                      <th class="text-center">Ganda</th>
                      <th class="text-center"></th>
                      <?php endif; ?>

                  </tr>
              </thead>
              <tbody>
                  <input type="hidden" id="area_update_id">
                  <input type="hidden" id="area_update_dag_no">
                  <input type="hidden" id="area_update_case_no">
                
                  <input type="hidden" id="area_update_urban_check">
                  <tr>
                      <th>Total Land in selected Dag</th>
                      <td>
                          <input type="number" id="total_bigha_in_dag" style="font-weight:bold;" readonly class="text-center form-control input-sm">
                      </td>
                      <td>
                          <input type="number" id="total_katha_in_dag" style="font-weight:bold;"  readonly class="text-center form-control input-sm">
                      </td>
                      <td>
                          <input type="number" id="total_lessa_in_dag" style="font-weight:bold;"  readonly class="text-center form-control input-sm">
                      </td>
                      
                      <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                      <td>
                          <input type="number" id="total_ganda_in_dag" style="font-weight:bold;"  readonly class="text-center form-control input-sm">
                      </td>
                      <td>
                          <input type="hidden" id="total_kranti_in_dag" style="font-weight:bold;"  readonly class="text-center form-control input-sm">
                      </td>
                      <?php endif; ?>

                  </tr>

                  <tr>
                      <th>Applied Area</th>
                      <td>
                          <input type="number" id="enc_bigha_home" style="font-weight:bold;" class="text-center form-control input-sm">
                      </td>
                      <td>
                          <input type="number" id="enc_katha_home" style="font-weight:bold;" class="text-center form-control input-sm">
                      </td>
                      <td>
                          <input type="number" id="enc_lessa_home" style="font-weight:bold;" class="text-center form-control input-sm">
                      </td>

                      <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                      <td>
                          <input type="number" id="enc_ganda_home" style="font-weight:bold;" class="text-center form-control input-sm">
                      </td>
                      <td>
                          <input type="hidden" id="enc_kranti_home" style="font-weight:bold;" class="text-center form-control input-sm">
                      </td>
                      <?php endif; ?>

                  </tr>
                  
              </tbody>
          </table>
          
          <div class="row justify-content-center">
              <button type="button" onclick="updateTeaGrantAreaAtAdc();" class="btn btn-sm btn-danger col-3">UPDATE</button>
          </div>
      </p>
    </div>
  </div>
</div>




