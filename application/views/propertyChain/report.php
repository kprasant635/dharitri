<?php
// echo "<pre>";
// var_dump($this->session->all_userdata()); 
?>

<?php if ($this->session->flashdata('message')) : ?>
    <?php include 'message.php';  ?>
<?php endif; ?>
<div class="propChainReport" id="show-prop-report"> 
    <div class="col-lg-8 col-lg-offset-2 mt-5">                
        <div class="bg-secondary text-white p-2  text-center font-weight-bold shadow-lg">                
            PROPERTY CHAIN DISPLAY
        </div>
        <div class="bg-dark text-white p-2 text-center font-weight-bold shadow-lg" >                
            LOCATION SELECTION
        </div>
    </div>
    <div class="col-lg-8 col-lg-offset-2" style="margin-top:-6px;">        
        <div class="panel panel-form">
            <div class="text-center" style="width: 100%;">
                <h5><span class="error_span_chain"></span></h5>
            </div>
            <div class="panel-body shadow-lg">
                <form class="form-horizontal unicode" name="prop_chain_form" id="prop_chain_form">

                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                <option value="<?php echo $dist_code; ?>" selected>
                                    <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control subdivselect" id="subdiv_code" name="subdiv_code" required>
                                <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                <option value="<?php echo $subdiv_code; ?>" selected>
                                    <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle') ?></label>
                        <div class="col-lg-9">
                            <?php
                            $circle_code = $this->session->userdata('cir_code');
                            ?>
                            <select class="form-control circleselect" id="circle_code" required name="circle_code">
                                <option value="<?php echo $circle_code; ?>" selected>
                                    <?php echo $this->utilityclass->getCircleNamebydbload($dist_code, $subdiv_code, $circle_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza') ?></label>
                        <div class="col-lg-9">
                            <?php
                            $mouza_code = $this->session->userdata('mouza_pargona_code');
                            ?>
                            <select class="form-control mouzaselect" id="mouza_code" required name="mouza_code">
                                <option disabled selected>Select Mouza</option>
                                <?php
                                if ($this->session->userdata('user_desig_code') == 'CO') {
                                    $d = $this->utilityclass->getAllMouzaDetails($dist_code, $subdiv_code, $circle_code);
                                    foreach ($d as $name) { ?>
                                        <option value="<?php echo $name->mouza_pargona_code; ?>">
                                            <?php echo $name->loc_name; ?>
                                        </option>
                                    <?php }
                                } elseif ($this->session->userdata('user_desig_code') == 'LM') { ?>
                                    <option value="<?php echo $mouza_code; ?>" selected>
                                        <?php echo  $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code); ?>
                                    </option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control lotselect" id="lot_no" name="lot_no">
                                <option disabled selected>Select Lot No</option>
                                <?php if ($this->session->userdata('user_desig_code') == 'LM') {
                                    $lot_no = $this->session->userdata('lot_no')
                                ?>
                                    <option value="<?php echo $lot_no; ?>" selected>
                                        <?php echo  $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control villageselect" id="vill_code" name="vill_code">
                                <option disabled selected>Select Village/Town</option>
                                <?php
                                if ($this->session->userdata('user_desig_code') == 'LM') {
                                    $d = $this->utilityclass->getAllVillageDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
                                    foreach ($d as $name) {
                                ?>
                                        <option value="<?php echo $name->vill_townprt_code; ?>">
                                            <?php echo $name->loc_name; ?>
                                        </option>
                                <?php }
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control" id="select_patta_type_chain" name="patta_code" required>
                                <option disabled selected>Select Pattatype</option>
                                <option value='0000'>All</option>
                                <?php foreach ($pattatype as $patta) : ?>
                                    <?php
                                    $typeCode = $patta->type_code;
                                    $pattatype = $patta->patta_type;
                                    ?>
                                    <option value="<?php echo $typeCode; ?>"><?php echo $pattatype; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('dag_no') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control dag_no_lower" id="selectlw" name="dag_no" onchange="return onchangeDag();" required>
                                <option value='' selected>Select Dag No</option>
                            </select>
                        </div>
                        <!-- <label for="select" class="col-lg-3  control-label"><?php echo $this->lang->line('to') ?> :</label>
                    <div class="col-lg-3">
                        <select class="form-control" id="selectup" name="dag_no_upper">
                            <option>Upper Range</option>
                        </select>
                    </div> -->
                    </div>
                    <input type="hidden" name="patta_no" id="patta_no">

                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="button" name="prop_chain_submit" id="prop_chain_submit" class="btn btn-success" onclick="return checkPropChain();" disabled><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                            <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="loader" style="display:none;"></div>
    </div>
</div>

<style>
    .spinner-grow {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        margin-top: -50px !important;
        margin-left: -50px !important;
    }

    #loader {
        position: fixed;
        z-index: 10;
        background: black;
        left: 0;
        top: 0;
        /* display: block; */
        opacity: .75;
        /* filter: alpha(opacity=75); */
        width: 100%;
        height: 100%;
    }
</style>