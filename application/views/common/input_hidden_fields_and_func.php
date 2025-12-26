<?php
    include 'application/views/common/only_hidden_fields.php';
    $optionalPush = ENABLED_BLOCKCHAIN_OPTIONAL_PUSH;
    if (($optionalPush == 1) && ($ulpinCheck == 0 || $chithaPropChainCmpFlag !='Y' ))
    {
        $buttonEnabledFlag = 0;
    }
    if($ulpinCheck == 0)
    {
        $buttonEnabledFlag = 0;
    }
?>

<div class="modal" id="view_traveller">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-body" id="view-modal-body">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        console.log("MB02:----PASS2----");
        msgPopUp();
    });

    $(function() {
        $(document).on("click", ".modal-show", function() {
          var dist_code = $(this).attr("dist_code");
          subdiv_code = $(this).attr("subdiv_code");
          circle_code = $(this).attr("cir_code");
          mouza_code = $(this).attr("mouza_pargona_code");
          lot_no = $(this).attr("lot_no");
          vill_code = $(this).attr("vill_townprt_code");
          dag_no = $(this).attr("dag_no");
          patta_type = $(this).attr("patta_type");
          console.log("MB03:---PASS3----------");
          $('#view-modal-body').empty().html(
            '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div><br><p class="text-primary text-center">....Fetching Data From Property Chain. Please Wait....</p>');
          $.ajax({
            url: baseurl + "PropChainReport/getPropChainData",
            type: 'POST',
            data: {
              dist_code: dist_code,
              subdiv_code: subdiv_code,
              circle_code: circle_code,
              mouza_code: mouza_code,
              // mouza_code: '02',
              lot_no: lot_no,
              // lot_no: '01',
              vill_code: vill_code,
              // vill_code: '10004',
              patta_code: patta_type,
              dag_no: dag_no,
              // dag_no: '1',
            },
            dataType: "json",
            success: function(data2) {
              console.log(data2);
              var object = JSON.parse(JSON.stringify(data2));
              console.log(object);
              if (object.result === 0) {
                alert(object.error_msg)
              } else if (object.result === 1) {
                var property_data = object.property_data
                console.log(property_data);
                // if modal send 1 in the parameter and 0 for other
                $.ajax({
                  url: baseurl + "PropChainReport/generatePropertyChain",
                  method: 'post',
                  data: {
                    property_data: property_data,
                  },
                  dataType: 'html',
                  success: function(data3) {
                    $('#view-modal-body').empty().html(data3);
                    // $("#view_traveller").modal("show");
                  }
                });
              } else {
                alert("An Error Occured");
              }
            }
          });
          $("#view_traveller").modal("show");
        });
    });

</script>