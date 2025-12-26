<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Pending Backlog Office Conversion Case Details</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                            <table class='table table-bordered unicode'>
                                <tr>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                    <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger">
                                        <?php $mut_type = $this->utilityclass->ByrightOf($case_details[0]->mut_type); ?>
                                        <?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $mut_type->order_type; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?> : <?php echo $dag_details[0]->dag_no; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?> : <?php echo $dag_details[0]->patta_no; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('case_no'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $case_details[0]->case_no; ?></label></td>
                                    <td><label class="text-danger">&nbsp;</label></td>
                                    <td><label class="text-danger">
                                        <?php $patta_type_name = $this->utilityclass->getPattaName($dag_details[0]->patta_type_code); ?>
                                        <?php echo $this->lang->line('patta_type'); ?> : <?php echo $patta_type_name; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('new_dag_no'); ?> : <?php echo $change_details[0]->new_dag_no; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('new_patta_no'); ?> : <?php echo $change_details[0]->new_patta_no; ?></label></td>
                                    <td><label class="text-danger">
                                        <?php $new_patta_type_name = $this->utilityclass->getPattaName($change_details[0]->new_patta_type); ?>
                                        <?php echo $this->lang->line('new_patta_type'); ?> : <?php echo $new_patta_type_name; ?></label></td>
                                </tr>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <label>লাঃমঃই প্ৰতিবেদন মৰ্মে জনা যায় যে ম্যদীকৰনৰ বাবে আবেদন কৰা জমী <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <?php echo $dag_details[0]->patta_no; ?> নং <?php echo $patta_type_name; ?> পট্টাৰ <?php echo $dag_details[0]->dag_no; ?> নং দাগৰ <?php echo $dag_details[0]->m_dag_area_b; ?> বিঘা <?php echo $dag_details[0]->m_dag_area_k; ?> কঠা <?php echo $dag_details[0]->m_dag_area_lc; ?> লেছা জমী হয় | 
                            লাঃমঃ ৰ প্ৰতিবেদনৰ মতে আবেদিত জমীৰ প্রিমিয়াম <?php echo $change_details[0]->premium; ?> টকা <?php echo $change_details[0]->premi_chal_recpt_no; ?> নং <?php echo $change_details[0]->premi_chal_recpt; ?> যোগে <?php echo $change_details[0]->new_patta_no; ?> নং <?php echo $new_patta_type_name; ?> পট্টা আৰু <?php echo $change_details[0]->new_dag_no; ?> নং দাগে ম্যাদীকৰণ কৰা হল | </label>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198">Applicant Details</h4>
                            <table class="table table-bordered  unicode">
                                <thead>
                                    <tr>
                                        <th><label class="text-danger">Applicant name</label></th>
                                        <th class="center"><label class="text-danger">Guardian Name</label></th>
                                        <th class="center"><label class="text-danger">Guardian Relation</label></th>
                                        <th class="center"><label class="text-danger">Address 1 / Address 2</label></th>
                                    </tr>
                                </thead>
                                <?php 
                                    foreach ($conversion_petitioner as $petitioner):
                                    ?>
                                    <tr>
                                        <td><label class="control-label"><?php echo $petitioner->pdar_name; ?></label></td>
                                        <td class="center"><label class="control-label"><?php echo $petitioner->pdar_guardian; ?></label></td>
                                        <td class="center"><label class="control-label"><?php echo $gurdian_relation = $this->utilityclass->get_relation($petitioner->pdar_add1); ?></label></td>
                                        <td class="center"><label class="control-label"><?php echo $petitioner->pdar_add1; ?></label></td>
                                    </tr>
                                    <?php
                                    endforeach;
                                ?>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12" id="co_block">
                                    <label class="rasid col-sm-12">
                                          <input type="checkbox" id="myCheck" onclick="myFunction()"> চঃ বিঃ – লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া ম্যাদীকৰণ ও নথি সংশোধন অনুমোদন কৰা হ’ল   |
                                    </label>
                            </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-4">
                                <?php
                                    if($case_details[0]->trans_code == 'F'){
                                        ?>
                                        <a href="<?php echo base_url() . "index.php/BackLogConversion/UpdateFConv"; ?>" class="btn btn-success" id="change_text1"><i class='fa fa-check'></i>&nbsp;Submit & Pass Final Order</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo base_url() . "index.php/BackLogConversion/UpdatePConv"; ?>" class="btn btn-success" id="change_text1"><i class='fa fa-check'></i>&nbsp;Submit & Pass Final Order</a>
                                        <?php
                                    }
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/BackLogConversion/PendingCases" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
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
 $("#change_text1").attr('disabled', true);
 function myFunction() {
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true){
      $('#change_text1').removeAttr('disabled', false);
    } else {
      $('#change_text1').attr('disabled', true);
    }
}   
</script>