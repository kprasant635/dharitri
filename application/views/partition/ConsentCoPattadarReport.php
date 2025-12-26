<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 panel-form col-lg-offset-1" style="padding: 10px">
             
            <h2 class="text-center uni_text"><?php echo $this->lang->line('copattadar_consent_rpt'); ?></h2>
            <hr>
            <form class="form-horizontal unicode" method="POST" action="<?php echo base_url()?>index.php/partition/SaveConsentF">
                
                
                <div class="form-group">
                    <label for="select" class="col-sm-4 "><?php echo $this->lang->line('case_no'); ?> : <?php echo $this->input->get('case') ?></label>
                    <label for="select" class="col-sm-2 "><?php echo $this->lang->line('patta_no') ?> : <?php echo $this->input->get('patta_no')?></label>
                    <label for="select" class="col-sm-2 "><?php echo $this->lang->line('dag_no') ?> : <?php echo $this->input->get('dag') ?></label>
                   
                </div>
                <hr>
                 <div class="form-group">
                  <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('name') ?></label>
                  <div class="col-sm-6">
                      <label class="radio-inline">
                          <input type="text" class="form-control" readonly=""  value="<?php echo $this->input->get('pdar_name'); ?>">
                      </label>
                     
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('co_pattadar_consent') ?> </label>
                  <div class="col-sm-6">
                      <label class="radio-inline">
                          <input type="radio" name="concent" id="inlineRadio1" na checked="" value="Y"> <?php echo $this->lang->line('consent_yes') ?>
                      </label>
                      <label class="radio-inline">
                          <input type="radio" name="concent" id="inlineRadio2" value="N"><?php echo $this->lang->line('consent_no') ?>
                      </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('consent_comment') ?> </label>
                  <div class="col-sm-6">
                      <textarea class="form-control" name="copattadar_comment" rows="3"> <?php echo $this->input->get('pdar_name'); ?> ৰ সন্মতি দিয়া হল | </textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary uni_text col-lg-offset-4"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?>  </button> 
                <input type="hidden" name="copattadar_name" value="<?php echo $this->input->get('pdar_name'); ?>" >
                <input type="hidden" name="copattadar_id" value="<?php echo $this->input->get('pdar_id'); ?>" >
                <input type="hidden" name="patta_no" value="<?php echo $this->input->get('patta_no'); ?>" >
                <input type="hidden" name="vill_townprt_code" value="<?php echo $this->input->get('vill'); ?>" >
                <input type="hidden" name="patta_type_code" value="<?php echo $this->input->get('pcode'); ?>" >
                <input type="hidden" name="case_no" value="<?php echo $this->input->get('case')?>" >
                <div class="btn btn-info  uni_text" id="backMain"><i class="fa fa-reply "></i> &nbsp; <?php echo $this->lang->line('previous_menu') ?></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
        document.getElementById("backMain").onclick = function () {
        location.href = "<?php echo base_url()?>index.php/home";
    };
</script>

