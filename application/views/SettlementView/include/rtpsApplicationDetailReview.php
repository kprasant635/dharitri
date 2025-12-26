<style>
    
  @media (max-width: 480px) {
    .modal-dialog {
      max-width: 94%;
      margin: 1.75rem auto;
    }
  }
  @media (min-width: 576px){
    .modal-dialog {
      max-width: 850px;
      margin: 1.75rem auto;
    }
  }

</style>


<!-- Modal -->
<div class="modal" id="applicationModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header" style="color:#fff; background-color:#176d84; font-weight: bold; border: none">
        Application: <b><span class="apl_no"></span></b> | Date of Submission: <b><span class="submission_date"></span></b>
        <span class="px-4" style="cursor: pointer;" onclick="btnCloseModal()">&times;</span>
      </div>

      <div class="modal-body">

        <!-- applicants detail -->
        <div class="row">
          <h1>Applicant Detail</h1>          
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              AppLicant Name:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <b><span class="applicant_name"></span></b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              Guardian Name:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <b><span class="guardian_name"></span></b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              Date of Birth:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <b><span class="dob"></span></b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              Mobile:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <b><span class="mobile"></span></b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              Present Address:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <b><span class="present_add"></span></b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              Permanent Address:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <b><span class="per_add"></span></b>
            </div>
          </div><hr>
        </div>

        <!-- area details of khas/pgr/tribal/culti -->
        <div class="row area_detail_div" style="display:none">
          <h1>Area Detail</h1>          
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <table class="table table-hover table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>Dag No</th>
                    <th>Actual Area(B/K/L/G/Kr)</th>
                    <th>Homestead Area(B/K/L/G/Kr)</th>
                    <th>Agriculture Area(B/K/L/G/Kr)</th>
                  </tr>
                </thead>
                <tbody class="area_details"></tbody>                
              </table>
            </div>
          </div><hr>         
        </div>

        <!-- occupier detail -->
        <div class="row occupier_detail_div" style="display:none">
          <h1>Occupier Detail</h1>          
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <table class="table table-hover table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>Dag No</th>
                    <th>Occupier Name</th>
                    <th>Guardian Name</th>
                    <th>Possession Since</th>
                  </tr>
                </thead>
                <tbody class="occupier_details"></tbody>                
              </table>
            </div>
          </div><hr>         
        </div>

        <!-- owner detail -->
        <div class="row owner_detail_div" style="display:none">
          <h1>Land Owner Detail</h1>          
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <table class="table table-hover table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Guardian Name</th>
                  </tr>
                </thead>
                <tbody class="owner_details"></tbody>                
              </table>
            </div>
          </div><hr>         
        </div> 

        <!-- area details of tenant / ap -->
        <div class="row tenant_ap_area_detail_div" style="display:none">
          <h1>Area Detail</h1>          
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <table class="table table-hover table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>Dag No</th>
                    <th>Actual Area</th>
                    <th>Applied Area</th>
                  </tr>
                </thead>
                <tbody class="tenant_ap_area_details"></tbody>                
              </table>
            </div>
          </div>  
          <hr>        
        </div>
        
      </div>
      
    </div>
    
  </div>
</div>

<script type="text/javascript">

  function btnCloseModal() {
    $('#applicationModal').modal('hide');
    $('.owner_details').html('');
    $('.tenant_ap_area_detail_divs').html('');
  }
</script>