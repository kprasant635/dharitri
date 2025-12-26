<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">

            <?php if($this->session->flashdata('message')):?>
            <div class="col-lg-12 ">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                </div>
            </div>
            <?php endif;?>

            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Take Co-Pattadar Consent For Partition
                    </h2>
                </div>
               
                <div class="mb-3 text-center">
                    <a target="__blank"  href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $pdars[0]->dag_no . '&m=' . $pdars[0]->mouza_pargona_code . '&l=' . $pdars[0]->lot_no . '&v=' . $pdars[0]->vill_townprt_code . '&p=' . $pdars[0]->patta_type_code . '&dist=' . $pdars[0]->dist_code . '&cir=' . $pdars[0]->cir_code . '&sub_div=' . $pdars[0]->subdiv_code ?>" class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                    <br>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location->date_entry)); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php $action = base_url()."index.php/lmmutation/takeconsent";?>
                        <form class='form-horizontal' action="<?php echo $action;?>"  method="post">
                            <table class='table table-striped table-bordered unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('pattadar_name')?></label></th>
                                <th class="center"><label class="control-label">Check All &nbsp;<input type="checkbox" id="selectall" class="squaredTwo"></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('remark')?></label></th>
                                </thead>
                                <input type="hidden" name='dist_code' id="dist_code" value="<?php echo $location->dist_code;?>"/>
                                <input type="hidden" name='subdiv_code' value="<?php echo $location->dist_code;?>"/>
                                <input type="hidden" name='cir_code' value="<?php echo $location->cir_code;?>"/>
                                <input type="hidden" name='subdiv_code' value="<?php echo $location->subdiv_code;?>"/>
                                <input type="hidden" name='mouza_pargona_code' value="<?php echo $location->mouza_pargona_code;?>"/>
                                <input type="hidden" name='lot_no' value="<?php echo $location->lot_no;?>"/>
                                <input type="hidden" name='vill_townprt_code' value="<?php echo $location->vill_townprt_code;?>"/>
                                <input type="hidden" name='patta_no' value="<?php echo $location->patta_no;?>"/>
                                <input type="hidden" name='patta_type_code' value="<?php echo $location->patta_type_code;?>"/>
                                <input type="hidden" name='case_no' id="case_no" value="<?php echo $case_no?>"/>
                                <?php 
                                $count = count($pdars);
                                if($count == 0){
                                    echo "<tr class='center'><td colspan='3'>No Need To Take Consent. (Here All Pattaders are the Applicants ).</td></tr>";
                                }
                                else{
                                    foreach ($pdars as $pdar): ?>
                                    <tr>
                                        <td><input type="text" readonly name="pdar[id][<?php echo $pdar->pdar_id; ?>]" value="<?php echo $pdar->pdar_name; ?>" /></td>
                                        <td class='center'><input type='checkbox' class='checkboxall squaredTwo' name="pdar[consentid][]" value="<?php echo $pdar->pdar_id; ?>"></td>
                                        <td><textarea cols="50" rows='5' required="" name="pdar[comment][<?php echo $pdar->pdar_id; ?>]" >সন্মতি আছে |</textarea></td>
                                    </tr>
                                    <?php endforeach; 
                                }
                                ?>
                            </table>


                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-12 text-bold text-red" id="alert_message"></div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <label><u>Upload Supportive Document</u></label>
                                &nbsp;
<i class="fa fa-info-circle text-red" 
title="1. Uploaded file types should be jpeg|jpg|png|pdf only.
2. Uploaded file size should not be more than 4MB"></i>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>


                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                                <table class="table table-striped table-bordered">
                                    <tbody id='certi_tab'>
                                        <tr>
                                            <td><span class="text-bold">1. <?=DEATH_CERTIFICATE?></span>
                                            </td>
                                            <td><input type='file' name="death_cer" id="death_cer"></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning uploadDocumentLM" id=1>Upload Death Certificate&nbsp;<i class='fa fa-upload'></i></button>
                                            </td>
                                            <td>
                                                <?php if(!empty($d_id)) { if($d_id->id!='' || $d_id->id!=null) { ?>
                                                <a  style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$d_id->id?>" target="_blank">VIEW <?=$d_id->file_name?></a>
                                                <?php }} ?>
                                                <div id="file_11"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="text-bold">2. <?=NOC?></span>
                                            </td>
                                            <td><input type='file' name="noc_file" id="noc_file"></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning uploadDocumentLM" id=2>Upload NOC&nbsp;<i class='fa fa-upload'></i></button>
                                                </a>
                                            </td>
                                            <td>

                                                <?php if(!empty($noc_id)) { if($noc_id->id!='' || $noc_id->id!=null) { ?>
                                                <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$noc_id->id?>" target="_blank">VIEW <?=$noc_id->file_name?></a>
                                                <?php }} ?>
                                                <div id="file_12"></div>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="text-bold">3. <?=NOK_CONSENT?></span>
                                            </td>
                                            <td><input type='file' name="nok_file" id="nok_file"></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning uploadDocumentLM" id=3>Upload NOK&nbsp;<i class='fa fa-upload'></i></button>
                                            </td>
                                            <td>

                                                <?php if(!empty($nok_id)) { if($nok_id->id!='' || $nok_id->id!=null) { ?>
                                                <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$nok_id->id?>" target="_blank">VIEW <?=$nok_id->file_name?></a>
                                                <?php }} ?>
                                                <div id="file_13"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>




                            <center>
                                <?php 
                                $count = count($pdars);
                                if($count != 0){
                                ?>
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button')?></button>
                                <?php
                                }
                                ?>
                                <a href="<?php echo base_url() . 'index.php/lmmutation/copattaddarConsent' ?>" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </center>
                        </form>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
$("#selectall").click(function(){
        if(this.checked){
            $('.checkboxall').each(function(){
                this.checked = true;
            })
        }else{
            $('.checkboxall').each(function(){
                this.checked = false;
            })
        }
    });
});

</script>