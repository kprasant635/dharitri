<!--<?php // KKB0007: Improvement of Land Share Details 
    ?> -->
<style>
    .modal_body p {
        font-family: 'Calibri' !important;
    }
</style>
<div class="row login">
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report bg-success">
                <h3 style="text-align: center;font-size: 28px">Land Share Updation </h3>
            </div>
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location'); ?></h3>
                </div>
                <!-- Select Location Gaon -->
                <div class="panel-body">
                    <?php echo form_open(base_url('index.php/LandShareUpdation/landShareDetails'), array('method' => 'post')); ?>
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text  control-label">গাওঁ / চহৰ</label>
                        <div class="col-lg-9 mb-4">
                            <select class="form-control villageselect" id="select_village" name="vill_code" required>
                                <option disabled selected><?php echo $this->lang->line('select') ?></option>
                                <?php foreach ($villages as $d) : ?>
                                    <option value='<?php echo $d->vill_townprt_code; ?>'><?php echo $d->loc_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text  control-label">Dag No</label>
                        <div class="col-lg-9 mb-4">
                            <select class="form-select" data-control="select2" id="select_dag" name="dag_no" required>
                                <option><?php echo $this->lang->line('select') ?></option>
                            </select>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button onclick="land_bank_location_form_submit()" class="btn uni_text btn-success"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $this->lang->line('submit_button') ?></button>
                            <button type="reset" id="MainIndex" class="btn uni_text btn-danger"><i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                        </div>
                    </div>
                    </form>
                    <?php echo form_close(); ?>
                </div>
                <!-- Select Location Gaon End-->
            </div>

        </div>
    </div>
</div>

<!-- <script type='text/javascript'>
    $(document).ready(function() {

        // village change
        $('#select_village').change(function() {
            var vill_code = $(this).val();

            // AJAX request
            $.ajax({
                url: '<?php echo base_url() . "index.php/LandShareUpdation/getDagNumber" ?>',
                method: 'post',
                data: {
                    vill_code: vill_code
                },
                dataType: 'json',
                success: function(response) {

                    // Remove options 
                    $('#select_dag').find('option').not(':first').remove();

                    // Add options
                    $.each(response, function(index, data) {
                        $('#select_dag').append('<option value="' + data['dag_no'] + '">' + data['dag_no'] + '</option>');
                    });
                }
            });
        });
    });
</script> -->