<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
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
        padding-bottom: 40px;

    }
    .rezaS{
        background-color: #ECEFF1;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .rezaButt {
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
    .btn-info{

    }
    .form-checkbox-input
    {
        width: 18px!important;
        height: 18px!important;
    }
    .me-1
    {
        width: 18px!important;
        height: 18px!important;
    }
</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="font-size: 20px;">
            <strong>Add / Edit  Members For Minutes Copy to :-</strong>

            <!--            --><?php //if($this->session->userdata('user_desig_code') == MB_ADD_DEPUTY_COMM) { ?>
            <!--                <a class="btn btn-sm btn-info pull-right" href="--><?//=base_url().'index.php/NcCommonProposalAdc/commonProposalListViewAdc'?><!--"><i class="fa fa-backward"></i>&nbsp;Go Back</a>-->
            <!--            --><?php //} else if($this->session->userdata('user_desig_code') == MB_SUB_DIV_COMM) { ?>
            <!--                <a class="btn btn-sm btn-info pull-right" href="--><?//=base_url().'index.php/NcCommonProposalSdo/commonProposalListViewSdo'?><!--"><i class="fa fa-backward"></i>&nbsp;Go Back</a>-->
            <!--            --><?php //} ?>

        </div>

        <div class="reza-card">
            <div class="reza-title"></div>
            <div class="reza-body">
                <!--                --><?php //if($this->session->userdata('user_desig_code') == MB_ADD_DEPUTY_COMM) { ?>
                <!--                     <form method="post" action="--><?//=base_url().'index.php/NcCommonProposalAdc/saveCcDataNc'?><!--">-->
                <!--                --><?php //} else if($this->session->userdata('user_desig_code') == MB_SUB_DIV_COMM) { ?>
                <!--                     <form method="post" action="--><?//=base_url().'index.php/NcCommonProposalSdo/saveCcDataNc'?><!--">-->
                <!--                --><?php //} ?>


                <form method="post" action="<?=base_url().'index.php/SettlementCommonDc/saveCcDataIns'?>">


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <h3 class="alert-warning text-center"><?=$this->session->flashdata('message')?></h3>

                            <!-- MP -->
                            <div class="container shadow-sm mt-3 rezaS">
                                <h5 class="reza-title">MP</h5>
                                <div class="reza-body">
                                    <?php if($userMp_count == 0): ?>
                                        <b style="color: red"> Kindly Add MP ! </b>
                                    <?php else: ?>
                                        <?php $j=0; foreach($userMp_name as $mp) { ?>

                                            <div class="form-check mb-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="checkbox" class="form-checkbox-input" value="<?=$mp->user_code?>" id="honble_mp" name="honble_mp<?=$j?>"
                                                            <?php if($isInserted == true){
                                                                foreach($inserted_data as $dtt)
                                                                {
                                                                    if((trim($dtt->user_code) == trim($mp->user_code)) && ($dtt->user_level == '1'))
                                                                    {
                                                                        echo "checked";
                                                                    }
                                                                }
                                                            }?>>
                                                        &nbsp;<?=$mp->username?> Hon'ble MP
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" value="<?php if($isInserted == true){
                                                            foreach($inserted_data as $dtt)
                                                            {
                                                                if((trim($dtt->user_code) == trim($mp->user_code)) && ($dtt->user_level == '1'))
                                                                {
                                                                    echo $dtt->hpc_lac;
                                                                }
                                                            }
                                                        }?>" id="hpc" name="hpc<?=$j?>" placeholder="Enter HPC">
                                                    </div>
                                                    <div class="col-md-4">
                                                        HPC.
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $j++; } ?>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <!-- MLA -->
                            <div class="container shadow-sm mt-3 rezaS">
                                <h5 class="reza-title">MLA</h5>
                                <div class="reza-body">

                                    <?php if($userMla_list == '' OR $userMla_list  == NULL): ?>
                                        <b style="color: red"> Kindly Add MLA ! </b>
                                    <?php else: ?>
                                        <?php $i=0; foreach($userMla_list as $mla) { ?>

                                            <div class="form-check mb-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="checkbox" class="form-checkbox-input" value="<?=$mla->user_code?>" id="honble_mla" name="honble_mla<?=$i?>"
                                                            <?php if($isInserted == true){
                                                                foreach($inserted_data as $dtt)
                                                                {
                                                                    if((trim($dtt->user_code) == trim($mla->user_code)) && ($dtt->user_level == '2'))
                                                                    {
                                                                        echo "checked";
                                                                    }
                                                                }
                                                            }?>>
                                                        &nbsp;<?=$mla->username?> Hon'ble MLA
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" value="<?php if($isInserted == true){
                                                            foreach($inserted_data as $dtt)
                                                            {
                                                                if((trim($dtt->user_code) == trim($mla->user_code)) && ($dtt->user_level == '2'))
                                                                {
                                                                    echo $dtt->hpc_lac;
                                                                }
                                                            }
                                                        }?>" id="lac" name="lac<?=$i?>" placeholder="Enter LAC">
                                                    </div>
                                                    <div class="col-md-4">
                                                        LAC.
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $i++; } ?>
                                    <?php endif; ?>



                                </div>
                            </div>

                            <!-- chairman -->
                            <div class="container shadow-sm mt-3 rezaS">
                                <h5 class="reza-title">Chairman</h5>
                                <div class="reza-body">
                                    <div class="form-check">

                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            The Chairman,
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <select class="form-control" id="zila_parishad" name="zila_parishad">
                                                <option value="">-- Select Zilla Parishad--</option>
                                                <?php foreach($usersdlc_list as $sdlc) { ?>
                                                    <option value="<?=$sdlc->user_code?>"
                                                        <?php if($isInserted == true){
                                                            foreach($inserted_data as $dtt)
                                                            {
                                                                if((trim($dtt->user_code) == trim($sdlc->user_code)) && ($dtt->user_level == '6'))
                                                                {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                        }?>>
                                                        <?=$sdlc->username?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            Zilla Parishad.
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- municipal board -->
                            <div class="container shadow-sm mt-3 rezaS">
                                <h5 class="reza-title">Municipal Board</h5>
                                <div class="reza-body">
                                    <div class="row">
                                        <?php $mm=0; foreach($usersdlc_list as $sdlc) { ?>
                                            <div class="col-3">
                                                <input class="form-check-input me-1" type="checkbox" value="<?php echo $sdlc->user_code;?>"
                                                       name="municipal_board[]" <?php if($isInserted == true){ foreach($inserted_data as $dtt){ if((trim($dtt->user_code) == trim($sdlc->user_code)) && ($dtt->user_level == '7')){ echo 'checked';}}}?>>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?=$sdlc->username?>
                                            </div>
                                            <div class="col-3" style="margin-bottom: 15px">
                                                <input type="text" class="form-control" value="<?php if($isInserted == true){
                                                    foreach($inserted_data as $dtt)
                                                    {
                                                        if(trim($dtt->user_level == '7') && (trim($dtt->user_code) == trim($sdlc->user_code)) )
                                                        {
                                                            echo $dtt->board_name;
                                                        }
                                                    }
                                                }?>" id="boardName" name="boardNameMunicipal<?= $sdlc->user_code?>" placeholder="Enter Board Name">
                                            </div>
                                            <?php  $mm++; } ?>

                                    </div>
                                </div>
                            </div>

                            <!-- Social Workers -->
                            <div class="container shadow-sm mt-3 rezaS">
                                <h5 class="reza-title">Social Workers</h5>
                                <div class="reza-body">

                                    <div class="row">

                                        <?php foreach($usersdlc_list as $sdlc) { ?>
                                            <!-- <label class="list-group-item"> -->
                                            <div class="col-3">
                                                <input class="form-check-input me-1" type="checkbox" value="<?=$sdlc->user_code?>"
                                                       name="social_worker[]" id="social_worker"
                                                    <?php
                                                    if($isInserted == true){
                                                        foreach($inserted_data as $dtt){
                                                            if((trim($dtt->user_code) == trim($sdlc->user_code)) && ($dtt->user_level == '8')){
                                                                echo 'checked';
                                                            }
                                                        }
                                                    }?>>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?=$sdlc->username?>
                                            </div>

                                            <!-- </label> -->
                                        <?php } ?>

                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4">
                                <button type="submit" class="rezaButt pull-right"
                                        id="saveData">Save Data</button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
