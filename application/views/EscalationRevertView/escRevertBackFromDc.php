<?php //var_dump($users); ?>

<div class="container-fluid form-top login">
  <div class="row">
    <div class="col-lg-12 ">
      <div class="col-lg-12">
        <div class="well well-sm">
          <h2 style="text-align: center;">Escalation Revert Back <i class='fa fa-undo'></i></h2>
        </div>
      </div>
      <div class="col-lg-12">
        
        <div class="error_container">
          <?php if($this->session->flashdata('message')){ ?>
            <div class="alert alert-warning alert-dismissible show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong class="text-danger"><?=$this->session->flashdata('message')?></strong>
            </div>
          <?php } ?>
        </div>

        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">
              <label class="col-sm-6 rasid">Case No : <span class="bg-yellow"><?php echo $this->utilityclass->decryptJwtCase($this->input->get('case_no')); ?></span></label>
              <label class="col-sm-2 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
              <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
              <br>
            </h3>
          </div>

          <div class="panel-body">
            <form class="form-horizontal" action="<?=base_url().'index.php/DcEscalationController/manuallyReallocateDaysToUser'?>" method="post">

              <table class="table table-striped table-bordered">
                <tbody>

                  <tr>
                    <td width="50%"><strong>Remaining Days to process with this case</strong></td>
                    <td width="50%">
                      <input text="hidden" class="form-control" name='remaining_days' 
                        id="remaining_days" value="<?=$dc_remaining_days?>">
                        
                      <input text="hidden" class="form-control" name='allocated_users' 
                        id="allocated_users" value="<?=count($users)?>" hidden>

                      <input text="hidden" class="form-control" name='to_be_reverted' 
                        id="to_be_reverted" value="<?=$from_dc_to?>" hidden>

                      <input text="hidden" class="form-control" name='environment' 
                        id="environment" value="<?=$environment?>" hidden>
                    </td>
                  </tr>

                  <?php foreach($users as $r) { ?>

                    <tr>
                      <td><strong>Assign Days to <?=strtoupper($r)?></strong></td>
                      <td>
                        <input class="form-control" name='allocate_days_to_<?=$r?>' 
                          id="allocate_days_to_<?=$r?>" value="">
                      </td>
                    </tr>

                  <?php } ?>

                  <tr>
                    <td><strong >Remarks </strong></td>
                    <td>
                        <textarea class="form-control" rows="5" name='revert_remarks' id="textArea" placeholder="Please Type Your Reason For Revert Back" required></textarea>
                    </td>
                  </tr>
                </tbody>
              </table>

              <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
              <input type='hidden' name='case_no' value='<?php echo $this->utilityclass->decryptJwtCase(($this->input->get('case_no'))); ?>'> 
              <input type='hidden' name='revert_to_user' value='<?php echo $this->utilityclass->decryptJwtCase(($this->input->get('revert_to_user'))); ?>'>
              

              <hr style="border-bottom: 2px solid #000;">

              <center>
                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Allocate Days</button>                  
              </center>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>