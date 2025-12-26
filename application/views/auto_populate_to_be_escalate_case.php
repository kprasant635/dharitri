
<style type="text/css">

  #table_scroll{
    overflow-x:scroll;
  }

</style>

<div class="modal" role="dialog" id="autoPopUpModal" data-backdrop="static" data-keyboard="false" 
  style="z-index:999999">

  <div class="modal-dialog" role="document" style="max-width: 85%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">To be escalated pending case(s)</h4>
        <h5 class="modal-title" style="color:red; font-weight: bold;">In case, if you don't take action in given remaining days, the case will auto escalate to next superior authority</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color: red">Close &times;</span>
      </button>
      </div>

      <div class="modal-body">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="row" id="table_scroll">            

            <table class="datatable table table-stripped" id='toBeEscCase' width="100%">
              <thead>
                <tr>
                  <th><label class="control-label">Case No</label></th> 
                  <th><label class="control-label">Mouza/Lot</label></th>
                  <th><label class="control-label">Village </label></th>  
                  <th><label class="control-label">Submission Date</label></th>                
                  <th><label class="control-label">Remaining Days</label></th>
                  <th><label class="control-label">Zone Detail</label></th>
                  <th><label class="control-label">Escalate Date</label></th>
                </tr>
              </thead>
              <tbody>                
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript"> 

  $('#autoPopUpModal').modal('show');
  load_auto_populate_case();

  function load_auto_populate_case()
  {
    var table = $('#toBeEscCase').DataTable({
      'pageLength': 10,
      "processing": true,
      "serverSide": true,
      "ordering"  : false,
      "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
      'language'  : {
                  "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
              },
      'ajax':{
      url: baseurl + "AutoPopUpController/autoPopolatedEscCases",
        type:'POST',
        deferLoading: 57,
      },
      // order: [[2, 'asc']],
      columnDefs: [{
        targets: 0,
        orderable: false,
        "className": "dt-center",
        "targets": [0],
        // checkboxes: {
        //     'selectRow': true
        // },
        data: "is_visible",
        'render': function(data, type, row) {
          let text = row[0];
          const myArray = text.split("/");
          var arr = myArray[3];
          return row[0];
        }
      }],
    });

  }

</script>
