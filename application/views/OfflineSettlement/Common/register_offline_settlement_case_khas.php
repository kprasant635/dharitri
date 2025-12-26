<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }


    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }

    .reza-title2{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
    .labDiv{
        margin-bottom: 15px;
    }
    .lab{
        margin-bottom: 5px;
    }
    .landDetails{
        display: none;
    }

    .mmm{
        font-weight: bold;
        margin-top: 3px!important;
    }
    .nnn{
        margin-top: 5px!important;
    }
    .form-check-input {
        width: 20px!important;
        height: 20px!important;
    }


    .form__input{
        padding: 18px 15px!important;

    }
</style>

<style>
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
        padding-top: 10px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }


    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005B96 !important;
        text-decoration: none;
    }
    .wizard li.active{
        background: #005B96;
        padding: 0px;
        box-shadow: 1px 0px 1px 1px;

    }

    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 45%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #ffffff;
    }

    .wizard .nav-tabs > li a {
        text-align: center;
        margin-top: -10px;
        margin-bottom: 10px;
        /* padding: 0; */
    }
    .wizard .nav-tabs > li a:hover {
        background-color: transparent !important;
    }


    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }



</style>

<?php
$max_bigha_home = MAX_BIGHA;
$max_bigha_agri = MAX_BIGHA;
?>

<script>
    $(document).ready(function () {
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);

            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);

        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }

</script>

<div class="row" style='padding-top: 15px; margin-bottom: 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php echo $this->lang->line('offlineSettlementSidebar') ?> /
        <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas" style="text-decoration: none">
            Khas Land /
        </a>
        Apply

        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
        </a>

        <?php if($this->session->flashdata('success')) { ?>
            <br>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <br>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>

        <?php if (!empty($error)) { ?>
            <br>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $error ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>
</div>
<div class="row">
    <form id="myForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url()?>index.php/OfflineSettlementRegisterController/submitOfflineApplicationKhas">
        <h5 class="bg-info p-2 text-white shadow">
            <span><?php echo $this->lang->line('offlineSettlementKhasLandTitle') ?></span>
        </h5>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="reza-card" style="margin-bottom: 25px; padding-top: 5px">
                    <div class="reza-body">
                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 5px">
                                <i class="fa fa-map-signs" aria-hidden="true"></i> Location Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <?php if($this->session->userdata('user_desig_code') == 'LM'): ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">District:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="dist_code" class="form-control districtselect" id="d" required>
                                            <?php $dist_code=$this->session->userdata('dist_code');?>
                                            <option value="<?php echo $dist_code;?>"  selected>
                                                <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Sub-Div:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="subdiv_code"  class="form-control subdivselect"  id="sd" required>
                                            <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                            <option value="<?php echo $subdiv_code;?>"  selected>
                                                <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Circle:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="cir_code"  class="form-control" id="c"  required>
                                            <?php $cir_code=$this->session->userdata('cir_code');?>
                                            <option value="<?php echo $cir_code;?>"  selected>
                                                <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Mouza/Porgona:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="mouza_pargona_code"  class="form-control" id="m" required >
                                            <?php $mouza_code=$this->session->userdata('mouza_pargona_code');?>
                                            <option value="<?php echo $mouza_code;?>"  selected>
                                                <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Lot:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="lot_no"  class="form-control" id="l" required >
                                            <?php
                                            $lot_no=$this->session->userdata('lot_no');
                                            $lot_name=$this->utilityclass->getLotLocationName($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no);
                                            ?>
                                            <option value="<?php echo $lot_no;?>"  selected>
                                                <?php echo $lot_name;?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Village:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="vill_townprt_code"  class="form-control" id="v" required>
                                            <option disabled selected><?php echo $this->lang->line('select')?></option>
                                            <?php foreach($villages as $d):?>
                                                <option value='<?php echo $d->vill_townprt_code;?>'><?php echo $d->loc_name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                <?php elseif($this->session->userdata('user_desig_code') == 'CO'): ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">District:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="dist_code" class="form-control districtselect" id="d" required>
                                            <?php $dist_code=$this->session->userdata('dist_code');?>
                                            <option value="<?php echo $dist_code;?>"  selected>
                                                <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Sub-Div:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="subdiv_code"  class="form-control subdivselect"  id="sd" required>
                                            <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                            <option value="<?php echo $subdiv_code;?>"  selected>
                                                <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab"  for="sel1">Circle:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select  class="form-control circleselect" id="c" required name="cir_code">
                                            <?php $cir_code=$this->session->userdata('cir_code');?>
                                            <option value="<?php echo $cir_code;?>"  selected>
                                                <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Mouza/Porgona:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control mouzaselect" id="m" required name="mouza_pargona_code">
                                            <option disabled selected>Select Mouza</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Lot :<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control lotselect" id="l" name="lot_no" required>
                                            <option disabled selected>Select Lot No</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Village:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control villageselect" id="v" name="vill_townprt_code" required>
                                            <option disabled selected>Select Village/Town</option>
                                        </select>
                                    </div>
                                <?php elseif($this->session->userdata('user_desig_code') == 'ADC'): ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Districts:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select  class="form-control districtselect" id="d" name="dist_code" required>
                                            <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                            <option value="<?php echo $dist_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Sub Division:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select  class="form-control subdivselect" id="sd" required name="subdiv_code">
                                            <option selected disabled>Select Sub Division</option>
                                            <?php foreach ($subDistricts as $name) { ?>
                                                <option value="<?php echo $name->subdiv_code; ?>"  >
                                                    <?php echo $name->loc_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Circle:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <?php $d = $this->utilityclass->getAllCircleName($dist_code, $subdiv_code); ?>
                                        <select  class="form-control circleselect" id="c" required name="cir_code">
                                            <option selected disabled>Select Circle</option>
                                            <?php foreach ($d as $name) { ?>
                                                <option value="<?php echo $name->cir_code; ?>"  >
                                                    <?php echo $name->loc_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Mouza/Porgona:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control mouzaselect" id="m" required name="mouza_pargona_code">
                                            <option disabled selected>Select Mouza</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Lot :<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control lotselect" id="l" name="lot_no" required>
                                            <option disabled selected>Select Lot No</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Village:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control villageselect" id="v" name="vill_townprt_code" required>
                                            <option disabled selected>Select Village/Town</option>
                                        </select>
                                    </div>
                                <?php else : ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">District:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select  class="form-control districtselect" id="d" name="dist_code" required>
                                            <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                            <option value="<?php echo $dist_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Sub Division:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select  class="form-control subdivselect" id="sd" name="subdiv_code" required>

                                            <?php foreach ($subDistricts as $key => $subdiv) { ?>
                                                <option value="<?php echo $subdiv->subdiv_code; ?>"  selected>
                                                    <?php echo $subdiv->loc_name; ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Circle:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <?php //$d = $this->utilityclass->getAllCircleName($dist_code, $subdiv_code);
                                        $d = $this->utilityclass->getAllCircleNameWithDistCode($dist_code);
                                        ?>
                                        <select  class="form-control circleselect" id="c" required name="cir_code">
                                            <option selected disabled>Select Circle</option>
                                            <?php foreach ($d as $name) { ?>
                                                <option value="<?php echo $name->cir_code; ?>"  >
                                                    <?php echo $name->loc_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Mouza/Porgona:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control mouzaselect" id="m" required name="mouza_pargona_code">
                                            <option disabled selected>Select Mouza</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Lot :<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control lotselect" id="l" name="lot_no" required>
                                            <option disabled selected>Select Lot No</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label class="lab" for="sel1">Village:<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select class="form-control villageselect" id="v" name="vill_townprt_code" required>
                                            <option disabled selected>Select Village/Town</option>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Apply For
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Apply For :<span style="color: red;font-weight: bold;"> *&nbsp; &nbsp; </span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="applyFor" id="option1" value="individual" required>
                                        <label class="form-check-label" for="option1">Individual</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="applyFor" id="option2" value="institution">
                                        <label class="form-check-label" for="option2">Institution </label>
                                    </div>
                                </div>


                                <div id="institutionSection" style="display: none; margin-top: 10px;">
                                    <hr>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">New Land Class <span style="color: red;font-weight: bold;">*</span></label>
                                        <?php  $land_types = LAND_TYPES; ?>
                                        <select class="form-control" id="newLandClass" name="newLandClass">
                                            <option value="" disabled selected>Select Land Class</option>
                                            <?php foreach ($land_types as  $value) {
                                                $selected = '';
                                                if($value['id'] == $dagsprem->rate_type)
                                                {
                                                    $selected = " selected";
                                                }
                                                ?>
                                                <option value="<?=$value['id']?>" <?=$selected?>><?=$value['name'];?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">Category of the Proposed Land Class <span style="color: red;font-weight: bold;">*</span></label>
                                        <select class="form-control" id="proposedLandClass" name="proposedLandClass">
                                            <option value="" disabled selected>Select Category</option>
                                            <?php foreach ($land_class_groups as $key => $value) {
                                                $selected = '';
                                                if($value->id == $dagsprem->ins_reclass_proposed)
                                                {
                                                    $selected = "selected";
                                                }
                                                ?>
                                                <option value="<?=$value->id?>" <?=$selected?>><?=$value->name;?></option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">Name of the Institution <span style="color: red;font-weight: bold;">*</span></label>
                                        <input type="text" class="form-control" id='institutionName' name='institutionName' value="<?php echo set_value('institutionName'); ?>" placeholder="" >
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv">
                                        <label for="departmentName" class="lab">Department Name <span style="color: red;font-weight: bold;">*</span></label>
                                        <select class="form-control" id="departmentName" name="departmentName">
                                            <option value="" disabled selected>Select Department</option>
                                            <?php $department = DEPARTMENT; foreach ($department as $key => $value) { ?>
                                                <option value="<?=$value;?>"><?=$value?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv">
                                        <label for="directorateName" class="lab">Directorate Name <span style="color: red;font-weight: bold;">*</span></label>
                                        <input type="text" class="form-control" id='directorateName' name='directorateName' placeholder="" value="<?php echo set_value('directorateName'); ?>">

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 labDiv">
                                        <label for="entityOf" class="lab">Entity of <span style="color: red;font-weight: bold;">*</span></label>
                                        <select class="form-control" id="entityOf" name="entityOf">
                                            <option value="" disabled selected>Select Entity</option>
                                            <option value="8">State Govt. Dept</option>
                                            <option value="9">State Govt. Undertaking</option>
                                            <option value="10">Central Govt Dept.</option>
                                            <option value="11">Central Govt. Undertaking</option>
                                            <option value="12">Non govt.</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-map" aria-hidden="true"></i> Area Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 labDiv ">
                                    <label for="sel1" class="lab">Dag No:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="dag_no"  class="form-control" id="dagno" required>
                                        <option value="" disabled selected>Select Dag No </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Is Urban:<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="is_urban"  class="form-control" id="is_urban" required>
                                        <option disabled selected>Select  </option>
                                        <option value="Y" >Yes, Urban</option>
                                        <option value="N" >No  </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 labDiv landDetails" >
                                    <label for="sel1" class="lab">Land Class<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="hidden" class="form-control" id='land_code' name='land_code' readonly>
                                    <input type="text" class="form-control" id='land_type' value="<?php echo set_value('land_type'); ?>" name='land_type' readonly>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv landDetails" style="font-weight: bold">
                                    <?php echo $this->lang->line('TotalAreaUnderDag'); ?>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                    <label for="sel1" class="lab"><?php echo $this->lang->line('bigha'); ?></label>
                                    <input type="text" class="form-control" id='bigha' name='dag_area_b' value="<?php echo set_value('dag_area_b'); ?>" placeholder="Bigha" readonly>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                    <label for="sel1" class="lab"><?php echo $this->lang->line('katha'); ?></label>

                                    <input type="text" class="form-control"  id='katha' name='dag_area_k' value="<?php echo set_value('dag_area_k'); ?>" placeholder="Katha" readonly>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                    <label for="sel1" class="lab"><?php echo $this->lang->line('lesa'); ?></label>

                                    <input type="text" class="form-control"  id='lessa' name='dag_area_lc' value="<?php echo set_value('dag_area_lc'); ?>" placeholder="Lessa" readonly>
                                </div>

                                <?php if (in_array($dist_code, json_decode(BARAK_VALLEY))): ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                        <label for="sel1" class="lab"><?php echo $this->lang->line('ganda'); ?></label>
                                        <input type="text" class="form-control"  id='ganda' name='dag_area_g' value="<?php echo set_value('dag_area_g'); ?>" placeholder="Lessa" readonly>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                        <label for="sel1" class="lab">Kranti</label>
                                        <input type="text" class="form-control"  id='kranti' name='dag_area_kranti' placeholder="Kranti" value="<?php echo set_value('dag_area_kranti'); ?>" readonly>
                                    </div>
                                <?php endif; ?>

                                <input type="hidden" id="district" value="<?=$dist_code?>">

                                <div class="chitha_check_lm" style="margin-top: 15px; " id="natureOfLandSection">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv landDetails" style="border: 1px solid red; padding-top: 20px; padding-bottom: 20px; margin-top: 15px; border-radius: 3px">
                                        <label for="sel1" class="lab">
                                        <span> Nature of Land ? <span style="color: red;font-weight: bold;"> *</span>
                                            <span class="error" id="chitha_verifiedErr"></span>
                                        </span>
                                        </label> &nbsp; &nbsp; &nbsp;
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn nature_of_land" type="radio" name="nature_of_land"  id="chitha_verified1"  value="<?=HOMESTEAD?>" />
                                            <label class="form-check-label mmm nature_of_land" for="inlineRadio1">Home</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn nature_of_land" type="radio" name="nature_of_land"  id="chitha_verified2" value="<?=AGRICULTURAL?>"  />
                                            <label class="form-check-label mmm nature_of_land" for="inlineRadio2">Agriculture</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn nature_of_land" type="radio" name="nature_of_land"  id="chitha_verified2" value="<?=BOTH_LAND?>"  />
                                            <label class="form-check-label mmm nature_of_land" for="inlineRadio2">Both</label>
                                        </div>


                                        <!--------- homestead starts here ---------->
                                        <div class="row for_homestead" style="display:none">
                                            <div style="color:green; font-weight: bold; margin-bottom: 15px; margin-top: 25px"><?=$this->lang->line('areaUnder')?><?=$this->lang->line('homestead')?></div>
                                            <div class="row">
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    <span id="hbighaErr" class="form__input__error__msg"></span>
                                                    <div class="form__div">
                                                        <?=$this->lang->line('bigha')?> <span style="color: red;font-weight: bold;"> *</span>
                                                        <select id="hbigha" class="form-select ps-3" name="hBigha">
                                                            <?php for($i=MIN_VALUE; $i<=$max_bigha_home; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    <span id="hkathaErr"   class="form__input__error__msg"></span>
                                                    <div class="form__div" id="home_katha" style="display: none;">
                                                        <?=$this->lang->line('katha')?> <span style="color: red;font-weight: bold;"> *</span>
                                                        <select id="hkatha" class="form-select ps-3" name="hKatha">
                                                            <?php for($i=MIN_VALUE; $i<=MAX_KATHA; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form__div" id="home_katha_barak" style="display: none;">
                                                        <?=$this->lang->line('katha')?> <span style="color: red;font-weight: bold;"> *</span>
                                                        <select id="hkatha_barak" class="form-select ps-3" name="hKathaBarak">
                                                            <?php for($i=MIN_VALUE; $i<=MAX_KATHA_BARAK; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    <span id="hlessaErr" class="form__input__error__msg"></span>
                                                    <span class="lessa_title"><?=$this->lang->line('lessa')?> <span style="color: red;font-weight: bold;"> *</span></span>
                                                    <span class="chatak_title"><?=$this->lang->line('chatak')?> <span style="color: red;font-weight: bold;"> *</span></span>
                                                    <div class="form__div">
                                                        <input type="text" name="hLessa" max="20" class="form__input form-control"
                                                               id="hlessa" value="0" oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_ganda_div" style="display:none">
                                                    <span id="hgandaErr" class="form__input__error__msg"></span>
                                                    <?=$this->lang->line('ganda')?> <span style="color: red;font-weight: bold;"> *</span>
                                                    <div class="form__div">
                                                        <input type="text" name="hGanda" max="20"
                                                               id="hganda" class="form__input form-control" value="0"
                                                               oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_kranti_div" style="display:none">
                                                    <span id="hkrantiErr" class="form__input__error__msg"></span>
                                                    <?=$this->lang->line('kranti')?>
                                                    <div class="form__div">
                                                        <input type="text" name="hKranti" max="20" readonly
                                                               id="hkranti" class="form__input form-control" value="0"
                                                               oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!--------- agriculture starts here ---------->
                                        <div class="row for_agriculture" style="display:none">
                                            <div style="color:green; font-weight: bold; margin-bottom: 15px; margin-top: 25px"><?=$this->lang->line('areaUnder')?><?=$this->lang->line('agriculture')?></div>
                                            <div class="row">
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    <div class="form__div">
                                                        <?=$this->lang->line('bigha')?> <span style="color: red;font-weight: bold;"> *</span>
                                                        <select id="abigha" class="form-select ps-3" name="aBigha">
                                                            <?php for($i=MIN_VALUE; $i<=$max_bigha_agri; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    <div class="form__div" id="agri_katha" style="display: none;">
                                                        <?=$this->lang->line('katha')?> <span style="color: red;font-weight: bold;"> *</span>
                                                        <select id="akatha" class="form-select ps-3" name="aKatha">
                                                            <?php for($i=MIN_VALUE; $i<=MAX_KATHA; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form__div" id="agri_katha_barak" style="display: none;">
                                                        <?=$this->lang->line('katha')?> <span style="color: red;font-weight: bold;"> *</span>
                                                        <select id="akatha_barak" class="form-select ps-3" name="aKathaBarak">
                                                            <?php for($i=MIN_VALUE; $i<=MAX_KATHA_BARAK; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    <span id="alessaErr" class="form__input__error__msg"></span>
                                                    <span class="lessa_title"><?=$this->lang->line('lessa')?> <span style="color: red;font-weight: bold;"> *</span> </span>
                                                    <span class="chatak_title"><?=$this->lang->line('chatak')?> <span style="color: red;font-weight: bold;"> *</span> </span>
                                                    <div class="form__div">
                                                        <input type="text" name="aLessa" max="20"
                                                               id="alessa" class="form__input form-control" value="0"
                                                               oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_ganda_div" style="display:none">
                                                    <?=$this->lang->line('ganda')?> <span style="color: red;font-weight: bold;"> *</span>
                                                    <div class="form__div" id="">
                                                        <input type="text" name="aGanda" max="20"
                                                               id="aganda" class="form__input form-control" value="0"
                                                               oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_kranti_div" style="display:none">
                                                    <div class="form__div" id="">
                                                        <?=$this->lang->line('kranti')?> <select id="aKranti" class="form-select ps-3" disabled>
                                                            <?php for($i=MIN_VALUE; $i<=MAX_KRANTI; $i++) { ?>
                                                                <option value="<?=$i?>" > <?=$i?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>


                            <input type="hidden" class="form-control" id='patta_no' name='patta_no' >
                            <input type="hidden" class="form-control" id='patta_type_code' name='patta_type_code'>
                        </div>


                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-edit" aria-hidden="true"></i> Application Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 10px">
                                    <label for="sel1" class="lab">Type of House<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="typeOfHouse"  class="form-control" id="typeOfHouse" required>
                                        <option disabled selected>Select House Type</option>
                                        <option value="RCC" >RCC</option>
                                        <option value="Assam Type" >Assam Type</option>
                                        <option value="Chali House" >Chali House</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 10px">
                                    <label for="sel1" class="lab">Period & Nature of Possession<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="natureOfPossession"  class="form-control" id="natureOfPossession" required>
                                        <option disabled selected>Select </option>
                                        <option value="yes" >Yes</option>
                                        <option value="no" >No</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">Whether eligible as per Clause 14.4 of Land Policy, 2019 <span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="landPolicy"  class="form-control" id="landPolicy" required>
                                        <option disabled selected>Select </option>
                                        <option value="yes" >Yes</option>
                                        <option value="no" >No</option>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">Checklist Submitted<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="checklistSubmitted"   class="form-control" id="checklistSubmitted" required>
                                        <option disabled selected>Select Checklist Submitted</option>
                                        <option value="yes" >Yes</option>
                                        <option value="no" >No</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">SDLAC Recommendation<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="sdlacRecommendation"   class="form-control" id="sdlacRecommendation" required>
                                        <option disabled selected>Select SDLAC Recommendation</option>
                                        <option value="1" > Recommended</option>
                                        <option value="2" >Not Recommended</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">SDLAC Recommendation Date<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="date" name="sdlacRecommendationDate" id="date" class="form-control"  max="<?php echo date("Y-m-d");?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">Accepted / Recommendation<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="recommendation"   class="form-control" id="recommendation" required>
                                        <option disabled selected>Select Recommendation</option>
                                        <option value="1" >Accepted</option>
                                        <option value="2" >Rejected</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">Zonal valuation<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" name="zonalValue" class="form-control" value="<?php echo set_value('zonalValue'); ?>" oninput="this.value = this.value.replace(/[^0-9\.]/g,'')" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <label for="sel1" class="lab">Rate of premium<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" name="premium" class="form-control" value="<?php echo set_value('premium'); ?>" oninput="this.value = this.value.replace(/[^0-9\.]/g,'')" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px; margin-bottom: 20px">
                                    <label for="sel1" class="lab">Concession (if Any)</label>
                                    <input type="text" name="concession" value="<?php echo set_value('concession'); ?>" class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-user" aria-hidden="true"></i> Applicant Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Name in English<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='applicantNameEng' name='applicantNameEng'  onkeydown="return /[a-z, ]/i.test(event.key)" value="<?php echo set_value('applicantNameEng'); ?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Name in Assamese<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control  search-box" id='applicantNameAss' name='applicantNameAss'  onkeydown="return /[a-zA-Z0-9., &:-]+/i.test(event.key)" value="<?php echo set_value('applicantNameAss'); ?>" required>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Guardian Name in English<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='guardNameEng' name='guardNameEng' onkeydown="return /[a-z, ]/i.test(event.key)" value="<?php echo set_value('guardNameEng'); ?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Guardian Name in Assamese<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control  search-box" id='guardNameAss' name='guardNameAss' value="<?php echo set_value('guardNameAss'); ?>" required>
                                </div>

                                <div class="row" style="padding-left: 15px;padding-right: 15px">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">Guardian Relation<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="guardianRelation" id="guardianRelation" class="form-control" required>
                                            <option selected value="" disabled>Select</option>
                                            <?php foreach(json_decode(RELATION_NEW_APPL) as $r) { ?>
                                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">Gender<span style="color: red;font-weight: bold;"> *</span></label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn " type="radio" name="gender"  id="gender1"  value="1" required />
                                            <label class="form-check-label mmm " for="inlineRadio1"><?php echo $this->lang->line('m'); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn " type="radio" name="gender"  id="gender2" value="2"  />
                                            <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('f'); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn " type="radio" name="gender"  id="gender3" value="3"  />
                                            <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('o'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Mobile No.<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='mobileNo' name='mobileNo' oninput="this.value = this.value.replace(/[^0-9\.]/g,'')" value="<?php echo set_value('mobileNo'); ?>" required>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv hideInstitution">
                                    <label for="sel1" class="lab">Date of Birth (dd/mm/yyyy)<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="date" class="form-control" id='dob' name='dob'  max="<?php echo date("Y-m-d");?>" value="<?php echo set_value('dob'); ?>">
                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv hideInstitution">
                                    <label for="sel1" class="lab">Community<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="castCategory" id="castCategory" class="form-control">
                                        <option selected value="-1" disabled>Select</option>
                                        <?php foreach(json_decode(CASTE) as $c) { ?>
                                            <option value="<?=$c->CODE?>"><?=$c->NAME?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv hideInstitution" id="proCategory">
                                    <label for="sel1" class="lab">Fall Under Protected Category<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="protectedCategory" id="protectedCategory" class="form-control">
                                        <?php foreach(json_decode(PROTECTED_CLASS) as $p) { ?>
                                            <option value="<?=$p->CODE?>"><?=$p->NAME?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv hideInstitution" >
                                    <label for="sel1" class="lab">Marital Status<span style="color: red;font-weight: bold;"> *</span></label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input nnn " type="radio" name="maritalStatus"  id="maritalStatus"  value="1" />
                                        <label class="form-check-label mmm " for="inlineRadio1"><?php echo $this->lang->line('married'); ?></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input nnn " type="radio" name="maritalStatus"  id="maritalStatus" value="2"  />
                                        <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('unmarried'); ?></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input nnn " type="radio" name="maritalStatus"  id="maritalStatus" value="3"  />
                                        <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('divorced'); ?></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input nnn " type="radio" name="maritalStatus"  id="maritalStatus" value="4"  />
                                        <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('widow'); ?></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input nnn " type="radio" name="maritalStatus"  id="maritalStatus" value="5"  />
                                        <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('widower'); ?></label>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row spouse_details_offline" style="display: none;">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-user" aria-hidden="true"></i> Spouse Details
                            </h5>
                        </div>
                        <div class="row spouse_details_offline" style="display: none;">
                            <div class="tableCard">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Name in English (Spouse)<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='applicantNameEng_spouse' name='applicantNameEng_spouse'  onkeydown="return /[a-z, ]/i.test(event.key)" value="<?php echo set_value('applicantNameEng'); ?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Name in Assamese (Spouse)<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control  search-box" id='applicantNameAss_spouse' name='applicantNameAss_spouse'  onkeydown="return /[a-zA-Z0-9., &:-]+/i.test(event.key)" value="<?php echo set_value('applicantNameAss'); ?>" required>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Guardian Name in English<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='guardNameEng_spouse' name='guardNameEng_spouse' onkeydown="return /[a-z, ]/i.test(event.key)" value="<?php echo set_value('guardNameEng'); ?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Guardian Name in Assamese<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control  search-box" id='guardNameAss_spouse' name='guardNameAss_spouse' value="<?php echo set_value('guardNameAss'); ?>" required>
                                </div>

                                <div class="row" style="padding-left: 15px;padding-right: 15px">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">Guardian Relation<span style="color: red;font-weight: bold;"> *</span></label>
                                        <select name="guardianRelation_spouse" id="guardianRelation_spouse" class="form-control" required>
                                            <option selected value="" disabled>Select</option>
                                            <?php foreach(json_decode(RELATION_NEW_APPL) as $r) { ?>
                                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                        <label for="sel1" class="lab">Gender<span style="color: red;font-weight: bold;"> *</span></label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn " type="radio" name="gender_spouse"  id="gender1"  value="1" required />
                                            <label class="form-check-label mmm " for="inlineRadio1"><?php echo $this->lang->line('m'); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn " type="radio" name="gender_spouse"  id="gender2" value="2"  />
                                            <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('f'); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input nnn " type="radio" name="gender_spouse"  id="gender3" value="3"  />
                                            <label class="form-check-label mmm " for="inlineRadio2"><?php echo $this->lang->line('o'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Date of Birth (dd/mm/yyyy)<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="date" class="form-control" id='dob_spouse' name='dob_spouse'  max="<?php echo date("Y-m-d");?>" value="<?php echo set_value('dob'); ?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Mobile No.<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='mobileNo_spouse' name='mobileNo_spouse' oninput="this.value = this.value.replace(/[^0-9\.]/g,'')" value="<?php echo set_value('mobileNo'); ?>" required>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Community<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="castCategory_spouse" id="castCategory_spouse" class="form-control" required>
                                        <option selected value="-1" disabled>Select</option>
                                        <?php foreach(json_decode(CASTE) as $c) { ?>
                                            <option value="<?=$c->CODE?>"><?=$c->NAME?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv" id="proCategory">
                                    <label for="sel1" class="lab">Fall Under Protected Category<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="protectedCategory_spouse" id="protectedCategory_spouse" class="form-control">
                                        <?php foreach(json_decode(PROTECTED_CLASS) as $p) { ?>
                                            <option value="<?=$p->CODE?>"><?=$p->NAME?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> Address Details
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color:green; font-weight: bold; margin-bottom: 15px;">
                                    Present Address
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Address<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='address1' name='address1'  required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">City<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='city1' name='city1'  required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">District<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="district1" id="district1" class="form-control" required>
                                        <option selected value="">Select</option>
                                        <?php foreach($districts as $dis): ?>
                                            <option value="<?=$dis->district_name?>"><?=$dis->district_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Pin Code<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='pinCode1' name='pinCode1' oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color:green; font-weight: bold; margin-bottom: 15px; margin-top: 25px">
                                    Permanent Address  &nbsp; /&nbsp;
                                    <span style="color: black">
                                  Same as Present Address &nbsp; &nbsp;
                                  <input type="checkbox" id="sameAddress" name="sameAddress" style="width: 18px;height: 18px;">
                                </span>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Address<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='address2' name='address2'  required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">City<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='city2' name='city2'  required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">District<span style="color: red;font-weight: bold;"> *</span></label>
                                    <select name="district2" id="district2" class="form-control" required>
                                        <option selected value="">Select</option>
                                        <?php foreach($districts as $dis): ?>
                                            <option value="<?=$dis->district_name?>"><?=$dis->district_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Pin Code<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="text" class="form-control" id='pinCode2' name='pinCode2' oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <h5 class="reza-title2" style="margin-top: 35px">
                                <i class="fa fa-upload" aria-hidden="true"></i> Upload Documents
                            </h5>
                        </div>
                        <div class="row">
                            <div class="tableCard">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="sel1" class="lab">Copy of the proposal with all supportive documents<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="file" class="form-control" name="proposalDoc" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="sel1" class="lab">Copy of the Minutes of SDLAC Meeting<span style="color: red;font-weight: bold;"> *</span></label>
                                    <input type="file" class="form-control" name="minutesDoc" required>
                                </div>


                                <input type="hidden" id="fileCounter" name="fileCounter" required>

                                <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv" style="margin-top: 30px">
                                    <?php include(APPPATH."views/OfflineSettlement/Common/add_more_document_offline_settlement.php"); ?>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv">
                                    <label for="sel1" class="lab">Remarks (if any)</label>
                                    <textarea name="remarks" id="remarks" class="form-control" rows="4" value="<?php echo set_value('remarks'); ?>" required> </textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 40px">
                                <button type="button" class="rezaButt buttPrimary" id="applicationSubmit">
                                    <i class="fa fa-check-square-o"></i> SUBMIT, APPLICATION
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal submit application -->
<div class="modal" role="dialog" id="submitApplicationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to submit this application </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="submitApplicationModalYes">Yes, Submit</button>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH. '/views/OfflineSettlement/Common/keyboard.php'); ?>

<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });

    $('.spouse_details_offline').hide(300);


    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }


</script>

<script>

    <?php if($this->session->userdata('user_desig_code') == 'LM'): ?>

    // get village list
    $(document).ready(function ()
    {
        $('.chitha_check_lm').hide();
        var dis     = $('#d').val();
        var subdiv  = $('#sd').val();
        var cir     = $('#c').val();
        var mza     = $('#m').val();
        var lot     = $('#l').val();

        $('.landDetails').hide();

        $.ajax({
            url: BASE_URL + "/OfflineSettlementRegisterController/getVillageList",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#v').prop('selectedIndex', 0);

            },
            success: function (data)
            {
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    console.log(data['location']);
                    $.unblockUI();
                    var html = '';
                    var i;
                    html += '<option value="">Select Village</option>';
                    for (i = 0; i < data['test'].length; i++) {
                        html += '<option value=' + data['test'][i].vill_townprt_code + '>' + data['test'][i].loc_name + '</option>';
                    }
                    $('#v').html(html);
                }

            },
            error: function (jqXHR, exception)
            {
                $.unblockUI();
                $('#v').prop('selectedIndex', 0);
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
        return false;
    });

    <?php endif; ?>


    <?php if($this->session->userdata('user_desig_code') == 'CO'): ?>

    // get Mouza list
    $(document).ready(function ()
    {
        $('.chitha_check_lm').hide();
        var dis     = $('#d').val();
        var subdiv  = $('#sd').val();
        var cir     = $('#c').val();


        $('.landDetails').hide();

        $.ajax({
            url: BASE_URL + "/OfflineSettlementRegisterController/getMouzaList",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#m').prop('selectedIndex', 0);

            },
            success: function (data)
            {
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    console.log(data['location']);
                    $.unblockUI();
                    var html = '';
                    var i;
                    html += '<option value="">Select Mouza</option>';
                    for (i = 0; i < data['test'].length; i++) {
                        html += '<option value=' + data['test'][i].mouza_pargona_code + '>' + data['test'][i].loc_name + '</option>';
                    }
                    $('#m').html(html);
                }

            },
            error: function (jqXHR, exception)
            {
                $.unblockUI();
                $('#v').prop('selectedIndex', 0);
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
        return false;
    });

    <?php endif; ?>


    $(document).ready(function() {
        $('input[name="applyFor"]').on('change', function()
        {
            if ($(this).val() === 'individual')
            {
                $('#individualSection').show();
                $('#institutionSection').hide();
                $('input[name="nature_of_land"]').prop('checked', false);
                $('.for_homestead').hide();
                $('.for_agriculture').hide();
                $('.hideInstitution').show();
            }
            else if ($(this).val() === 'institution')
            {
                $('#institutionSection').show();
                $('#individualSection').hide();
                $('.for_homestead').show();
                $('.for_agriculture').hide();
                $('.hideInstitution').hide();
                $('#chitha_verified1').prop('checked', true);  // Select this one
                $('#chitha_verified2').prop('disabled', false); // Ensure it's enabled

            }
        });
    });


    // get dag list
    $('#v').change(function ()
    {
        var dis = $('#d').val();
        var subdiv = $('#sd').val();
        var cir = $('#c').val();
        var mza = $('#m').val();
        var lot = $('#l').val();
        var vill=$('#v').val();
        var pattatype= $(this).val();
        $('.landDetails').hide();

        $.ajax({
            url: BASE_URL + "/OfflineSettlementRegisterController/getDagList",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#pattano').prop('selectedIndex', 0);

            },
            success: function (data)
            {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    var html = '';
                    var i;
                    html += '<option value="">Please select</option>';
                    for (i = 0; i < data['test'].length; i++) {
                        var dagNo = data['test'][i].dag_no;
                        var dag_no_int = data['test'][i].dag_no_int;
                        html += '<option value=' + dagNo + "@" +dag_no_int + '>' + dagNo + '</option>';
                    }
                    $('#dagno').html(html);
                }

            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                $('#dagno').prop('selectedIndex', 0);
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
        return false;
    });


    // get area details
    $('#dagno').change(function ()
    {
        $('.chitha_check_lm').hide();
        var dis = $('#d').val();
        var subdiv = $('#sd').val();
        var cir = $('#c').val();
        var mza = $('#m').val();
        var lot = $('#l').val();
        var vill=$('#v').val();
        var text= $(this).val();
        const myArray = text.split("@");
        var dag_no = myArray[1];

        $.ajax({
            url: BASE_URL + "/OfflineSettlementRegisterController/getAreaDetails",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill,dag:dag_no},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#area').prop('selectedIndex', 0);

            },
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    $("#bigha").val(data.bigha);
                    $("#katha").val(data.katha);
                    $("#lessa").val(data.lessa);

                    $("#land_b").val(data.bigha);
                    $("#land_k").val(data.katha);
                    $("#land_lc").val(data.lessa);


                    $("#ganda").val(data.ganda);
                    $("#kranti").val(data.kranti);

                    $("#land_type").val(data.land_type);
                    $("#land_code").val(data.land_code);

                    $("#patta_no").val(data.patta_no);
                    $("#patta_type_code").val(data.patta_type_code);

                    var html = '';
                    var i;
                    html += '<option value="">Please select</option>';
                    for (i = 0; i < data.land_type_present.length; i++) {
                        var land_type_present = data.land_type_present[i].land_type;
                        var land_type_code = data.land_type_present[i].class_code;
                        html += '<option value=' + land_type_code + '>' + land_type_present + '</option>';
                    }
                    $('#land_type_present').html(html);
                    $('#part_bigha').val('');
                    $('#part_katha').val('');
                    $('#part_lessa').val('');
                }

            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                // $('#dagno').prop('selectedIndex', 0);
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });

        $.ajax({
            url: BASE_URL + "/OfflineSettlementRegisterController/getAllPattadarInDag",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill,dag:dag_no},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#area').prop('selectedIndex', 0);

            },
            success: function (data)
            {
                if (data.responseType == 1)
                {
                    $('.landDetails').hide();
                    $('.chitha_check_lm').hide();
                    var table = '';
                    var html_list = '';
                    $('#pattadardetails').html(table);
                    $("#deleted_pattadar").html(html_list);
                    showWarningMessage(data.message);
                }
                else
                {
                    var selectedValue = $('input[name="applyFor"]:checked').val();
                    if (selectedValue === 'individual')
                    {
                        $('.landDetails').show();
                    }
                    else if (selectedValue === 'institution')
                    {
                        $('.landDetails').show();
                        $('.for_homestead').show();
                        $('.for_agriculture').hide();
                        $('#chitha_verified1').prop('checked', true);  // Select this one
                        $('#chitha_verified2').prop('disabled', false); // Ensure it's enabled
                    }

                    $('.chitha_check_lm').show();
                    var table = '';
                    var html_list = '';
                    for (var i = 0; i <= data.length - 1; i++) {
                        table +=
                            '<tr>'+
                            '<td><input type="hidden" name="pdarname[]" value="'+data[i].id+'__'+data[i].name+'__'+data[i].fathers_name+'">' + data[i].name + '</td>' +
                            '<td><input type="hidden" name="pdarfname[]" value="'+data[i].fathers_name+'">' + data[i].fathers_name + '</td>' +
                            '<td align="center"><input type="hidden" name="encroachmentfrom[]" value="'+data[i].encroachment_from+'">' + data[i].encroachment_from + '</td>' +
                            '<td align="center"><input type="radio" name="select_encroacher" id="select_encroacher'+data[i].c_land_bank_details_id+'" value="'+data[i].id+'"> </td>' +
                            '</tr>';


                        html_list +=
                            '<label class="list-group-item">' +
                            '<input class="form-check-input me-1 form_input ps-3 list-group-flush uncheckpdar" type="checkbox" value="' +
                            data[i].c_land_bank_details_id +'__'+data[i].name+'__'+data[i].fathers_name+
                            '" id="chk_deleted_pattadar"' +
                            data[i].c_land_bank_details_id +
                            ' name="chk_deleted_pattadar[]"><label for="chk_deleted_pattadar"' +
                            data[i].c_land_bank_details_id +
                            ">" +
                            data[i].name +
                            " (" +
                            data[i].fathers_name +
                            ") </label>" +
                            "</label>";
                    }

                    //console.log(html_list);
                    $('#pattadardetails').html(table);
                    $("#deleted_pattadar").html(html_list);
                }

            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                // $('#dagno').prop('selectedIndex', 0);
                $('#pattadardetails').html('');
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });


        return false;
    });

    barak_valley = new Array('21','22','23');

    if($.inArray(district, barak_valley) == -1 ) // other than barak valley
    {
        $('.in_ganda_div').hide();
        $('.in_kranti_div').hide();
        $('.chatak_title').hide();
        $('#agri_katha_barak').hide();
        $('#home_katha_barak').hide();

        $('.lessa_title').show();
        $('#home_katha').show();
        $('#agri_katha').show();

    }
    else // for barak valley
    {
        $('.lessa_title').hide();
        $('#home_katha').hide();
        $('#agri_katha').hide();

        $('.in_ganda_div').show();
        $('.in_kranti_div').show();
        $('.chatak_title').show();
        $('#home_katha_barak').show();
        $('#agri_katha_barak').show();
    }

    $('.nature_of_land').change(function()
    {
        var selectedValue = $('input[name="applyFor"]:checked').val();
        if (selectedValue === 'individual')
        {
            if($(this).val()==1){ //homestead
                $('.for_homestead').show();
                $('.for_agriculture').hide();
            }
            else if($(this).val()==2){ //agriculture
                $('.for_homestead').hide();
                $('.for_agriculture').show();
            }
            else if($(this).val()==3){ //both
                $('.for_homestead').show();
                $('.for_agriculture').show();
            }
        }
        else
        {
            $('.for_homestead').show();
            $('.for_agriculture').hide();
            $('#chitha_verified1').prop('checked', true);  // Select this one
            $('#chitha_verified2').prop('disabled', false); // Ensure it's enabled
        }


    });

    var district = $('#district').val();


    // hide show Protected Category
    $("#castCategory").change(function()
    {
        // general
        if($(this).val() == 6)
        {
            $("#proCategory").hide();
        }
        else
        {
            $("#proCategory").show();
        }

    });




    // set same as address value
    $(document).on('click', '#sameAddress', function()
    {
        if(this.checked){

            var address1  = document.getElementById("address1").value;
            var city1     = document.getElementById("city1").value;
            var district1 = document.getElementById("district1").value;
            var pinCode1  = document.getElementById("pinCode1").value;

            var copyAddress1  = address1;
            var copyCity1     = city1;
            var copyDistrict1 = district1;
            var copyPinCode1  = pinCode1;

            document.getElementById("address2").value  = copyAddress1;
            document.getElementById("city2").value     = copyCity1;
            document.getElementById("district2").value = copyDistrict1;
            document.getElementById("pinCode2").value  = copyPinCode1
        }
        else
        {
            document.getElementById("address2").value  = '';
            document.getElementById("city2").value     = '';
            document.getElementById("district2").value = '';
            document.getElementById("pinCode2").value  = '';
        }
    });


    // application submit confirmation
    $(document).on('click','#applicationSubmit',function ()
    {
        $('#submitApplicationModal').modal('show');
    });

    $(document).on('click','#submitApplicationModalNo',function ()
    {
        $('#submitApplicationModal').modal('hide');
    });

    // application submit
    $(document).on('click','#submitApplicationModalYes',function ()
    {
        var fileTotCount = $('#fileCounter').val();
        $('#myForm').submit();
        $('#submitApplicationModal').modal('hide');
    });

    $('input[type=radio][name=maritalStatus]').change(function (e)
    {
        if ($(this).val() == null) {
            return;
        }
        if($(this).val() == '1')
        {
            $('.spouse_details_offline').show(300);
        }
        else
        {
            $('.spouse_details_offline').hide(300);
        }
    });





</script>


