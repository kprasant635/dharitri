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
            
           <?php //var_dump($data->dist_code);exit;?>
                <!-- Location Information Section -->
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
        <hr>
        <h4 class="form-section-patta">Patta Information</h4>
        <div class="col-lg-6">
            <div class="row mb-3">
                <label for="dist_code" class="col-lg-4 col-form-label required-field">Patta Type</label>
                <div class="col-lg-8">
                    <select class="form-select districtselect" id="patta_type" name="patta_type">
                        <?php $dist_code = $data->patta_type_code; ?>
                        <option selected value="<?php echo $data->patta_type_code; ?>">
                            <?php echo $this->utilityclass->getPattaName($data->patta_type_code); ?>
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-3">
                <label for="subdiv_code" class="col-lg-4 col-form-label required-field">Patta No</label>
                <div class="col-lg-8">
                    <select class="form-select subdivselect" id="patta_no" name="patta_no">
                        <option value="<?php echo $data->patta_no; ?>" selected>
                            <?php echo $data->patta_no; ?>
                        </option>
                    </select>
                </div>
        </div>
        </div>
        <hr>

        <h4 class="form-section-pattadar">Pattadar Information</h4>
        <div class="col-lg-6">
            <div class="row mb-3">
                <label for="dist_code" class="col-lg-4 col-form-label required-field">Existing Pattadar Name</label>
                <div class="col-lg-8">
                  <input class="form-control" type="text" name="" value="<?=$data->old_pdar_name?>" readonly>    
                </div>
            </div>

            <div class="row mb-3">
                <label for="subdiv_code" class="col-lg-4 col-form-label required-field">Existing Father's Name</label>
                <div class="col-lg-8">
                   <input class="form-control" type="text" name="" value="<?=$data->old_pdar_father?>" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row mb-3">
                <label for="dist_code" class="col-lg-4 col-form-label required-field">Corrected Name</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="" value="<?=$data->new_pdar_name?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="subdiv_code" class="col-lg-4 col-form-label required-field">Corrected Father's Name</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="" value="<?=$data->new_pdar_father?>" readonly>
                </div>
            </div>
        </div>
        <hr>
       
        <div class="row mb-3">
                <label for="subdiv_code" class="col-lg-4 col-form-label required-field">LRA Remark</label>
                <div class="col-lg-8">
                    <textarea class="form-control" readonly>
                        <?php echo $data->lra_remarks;?>
                    </textarea>
                </div>
        </div>
        <hr>
        <div class="row mb-12">
                        <label class="col-lg-3 col-form-label required-field">REMARKS</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" rows="5" name="lra_remark"></textarea>
                        </div>
                    </div>
            </div>

    
    <div class="col-lg-6">
        <div class="col-lg-9 offset-lg-3">
            <button type="submit" class="btn btn-submit">Submit Correction</button>
        </div>
    </div>
</div>
        </div>   
        </div>
    </div>