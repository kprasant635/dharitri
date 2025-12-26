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


<div id="updateDagReclassDetails" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-edit-applicant px-4">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
               <strong>Enter Reclass Details for selected Dag</strong>
            </div>
        </div><br>
       <input type="hidden" id="dag_no" name="dag_no">

    <div class="mb-3">
      <label class="form-label">Whether land covered by the dag is fit for reclassification ? (The Dag will be ineligible for reclassification if you click NO)</label><br>
      <div>
        <input type="radio" id="reclassificationfitYes" name="reclassification_nonagri" value="yes"> 
        <label for="reclassificationfitYes" style="color:red;">YES</label>
        <input type="radio" id="reclassificationfitNo" name="reclassification_nonagri" value="no" class="ms-3"> 
        <label for="reclassificationfitNo">NO</label>
      </div>
    </div>

    <div class="mb-3 d-none" id="remarksection">
      <label class="form-label">Reason for not fit</label><br>
      <div>
        <textarea id="remark" name="remark" rows="4" class="form-control shadow-sm" placeholder="Enter your remark here..." required></textarea>
      </div>
    </div>

        <div class="row justify-content-center">
            <button type="button" onclick="updateApplicantDetailsReclassfit();" class="btn btn-sm btn-danger col-3">UPDATE</button>
        </div>
    </p>
  </div>

</div>

<script>
  document.getElementById('reclassificationfitYes').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById("remarksection").classList.add("d-none");
    } else {
        document.getElementById("remarksection").classList.remove("d-none");
    }
});

  document.getElementById("reclassificationfitNo").addEventListener("click", function () {
    document.getElementById("remarksection").classList.remove("d-none");
  });

</script>
