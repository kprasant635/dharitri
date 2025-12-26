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
</style>

<div class="container-fluid form-top login">

  <?php 

    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $dist_code       = $this->session->userdata('dist_code');
  ?>
  
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <!-- flash message -->

      <div class="row" style='padding: 40px 50px 40px 20px'>
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
              <th ><b>ESCALATED FROM</b></th>
              <th>CO</th>
              <th>ADC</th>
              <!-- <th>BO</th> -->
            </tr>
          </thead>
          <tbody>
            <tr>
              <th width="30%">Click on numbers to view cases</th>

              <th onclick="getPendingList('CO')" class="css"><?=$escalated_cases['escalatedfromCo']?></th>

              <th onclick="getPendingList('ADC')" class="css"><?=$escalated_cases['escalatedfromAdc']?></th>

              <!-- <th onclick="getPendingList('BO')" class="css"><?=$escalated_cases['escalatedfromBo']?></th> -->
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
              <thead>
                <th><label class="control-label">Case No</label></th>                
                <th class="center"><label class="control-label"> Mouza/Lot no</label></th>
                <th class="center"><label class="control-label"> Village </label></th>
                <th class="center"><label class="control-label"><?=$this->lang->line('submission_date')?></label></th>                
                <th class="center"><label class="control-label">Revert Back</label></th>
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
  
  function getPendingList(from_user)
  {
    $('.table_dc_escalated_div').show();
    $('#pending_at_dc_escalated_cases').DataTable().destroy();
    $('#escalated_from_user').html(from_user);

    var dataTable = $('#pending_at_dc_escalated_cases').DataTable({  
      "processing" : true,  
      "serverSide" : true, 
      "ordering"   : false,
      "ajax":{  
        url:"<?php echo base_url().'index.php/DcEscalationController/getPendingEscalatedCases';?>", 
        type:"POST",
        data: { from_user : from_user }, 
      },  
      "columnDefs":[  
        {
          "orderable":false,  
        },  
      ],  
    });
    dataTable.columns().every(function () {
      var table = this;
      $('input', this.header()).on('keyup change', function () {
          if (table.search() !== this.value) {
            table.search(this.value).draw();
          }
      });
    });
  }

</script>

