<?php
                                 
                                
                        foreach ($deleted_dags as $all_deleted_dag) {
                            ?>
                              <tr>
                              <?php if($basic["service_code"]!=18){ ?>
                                 <th rowspan="6" style="vertical-align : middle;">
                              <?php } else { ?>
                                 <th rowspan="4" style="vertical-align : middle;">
                              <?php } ?>
                                    <div class="vertical">
                                       DAG : <span class="text-danger"><?=$all_deleted_dag->dag_no?></span> &nbsp;|&nbsp;
                                       PATTA : <span class="text-danger"><?=$all_deleted_dag->patta_no?></span>
                                       <input type="hidden" id="dag_no<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->dag_no?>">
                                        <input type="hidden" id="patta_no<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->patta_no?>">
                                        <input type="hidden" name="is_urban" id="urbanCheck<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->is_urban?>">
                                    </div>
                                 </th>
                                 <th class="bg-white">Total Land Area in Selected Dag</th>
                                 <td class="bg-white">
                                    <strong>
                                    <input type="text" style="text-align: center;" name="dag_area_b<?=$all_deleted_dag->dag_no?>" id="dag_area_b<?=$all_deleted_dag->dag_no?>" class="form-control input-sm" value="<?=$all_deleted_dag->dag_area_b;?>" readonly>
                                    </strong>
                                 </td>
                                 <td class="bg-white">
                                    <input type="text" style="text-align: center;" name="dag_area_k<?=$all_deleted_dag->dag_no?>" id="dag_area_k<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->dag_area_k;?>" class="form-control input-sm" readonly>
                                 </td>
                                 <td class="bg-white">
                                    <input type="text" style="text-align: center;" name="dag_area_lc<?=$all_deleted_dag->dag_no?>" id="dag_area_lc<?=$all_deleted_dag->dag_no?>" class="form-control input-sm" value="<?= $all_deleted_dag->dag_area_lc;?>" readonly>
                                 </td>
                                 <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                 <td class="bg-white">
                                    <input type="text" style="text-align: center;" value="<?=$all_deleted_dag->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$all_deleted_dag->dag_no?>" id="dag_area_g<?=$all_deleted_dag->dag_no?>" readonly>
                                 </td>
                                 <td class="bg-white hide">
                                    <input type="text" style="text-align: center;" value="<?=$all_deleted_dag->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$all_deleted_dag->dag_no?>" id="dag_area_kr<?=$all_deleted_dag->dag_no?>" readonly>
                                 </td>
                                 <?php endif;?>
                              </tr>
                              <?php $hide = 'area_show';
                                 if ($all_deleted_dag->land_type == 3 || $all_deleted_dag->land_type == 1) {
                                     $hide = 'area_show';
                                 } else {
                                     $hide = 'area_hide';
                                 }
                                 ?>
                              <?php
                                 $encroachment_area = json_decode($all_deleted_dag->encroachement_area);
                                 ?>
                                 <?php if($basic["service_code"]!=18){ ?>
                              <tr>
                                 <th class="text-success enc-area-color">Encroachment Area (Homestead)</th>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$all_deleted_dag->dag_no?>" id="enc_home_b<?=$all_deleted_dag->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$encroachment_area->homestead->bigha;?>">
                                 </td>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$all_deleted_dag->dag_no?>" id="enc_home_k<?=$all_deleted_dag->dag_no?>" value="<?=$encroachment_area->homestead->katha;?>" class="form-control input-sm enc_home_k">
                                 </td>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$all_deleted_dag->dag_no?>" id="enc_home_lc<?=$all_deleted_dag->dag_no?>" class="form-control input-sm enc_home_lc" value="<?=$encroachment_area->homestead->lessa;?>">
                                 </td>
                                 <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->homestead->ganda;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_deleted_dag->dag_no?>" id="enc_home_g<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="enc-area-color hide">
                                    <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->homestead->kranti;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_deleted_dag->dag_no?>" id="enc_home_kr<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <?php endif;?>
                              </tr>
                              <?php } ?>
                              <tr>
                                 <th class="text-success enc-area-color">Encroachment Area (Agricultural)</th>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" name="enc_agri_b<?=$all_deleted_dag->dag_no?>" id="enc_agri_b<?=$all_deleted_dag->dag_no?>" class="form-control input-sm agri_b" value="<?=$encroachment_area->agriculture->bigha;?>">
                                 </td>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" name="enc_agri_k<?=$all_deleted_dag->dag_no?>" id="enc_agri_k<?=$all_deleted_dag->dag_no?>" value="<?=$encroachment_area->agriculture->katha;?>" class="form-control input-sm agri_k">
                                 </td>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" name="enc_agri_lc<?=$all_deleted_dag->dag_no?>" id="enc_agri_lc<?=$all_deleted_dag->dag_no?>" class="form-control input-sm agri_lc" value="<?=$encroachment_area->agriculture->lessa;?>">
                                 </td>
                                 <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->agriculture->ganda;?>" class="form-control input-sm agri_g" name="enc_agri_g<?=$all_deleted_dag->dag_no?>" id="enc_agri_g<?=$all_deleted_dag->dag_no?>" onkeyup="agriArea()">
                                 </td>
                                 <td class="enc-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->agriculture->kranti;?>" class="form-control input-sm agri_kr hide" name="enc_agri_kr<?=$all_deleted_dag->dag_no?>" id="enc_agri_kr<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <?php endif;?>
                              </tr>
                              <?php if($basic["service_code"]!=18){ ?>
                              <tr class='<?=$hide?>'>
                                 <th class="text-primary settlement-area-color">Area for Settlement (Homestead)</th>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" name="home_b<?=$all_deleted_dag->dag_no?>" class="form-control input-sm home_b" value="<?=$all_deleted_dag->home_b;?>" onkeyup="totalAreaCal()" id="home_b<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" name="home_k<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->home_k;?>" class="form-control input-sm home_k" onkeyup="totalAreaCal()" id="home_k<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" name="home_lc<?=$all_deleted_dag->dag_no?>" class="form-control input-sm s_dag_area_lc" value="<?=$all_deleted_dag->home_lc;?>" onkeyup="totalAreaCal()" id="home_lc<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$all_deleted_dag->home_g;?>" class="form-control input-sm s_dag_area_g" name="home_g<?=$all_deleted_dag->dag_no?>" onkeyup="totalAreaCal()" id="home_g<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$all_deleted_dag->home_kr;?>" class="form-control input-sm s_dag_area_kr hide" name="home_kr<?=$all_deleted_dag->dag_no?>" onkeyup="totalAreaCal()" id="home_kr<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <?php endif;?>
                              </tr>
                              <?php } ?>
                              <?php $hide = 'area_show';
                                 if ($all_deleted_dag->land_type == 2) {
                                     $hide = 'area_show';
                                 } else {
                                     $hide = 'area_hide';
                                 }
                                 
                                 ?>
                              <tr class='<?=$hide?>'>
                                 <th class="text-primary settlement-area-color">Area for Settlement (Agricultural)</th>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" name="agri_b<?=$all_deleted_dag->dag_no?>" class="form-control input-sm agri_b" value="<?=$all_deleted_dag->agri_b;?>" onkeyup="agriArea()" id="agri_b<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" name="agri_k<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->agri_k;?>" class="form-control input-sm agri_k" onkeyup="agriArea()" id="agri_k<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" name="agri_lc<?=$all_deleted_dag->dag_no?>" class="form-control input-sm agri_lc" value="<?=$all_deleted_dag->agri_lc;?>" onkeyup="agriArea()" id="agri_lc<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$all_deleted_dag->agri_g;?>" class="form-control input-sm agri_g" name="agri_g<?=$all_deleted_dag->dag_no?>" onkeyup="agriArea()" id="agri_g<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <input readonly type="text" style="text-align: center;" value="<?=$all_deleted_dag->agri_kr;?>" class="form-control input-sm agri_kr hide" name="agri_kr<?=$all_deleted_dag->dag_no?>" onkeyup="agriArea()" id="agri_kr<?=$all_deleted_dag->dag_no?>">
                                 </td>
                                 <?php endif;?>
                              </tr>
                              <tr style="display:none">
                                 <th class="text-primary settlement-area-color">Applied area (Fishery)</th>
                                 <td class="settlement-area-color">
                                    <span class="input-group-addon">Bigha</span>
                                    <input type="text" style="text-align: center;" required name="fbigha<?=$all_deleted_dag->dag_no?>" class="form-control input-sm fbigha" value="<?=$all_deleted_dag->fbigha?>" onkeyup="fisheryArea()" id="fbigha<?=$total_area_fbigha++?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <span class="input-group-addon">Katha</span>
                                    <input type="text" style="text-align: center;" required name="fkatha<?=$all_deleted_dag->dag_no?>" value="<?=$all_deleted_dag->fkatha?>" class="form-control input-sm fkatha" onkeyup="fisheryArea()" id="fkatha<?=$total_area_fkatha++?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <span class="input-group-addon">Lessa</span>
                                    <input type="text" style="text-align: center;" required name="flessa<?=$all_deleted_dag->dag_no?>" class="form-control input-sm flessa" value="<?=$all_deleted_dag->flessa?>" onkeyup="fisheryArea()" id="flessa<?=$total_area_flessa++?>">
                                 </td>
                                 <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                 <td class="settlement-area-color">
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;"  value="<?=$all_deleted_dag->fganda?>" class="form-control input-sm fganda" name="fganda<?=$all_deleted_dag->dag_no?>" onkeyup="fisheryArea()" id="fganda<?=$total_area_fganda++?>">
                                 </td>
                                 <td class="settlement-area-color">
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;"  value="<?=$all_deleted_dag->fkranti?>" class="form-control input-sm fkranti" name="fkranti<?=$all_deleted_dag->dag_no?>" onkeyup="fisheryArea()" id="fkranti<?=$total_area_fkranti++?>">
                                 </td>
                                 <?php endif ; ?>
                              </tr>
                              <tr style="border-bottom:1px solid #227576">
                                    <td colspan="2">
                                        <?php if(ENABLE_AREA_BUTTON != 0){?>
                                        <button type="button" id="editarea<?=$all_deleted_dag->id?>" onclick="editArea(<?=$all_deleted_dag->id?>,<?=$all_deleted_dag->dag_no?>);" class="btn btn-sm btn-warning" style="display:none">Edit Area</button>
                                        <?php } if(ENABLE_DAG_ELIGIBLE_BUTTON != 0){ ?>
                                        <button type="button" id="deldag<?=$all_deleted_dag->id?>" onclick="deleteDag(<?=$all_deleted_dag->id?>,<?=$all_deleted_dag->dag_no?>);" class="btn btn-sm btn-danger" style="display:none"><i class="fa fa-remove" style="color:white"></i> Dag Not Eligible</button>
                                        <?php if($basic['status'] == 'R') { ?>
                                        <button type="button" id="insdag<?=$all_deleted_dag->id?>" onclick="insertDagRevert(<?=$all_deleted_dag->id?>,<?=$all_deleted_dag->dag_no?>);" class="btn btn-sm btn-success" >Eligible</button>
                                        <?php } else { ?>
                                          <button type="button" id="insdag<?=$all_deleted_dag->id?>" onclick="insertDag(<?=$all_deleted_dag->id?>,<?=$all_deleted_dag->dag_no?>);" class="btn btn-sm btn-success" >Eligible</button>
                                        <?php }  }?>
                                        
                                        <div id="dageligiblemsg<?=$all_deleted_dag->id?>" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold;"> 
                                        This dag was Removed by LM!!!
                                        </div>
                                    </td>
                                    <td colspan="2" class="text-center">
                                        
                                    <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$basic["applid"];?>&dag=<?=$all_deleted_dag->dag_no;?>">
                                        <small style="font-size:14px; color:white; font-weight:bold">
                                            <i class="fa fa-eye"></i> View Total Applications in this Dag
                                        </small>
                                    </a>
                                    </td>
                              </tr>
                              
                              <?php }?>