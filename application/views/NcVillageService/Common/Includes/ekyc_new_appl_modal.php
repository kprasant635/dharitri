



<div id="ekycVerifyModal" class="modal">
  <div class="modal-dialog" role="document" style="max-width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">
              eKyc response
          </h5>
          <i class="fa fa-close fa-2x text-red closeEkyc" style="cursor:pointer;"></i>
      </div>
      <div class="modal-body">
        <div id="show_ekyc_detail"></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.closeEkyc').click(function(){
    var ekycVerifyModal = document.getElementById("ekycVerifyModal");
    ekycVerifyModal.style.display = "none";
  })
</script>