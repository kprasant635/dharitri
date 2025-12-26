<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Request For Activation ( Back Log Entry )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('select_location') ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <label><font color=blue size=4>Sequence to be followed for sending Request for backlog :</font></label><br>
                        <label>1) Select the village listed in the drop down in which backlog cases has to be done..</label><br>
                        <label>2) Select the Request for based on the type of backlog's that need to be Activated.</label><br>
                        <hr style="border-bottom: 2px solid #000;">
                        <form class="form-horizontal" id="myForm" method='post' action="<?php echo base_url() . "index.php/Request/SaveRequest"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" id="dist_code_new" name="dist_code" >
                                    <?php $dist_code=$this->session->userdata('dist_code');?>
                                    <option value="<?php echo $dist_code;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                    </option>
                                </select>
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" id="subdiv_code_new" name="subdiv_code" >
                                    <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                    </option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" id="circle_code_new"  name="circle_code">
                                    <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="mouza_code_new"  name="mouza_code">
                                    <?php $mouza_code=$this->session->userdata('mouza_pargona_code');?>
                                    <option value="<?php echo $mouza_code;?>"  selected>
                                        <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_code);?>
                                    </option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" id="lot_no_new"  name="lot_no">
                                    <?php 
                                    $lot_no=$this->session->userdata('lot_no');
                                    $lot_name=$this->utilityclass->getLotLocationName($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no);
                                    ?>
                                    <option value="<?php echo $lot_no;?>"  selected>
                                        <?php echo $lot_name;?>
                                    </option>
                                </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="village"  name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach($villages as $d):?>
                                    <option value='<?php echo $d->vill_townprt_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                                </div>
                            </div>  
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="select" class="col-sm-2 control-label">Request For</label>
                                <div  class="col-sm-3">
                                    <select class="form-control" id="requestfor" name="request_for" required>
                                        <option disabled selected><?php echo $this->lang->line('select')?></option>
                                        <option value="M">Mutation / নামজাৰী</option>
                                        <option value="P">Partition / আপোচ বাটোৱাৰা</option>
                                        <option value="C">Conversion / ম্যাদীকৰণ</option>
                                        <!--<option value="R">Reclassification / শ্ৰেণী পৰিবৰ্ত্তন</option>-->
                                    </select>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" name="ASTSTEP2Submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#formsubmit').click(function() {
        var village_new = $('#village').val();
        var requestfor = $('#requestfor').val();
        if(village_new == null){
            alert('Please Select Village Details!');
            return false;
        }
        if(requestfor == null){
            alert('Please Select Request For Details!');
            return false;
        }
        document.getElementById("myForm").submit();
    });
</script>
