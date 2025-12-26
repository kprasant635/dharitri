<style>
    .enc-area-color{
        background: #FDEBEA!important;
    }
    .settlement-area-color{
        background: #EAFFEA!important;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }
</style>

<div class="modal" role="dialog" id="modifiedDataModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header shadow justify-content-center">
                <h5 class="modal-title text-center" id="exampleModalLongTitle">Modified Data - <span><?=$application->application_no?></span></h5>
            </div>
            <div class="modal-body">

            <?php 

            if($modified_data->join_applicant_new){
            ?>
                <table class="table table-bordered shadow-sm">
                    <thead>
                        <tr class="bg-info">
                            <th colspan="3" class="text-center">Applicant Details</th>
                        </tr>

                        <?php
                        $ja_count = 1;
                        foreach($settlements as $joint_app){
                            if($joint_app->is_changed != 'Y' && $joint_app->pdar_type == 'B' && $joint_app->is_applicant == 1){
                            ?>
                                <tr>
                                    <th rowspan="3" style="vertical-align : middle;">
                                        <div class="text-center">
                                            <?=$ja_count++?></ 
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Name <span class="text-danger">(Applicant)</span>
                                    </th>
                                    <th><?=$joint_app->name_ass?></th>
                                </tr>
                                <tr>
                                    <th>Guardian Name</th>
                                    <th><?=$joint_app->gurdian_name_ass?></th>
                                </tr>
                                    
                                
                            <?php
                            }
                        }
                        foreach($settlements as $joint_app){
                            if($joint_app->is_changed != 'Y' && $joint_app->pdar_type == 'B' && $joint_app->is_applicant != 1){
                            ?>
                                <tr>
                                    <th rowspan="3" style="vertical-align : middle;">
                                        <div class="text-center">
                                            <?=$ja_count++?></ 
                                        </div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>
                                        Name <span class="text-danger">(Joint Applicant)</span>
                                    </th>
                                    <th><?=$joint_app->name_ass?></th>
                                </tr>
                                <tr>
                                    <th>Guardian Name</th>
                                    <th><?=$joint_app->gurdian_name_ass?></th>
                                </tr>
                                    
                               <?php
                            }
                        }
                        ?>
            
                    </thead>
                </table>
            <?php
            }
            ?>
                
            <?php
            if(!empty($modified_data->modified_new_dag)){
                ?>
                <!-- encroacher changed and dag/area changed -->
                <table class="table table-bordered shadow-sm">
                    <thead>
                        <tr class="bg-info">
                            <th colspan="3" class="text-center">Encroacher Details <span class="text-danger">(NEW)</span></th>
                        </tr>
                        <?php
                        foreach($settlements as $settl){
                            if((in_array($settl->dist_code, json_decode(BARAK_VALLEY)))){
                                $lessa_chatak='Chatak'; }
                            else{
                                $lessa_chatak='Lessa';
                            }
                            if(in_array($settl->dag_no, $modified_data->modified_new_dag)){
                                if($settl->pdar_type == 'EN'){
                                ?>
                                    <tr>
                                        <th rowspan="4" style="vertical-align : middle;">
                                            <div class="vertical text-center">
                                                DAG : <span class="text-danger"><?=$settl->dag_no?></span> 
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Encroacher Name</th>
                                        <th><?=$settl->name_ass?></th>
                                    </tr>
                                    <tr>
                                        <th>Guardian Name</th>
                                        <th><?=$settl->gurdian_name_ass?></th>
                                    </tr>
                                    <tr>
                                        <th>Possession from</th>
                                        <th><?=$settl->possession_date?></th>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </thead>
                </table>

                <!-- area details -->
                <div class="tableCard shadow-sm">
                    <table class="table">
                        <thead class="thead-warning">
                            <tr>
                                <th>#</th>
                                <th>Description<span class="text-danger">(NEW DAG)</span></th>
                                <th class="text-center">Bigha</th>
                                <th class="text-center">Katha</th>
                                <th class="text-center"><?=$lessa_chatak?></th>
                                <?php if ((in_array($settl->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <th class="text-center">Ganda</th>
                                <th class="text-center">Kranti</th>
                                <?php endif; ?>
                            </tr>
                            <?php
                            foreach($settlements as $settl){
                                if((in_array($settl->dist_code, json_decode(BARAK_VALLEY)))){
                                    $lessa_chatak='Chatak'; }
                                else{
                                    $lessa_chatak='Lessa';
                                }
                                if(in_array($settl->dag_no, $modified_data->modified_new_dag)){
                                    if($settl->pdar_type == 'EN'){
                                    ?>
                                        <tr class="bg-white">
                                            <th rowspan="3" style="vertical-align : middle;">
                                                <div class="vertical text-center">
                                                    DAG : <span class="text-danger"><?=$settl->dag_no?></span> 
                                                    <br> 
                                                    PATTA : <span class="text-danger"><?=$settl->patta_no?> 
                                                    <br> 
                                                    <?=$this->utilityclass->getPattaType($settl->patta_code)?></span>
                                                </div>
                                            </th>
                                            <td><strong>Total Land Area in Selected Dag</strong></td>
                                            <td style="text-align: center;">
                                                <strong><?=$settl->applied_bigha?></strong>
                                            </td>
                                            <td style="text-align: center;">
                                                <strong><?=$settl->applied_katha?></strong>
                                            </td>
                                            <td style="text-align: center;">
                                                <strong><?=$settl->applied_lessa?></strong>
                                            </td>
                                            <?php if((in_array($settl->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                                <td style="text-align: center;">
                                                    <strong><?=$settl->applied_ganda?></strong>
                                                </td>
                                                <td class="hide" style="text-align: center;">
                                                    <strong><?=$settl->applied_kranti?></strong>
                                                </td>
                                            <?php endif ; ?>
                                        </tr>

                                        <!-- area settlement homestead -->
                                        <?php $hide = 'area_show';
                                            if ($settl->land_type == 3 || $settl->land_type == 1) {
                                                $hide = 'area_show';
                                            } else {
                                                $hide = 'area_hide';
                                            }
                                        ?>
                                        <tr class='<?=$hide?>' class="bg-white">
                                            <td class="settlement-area-color"><strong>Area for Settlement (Homestead)</strong></td>
                                            <td class="settlement-area-color" style="text-align:center">
                                                <strong><?=$settl->mbigha?></strong>
                                            </td>
                                            <td class="settlement-area-color" style="text-align:center">
                                                <strong><?=$settl->mkatha?></strong>
                                            </td>
                                            <td class="settlement-area-color" style="text-align:center">
                                                <strong><?=$settl->mlessa?></strong>
                                            </td>
                                            <?php if ((in_array($settl->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                                <td class="settlement-area-color" style="text-align:center">
                                                    <strong><?=$settl->mganda?></strong>
                                                </td>
                                                <td class="settlement-area-color" style="text-align:center">
                                                    <strong><?=$settl->mkranti?></strong>
                                                </td>
                                            <?php endif; ?>
                                        </tr>

                                        <!-- area settlement agriculture -->
                                        <?php 
                                            $hide = 'area_show';
                                            if ($settl->land_type == 2) {
                                                $hide = 'area_show';
                                            } else {
                                                $hide = 'area_hide';
                                            }
                                        ?>
                                        <tr class='<?=$hide?>' class="bg-white">
                                            <td class="settlement-area-color"><strong>Area for Settlement (Agriculture)</strong></td>
                                            <td class="settlement-area-color" style="text-align:center">
                                                <strong><?=$settl->agri_bigha?></strong>
                                            </td>
                                            <td class="settlement-area-color" style="text-align:center">
                                                <strong><?=$settl->agri_katha?></strong>
                                            </td>
                                            <td class="settlement-area-color" style="text-align:center">
                                                <strong><?=$settl->agri_lessa?></strong>
                                            </td>
                                            <?php if ((in_array($settl->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                                <td class="settlement-area-color" style="text-align:center">
                                                    <strong><?=$settl->agri_ganda?></strong>
                                                </td>
                                                <td class="settlement-area-color" style="text-align:center">
                                                    <strong><?=$settl->agri_kranti?></strong>
                                                </td>
                                            <?php endif;?>
                                        </tr>
                                          
                                    <?php
                                    }
                                }
                            }

                            ?>
                        </thead>
                    </table>
                </div>

            <?php
            }
            ?>
            <?php
            if($modified_data->is_new_document){
                ?>
                <table class="table table-bordered mt-2">
                    <tr>
                        <th class="font-weight-bold bg-info">Documents</th>
                    </tr>
                        <?php
                        foreach($modified_data->docs as $d){
    
                        ?>
                        <tr>
                            <th>
                                <a target='download' href="<?php echo base_url(); ?>index.php/basundhara2/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i>  <?=$d->file_details;?></a>
                            </th>
                        </tr>

                        <?php }?>
         
                </table>

                <?php
            }
            ?>
            <label for="">Remark</label>
            
            <textarea name="" id="" class="mt-2 col-12 p-2" readonly><?=$modified_data->remark?></textarea>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modifiedDataModallNo">Close</button>
            </div>
        </div>
    </div>
</div>