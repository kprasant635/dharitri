<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<?php $errorFlag = FALSE; ?>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm bg-info">
                    <h2 style="text-align: center;">Information regarding chitha and jamabandi synchronization</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Field Mutation/Partition (Pattadar Sync)
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text">
                                <?php if ($jcount == $ccount): ?>
                                    <p style="font-size: 1.2em;color:red;text-align: center;">*The Chitha and Jamabandi is Matching and no manual correction needed.</p><br>
                                <?php endif; ?>
                                <?php if ($jcount != $ccount): ?>
                                    <p style="font-size: 1.2em;color:red;text-align: center;">*The Chitha and Jamabandi is not matching kindly synchronize Jama and Chitha .</p><br>
                                <?php endif; ?>
                                <p>If the last pattadars name and the id Don't match in bothe the chitha and jamabandi than use the utility module to sync the pattadars.</p>
                            </h6>
                        </div>
                        <table class="table">
                            <tr>
                                <td colspan="2" style="text-align: center;"><label class="label label-danger">JAMABANDI</label>
                                    <hr>
                                    <form target="__blank" method="post" action="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano">
                                        <input type="hidden" name="dist_code" value="<?php echo $dist_code; ?>"/>
                                        <input type="hidden" name="subdiv_code" value="<?php echo $subdiv_code; ?>"/>
                                        <input type="hidden" name="circle_code" value="<?php echo $circle_code; ?>"/>
                                        <input type="hidden" name="mouza_code" value="<?php echo $mouza_code; ?>"/>
                                        <input type="hidden" name="lot_no" value="<?php echo $lot_no; ?>"/>
                                        <input type="hidden" name="vill_code" value="<?php echo $vill_code; ?>"/>
                                        <input type="hidden" name="patta_type" value="<?php echo $patta_type; ?>"/>
                                        <input type="hidden" name="patta_no" value="<?php echo $patta_no; ?>"/>
                                        <input type="submit" value="View Jama"/>
                                    </form>
                                </td>
                                <td colspan="2" style="text-align: center;"><label class="label label-danger">CHITHA</label></td>
                            </tr>
                        </table>
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">
                                        <tr>
                                            <td>ID</td>
                                            <td>NAME</td>
                                        </tr>
                                        <?php foreach ($comparesj as $compare): ?>
                                            <tr>
                                                <td>
                                                    <input  name="pattadar[<?php echo $compare->jpid; ?>][jama][new_pdar_id]" value="<?php echo $compare->jpid; ?>"/>
                                                    <input type="hidden" readonly="" name="pattadar[<?php echo $compare->jpid; ?>][jama][pdar_id]" value="<?php echo $compare->jpid; ?>"/>
                                                </td>
                                                <td>
                                                    <input name="pattadar[<?php echo $compare->jpid; ?>][jama][new_pdar_name]" value="<?php echo $compare->jpname; ?>"/>
                                                    <input type="hidden"  name="pattadar[<?php echo $compare->jpid; ?>][jama][pdar_name]" value="<?php echo $compare->jpname; ?>"/>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table">
                                        <tr>
                                            <td>ID</td>
                                            <td>NAME</td>
                                        </tr>
                                        <?php foreach ($comparesc as $compare): ?>
                                            <tr>
                                                <td>
                                                    <input name="pattadar[<?php echo $compare->cpid; ?>][chitha][new_pdar_id]" value="<?php echo $compare->cpid; ?>"/>
                                                    <input type="hidden" name="pattadar[<?php echo $compare->cpid; ?>][chitha][pdar_id]" value="<?php echo $compare->cpid; ?>"/>
                                                </td>
                                                <td>
                                                    <input hidden name="pattadar[<?php echo $compare->cpid; ?>][chitha][pdar_name]" value="<?php echo $compare->cpname; ?>"/>
                                                    <input name="pattadar[<?php echo $compare->cpid; ?>][chitha][new_pdar_name]" value="<?php echo $compare->cpname; ?>"/>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-12 center">
                                    <?php
                                    if($is_jama_updated <= '0'){
                                        ?>
                                        <?php if ($this->session->userdata('user_desig_code') == 'AST'): ?>
                                        <a href="<?php echo base_url(); ?>index.php/officemutation/mutationapplicantDetails/" class="btn btn-success">
                                            <i class="fa fa-check"></i>&nbsp;NEXT
                                        </a>
                                        <?php endif; ?>
                                        <?php if ($this->session->userdata('user_desig_code') == 'LM'): ?>
                                            <a href="<?php echo base_url(); ?>index.php/lmmutation/saveFieldMutatonBasic/1" class="btn btn-success">
                                                <i class="fa fa-check"></i>&nbsp;NEXT
                                            </a>
                                        <?php endif; ?>
                                        <?php
                                    } else {
                                        echo '<label class="btn btn-warning">Please Update Jamabandi First</label>';
                                    }
                                    ?>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

