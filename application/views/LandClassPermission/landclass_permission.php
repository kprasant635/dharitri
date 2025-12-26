
<div class="card">
    <div class="card-header">
        <h4 class="bg-warning shadow-sm round text-center p-2">
            <?=$this->lang->line('land-class-allowed-in-dag')?>
        </h4>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Select Village</label>
                    <div class="col-sm-9">
                        <select name="village_code" id="village_code" class="form-control">
                            <option value="">--select--</option>
                            <?php
                            foreach($village_list as $vil_row){
                                ?>
                                <option value="<?=$vil_row->dist_code?>,<?=$vil_row->subdiv_code?>,<?=$vil_row->cir_code?>,<?=$vil_row->mouza_pargona_code?>,<?=$vil_row->lot_no?>,<?=$vil_row->vill_townprt_code?>"><?=$vil_row->loc_name?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div id="result_div">
            <div id="menu"></div>
            <div id="permission_view"></div>
            
        </div>

    </div>
</div>

<script src="<?php echo base_url('application/views/LandClassPermission/landclass_permission.js?v='.time())?>"></script>