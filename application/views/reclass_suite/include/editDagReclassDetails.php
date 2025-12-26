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


<div id="editDagReclassDetails" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-edit-applicant px-4">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
               <strong>Enter Dag Details</strong>
            </div>
        </div>
       <input type="hidden" id="dag_no" name="dag_no">

    <div class="mb-3">
      <label class="form-label">Whether the Area is Prime Agri Land?</label><br>
      <div>
        <input type="radio" id="primeAgriYes" name="primeAgriLand" value="yes"> 
        <label for="primeAgriYes" style="color:red;">YES</label>
        <input type="radio" id="primeAgriNo" name="primeAgriLand" value="no" class="ms-3"> 
        <label for="primeAgriNo">NO</label>
      </div>
    </div>
    <div class="mb-3 d-none" id="unfitForCultivationSection">
      <label class="form-label">Whether the land is unfit for cultivation ?</label><br>
      <div>
        <input type="radio" id="unfitYes" name="unfitForCultivation" value="yes"> 
        <label for="unfitYes">Yes</label>
        <input type="radio" id="unfitNo" name="unfitForCultivation" value="no" class="ms-3"> 
        <label for="unfitNo">No</label>
      </div>
    </div>
    <div class="mb-3 d-none" id="notUnderCultivationSection">
      <label class="form-label">Whether it is not under cultivation for last minimum ten years ?</label><br>
      <div>
        <input type="radio" id="notUnderYes" name="notUnderCultivation" value="yes"> 
        <label for="notUnderYes">Yes</label>
        <input type="radio" id="notUnderNo" name="notUnderCultivation" value="no" class="ms-3"> 
        <label for="notUnderNo">No</label>
      </div>
    </div>
    <div class="mb-3 d-none" id="uploadDocument">
      <label class="form-label">Upload cultivation Document(Agriculture dept)</label>
      <input type="file" class="form-control" name="recommendedDocument" id="recommendedDocument" accept="application/pdf,image/*">
    </div>
    <div class="mb-3">
      <label class="form-label">Whether land covered by the dag is fit for reclassification?</label><br>
      <div>
        <input type="radio" id="reclassificationYes" name="reclassification" value="yes"> 
        <label for="reclassificationYes">YES</label>
        <input type="radio" id="reclassificationNo" name="reclassification" value="no" class="ms-3"> 
        <label for="reclassificationNo">NO</label>
      </div>
    </div>
    

        <div class="row justify-content-center">
            <button type="button" onclick="updateApplicantDetails();" class="btn btn-sm btn-danger col-3">UPDATE</button>
        </div>
    </p>
  </div>

</div>

<script>


  // document.getElementById("primeAgriYes").addEventListener("click", function () {
  //   document.getElementById("unfitForCultivationSection").classList.remove("d-none");
  // });

  document.getElementById('primeAgriYes').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('reclassificationNo').checked = true;
        document.getElementById('reclassificationYes').disabled = true;
        document.getElementById('reclassificationNo').disabled = true;

        document.getElementById("unfitForCultivationSection").classList.add("d-none");
        document.getElementById("notUnderCultivationSection").classList.add("d-none");
        document.getElementById("uploadDocument").classList.add("d-none");
    } else {
        document.getElementById('reclassificationYes').disabled = false;
        document.getElementById('reclassificationNo').disabled = false;
    }
});

document.getElementById('primeAgriNo').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('reclassificationNo').checked = false;
        document.getElementById('reclassificationYes').disabled = false;
        document.getElementById('reclassificationNo').disabled = false;

        document.getElementById("unfitForCultivationSection").classList.remove("d-none");
        document.getElementById("notUnderCultivationSection").classList.remove("d-none");
    }
});


  document.getElementById("primeAgriNo").addEventListener("click", function () {
    document.getElementById("unfitForCultivationSection").classList.add("d-none");
    document.getElementById("notUnderCultivationSection").classList.add("d-none");
  });

  document.getElementById("unfitYes").addEventListener("click", function () {
    document.getElementById("notUnderCultivationSection").classList.remove("d-none");
  });

  document.getElementById("unfitNo").addEventListener("click", function () {
    document.getElementById("notUnderCultivationSection").classList.add("d-none");
  });
  document.getElementById("notUnderCultivationSection").addEventListener("click", function () {
    document.getElementById("uploadDocument").classList.remove("d-none");
  });


  document.getElementById('unfitNo').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('reclassificationNo').checked = true;
        document.getElementById('reclassificationYes').disabled = true;
        document.getElementById('reclassificationNo').disabled = true;

        //document.getElementById("unfitForCultivationSection").classList.add("d-none");
        document.getElementById("notUnderCultivationSection").classList.add("d-none");
        document.getElementById("uploadDocument").classList.add("d-none");
    } 
    else {
        document.getElementById('reclassificationYes').disabled = false;
        document.getElementById('reclassificationNo').disabled = false;
        document.getElementById('reclassificationNo').checked = false;
        document.getElementById('reclassificationYes').checked = false;
    }

});


  document.getElementById('unfitYes').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('reclassificationNo').checked = false;
        document.getElementById('reclassificationYes').disabled = false;
        document.getElementById('reclassificationNo').disabled = false;

        document.getElementById("unfitForCultivationSection").classList.remove("d-none");
        document.getElementById("notUnderCultivationSection").classList.remove("d-none");
    }
});

</script>
