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

    // include(APPPATH."views/common/audio.php");

    $service_type    = $this->utilityclass->decryptJwtCase($_GET['service']);
    $user_desig_code = $this->session->userdata('user_desig_code');
    $user_code       = $this->session->userdata('user_code');
    $dist_code       = $this->session->userdata('dist_code');
    $subdiv_code     = $this->session->userdata('subdiv_code');
    $cir_code        = $this->session->userdata('cir_code');
    
    if(isset($user_code) && !empty($user_code))
    {
      $back_to_main_menu = $this->EscalationListModel->goBackButtonByUser($service_type, $user_desig_code);
    }

  ?>
  
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <?php if($this->session->flashdata('required_message')) { ?>
        <div class="alert alert-warning alert-dismissible show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong class="text-danger">
            <?= $this->session->flashdata('required_message'); ?>
          </strong>
        </div>
      <?php } ?>



      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a href="<?=$back_to_main_menu?>">
          <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
      </div>&nbsp;

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="well well-sm mis_report">
          <h2 style="text-align: center;">
            <?php echo $this->EscalationListModel->getTitleOfServices($service_type); ?>
          </h2>
        </div>
      </div>
      
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <!--------- ESCALATED FROM STARTS HERE --------->
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <table class="table table-striped table-hover text-center table-bordered table-responsive">

            <thead>     
              <tr>
                <th width="30%"><b>ESCALATED FROM</b></th>
                <th width="10%">AST</th>
                <th width="10%">LM</th>
                <th width="10%">SK</th>
                <th width="10%">CO</th>
                <th width="10%">ADC</th>
                <th width="10%">DC</th>
                <th width="10%">BO</th>
                <th width="10%">DEPT</th>
              </tr>
            </thead>

            <?php if(isset($user_code) && !empty($user_code)) { ?>
    
              <tbody id='div_escalated_from'></tbody>

            <?php } ?>

          </table>
        </div>
        <!--------- ESCALATED FROM ENDS HERE --------->


        <!--------- ESCALATED TO STARTS HERE --------->
        <!-- <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
          <table class="table table-striped table-hover text-center table-bordered table-responsive">
            <thead>     
              <tr>
                <th width="30%"><b>ESCALATED <br>TO</b></th>
                <th width="10%">AST</th>
                <th width="10%">LM</th>
                <th width="10%">SK</th>
                <th width="10%">CO</th>
                <th width="10%">ADC</th>
                <th width="10%">DC</th>
                <th width="10%">BO</th>
                <th width="10%">DEPT</th>
              </tr>
            </thead>

            <?php //if(isset($user_code) && !empty($user_code)) { ?>

              <tbody id='div_escalated_to'></tbody>

            <?php //} ?>

          </table>
        </div> -->
        <!--------- ESCALATED TO ENDS HERE --------->


        <!--------- REVERTED STARTS HERE --------->
        <!-- <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
          <table class="table table-striped table-hover text-center table-bordered table-responsive">
            <thead>     
              <tr>
                <th width="30%"><b>REVERTED FROM</b></th>
                <th width="10%">AST</th>
                <th width="10%">LM</th>
                <th width="10%">SK</th>
                <th width="10%">CO</th>
                <th width="10%">ADC</th>
                <th width="10%">DC</th>
                <th width="10%">BO</th>
                <th width="10%">DEPT</th>
              </tr>
            </thead>

            <?php //if(isset($user_code) && !empty($user_code)) { ?>

              <tbody id='div_reverted_from'></tbody>

            <?php //} ?>

          </table>
        </div> -->
        <!--------- REVERTED ENDS HERE --------->



        <!--------- LIST OF ESCALATED FROM STARTS HERE --------->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table_escalated_div" style="display: none;">
          <div class="panel panel-info panel-form">
            <div class="panel-heading">
              <h3 class="panel-title">
                  List of Escalated Case(s) <span id="from_to_user"></span> <span id="escalated_user_list"></span>
              </h3>
            </div>
              <div class="panel-body table_div_responsive">
                <table class='table table-striped table-bordered' id='pending_escalated_cases'>
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




        <!--------- LIST OF ESCALATED FROM STARTS HERE --------->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table_reverted_div" style="display: none;">
          <div class="panel panel-info panel-form">
            <div class="panel-heading">
              <h3 class="panel-title">
                  List of Reverted Case(s) <span id="preposition"></span> <span id="reverted_user_list"></span>
              </h3>
            </div>
              <div class="panel-body table_div_responsive">
                <table class='table table-striped table-bordered' id='pending_reverted_cases'>
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

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a href="<?=$back_to_main_menu?>">
          <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
      </div>&nbsp;
    </div>
  </div>
</div>

<script type="text/javascript">  

  $(document).ready(function()
  {
    load_data_esc_from();
    load_data_esc_to();
    load_data_reverted_from();
  
    function load_data_esc_from() // escalated from
    {
      var service_type    = '<?php echo $service_type?>';
      var user_desig_code = '<?php echo $user_desig_code?>';
      var ast_data        = '<?php echo $ast_data?>';
      var sk_data         = '<?php echo $sk_data?>';
      var lm_data         = '<?php echo $lm_data?>';
      var co_data         = '<?php echo $co_data?>';
      var adc_data        = '<?php echo $adc_data?>';
      var dc_data         = '<?php echo $dc_data?>';
      var bo_data         = '<?php echo $bo_data?>';
      var dept_data       = '<?php echo $dept_data?>';

      $.ajax({
        url  : "<?php echo base_url().'index.php/EscalatedListController/getPendingEscalatedFromUser';?>",
        type : "post",
        data : {from_user:user_desig_code, service_type:service_type, ast_data:ast_data, sk_data:sk_data, lm_data:lm_data, co_data:co_data, adc_data:adc_data, dc_data:dc_data, bo_data:bo_data, dept_data:dept_data},
        success: function(data) 
        {
          $('#div_escalated_from').html(data);
        }, 
        error: (error) => 
        {
          showErrorMessage("SOMETHING WENT WRONG !!!!");
        },
      });
    }

    function load_data_esc_to() // escalated to
    {
      var service_type    = '<?php echo $service_type?>';
      var user_desig_code = '<?php echo $user_desig_code?>';
      var ast_data        = '<?php echo $ast_data?>';
      var sk_data         = '<?php echo $sk_data?>';
      var lm_data         = '<?php echo $lm_data?>';
      var co_data         = '<?php echo $co_data?>';
      var adc_data        = '<?php echo $adc_data?>';
      var dc_data         = '<?php echo $dc_data?>';
      var bo_data         = '<?php echo $bo_data?>';
      var dept_data       = '<?php echo $dept_data?>';

      $.ajax({
        url  : "<?php echo base_url().'index.php/EscalatedListController/getPendingEscalatedToUser';?>",
        type : "post",
        data : {from_user:user_desig_code, service_type:service_type, ast_data:ast_data, sk_data:sk_data, lm_data:lm_data, co_data:co_data, adc_data:adc_data, dc_data:dc_data, bo_data:bo_data, dept_data:dept_data},
        success: function(data) 
        {
          $('#div_escalated_to').html(data);
        }, 
        error: (error) => 
        {
          showErrorMessage("SOMETHING WENT WRONG !!!!");
        },
      });
    }

    // reverted from list
    function load_data_reverted_from()
    {
      var service_type    = '<?php echo $service_type?>';
      var user_desig_code = '<?php echo $user_desig_code?>';
      var ast_data        = '<?php echo $revert_ast_data?>';
      var sk_data         = '<?php echo $revert_sk_data?>';
      var lm_data         = '<?php echo $revert_lm_data?>';
      var co_data         = '<?php echo $revert_co_data?>';
      var adc_data        = '<?php echo $revert_adc_data?>';
      var dc_data         = '<?php echo $revert_dc_data?>';
      var bo_data         = '<?php echo $revert_bo_data?>';
      var dept_data       = '<?php echo $revert_dept_data?>';

      $.ajax({
        url  : "<?php echo base_url().'index.php/EscalatedListController/getPendingRevertedFromUser';?>",
        type : "post",
        data : {from_user:user_desig_code, service_type:service_type, ast_data:ast_data, sk_data:sk_data, lm_data:lm_data, co_data:co_data, adc_data:adc_data, dc_data:dc_data, bo_data:bo_data, dept_data:dept_data},
        success: function(data) 
        {
          $('#div_reverted_from').html(data);
        }, 
        error: (error) => 
        {
          showErrorMessage("SOMETHING WENT WRONG !!!!");
        },
      });
    }
  });

  function escalated_user_from_to(from_user, to_user, whom)
  {
    if(whom == 'from')
    {
      if(from_user == 'AST'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'LM'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'SK'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'CO'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'ADC'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'DC'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'BO'){
        $('#escalated_user_list').html(from_user);
      }
      else if(from_user == 'DEPT'){
        $('#escalated_user_list').html(from_user);
      }
    }
    else 
    {
      if(to_user == 'AST'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'LM'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'SK'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'CO'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'ADC'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'DC'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'BO'){
        $('#escalated_user_list').html(to_user);
      }
      else if(to_user == 'DEPT'){
        $('#escalated_user_list').html(to_user);
      }
    }
  }

  function getPendingDetail(from_user, to_user, whom, stype)
  {
    $('.table_escalated_div').show();
    $('.table_reverted_div').hide();
    $('#pending_escalated_cases').DataTable().destroy();
    $('#from_to_user').html(whom);

    escalated_user_from_to(from_user, to_user, whom);      

    var dataTable = $('#pending_escalated_cases').DataTable({  
      "processing" : true,  
      "serverSide" : true, 
      "ordering"   : false,
      "ajax":{  
        url:"<?php echo base_url().'index.php/EscalatedListController/getPendingEscalatedCasesByUser';?>", 
        type:"POST",
        data: { 
          from_user : from_user, 
          to_user   : to_user, 
          stype     : stype,
        }, 
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


  function reverted_user_from_to(from_user, to_user, preposition)
  {
    if(preposition == 'from')
    {
      if(from_user == 'AST'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'LM'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'SK'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'CO'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'ADC'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'DC'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'BO'){
        $('#reverted_user_list').html(from_user);
      }
      else if(from_user == 'DEPT'){
        $('#reverted_user_list').html(from_user);
      }
    }
    else 
    {
      if(to_user == 'AST'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'LM'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'SK'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'CO'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'ADC'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'DC'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'BO'){
        $('#reverted_user_list').html(to_user);
      }
      else if(to_user == 'DEPT'){
        $('#reverted_user_list').html(to_user);
      }
    }
  }

  // reverted from users
  function getRevertedFromPendingDetail(preposition, from_user, to_user, stype)
  {
    $('.table_escalated_div').hide();
    $('.table_reverted_div').show();    
    $('#pending_reverted_cases').DataTable().destroy();
    $('#preposition').html(preposition);

    reverted_user_from_to(from_user, to_user, preposition);      

    var dataTable = $('#pending_reverted_cases').DataTable({  
      "processing" : true,  
      "serverSide" : true, 
      "ordering"   : false,
      "ajax":{  
        url:"<?php echo base_url().'index.php/EscalatedListController/getPendingRevertedCasesByUser';?>", 
        type:"POST",
        data: { 
          from_user : from_user, 
          to_user   : to_user, 
          stype     : stype,
        }, 
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
