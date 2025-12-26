<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px">Compare Mismatch Dag No in Chitha & Jamabandi</h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/ChithaJama/index' ?>">
                        <div class="form-group">
                            <label class="col-lg-12" style="color: red; text-align: center"><?php echo validation_errors(); ?></label>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district');?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision');?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>

                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle');?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza');?></label>
                            <div class="col-lg-9">
                                <select class="form-control  mouzaselect" id="select" required name="mouza_code">
                                        <option><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouza as $moz): ?>
                                            <?php
                                            $mouza_code = $moz->mouza_pargona_code;
                                            $mouza_name = $moz->loc_name;
                                            ?>
                                            <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no');?></label>
                            <div class="col-lg-9">
                                <select class="form-control  lotselect" id="select" required name="lot_no">
                                        <option disabled selected>Select Lot No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town');?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="villageselect_allot" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type');?></label>
                            <div class="col-lg-9">
                                <select class="form-control" required name="patta_type">
                                        <option>Select Patta Type</option>
                                        <?php foreach ($patta as $p): ?>
                                            <option value="<?=$p->type_code?>"><?php echo $p->patta_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                 <button type="submit" class="btn btn-success" onclick="LoadData();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
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

<script language="javascript" type="text/javascript">
    $(window).load(function () {
        $('#loading').hide();
    });
    function LoadData() {
        $("#loading").show();
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        });
    }
</script>  
<div class="modal fade modal-transparent" style="margin-top: 250px" id='myModal' >
    <div class="" role="document"> 

        <center>
            <img id="loading-image" style="" width="100px" src= "<?php echo base_url(); ?>application/views/images/load.gif" alt="Loading..." />
            <h2 style="color:#fff   " >Please Wait ! </h2>
            <h5 style="color: #fff   ">Comparing Mismatched Dags in Chitha & Jamabandi might take some time. </h5>
        </center>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->