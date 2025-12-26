

<?php
if($err == true){
    ?>
    <div class="alert alert-danger">
           <?=$err_msg?>
    </div>
    <?php
}

if($err == false && $check_ren == 'true'){
    ?>
    <div class="container border border-info p-3">
        <div class="row">
            <?php if($this->session->userdata('user_desig_code')=='CO'){?>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Area Details</th>
                        <?php if($dd_row->is_full_partial=='N'){?>
                        <td>
                            <input type="number" class="form-control font-weight-bold" id="bigha_p<?=$dd_row->dag_no?>" name="bigha_part<?=$dd_row->dag_no?>" placeholder="Enter bigha" value="<?=$dd_row->dag_area_b?>">
                        
                        </td>
                        <td><strong><input type="number" class="form-control  font-weight-bold" id="katha_p<?=$dd_row->dag_no?>" name="katha_part<?=$dd_row->dag_no?>" placeholder="Enter katha" value="<?=$dd_row->dag_area_k?>"></strong></td>
                        <td><strong><input type="number" class="form-control font-weight-bold" id="lessa_p<?=$dd_row->dag_no?>" name="lessa_part<?=$dd_row->dag_no?>" placeholder="Enter lessa" value="<?=$dd_row->dag_area_lc?>"></strong></td>
                    <?php }else{?>
                        <td><strong><input type="number" class="form-control font-weight-bold" id="bigha_p<?=$dd_row->dag_no?>" name="bigha_part<?=$dd_row->dag_no?>" placeholder="Enter bigha"  value="<?=$dd_row->s_dag_area_b?>"></strong></td>
                        <td><strong><input type="number" class="form-control font-weight-bold" id="katha_p<?=$dd_row->dag_no?>" name="katha_part<?=$dd_row->dag_no?>" placeholder="Enter katha" value="<?=$dd_row->s_dag_area_k?>"></strong></td>
                        <td><strong><input type="number" class="form-control font-weight-bold" id="lessa_p<?=$dd_row->dag_no?>" name="lessa_part<?=$dd_row->dag_no?>" placeholder="Enter lessa" value="<?=$dd_row->s_dag_area_lc?>"></strong></td>
                    <?php }?>
                    </tr>
                </table>
            </div>
        <?php }?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="p-2"># Pattadar to be remain in the old dag</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name of Pattdar</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php $sl_count = 1; foreach($pattadars_array as $pattadar_row){
                        ?>
                            <tr>
                                <th><?=$sl_count++?></th>
                                <td><?=$pattadar_row->pdar_name?></td>
                              <!--   <td><input type="checkbox" value="<?=$pattadar_row->pdar_id?>" name="pdar_selected<?=$pattadar_row->dag_no?>"></td> -->
                              <td><input type="hidden" value="<?=$pattadar_row->pdar_id?>" name="pdar_selected_all[]"></td>
                              <td><input type="checkbox" value="<?=$pattadar_row->pdar_id?>" name="pdar_selected[]"></td>
                            </tr>
                    <?php
                    }
                    ?>
            
                </table>
            </div>

        </div>
    </div>


    <?php
     
}

?>