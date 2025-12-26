<script>
    $(function () {
        $('#myModal').modal({});
    })
</script>
<style>
    .modal_body p {
        font-family: 'Calibri' !important;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-7 col-lg-offset-3">
            <div class="panel panel-info panel-form">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">KHATIAN</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?php echo $this->lang->line('select_location') ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open(base_url('index.php/Khatian/khatianViewTenantFormUpdate'), array('class' => 'form-horizontal')); ?>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('district')?></label>
                        <div class="col-lg-9">
                            <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" readonly="">
                                <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                <option value="<?php echo $dist_code; ?>" selected>
                                    <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('subdivision')?></label>
                        <div class="col-lg-9">
                            <select class="form-control subdivselect" id="select" name="subdiv_code" readonly="">
                                <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                <option value="<?php echo $subdiv_code; ?>" selected>
                                    <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                   
                        <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('circle')?></label>
                        <div class="col-lg-9">
                            <select class="form-control circleselect" id="select" required name="circle_code" readonly="">
                                <?php $cir_code = $this->session->userdata('cir_code'); ?>
                                <option value="<?php echo $cir_code; ?>" selected>
                                    <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                        <!-- <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="mouza" name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select_mouza');?></option>
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
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="select" name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="village_by_khatian_no" name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label required"><?php echo $this->lang->line('old_khatian')?></label>
                        <div class="col-lg-9">
                            <select name="khatian_no" required id="khatian_data" class="form-control">
                                <option value="">Select Khatian No.</option>
                            </select>
                            <?php echo form_error('khatian_no', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label required"><?php echo $this->lang->line('new_khatian')?></label>
                        <div class="col-lg-9">
                            <input class='form-control numeric' required name='new_khatian_no' id="new_khatian_no" placeholder='Enter New Khatian Number' autocomplete="off">
                            <?php echo form_error('new_khatian_no', '<p class="red form_error">', '</p>'); ?>
                            <b style="color:red" id="khatian_valid_or_not"></b>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label required"><?php echo $this->lang->line('remarks')?></label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="remarks_co" required placeholder="Circle officer remarks"></textarea>
                            <?php echo form_error('remarks', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Once you submit, data can not be changed. Kindly confirm')"><i
                                        class='fa fa-edit'></i> <?php echo $this->lang->line('update') ?>
                            </button>
                        </div>
                    </div>
                    </form>
                    <?php if ($this->session->flashdata('message')): ?>
                        <div class="col-lg-12 ">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                            </div>
                            <?php if($this->session->flashdata('message2')):?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message2');?></strong>
                                </div>
                            <?php endif;?>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $('#village_by_khatian_no').change(function (e) {
        var vill_code = $(this).val();
        $('#new_khatian_no').val('');
        var dist_code = $('.districtselect').val();
        var subdiv_code = $('.subdivselect').val();
        var cir_code = $('.circleselect').val();
        var mouza_pargona_code = $('.mouzaselect').val();
        var lot_no = $('.lotselect').val();
        $.ajax({
            type: 'post',
            url: baseurl + "Khatian/getKhatianNoVillage",
            data: {'dist_code': dist_code, 'subdiv_code' : subdiv_code , 'cir_code' :cir_code,'mouza_pargona_code' : mouza_pargona_code, 'lot_no' : lot_no, 'vill_townprt_code':vill_code},
            success: function (data)
            {
                var obj = JSON.parse(data);
                // console.log(obj);
                var template = "<option>Select Khatian no</option>";
                for (var i = 0; i < obj.length; i++) {
                    template += "<option value='" + obj[i].khatian_no + "'>" + obj[i].khatian_no + "</option>";
                }
                $('#khatian_data').html(template);
            }
        });
    });

    $('#new_khatian_no').change(function (e) {
        var newKhatianNo = $(this).val();
        var dist_code = $('.districtselect').val();
        var subdiv_code = $('.subdivselect').val();
        var cir_code = $('.circleselect').val();
        var mouza_pargona_code = $('.mouzaselect').val();
        var vill_code = $('#village_by_khatian_no').val();
        var lot_no = $('.lotselect').val();
        $.ajax({
            type: 'post',
            url: baseurl + "Khatian/getKhatianExistOrNot",
            data: {'dist_code': dist_code, 'subdiv_code' : subdiv_code , 'cir_code' :cir_code,'mouza_pargona_code' : mouza_pargona_code, 'lot_no' : lot_no, 'vill_townprt_code':vill_code,'khatian_no' : newKhatianNo},
            success: function (data)
            {
                var obj = JSON.parse(data);
                if(obj.error_code!=null){
                    $('#khatian_valid_or_not').html(obj.error_code);
                    $('#new_khatian_no').val('');
                }else{
                     $('#khatian_valid_or_not').html('');

                }
                
            }
        });
    });

    $('.numeric').on('input', function (event) { 
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>