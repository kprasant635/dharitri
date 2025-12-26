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
    .reza-title{
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 10px;
      margin-top: 10px;
      background: linear-gradient(to right, #267871, #136a8a);
      color: white;
      text-transform: capitalize;
      text-align: center;
      padding: 8px;
   }
</style>
<input type="hidden" id="case_no" value="<?=$basic['case_no']?>">
<input type="hidden" id="code_service" value="<?=$basic['service_code']?>">
<input type="hidden" id="code_dist" value="<?=$basic['dist_code']?>">
<input type="hidden" id="code_sub" value="<?=$basic['subdiv_code']?>">
<input type="hidden" id="code_cir" value="<?=$basic['cir_code']?>">
<input type="hidden" id="code_mouza" value="<?=$basic['mouza_pargona_code']?>">
<input type="hidden" id="code_lot" value="<?=$basic['lot_no']?>">
<input type="hidden" id="code_vill" value="<?=$basic['vill_townprt_code']?>">

<?php 

  foreach($dags as $r){
      $urban = $r->is_urban;
      break;
  }
?>
<input type="hidden" id="code_rural_urban" value="<?=$urban?>">

<div id="newTeaGrantDagEntryDetails" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
      <span class="close-new-dag-entry px-4" style="cursor:pointer;">&times;</span>
      <div id="closeModalDagDiv"></div>
    </div><p>
    
    <div class="row">
      <div class="col-md-12 text-center">
        <h5 class="reza-title">
          New Dag Entry Form
        </h5>
      </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <input type="hidden" id="applied_detail" value="0"> <!-- 0: old data, 1: new data -->
      <input type="hidden" id="clicked_from" value=""> <!-- R: clicked from revert, F: clicked from first proceeding -->

      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <label>Patta Type</label>
        <select class="form-control" id="new_patta_type">
          <option value="" disabled selected>-- Select Patta Type --</option>
        </select>
      </div>

      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <label>Patta No</label>
        <select class="form-control" id="new_patta_no">
          <option value="" disabled selected>-- Select Patta No --</option>
        </select>
      </div>


      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label>Choose Dag to be added</label>
        <select class="form-control" id="dag_list">
          <option value="" disabled selected>-- Select Dag --</option>
        </select>
      </div>

      <div class="pattadar_detail" style="display:none">
        
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              

              <label>Select Pattadar</label>
              <hr>
              <div class="list-group form__div" id="pattadar_list_details">
              </div>
              <br>
              <div id="pattadar_not_exist_id"></div>

              <br>

              <div class="new_dag_div_deed_detail" style="display:none">
                
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Select Land Owner&nbsp;<span class="text-red">*</span></label>
                  <select class="form-control" id="land_owner_list">
                  </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Enter Deed No&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_deed_no">
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Name is Assamese&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_name_in_asm">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Name is English&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_name_in_eng">
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Guardian Name is Assamese&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_gname_in_asm">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Guardian Name is English&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_gname_in_eng">
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Relation&nbsp;<span class="text-red">*</span></label>
                  <select class="form-control" id="new_dag_relation" required>
                  </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Date of Birth&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_dob" readonly>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Gender&nbsp;<span class="text-red">*</span></label>
                  <select class="form-control" id="new_dag_gender" required>
                  </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <label class="form-check-label label-style">Mobile&nbsp;<span class="text-red">*</span></label>
                  <input type="text" class="form-control new_dag_data" value="" id="new_dag_mobile" maxlength="10">
                </div>

              </div>


              <label>Enter Your Area Details</label>
              <hr>
              <div id="area_details">
              </div>
            </div>
            
          </div>
        </div>
        
        <input type="hidden" id="new_dag_int" value="0">
        <input type="hidden" id="basu_appl_no" value="<?=$basic['applid']?>">

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>

        <div class="row">
          <button type="button" class="btn btn-primary" id="saveTeaGrantNewDag" data-dismiss="modal">Save New Dag</button>
        </div>
      </div>
      
    </div>

  </div>

</div>

<script src="<?php echo base_url();?>js/mb3/teaGrant/newDagEntryTea.js"></script>