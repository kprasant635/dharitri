<style type="text/css">
  .table_div_responsive {
    overflow-y: scroll;
  }
  .css {
    cursor: pointer;
  }
  td:hover {
/*    background-color: purple;*/
    font-weight: bold;
    color: white;
  }


  .navbar form {
    display: none !important;
}


</style>

<div class="container-fluid">

  <?php 

    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $dist_code       = $this->session->userdata('dist_code');
  ?>
  
  <div class="row">
    <h4>Escalated Cases List (From CO/ADC)</h4>
    <p style="font-weight: bold;">Note : You can revert the cases to CO/ADC for taking action as the case has not been passed in given timeframe.</p>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <!-- flash message -->

      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
              <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
              </div>
            </div>
          <?php } ?>

          <?php if($this->session->flashdata('error')) { ?>
            <div class="danger-msg">
              <div class="alert alert-danger" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('error') ?></b>
              </div>
            </div>
          <?php } ?>
          
        </div>
      </div>



      <!--------- ESCALATED FROM STARTS HERE --------->
      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <table class="table table-striped table-hover text-center table-bordered table-responsive">

          <thead>     
            <tr>
              <th width="30%"><b>ESCALATED FROM</b></th>
              <th width="10%">CO</th>
              <th width="10%">ADC</th>
              <!-- <th width="10%">BO</th> -->
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Click on numbers to view cases</th>

              <th onclick="getPendingList('CO')" class="css"><?=$escalated_cases['escalatedfromCo']?></th>

              <th onclick="getPendingList('ADC')" class="css"><?=$escalated_cases['escalatedfromAdc']?></th>

              <!-- <th width="10%" onclick="getPendingList('BO')" class="css"><?=$escalated_cases['escalatedfromBo']?></th> -->
            </tr>
          </tbody>
        </table>
      </div>
      <!--------- ESCALATED FROM ENDS HERE --------->



      <!--------- LIST OF ESCALATED FROM STARTS HERE --------->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table_dc_escalated_div" style="display: none;">
        <div class="panel panel-info panel-form">
          <div class="panel-heading">
            <h3 class="panel-title">
                List of Escalated Case(s) <span id="escalated_from_user"></span>
            </h3>
          </div>
          <div class="panel-body table_div_responsive">
            <table class='table table-striped table-bordered' id='pending_at_dc_escalated_cases'>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="by_case_no" name="by_case_no" class="form-control" placeholder="Search by Case No">
                  <input type="hidden" id="esc_from_user" value="">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <button type="button" class="search_button btn btn-sm btn-success form-control"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                </div>
              </div>  
              <br>        

              <thead>
                <tr>
                  <th><label class="control-label">Case No</label></th>                
                  <th class="center"><label class="control-label"> Mouza/Lot no</label></th>
                  <th class="center"><label class="control-label"> Village </label></th>
                  <th class="center"><label class="control-label"><?=$this->lang->line('submission_date')?></label></th>
                  <th class="center"><label class="control-label">Revert Back</label></th>
                </tr>
                  
              </thead>
              <tbody>                                    
              </tbody>              
            </table>
          </div>
        </div>
      </div>
      <!--------- LIST OF ESCALATED FROM ENDS HERE --------->
      
      
    </div>
  </div>
</div>


<script type="text/javascript">
  
  // function getPendingList(from_user)
  // {
  //   $('.table_dc_escalated_div').show();
  //   $('#pending_at_dc_escalated_cases').DataTable().destroy();
  //   $('#escalated_from_user').html(from_user);

  //   var dataTable = $('#pending_at_dc_escalated_cases').DataTable({  
  //     "processing" : true,  
  //     "serverSide" : true, 
  //     "ordering"   : false,
  //     "ajax":{  
  //       url:"<?php echo base_url().'index.php/DcEscalationController/getPendingEscalatedCases';?>", 
  //       type:"POST",
  //       data: { from_user : from_user }, 
  //     },  
  //     "columnDefs":[  
  //       {
  //         "orderable":false,  
  //       },  
  //     ],  
  //   });
  //   dataTable.columns().every(function () {
  //     var table = this;
  //     $('input', this.header()).on('keyup change', function () {
  //         if (table.search() !== this.value) {
  //           table.search(this.value).draw();
  //         }
  //     });
  //   });
  // }


  $('#pending_at_dc_escalated_cases').DataTable();
  function getPendingList(from_user)
  {
    $('.table_dc_escalated_div').show();
    $('#pending_at_dc_escalated_cases').DataTable().destroy();
    $('#escalated_from_user').html(from_user);
    $('#esc_from_user').val(from_user);

    var dataTable = $('#pending_at_dc_escalated_cases').DataTable({  
      'pageLength' : 10,
      "processing" : true,  
      "serverSide" : true, 
      "ordering"   : false,
      "bSort"      : false,
      "searching"  : false,
      "lengthMenu" : [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
      'language': {
        "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
      },
      "ajax":{  
        url:"<?php echo base_url().'index.php/DcEscalationController/getPendingEscalatedCases';?>", 
        type:"POST",
        data: { 
          from_user : from_user, 
          case_no   : $('#by_case_no').val(),
        }, 
      },  
      order: [[2, 'asc']],
      columnDefs:[  
        {
          targets: "_all",
          orderable:false,  
          "className": "dt-center", "targets":[ 0, 1, 2, 3, 4],
        },  
      ],  
    });
  }


  $('.search_button').click(function(){
    var from_user = $('#esc_from_user').val();
    getPendingList(from_user);
  });


</script>

