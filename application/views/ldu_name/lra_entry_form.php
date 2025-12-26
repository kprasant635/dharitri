    <style>
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        .form-header {
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .form-section-title {
            color: #3498db;
            margin-bottom: 15px;
        }
        .btn-submit {
            background-color: #3498db;
            color: white;
            padding: 10px 25px;
            font-weight: bold;
        }
        .btn-submit:hover {
            background-color: #2980b9;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
    <div class="container">
        <div class="form-container">
            <h2 class="form-header">Pattadar Gurdian Name Correction</h2>
            
            <form id="lraCorrectionForm" enctype="multipart/form-data" class="form-horizontal">
                <!-- Location Information Section -->
                <div class="form-section">
                    <h4 class="form-section-title">Location Information</h4>
                    
                    <div class="row mb-3">
                        <label for="dist_code" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('district'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select districtselect" id="dist_code" name="dist_code" required>
                                <?php if ($this->session->userdata('subdiv_code') == '00') : ?>
                                    <option disabled>Select District</option>
                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                    <option selected value="<?php echo $dist_code; ?>">
                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                    </option>
                                <?php else : ?>
                                    <option value="<?php echo $d; ?>" selected>
                                        <?php echo $this->utilityclass->getDistrictName($d); ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="subdiv_code" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('subdivision'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select subdivselect" id="subdiv_code" name="subdiv_code" required>
                                <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                <?php if ($subdiv_code == '00') : ?>
                                    <option selected disabled>Select Sub-division</option>
                                <?php else : ?>
                                    <option value="<?php echo $subdiv_code; ?>" selected>
                                        <?php echo $this->utilityclass->getSubDivName($d, $subdiv_code); ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="cir_code" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('circle'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select circleselect" id="cir_code" required name="circle_code">
                                <?php $cir_code = $this->session->userdata('cir_code'); ?>
                                <?php if ($cir_code == '00') : ?>
                                    <option selected disabled>Select Circle</option>
                                <?php else : ?>
                                    <option value="<?php echo $cir_code; ?>" selected>
                                        <?php echo $this->utilityclass->getCircleName($d, $subdiv_code, $cir_code); ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="mouza_pargona_code" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('mouza'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select mouzaselect" id="mouza_pargona_code" required name="mouza_code">
                                <?php $mouza_pargona_code = $this->session->userdata('mouza_pargona_code'); ?>
                                <?php if ($mouza_pargona_code == '00') : ?>
                                    <option selected disabled>Select Mouza</option>
                                <?php else : ?>
                                    <option value="<?php echo $m; ?>" selected>
                                        <?php echo $this->utilityclass->getMouzaName($d, $subdiv_code, $cir_code, $m); ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="lot_no" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('lot_no'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select lotselect" id="lot_no" required name="lot_no">
                                <?php $lot_no = $this->session->userdata('lot_no'); ?>
                                <?php if ($lot_no == '00') : ?>
                                    <option selected disabled>Select Lot No</option>
                                <?php else : ?>
                                    <option selected disabled>Select Lot No</option>
                                    <option value="<?php echo $l; ?>">
                                        <?php echo $this->utilityclass->getLotName($d, $subdiv_code, $cir_code, $m, $l); ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="village_code" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('vill_town'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select villageselect" id="village_code" required name="vill_code">
                                <option disabled selected>Select Village/Town</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Patta Information Section -->
                <div class="form-section">
                    <h4 class="form-section-title">Patta Information</h4>
                    
                    <div class="row mb-3">
                        <label for="patta_type" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('patta_type'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select pattatype_name" id="patta_type" name="patta_type_code" required>
                                <option value="" selected disabled>Patta Type</option>
                                <?php foreach ($patta_types as $pt): ?>
                                    <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="patta_no" class="col-lg-3 col-form-label required-field"><?php echo $this->lang->line('patta_no'); ?></label>
                        <div class="col-lg-9">
                            <select class="form-select pattanoselect" id="patta_no" name="patta_no" required>
                                <option value="" selected disabled>Patta No</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Pattadar Information Section -->
                <div class="form-section">
                    <h4 class="form-section-title">Pattadar Information</h4>
                    
                    <div class="row mb-3">
                        <label for="old_pdar_name_select" class="col-lg-3 col-form-label required-field">Select Existing Pattadar:</label>
                        <div class="col-lg-9">
                            <select class="form-select old_pdar_name_select" id="old_pdar_name_select" name="old_pdar_name_select" required>
                                <option selected disabled>Old Pattadar</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="old_pdar_name" class="col-lg-3 col-form-label required-field">Existing Name:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="old_pdar_name" name="exist_pdar_name" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="new_pdar_name" class="col-lg-3 col-form-label required-field">Corrected Name:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="new_pdar_name" id="new_pdar_name" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="old_pdar_father_name" class="col-lg-3 col-form-label required-field">Existing Father's Name:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="old_pdar_father_name" name="exist_pdar_father_name" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="new_pdar_father_name" class="col-lg-3 col-form-label required-field">Corrected Father's Name:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="new_pdar_father_name" id="new_pdar_father_name" required>
                        </div>
                    </div>
                    <?php if(ENABLE_NGCOR_REL != 0){?>
                    <div class="row mb-3">
                        <label for="new_pdar_father_name" class="col-lg-3 col-form-label required-field">Relation</label>
                        <div class="col-lg-6">
                            <select class="form-select" id="get_relation" name="relation" required>
                                <option selected disabled>Select Relation</option>
                                <?php foreach ($relation as $r): ?>
                                    <option value="<?php echo $r->id; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new_pdar_father_name" class="col-lg-3 col-form-label required-field">Gender</label>
                        <div class="col-lg-6">
                            <select class="form-select" id="get_gender" name="gender" required>
                                <option selected disabled>Select Gender</option>
                                <?php foreach ($gender as $g): ?>
                                    <option value="<?php echo $g->id; ?>"><?php echo $g->gen_name_ass; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new_pdar_father_name" class="col-lg-3 col-form-label required-field">Caste</label>
                        <div class="col-lg-6">
                            <select class="form-select" id="get_caste" name="caste" required>
                                <option selected disabled>Select Caste</option>
                                <?php foreach ($caste as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->caset_name_eng; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new_pdar_father_name" class="col-lg-3 col-form-label required-field">DOB</label>
                        <div class="col-lg-4">
                            <input type="text" readonly="" class="form-control" name="dob" id="popup1Datepicker" required>
                        </div>
                    </div>
                <?php }?>
                    <div class="row mb-12">
                        <label class="col-lg-3 col-form-label required-field">REMARKS</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" rows="5" id="lm_report" name="lra_remark"></textarea>
                        </div>
                    </div>
                </div>             
                <!-- Supporting Documents Section -->
                <div class="form-section">
                    <h4 class="form-section-title">Supporting Documents</h4>
                    
                    <div class="row mb-3">
                        <label for="attachment" class="col-lg-3 col-form-label required-field">Supporting Document:</label>
                        <div class="col-lg-9">
                            <input type="file" class="form-control" name="attachment" id="attachment" accept=".pdf,.jpg,.png" required>
                            <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG</small>
                        </div>
                    </div>
                </div>  

                 <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label required" aria-required="true">Assign Recieving Circle Officer</label>
                            <div class="col-sm-5">
                                <select name="official" class="form-control" required="" id='selectCo' aria-required="true" aria-invalid="false">
                                <option value="">Select CO</option>
                                  <?php foreach($user as $u){
                                    
                                   ?>
                                 <option value="<?=$u['user_code']?>"><?=$u['username']?> </option>
                                  <?php } ?>
                                </select>
                               
                            </div>
                        </div>            
                <!-- Submit Button -->
                <div class="row">
                    <div class="col-lg-9 offset-lg-3">
                        <button type="submit" class="btn btn-submit">Submit Correction</button>
                    </div>
                </div>
            </form>
            
            <div id="responseMessage" class="mt-3"></div>
        </div>
    </div>
    <!-- /////////MODAL///////////////// -->
    <div class="modal" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="consentModalLabel">Verification Consent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="consentCheckbox">
                    <label class="form-check-label" for="consentCheckbox">
                        I hereby confirm that I have personally verified all the documents and information provided, 
                        and to the best of my knowledge, they are correct and authentic. I understand that if any 
                        discrepancies or false information are found in the future, I will be held fully responsible 
                        for providing misleading data.
                    </label>
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i> Please ensure all information is correct before submitting. 
                    This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">I Agree & Submit</button>
            </div>
        </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {

       $("#village_code").change(function () {
            $("#patta_type").val('');
            $("#patta_no").val('');
            $("#old_pdar_name_select").val('');
            $("#old_pdar_name").val('');
            $("#new_pdar_name").val('');
            $("#old_pdar_father_name").val('');
            $("#new_pdar_father_name").val('');
        });


       $('.pattatype_name').change(function (e) {
        $("#patta_no").val('');
        $("#old_pdar_name_select").val('');
        $("#old_pdar_name").val('');
        $("#new_pdar_name").val('');
        $("#old_pdar_father_name").val('');
        $("#new_pdar_father_name").val('');


        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type = $(this).val();
        $.ajax({
            url: baseurl + "JamabandiControllerBondita/getpattaTypebyname/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode+ "/" + patta_type,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                //  console.log(data);
               var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Patta Number</option>";

                if(lot[0].error) {
                    alert(lot[0].error);
                }
                else{
                    for (var i = 0; i < lot.length; i++) {
                        template += "<option value='" + lot[i].patta_no + "'>" + lot[i].patta_no + "</option>";
                    }
                }
                // console.log(template);
                $('.pattanoselect').html(template);
            }
        });
    });


        $("#patta_no").change(function () {
            $("#old_pdar_name_select").val('');
            $("#old_pdar_name").val('');
            $("#new_pdar_name").val('');
            $("#old_pdar_father_name").val('');
            $("#new_pdar_father_name").val('');

            var patta_no = $(this).val();
            var dist_code = $("#dist_code").val();
            var subdiv_code = $("#subdiv_code").val();
            var cir_code = $("#cir_code").val();
            var mouza_code = $("#mouza_pargona_code").val();
            var lot_no = $("#lot_no").val();
            var village_code = $("#village_code").val();
            var patta_type = $("#patta_type").val();
            
            if (patta_no && dist_code && subdiv_code) {
                $.ajax({
                    url: baseurl + "CorrectionController/getPattaDetails",
                    type: "POST",
                    data: { 
                        patta_type: patta_type, 
                        patta_no: patta_no, 
                        dist_code: dist_code, 
                        subdiv_code: subdiv_code,
                        cir_code: cir_code,
                        mouza_code: mouza_code,
                        lot_no: lot_no,
                        village_code: village_code
                    },
                    dataType: "json",
                    success: function (response) {
                        const $dropdown = $('#old_pdar_name_select');
                        $dropdown.empty().append('<option selected disabled>Old Pattadar</option>');
                        
                        if (response.status === 'success') {
                            $.each(response.data, function(index, item) {
                                $dropdown.append($('<option>', {
                                    value: item.pdar_id,
                                    text: item.pdar_name + ' (' + item.pdar_father_name +')',
                                    'data-name': item.pdar_name,
                                    'data-father': item.pdar_father_name
                                }));
                            });
                            // When a selection is made, display the names
                            $dropdown.change(function() {
                                var selectedOption = $(this).find('option:selected');
                                var name = selectedOption.data('name');
                                var fatherName = selectedOption.data('father');
                                
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
        $("#lraCorrectionForm").submit(function (e) {
        e.preventDefault();       
        var selectCo = $("#selectCo");
        var lmremark = $("#lm_report");
        if (selectCo.val() == "") {
                  alert("Please select Assign CO!");
                  return false;
              }
        if (lmremark.val() == "") {
              alert("Please enter a remark!");
              return false;
          }
        // Show consent modal instead of directly submitting
        $('#consentModal').modal('show');
        });
        // Handle the consent confirmation
        $('#confirmSubmit').click(function() {
            if ($('#consentCheckbox').is(':checked')) {
                // Hide the modal
                $('#consentModal').modal('hide');               
                // Proceed with form submission
                var formData = new FormData(document.getElementById('lraCorrectionForm'));              
                $.ajax({
                    url: baseurl + "CorrectionController/submitCorrection",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        // Show loading indicator
                        $('#responseMessage').html('<div class="alert alert-info">Submitting your correction request...</div>');
                    },
                    success: function (response) {
                        //console.log(response.redirect_url);
                        if (response.status=='success') {
                            $("#responseMessage").html('<div class="alert alert-success">' + response.message + '</div>');
                            // $("#lraCorrectionForm")[0].reset();
                            window.location.href = response.redirect_url;
                        } else {
                            $("#responseMessage").html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#responseMessage").html('<div class="alert alert-danger">Error submitting form. Please try again.</div>');
                    }
                });
            } else {
                alert('Please confirm your verification by checking the consent checkbox.');
            }
        });
        
    });
    </script>