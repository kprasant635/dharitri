<script>
    $(function () {
        $('#myModal').modal({});
    })
</script>
<style>
    .modal_body p {
        font-family: 'Calibri' !important;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-info panel-form">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">KHATIAN</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?php echo $this->lang->line('select_location') ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open(base_url('index.php/Khatian/khatianViewTenantForm'), array('class' => 'form-horizontal')); ?>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label">জিলা</label>
                        <div class="col-lg-9">
                            <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" readonly="">
                                <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                <option value="<?php echo $dist_code; ?>" selected>
                                    <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label">মহকুমা</label>
                        <div class="col-lg-9">
                            <select class="form-control subdivselect" id="select" name="subdiv_code" readonly="">
                                <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                <option value="<?php echo $subdiv_code; ?>" selected>
                                    <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label">চক্র</label>
                        <div class="col-lg-9">
                            <select class="form-control circleselect" id="select" required name="circle_code" readonly="">
                                <?php $cir_code = $this->session->userdata('cir_code'); ?>
                                <option value="<?php echo $cir_code; ?>" selected>
                                    <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label">মৌজা</label>
                        <div class="col-lg-9">
                            <select class="form-control mouzaselect" id="select" name="mouza_code" readonly="">
                                <?php $mouza_code=$this->session->userdata('mouza_pargona_code');?>
                                <option value="<?php echo $mouza_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label">লাট</label>
                        <div class="col-lg-9">
                            <select class="form-control lotselect" id="select" name="lot_no" readonly="">
                                <?php $lot_no=$this->session->userdata('lot_no');?>
                                <option value="<?php echo $lot_no; ?>"  selected>
                                         <?php echo $this->utilityclass->getLotLocationName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text required control-label">গাওঁ / চহৰ</label>
                        <div class="col-lg-9">
                            <select class="form-control villageselect" id="select" name="vill_code" required>
                                <option disabled selected>Select Village/Town</option>
									<?php foreach($villages as $d):?>
                                    <option value='<?php echo $d->vill_townprt_code; ?>'><?php echo $d->loc_name; ?></option>
                                    <?php endforeach;?>
                            </select>
                            <?php echo form_error('vill_code', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label required">খতিয়ান নং</label>
                        <div class="col-lg-9">
                            <input class='form-control' required name='khatian_no' placeholder='Enter Khatian Number' autocomplete="off">
                            <?php echo form_error('khatian_no', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary"><i
                                        class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?>
                            </button>
                        </div>
                    </div>
                    </form>
                    <?php if ($this->session->flashdata('message')): ?>
                        <div class="col-lg-12 ">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                            </div>
                            <?php if($this->session->flashdata('message2')):?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message2');?></strong>
                                </div>
                            <?php endif;?>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>