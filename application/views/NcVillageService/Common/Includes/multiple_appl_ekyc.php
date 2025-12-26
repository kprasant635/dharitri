
<div id="listOfToBeEkycAppl" class="modal">
  <div class="modal-dialog" role="document" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">
              List of Applicant to be replaced by main applicant
          </h5>
          <i class="fa fa-close fa-2x text-red closeAppl" style="cursor:pointer;"></i>
      </div>
      <div class="modal-body">
        <div id="show_ekyc_appl_list"></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.closeAppl').click(function(){
    var listOfToBeEkycAppl = document.getElementById("listOfToBeEkycAppl");
    listOfToBeEkycAppl.style.display = "none";
  })
</script>