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
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Information regarding chitha and jamabandi synchronization</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if($jcount==$ccount):?>
                            <p style="font-size: 1.4em;color:red;text-align: center;">*The Chitha and Jamabandi is Matching and no manual correction needed.</p><br>
                            <?php endif;?>
                            <?php if($jcount==$ccount):?>
                            <p style="font-size: 1.4em;color:red;text-align: center;">*The Chitha and Jamabandi is not matching kindly synchronize Jama and Chitha .</p><br>
                            <?php endif;?>
                            
                        </div>
                    </div>
                    <table class="table">
                        <tr>
                            <td colspan="2" style="text-align: center;"><label class="label label-danger">JAMABANDI</label>
                                <hr>
                                <form target="__blank" method="post" action="<?php echo base_url();?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano">
                                    <input type="hidden" name="dist_code" value="<?php echo $dist_code;?>"/>
                                    <input type="hidden" name="subdiv_code" value="<?php echo $subdiv_code;?>"/>
                                    <input type="hidden" name="circle_code" value="<?php echo $circle_code;?>"/>
                                    <input type="hidden" name="mouza_code" value="<?php echo $mouza_code;?>"/>
                                    <input type="hidden" name="lot_no" value="<?php echo $lot_no;?>"/>
                                    <input type="hidden" name="vill_code" value="<?php echo $vill_code;?>"/>
                                    <input type="hidden" name="patta_type" value="<?php echo $patta_type;?>"/>
                                    <input type="hidden" name="patta_no" value="<?php echo $patta_no;?>"/>
                                    <input type="submit" value="View Jama"/>
                                </form>
                            </td>
                            <td colspan="2" style="text-align: center;"><label class="label label-danger">CHITHA</label>
                            
                            </td>
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
                                        <td>DAG</td>
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
                                            <td>
                                               <span class="badge badge-primary"><?php echo $compare->dag_no;?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <input type="submit" value="Submit" class="btn btn-danger"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>