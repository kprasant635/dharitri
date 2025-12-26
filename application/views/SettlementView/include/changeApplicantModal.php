<style>
    /* The Close Button */
    .close-edit-applicant {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-edit-applicant:hover,
    .close-edit-applicant:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<div id="changeApplDetail" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-edit-applicant px-4 close_appl_modal">&times;</span>
    </div>
    <p>
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <label>Do you want to change the <span class="text-red">Main Applicant</span> ?</label> 
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

              <div class="form-check form-check-inline">
                  <input class="form-check-input changes_required_yes" 
                  type="radio" name="changes_required" value="1">
                  <label class="form-check-label">YES</label>                  
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input changes_required_no" 
                  type="radio" name="changes_required" value="0">
                  <label class="form-check-label">NO</label>
              </div>
          </div>                  

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

        </div>

    </p>
  </div>

</div>


<script type="text/javascript">
  
  $('.close_appl_modal').click(function(){
    $('#changeApplDetail').hide();
  });


</script>
