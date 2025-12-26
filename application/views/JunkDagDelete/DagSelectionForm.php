
<?php if ($this->session->flashdata('message')): ?>
    <?php include 'message.php'; ?>
<?php endif; ?>
<div class="col-lg-8 col-lg-offset-2 mt-4">
    <div class="well well-sm mis_report">
        <h3 style="text-align: center; font-size: 28px">Junk Dag Selection</h3>
        <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
    </div>

    <div class="panel panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">Select Dag Number</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url() . 'index.php/junkdagdelete/viewdagdetails' ?>">
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('district')?></label>
                    <div class="col-lg-9">
                        <select  class="form-control districtselect disabled"
                                 id="LmMutationSelectDistrict" name="dist_code" required>
                            <?php $dist_code = $this->session->userdata('dist_code'); ?>
                            <option value="<?php echo $dist_code; ?>"  selected>
                                <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('subdivision')?></label>
                    <div class="col-lg-9">
                        <select  class="form-control subdivselect disabled" id="select" name="subdiv_code" required>
                            <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                            <option value="<?php echo $subdiv_code; ?>"  selected>
                                <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('circle')?></label>
                    <div class="col-lg-9">
                        <select class="form-control circleselect disabled" id="select" required name="cir_code">
                            <?php $cir_code = $this->session->userdata('cir_code'); ?>
                            <option value="<?php echo $cir_code; ?>"  selected>
                                <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('mouza')?></label>
                    <div class="col-lg-9">
                        <select class="form-control mouzaselect disabled" id="select" required name="mouza_code">
                            <?php $mouza_pargona_code = $this->session->userdata('mouza_pargona_code'); ?>
                            <option value="<?php echo $mouza_pargona_code; ?>"  selected>
                                <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('lot_no')?></label>
                    <div class="col-lg-9">
                        <select class="form-control lotselect disabled" id="select" name="lot_no" >
                            <?php $lot_no = $this->session->userdata('lot_no'); ?>
                            <option value="<?php echo $lot_no; ?>"  selected>
                                <?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code,
                                    $cir_code, $mouza_pargona_code,$lot_no); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('vill_town')?></label>
                    <div class="col-lg-9">
                        <select class="form-control villageselect" id="vill_code" name="vill_code">
                            <option disabled selected>Select Village/Town</option>
                            <?php foreach($villages as $d):?>
                                <option value='<?php echo $d->vill_townprt_code;?>'>
                                    <?php echo $d->loc_name;?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        Patta Type
                    </label>
                    <div class="col-lg-9">
                        <select class="form-control dag_patta_type" id="dag_patta_type" name="patta_type">
                            <option disabled selected>Select Patta Type</option>
                            <option value='0000'>All</option>
                            <?php foreach ($patta_type as $patta): ?>
                                <option value="<?php echo $patta->type_code; ?>"><?php echo $patta->patta_type; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">
                        Select Dag
                    </label>
                    <div class="col-lg-9">
                        <select class="form-control dag_dag_no" id="dag_dag_no" name="dag_no">
                            <option disabled selected>Select Dag Number</option>
                        </select>
                    </div>
                </div>
                <hr style="border-bottom: 2px solid #000;">
                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-3">
                        <button type="submit" class="btn btn-success">
                            <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                        <button type="reset" class="btn btn-primary">
                            <i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).on('change', '#vill_code', function(e) {
        $('#dag_patta_type').prop('selectedIndex', 0);
    });

    // ----------------------------------
    $("#dag_patta_type").change(function (e) {
        console.log("change");
        var vill_code = $('#vill_code').val();
        var patta_type_code = $(this).val();
        $.ajax({
            url: baseurl + "junkdagdelete/getDags/" + patta_type_code + "/" + vill_code,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "<option disabled selected>Select Dag Number</option>";
                for (var i = 0; i < object.length; i++) {
                    template += "<option value='" + object[i].dag + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no']").html(template);
            }
        });
    });
</script>