<h2>Name Correction(Pattadar-Gurdian-Relation-Gender) Entry</h2>
<form id="lraCorrectionForm" enctype="multipart/form-data">
    <div class="form-group">
        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('district'); ?></label>
        <div class="col-lg-9">
            <select class="form-control districtselect" id="dist_code" name="dist_code" required>
                <?php
                if ($this->session->userdata('subdiv_code') == '00') {
                    ?>
                    <option  disabled>Select District</option>
                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                    <option selected value="<?php echo $dist_code; ?>" >
                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                    </option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $d; ?>"  selected>
                        <?php echo $this->utilityclass->getDistrictName($d); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div> 
    </div>
    <div class="form-group">
        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('subdivision'); ?></label>
        <div class="col-lg-9">
            <select class="form-control subdivselect" id="subdiv_code" name="subdiv_code" required>
                <?php
                $subdiv_code = $this->session->userdata('subdiv_code');
                if ($subdiv_code == '00') {
                    ?>
                    <option selected disabled>Select Sub-divsion</option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $subdiv_code; ?>"  selected>
                        <?php echo $this->utilityclass->getSubDivName($d, $subdiv_code); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('circle'); ?></label>
        <div class="col-lg-9">
            <select class="form-control circleselect" id="cir_code" required name="circle_code">
                <?php
                $cir_code = $this->session->userdata('cir_code');
                if ($cir_code == '00') {
                    ?>
                    <option selected disabled>Select Circle</option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $cir_code; ?>"  selected>
                        <?php echo $this->utilityclass->getCircleName($d, $subdiv_code, $cir_code); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('mouza'); ?></label>
        <div class="col-lg-9">
            <select class="form-control mouzaselect" id="mouza_pargona_code" required name="mouza_code">
                <?php
                $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                if ($mouza_pargona_code == '00') {
                    ?>
                    <option selected disabled>Select Mouza</option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $m; ?>"  selected>
                        <?php echo $this->utilityclass->getMouzaName($d, $subdiv_code, $cir_code, $m); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('lot_no'); ?></label>
        <div class="col-lg-9">
            <select class="form-control lotselect" id="lot_no" required name="lot_no">
                <?php
                $lot_no = $this->session->userdata('lot_no');
                if ($lot_no == '00') {
                    ?>
                    <option selected disabled>Select Lot No</option>
                    <?php
                } else {
                    ?>
                    <option selected disabled>Select Lot No</option>
                    <option value="<?php echo $l; ?>">
                        <?php echo $this->utilityclass->getLotName($d, $subdiv_code, $cir_code, $m, $l); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('vill_town'); ?></label>
        <div class="col-lg-9">
            <select class="form-control villageselect" id="village_code" required name="vill_code">
                <option disabled selected>Select Village/Town</option>
            </select>
        </div>
    </div>
    <hr style="border-bottom: 2px solid #000;">
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type') ?></label>
        <div class="col-lg-9">
            <select class="form-control pattatype_nmae" id='patta_type' name="patta_type_code" required>
                <option selected disabled>Patta Type</option>
                <?php foreach ($patta_types as $pt): ?>
                    <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_no') ?></label>
        <div class="col-lg-9">
            <select class="form-control pattanoselect" id='patta_no' name="patta_no" required>
                <option selected disabled>Patta No</option>  
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Select Existing Pattadar:</label>
        <div class="col-lg-9">
            <select class="form-control old_pdar_name_select" id='old_pdar_name_select' name="old_pdar_name_select" required>
                <option selected disabled>Old Pattadar</option>  
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Selected Existing Name:</label>
        <div class="col-lg-9">
            <input type="text" id="old_pdar_name" name='exist_pdar_name' required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Corrected Name:</label>
        <div class="col-lg-9">
            <input type="text" name="new_pdar_name" id="new_pdar_name" required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Existing Father's Name:</label>
        <div class="col-lg-9">
            <input type="text" id="old_pdar_father_name" name='exist_pdar_father_name' required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Corrected Father's Name:</label>
        <div class="col-lg-9">
            <input type="text" name="new_pdar_father_name" id="new_pdar_father_name" required>
        </div>
    </div>
    <!-- <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Relation</label>
        <div class="col-lg-9">
            <input type="text" name="new_pdar_name" id="new_pdar_name" required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-lg-3 control-label">Gender</label>
        <div class="col-lg-9">
            <input type="text" name="new_pdar_name" id="new_pdar_name" required>
        </div>
    </div> -->

    <label for="attachment">Supporting Document:</label>
    <input type="file" name="attachment" id="attachment" accept=".pdf,.jpg,.png" required>
    <br><br>
    <button type="submit">Submit Correction</button>
</form>
<div id="responseMessage"></div>
<script>
$(document).ready(function () {
    // Fetch Existing Data on Patta No Entry
    $("#patta_no").blur(function () {
        var patta_no = $(this).val();
        var dist_code = $("#dist_code").val();
        var subdiv_code = $("#subdiv_code").val();
        var cir_code   = $("#cir_code").val();
        var mouza_code = $("#mouza_pargona_code").val();
        var lot_no = $("#lot_no").val();
        var village_code = $("#village_code").val();
        var patta_type = $("#patta_type").val();
        if (patta_no && dist_code && subdiv_code) {
            $.ajax({
                url: baseurl +"CorrectionController/getPattaDetails",
                type: "POST",
                data: { patta_type:patta_type, patta_no: patta_no, dist_code: dist_code, subdiv_code: subdiv_code ,cir_code:cir_code,mouza_code:mouza_code,lot_no:lot_no,village_code:village_code},
                dataType: "json",
                success: function (response) {
                    const $dropdown = $('#old_pdar_name_select');
                    $dropdown.empty().append('<option selected disabled>Old Pattadar</option>');
                    if (response.status === 'success') {
                        $.each(response.data, function(index, item) {
                            $dropdown.append($('<option>', {
                            value: item.pdar_id,
                            text: item.pdar_name + ' ' + item.pdar_father_name ,
                            'data-name': item.pdar_name,
                            'data-father': item.pdar_father_name
                        }));
                        });
                        // When a selection is made, display the names
                        $dropdown.change(function() {
                            var selectedOption = $(this).find('option:selected');
                            var name = selectedOption.data('name');
                            var fatherName = selectedOption.data('father');                           
                            // Display the selected names (you can modify this part to show them where you want)
                            console.log('Selected Name:', name);
                            console.log('Father\'s Name:', fatherName);                        
                            // Or update specific elements on your page
                            $('#old_pdar_name').val(name);
                            $('#old_pdar_father_name').val(fatherName);
                        });
                    } else {
                        $dropdown.append($('<option>', {
                            value: '',
                            text: 'No records found'
                        }));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('#old_pdar_name_select').empty()
                        .append('<option selected disabled>Error loading data</option>');
                }
            });
        }
    });
    // Submit Form via AJAX
    $("#lraCorrectionForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: baseurl +"CorrectionController/submitCorrection",
            type: "POST",
            data: formData, 
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $("#responseMessage").html("<p style='color:green;'>" + response.message + "</p>");
                $("#lraCorrectionForm")[0].reset();
            }
        });
    });
});
</script>