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
            content: "";
            color: red;
        }

        .form-section-pattadar {
            color: #db3434d1;
            margin-bottom: 15px;
        }

        .form-section-patta {
            color: #34db4a;
            margin-bottom: 15px;
        }
    </style>
    <div class="container">
    <div class="form-container">
        <h2 class="form-header">Pattadar Guardian Name Correction</h2>
        <form id="coCorrectionForm" enctype="multipart/form-data" class="form-horizontal">

            <input type="hidden" name="case_no" value="<?=$data->case_no?>">
            <input type="hidden" name="id" value="<?=$data->id?>">
        <div class="form-section">
            <h4 class="form-section-title">Location Information</h4>

            <div class="row">
                <!-- Left Side (First 3 Rows) -->
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <label for="dist_code" class="col-lg-4 col-form-label required-field"><?php echo $this->lang->line('district'); ?></label>
                        <div class="col-lg-8">
                            <select class="form-select districtselect" id="dist_code" name="dist_code">
                                <option disabled>Select District</option>
                                <?php $dist_code = $data->dist_code; ?>
                                <option selected value="<?php echo $dist_code; ?>">
                                    <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="subdiv_code" class="col-lg-4 col-form-label required-field"><?php echo $this->lang->line('subdivision'); ?></label>
                        <div class="col-lg-8">
                            <select class="form-select subdivselect" id="subdiv_code" name="subdiv_code">
                                <option value="<?php echo $data->subdiv_code; ?>" selected>
                                    <?php echo $this->utilityclass->getSubDivName($data->dist_code, $data->subdiv_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cir_code" class="col-lg-4 col-form-label required-field"><?php echo $this->lang->line('circle'); ?></label>
                        <div class="col-lg-8">
                            <select class="form-select circleselect" id="cir_code" required name="circle_code">
                                <option value="<?php echo $data->cir_code; ?>" selected>
                                    <?php echo $this->utilityclass->getCircleName($data->dist_code, $data->subdiv_code, $data->cir_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Right Side (Next 3 Rows) -->
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <label for="mouza_pargona_code" class="col-lg-4 col-form-label required-field"><?php echo $this->lang->line('mouza'); ?></label>
                        <div class="col-lg-8">
                            <select class="form-select mouzaselect" id="mouza_pargona_code" required name="mouza_code">
                                <option value="<?php echo $data->mouza_pargona_code; ?>" selected>
                                    <?php echo $this->utilityclass->getMouzaName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lot_no" class="col-lg-4 col-form-label required-field"><?php echo $this->lang->line('lot_no'); ?></label>
                        <div class="col-lg-8">
                            <select class="form-select lotselect" id="lot_no" required name="lot_no">
                                <option value="<?php echo $data->lot_no; ?>" selected>
                                    <?php echo $this->utilityclass->getLotName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="village_code" class="col-lg-4 col-form-label required-field"><?php echo $this->lang->line('vill_town'); ?></label>
                        <div class="col-lg-8">
                            <select class="form-select villageselect" id="village_code" required name="vill_code">
                                <option value="<?php echo $data->vill_townprt_code; ?>" selected>
                                    <?php echo $this->utilityclass->getVillageName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h4 class="form-section-patta">Patta Information</h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required-field">Patta Type</label>
                        <div class="col-lg-8">
                            <select class="form-select districtselect" id="patta_type" name="patta_type">
                                <option selected value="<?php echo $data->patta_type_code; ?>">
                                    <?php echo $this->utilityclass->getPattaName($data->patta_type_code); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required-field">Patta No</label>
                        <div class="col-lg-8">
                            <select class="form-select subdivselect" id="patta_no" name="patta_no">
                                <option value="<?php echo $data->patta_no; ?>" selected>
                                    <?php echo $data->patta_no; ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h4 class="form-section-pattadar">Pattadar Information</h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required-field">Existing Pattadar Name</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="<?=$data->old_pdar_name?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required-field">Existing Father's Name</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="<?=$data->old_pdar_father?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required-field">Corrected Name</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="<?=$data->new_pdar_name?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required-field">Corrected Father's Name</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="<?=$data->new_pdar_father?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <label class="col-lg-4 col-form-label required-field">LRA Remark</label>
                <div class="col-lg-8">
                    <textarea class="form-control" readonly><?php echo $data->lra_remarks; ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-lg-4 col-form-label required-field">CO Remark</label>
                <div class="col-lg-8">
                    <textarea class="form-control" readonly><?php echo $data->co_remarks; ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
            <label class="col-lg-3 col-form-label required-field">Attachment</label>
                <div class="col-lg-9">
                        <a href="<?= base_url('index.php/CorrectionController/document/' . $data->attachment); ?>" target="_blank">
                            View Attachment
                        </a>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <label class="col-lg-3 col-form-label required-field">REMARKS</label>
                <div class="col-lg-9">
                    <textarea class="form-control" rows="3" name="adc_remark"></textarea>
                </div>
            </div>

            <?php if($data->status=='Forwarded' && $data->pending_with_officer=='ADC' && $data->pending_status='A'){?>
            <div class="row mt-4">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary btn-sm">Approve Correction</button>
                    <button type="button" class="btn rejectCO btn-danger btn-sm">Reject</button>
                </div>
            </div>
            <?php }?>
        </div>
    </form>

    <div id="responseMessage" class="mt-3"></div>
    </div>
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

    <div id="rejectCO" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject reason</h5>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/CorrectionController/rejectNGCorCO" method="post" >
                <div class="modal-body">
                    <input type="hidden" class="form-control" name='case_no' 
                    value="<?=$data->case_no?>">
                    <input type="hidden" class="form-control" name='id' 
                    value="<?=$data->id?>">
                    <input type="hidden" name="dist_code" value="<?=$data->dist_code?>">
                    <input type="hidden" name="subdiv_code"  value="<?=$data->subdiv_code?>">
                    <input type="hidden" name="cir_code" value="<?=$data->cir_code?>">
                    <textarea name='co_report' id="co_report" class="form-control" placeholder="Remark" required></textarea> 
                    <textarea name="co_report_suffix" class="form-control hide" 
                    rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"  onclick="return validateForm();">Save</button>
                    <button type="button" class="btn btn-sm btn-default btnRevertClose" id="">Close</button>
                </div>
            </form> 
        </div>
    </div>
</div>

    <script type="text/javascript">
         $("#coCorrectionForm").submit(function (e) {
        e.preventDefault();       
        // Show consent modal instead of directly submitting
        $('#consentModal').modal('show');
        });


         $('#confirmSubmit').click(function() {
            if ($('#consentCheckbox').is(':checked')) {
                // Hide the modal
                $('#consentModal').modal('hide');               
                // Proceed with form submission
                var formData = new FormData(document.getElementById('coCorrectionForm'));              
                $.ajax({
                    url: baseurl + "CorrectionController/updateADCCorrection",
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
                         if (response.status=='success') {
                            $("#responseMessage").html('<div class="alert alert-success">' + response.message + '</div>');
                            //$("#lraCorrectionForm")[0].reset();
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
    </script>

    <script type="text/javascript">
        $(".rejectCO").click(function(event){
              event.preventDefault();
              $("#rejectCO").modal('show');
      });

        $(document).on('click','.btnRevertClose', function(){
                $('#rejectCO').modal('hide');
            });
    </script>