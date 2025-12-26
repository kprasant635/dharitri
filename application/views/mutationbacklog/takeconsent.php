<div class='container-fluid login form-top'>
    <div class="row ">
        <div class="col-lg-10 panel panel-default panel-body center-col">
            <?php $action = base_url()."index.php/lmmutation/takeconsent";?>
            <form class='form-horizontal' action="<?php echo $action;?>"  method="post">
                <table class="table table-striped" style="text-align: left;">
                    <thead>
                        <tr>
                            <th class='alert-new'><?php echo $this->lang->line('pattadar_name')?></th>
                            <th class='alert-new'><?php echo $this->lang->line('consent')?></th>
                            <th class='alert-new'><?php echo $this->lang->line('remark')?></th>
                        </tr>
                        <input type="hidden" name='dist_code' value="<?php echo $location->dist_code;?>"/>
                        <input type="hidden" name='subdiv_code' value="<?php echo $location->dist_code;?>"/>
                        <input type="hidden" name='cir_code' value="<?php echo $location->cir_code;?>"/>
                        <input type="hidden" name='subdiv_code' value="<?php echo $location->subdiv_code;?>"/>
                        <input type="hidden" name='mouza_pargona_code' value="<?php echo $location->mouza_pargona_code;?>"/>
                        <input type="hidden" name='lot_no' value="<?php echo $location->lot_no;?>"/>
                        <input type="hidden" name='vill_townprt_code' value="<?php echo $location->vill_townprt_code;?>"/>
                        <input type="hidden" name='patta_no' value="<?php echo $location->patta_no;?>"/>
                        <input type="hidden" name='patta_type_code' value="<?php echo $location->patta_type_code;?>"/>
                        <input type="hidden" name='case_no' value="<?php echo $case_no?>"/>
                        
                        <?php foreach ($pdars as $pdar): ?>
                            <tr>
                                <td><input type="text" maxlength="10" name="pdar[id][<?php echo $pdar->pdar_id; ?>]" value="<?php echo $pdar->pdar_name; ?>" /></td>
                                <td>
                                    <input type='checkbox' name="pdar[consentid][]" value="<?php echo $pdar->pdar_id; ?>"
                                </td>
                                <td>
                                    <textarea cols="50" rows='5' name="pdar[comment][<?php echo $pdar->pdar_id; ?>]" ></textarea>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </thead>
                </table>
                <div class="form-group">
                    <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>