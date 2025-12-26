<!-- Masud's CSS-->
<style>
    .error
    {
        color: red;
    }
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard {
        margin: 10px auto;
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
        /* width: 90%; */
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

<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
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
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }

    .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        text-transform: capitalize;
        margin-left: 25px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
        margin: 10px;
    }

    .bgheading{
        background-color: #248cf7 !important;
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
</style>

<style>
    .timeline {
        max-width: 830px;
        margin: 0px auto;
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 15px 0px;
    }
    .timeline::after {
        content: "";
        position: absolute;
        width: 3px;
        background-color: #848892;
        height: 100%;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
    }
    .timeline__content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 18px 30px;
        background-color: white;
        border-radius: 5px;
        position: relative;
        width: 386px;
        box-shadow: 0 2px 8px 0 #242e4c59;
    }
    .timeline__content::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: white;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
    }
    .timeline__content::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        /*background-color: #848892;*/
        border-radius: 50%;
        transform: translateY(-50%);
    }
    .timeline__content:nth-child(odd) {
        margin-left: auto;
    }
    .timeline__content:nth-child(odd) .content_tag {
        right: 5px;
    }
    .timeline__content:nth-child(odd)::after {
        left: -10px;
    }
    .timeline__content:nth-child(odd)::before {
        top: 50%;
        left: -39px;
    }
    .timeline__content:nth-child(even) {
        align-items: flex-end;
    }
    .timeline__content:nth-child(even) .content_p {
        text-align: right;
    }
    .timeline__content:nth-child(even)::after {
        right: -10px;
    }
    .timeline__content:nth-child(even)::before {
        top: 50%;
        right: -39px;
    }
    .timeline__content:nth-child(even) .content_tag {
        left: 5px;
    }

    .content_tag {
        position: absolute;
        top: 5px;
        padding: 6px 10px;
        background-color: #66BB6A;
        border-radius: 3px;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
        text-transform: capitalize;
    }

    .content_date {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #848892;
    }
    .content_Name {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #673AB7;
    }
    .content_p {
        color: #242e4c;
        max-width: 230px;
        margin-bottom: 20px;
    }
    .content_link {
        display: inline-flex;
        text-decoration: none;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
    }
    .content_link svg {
        margin-left: 5px;
    }
    .content_link:hover {
        color: royalblue;
        transition-duration: 300ms;
    }
    .content_link:hover svg path {
        fill: royalblue;
    }

    .rezaCaseSpanTotal{
        min-width: 270px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanBTotal{
        min-width: 100px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanTotal{
        min-width: 140px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .badge-reza1{
        background-color: #F44336;
    }

    .badge-reza3{
        background-color: #9C27B0;
    }



    @media screen and (max-width: 600px) {
        .timeline {
            gap: 15px;
            padding: 10px;
        }
        .timeline::after {
            display: none;
        }
        .timeline__content {
            width: 100%;
        }
        .timeline__content::after {
            display: none;
        }
        .timeline__content::before {
            display: none;
        }
    }
</style>

<style>
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
        border: 1px solid #999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative;
    }
    .tree li::before,
    .tree li::after {
        content: "";
        left: -20px;
        position: absolute;
        right: auto;
    }
    .tree li::before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px;
    }
    .tree li::after {
        border-top: 1px solid #999;
        height: 20px!important;
        top: 25px;
        width: 25px;
    }
    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #999;
        border-radius: 5px;
        display: inline-block;
        padding: 3px 8px;
        text-decoration: none;
    }
    .tree li.parent_li > span {
        cursor: pointer;
    }
    .tree > ul > li::before,
    .tree > ul > li::after {
        border: 0;
    }
    .tree li:last-child::before {
        height: 46px;
    }
    .tree li.parent_li > span:hover,
    .tree li.parent_li > span:hover + ul li span {
        background: #eee;
        border: 1px solid #94a0b4;
        color: #000;
    }


    .rezaSpan{
        min-width: 140px;
        padding-left: 15px;
    }
    .rezaSpanB{
        min-width: 100px;
        padding-left: 15px;
    }
    .rezaCaseSpan{
        min-width: 270px;
        padding-left: 15px;
    }

    .badge-reza1{
        background-color: #F44336;
    }
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #9C27B0;
    }
    .textBold{
        font-size: 18px;
        font-weight: bold;
        color: #156B88;
        text-transform: uppercase;

    }

</style>



<div class="row" style='padding: 30px 40px 30px 10px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">


        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
            <br>
        <?php } ?>

        <h5 class="bg-info p-2 text-white shadow"  style="margin-top: 10px; text-transform: uppercase">
            Request For Dag Deletions
        </h5>

        <div class="reza-card">
            <form id="myForm" action="" method="POST" enctype="multipart/form-data">

                <div class="reza-body">
                    <div class="row">
                        <h5 class="reza-title" style="margin-top: -5px">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Area Details
                        </h5>
                    </div>
                    <div class="row">
                        <div class="tableCard">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                <label class="lab" for="sel1">District:<span style="color: red;font-weight: bold;"> *</span></label>
                                <select name="dist_code" class="form-control" id="d" required>
                                    <?php $dist_code=$this->session->userdata('dist_code');?>
                                    <option value="<?php echo $dist_code;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                    </option>

                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                <label class="lab"  for="sel1">Sub-Div:<span style="color: red;font-weight: bold;"> *</span></label>
                                <select name="subdiv_code"  class="form-control"  id="sd" required>
                                    <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                    </option>
                                </select>
                                <!-- </div> -->
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

                        </div>
                    </div>

                    <div class="row">
                        <h5 class="reza-title" style="margin-top: 35px">
                            <i class="fa fa-map" aria-hidden="true"></i> Dag Details
                        </h5>

                    </div>
                    <div class="row">
                        <div class="tableCard">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv">
                                <label for="sel1" class="lab">Dag No:<span style="color: red;font-weight: bold;"> *</span></label>
                                <select name="dag_no"  class="form-control" id="dagno" required>
                                    <option value="">Select Dag No </option>
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labDiv landDetails" >
                                <label for="sel1" class="lab">Land Class<span style="color: red;font-weight: bold;"> *</span></label>
                                <input type="hidden" class="form-control" id='land_code' name='land_code' readonly>
                                <input type="text" class="form-control" id='land_type' name='land_type' readonly>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                <label for="sel1" class="lab"><?php echo $this->lang->line('bigha'); ?></label>

                                <input type="text" class="form-control" id='bigha' name='dag_area_b' placeholder="Bigha" readonly>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                <label for="sel1" class="lab"><?php echo $this->lang->line('katha'); ?></label>

                                <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="Katha" readonly>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                <label for="sel1" class="lab"><?php echo $this->lang->line('lesa'); ?></label>

                                <input type="text" class="form-control"  id='lessa' name='dag_area_lc' placeholder="Lessa" readonly>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                <label for="sel1" class="lab"><?php echo $this->lang->line('ganda'); ?></label>
                                <input type="text" class="form-control"  id='ganda' name='dag_area_ganda' placeholder="Lessa" readonly>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv landDetails">
                                <label for="sel1" class="lab">Kranti</label>
                                <input type="text" class="form-control"  id='kranti' name='dag_area_kranti' placeholder="Lessa" readonly>
                            </div>

                            <div class="chitha_check_lm" style="margin-top: 15px; ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv landDetails"
                                     style="border: 1px solid red; padding-top: 10px; padding-bottom: 5px; margin-top: 15px; border-radius: 3px">
                                    <label for="sel1" class="lab">
                                        <span> Have you verified Chitha? <span style="color: red;font-weight: bold;"> *</span>
                                            <span class="error" id="chitha_verifiedErr"></span>
                                        </span>
                                    </label> &nbsp; &nbsp; &nbsp;
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="chitha_verified"  id="chitha_verified1"  value="YES" />
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="chitha_verified"  id="chitha_verified2" value="NO"  />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 landDetails" style="margin-top: 15px">
                                <hr>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 landDetails" style="margin-top: 15px">
                                <span class=" textBold">Pattdars:</span>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv landDetails">
                                <table class="table table-bordered" id='showpattadars' >
                                    <thead style="white-space:nowrap; width:100%">
                                    <tr class="text-bold" style="background-color: #186E83!important; color: white!important;">
                                        <th style="width: 50%;">Name</th>
                                        <th style="width: 50%;">Fathers Name</th>
                                    </tr>
                                    </thead>
                                    <tbody id='pattadardetails'>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id='patta_no' name='patta_no' >
                        <input type="hidden" class="form-control" id='patta_type_code' name='patta_type_code'>

                    </div>

                    <div class="row">
                        <h5 class="reza-title" style="margin-top: 35px">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Application Details
                        </h5>
                    </div>
                    <div class="row">
                        <div class="tableCard">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv">
                                <label for="sel1" class="lab">Reason For Delete<span style="color: red;font-weight: bold;"> *</span></label>
                                <select name="reason"  class="form-control" id="reason" required>
                                    <option selected disabled>Select Reason  </option>
                                    <?php foreach(json_decode(DAG_DELETE_REASON) as $r) { ?>
                                        <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="hidden" id="fileCounter" name="fileCounter" required>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labDiv">
                                <label for="sel1" class="lab">Remarks<span style="color: red;font-weight: bold;"> *</span></label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="4" required> </textarea>
                            </div>

                        </div>
                    </div>
                    <?php
                    include(APPPATH."views/SettlementView/include/addMoreDocumentDagEntryView.php");
                    ?>

                    <div class="row"  align="right">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px!important;">
                            <button type="button" class="rezaButt buttPrimary" id="submitToCo" style="margin-top: 35px">
                                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                SUBMIT & FORWARD TO CO
                            </button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal for confirmation -->
<div class="modal" role="dialog" id="submitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to submit this application & forward to CO</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitModalNo">NO</button>
                <button type="button" class="btn btn-primary"   id="submitModalYes">YES, SUBMIT</button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->


<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>



<script>

    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 8000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 50000,
            showCancelButton: true

        });
    }

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 50000,
            showConfirmButton: true,
        });
    }

    // ****************************************************************


    $(document).on('click','#submitToCo',function ()
    {
        $('#submitModal').modal('show');
    });

    $(document).on('click','#submitModalNo',function ()
    {
        $('#submitModal').modal('hide');
    });

    // submit & forward to Co
    $(document).on('click','#submitModalYes',function ()
    {
        $('#submitModal').modal('hide');
        var form_data = new FormData();

        var district = $('#d').val();
        form_data.append("dist_code", district);

        var subDiv   = $('#sd').val();
        form_data.append("subdiv_code", subDiv);

        var circle   = $('#c').val();
        form_data.append("cir_code", circle);

        var mouzza   = $('#m').val();
        form_data.append("mouza_pargona_code", mouzza);

        var lot      = $('#l').val();
        form_data.append("lot_no", lot);

        var village  = $('#v').val();
        form_data.append("vill_townprt_code", village);

        var text= $("#dagno").val();
        const myArray = text.split("@");
        let dagNo = myArray[1];

        form_data.append("dag_no", dagNo);

        var landCode = $("#land_code").val();
        form_data.append("land_class_code", landCode);

        var reason   = $("#reason").val();
        form_data.append("reason", reason);

        var remarks  = $("#remarks").val();
        form_data.append("remarks", remarks);

        var fileTotCount = $('#fileCounter').val();
        if(!fileTotCount)
        {
            showWarningMessage("Kindly upload atleast one document file...");
            return false;
        }
        for (var index = 1; index <= fileTotCount; index++) {
            console.log("--"+index);
            var name = document.getElementById('uploadFile'+index);

            if(name){
                form_data.append("uploadFile"+index, name.files[0]);
                form_data.append("document"+index, $('#document'+index).val());
            }
        }
        form_data.append("chitha_verified", $('input[type="radio"][name="chitha_verified"]:checked').val());


        var bigha = $("#bigha").val();
        form_data.append("bigha", bigha);

        var katha = $("#katha").val();
        form_data.append("katha", katha);

        var lessa = $("#lessa").val();
        form_data.append("lessa", lessa);

        var ganda  = $("#ganda").val();
        form_data.append("ganda", ganda);

        var kranti = $("#kranti").val();
        form_data.append("kranti", kranti);

        var patta_no = $("#patta_no").val();
        form_data.append("patta_no", patta_no);

        var patta_type_code = $("#patta_type_code").val();
        form_data.append("patta_type_code", patta_type_code);

        var fileCounter = $("#fileCounter").val();
        form_data.append("fileCounter", fileCounter);



        if(village == '')
        {
            showWarningMessage("Please Select village !");
            return false;
        }
        if(dagNo == '')
        {
            showWarningMessage("Please Select dag number !");
            return false;
        }
        if(landCode == '')
        {
            showWarningMessage("Land Class not found !");
            return false;
        }
        if(reason == '')
        {
            showWarningMessage("Please Select reason for dag delete !");
            return false;
        }
        if(remarks == '')
        {
            showWarningMessage("Please Enter Some Remarks !");
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border: 'none',
                backgroundColor: 'transparent'
            }
        });

        $.ajax({
            url: BASE_URL + "/DagDeletionController/lmSubmitAndForwardToCo",
            type: "POST",
            processData: false, // important
            contentType: false, // important
            dataType: "json",
            data: form_data,
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    $('#submitModal').modal('hide');

                    showErrorMessage(data.msg);
                    data.validation.forEach(function(validation) {

                        var errMsg = "#" + validation.field + "Err";
                        $(errMsg).text("⚠️ " + validation.message);

                    });
                }
                else if (data.responseType == 2)
                {
                    Swal.fire({
                        icon              : 'success',
                        backdrop          : true,
                        allowOutsideClick : false,
                        text              : data.msg,
                        showCancelButton  : true,
                        confirmButtonText : 'CONFIRM',
                    }).then((result) => {
                        location.reload();
                })
                }
            },
            error:function(data){
                $.unblockUI();
                showErrorMessage("Something went wrong");
            }
        });
    });
</script>

<script>

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
            url: BASE_URL + "/DagDeletionController/getVillageList",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#v').prop('selectedIndex', 0);

            },
            success: function (data)
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
            url: BASE_URL + "/DagDeletionController/getDagList",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#pattano').prop('selectedIndex', 0);

            },
            success: function (data) {

                $.unblockUI();
                var html = '';
                var i;
                html += '<option value="">Please select</option>';
                for (i = 0; i < data['test'].length; i++) {
                    var dagNo = data['test'][i].dag_no;
                    var dag_no_int = data['test'][i].dag_no_int;
                    html += '<option value=' + dagNo + "@" +dag_no_int + '>' + dagNo + '</option>';
                }
                $('#dagno').html(html);
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
        let dag_no = myArray[1];

        $.ajax({
            url: BASE_URL + "/DagDeletionController/getAreaDetails",
            method: "POST",
            data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill,dag:dag_no},
            async: true,
            dataType: 'json',
            beforeSend: function () {
                $('#area').prop('selectedIndex', 0);

            },
            success: function (data) {
                $.unblockUI();

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

            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                // $('#dagno').prop('selectedIndex', 0);
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });

        $.ajax({
            url: BASE_URL + "/DagDeletionController/getAllPattadarInDag",
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
                    $('.landDetails').show();
                    $('.chitha_check_lm').show();
                    var table = '';
                    var html_list = '';
                    for (var i = 0; i <= data.length - 1; i++) {
                        table +=
                            '<tr>'+
                            '<td><input type="hidden" name="pdarname[]" value="'+data[i].pdar_id+'__'+data[i].pdar_name+'__'+data[i].pdar_father+'">' + data[i].pdar_name + '</td>' +
                            '<td><input type="hidden" name="pdarfname[]" value="'+data[i].pdar_father+'">' + data[i].pdar_father + '</td>' +
                            '</tr>';


                        html_list +=
                            '<label class="list-group-item">' +
                            '<input class="form-check-input me-1 form_input ps-3 list-group-flush uncheckpdar" type="checkbox" value="' +
                            data[i].pdar_id +'__'+data[i].pdar_name+'__'+data[i].pdar_father+
                            '" id="chk_deleted_pattadar"' +
                            data[i].pdar_id +
                            ' name="chk_deleted_pattadar[]"><label for="chk_deleted_pattadar"' +
                            data[i].pdar_id +
                            ">" +
                            data[i].pdar_name +
                            " (" +
                            data[i].pdar_father +
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

</script>