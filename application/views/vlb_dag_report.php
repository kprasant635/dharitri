<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 panel panel-deafult panel-body">
         
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">VLB Dag Search and fetch details<h3>
                </div>
                <div class="panel-body">
                        <input type="hidden" class="districtselect" name="dist_code" id="dist_code" value="<?php echo $datas['dist_code']; ?>">
                        <input type="hidden" class="subdivselect" name="subdiv_code" id="subdiv_code" value="<?php echo $datas['subdiv_code']; ?>">
                        <input type="hidden" class="circleselect" name="cir_code" id="cir_code" value="<?php echo $datas['cir_code']; ?>">
                        <div class="" role="alert" style="text-align:center">
                            <h4><?php echo $this->lang->line('district');?> : <kbd><?php echo $datas['dist_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('subdivision');?> : <kbd><?php echo $datas['sub_div_name']; ?></kbd> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->lang->line('circle');?> : <kbd><?php echo $datas['cir_name']; ?></kbd> </h4>
                        </div>
                        <div class="col-lg-3">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                            <div class="col-sm-8">
                                <select class="form-control mouzaselect form-select" id="mouza_pargona_code" required name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_mouza'); ?></option>
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
                        <div class="col-lg-3">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                            <div class="col-sm-8">
                                <select class="form-control lotselect form-select" id="lot_no" required name="lot_no">
                                    <option disabled selected>Lot No.</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                            <div class="col-sm-8">
                                <select class="form-control villageselect form-select" id="vill_code" required name="vill_code">
                                    <option disabled selected>Village/Town</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                            <div class="col-sm-8">
                                <input type="text" name="dag_no" id="dag_no" class="form-control">
                            </div>
                        </div>

                        <br>
                       <div style="margin-top:20px"></div>
                        <center style="margin-top: 41px;">
                            <button type="button" id="btn-find-dag" class="btn btn-primary"><i class='fa fa-check'></i> Fetch Details</button>
                           
                        </center>
                        
                        <div id="pattadetails"></div>
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
            <h2 style="color:#fff" >Please Wait ! </h2>
            <h5 style="color: #fff">Generating Land Class Wise Village Land Scenario. </h5>
        </center>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
            $('#btn-find-dag').on('click', function(e) {
                var dist_code = $("#dist_code").val();
                var subdiv_code = $("#subdiv_code").val();
                var cir_code = $("#cir_code").val();
                var mouza_pargona_code = $("#mouza_pargona_code").val();
                var lot_no = $("#lot_no").val();
                var vill_code = $("#vill_code").val();
                var dag_no = $("#dag_no").val();

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
                $.ajax({
                    url: '<?= base_url()?>'+ "index.php/LandBankCO/findDagVillageWise",
                    type: "POST",
                    data : {dist_code : dist_code , subdiv_code : subdiv_code,cir_code : cir_code,mouza_pargona_code:mouza_pargona_code,lot_no:lot_no,vill_code:vill_code,dag_no:dag_no},
                    error: function() {
                        $.unblockUI();
                        Swal.fire({
                            title: "Failed",
                            text: "Error",
                            icon: "warning",
                            timer: 50000
                        });
                    },
                    
                    success: function(data) {
                        $.unblockUI();
                        $("#pattadetails").html(data);                         
                    }
                });
            }); 
</script>