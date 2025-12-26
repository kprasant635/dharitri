<style>
    /* The Close Button */
    .close-add-applicant {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-add-applicant:hover,
    .close-add-applicant:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<div id="addTenantApplicantDetails" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-add-tenant-applicant px-4" style="cursor: pointer;">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>Add Applicant Details</h5>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>Applicant Name (Assamese)</th>
                <td>
                    <input type="text" placeholder="Enter name in assamese" id="add_tenant_applicant_name_ass" class="form-control">
                </td>

                <th>Applicant Name (English)</th>
                <td>
                    <input type="text" placeholder="Enter name in english" id="add_tenant_applicant_name_eng" class="form-control">
                </td>
            </tr>
            <tr>
                <th>Guardian Name (Assamese)</th>
                <td>
                    <input type="text" placeholder="Enter guardian name in assamese" id="add_tenant_guardian_name_ass" class="form-control">
                </td>
                <th>Guardian Name (English)</th>
                <td>
                    <input type="text" placeholder="Enter guardian name in english" id="add_tenant_guardian_name_eng" class="form-control">
                </td>
            </tr>
            <tr>
                <th>Relation</th>
                <td>
                    <select id="add_tenant_relation" class="form-control">
                        <option value="">Select</option>
                        <?php foreach ($guar_rel as $guar_rel_list) {
                            ?>
                            <option value="<?=$guar_rel_list->id?>">
                                <?=$guar_rel_list->guard_rel_desc_as?>
                            </option>
                        <?php }?>
                    </select>
                </td>
                <th>Gender</th>
                <td>
                    <select id="add_tenant_gender" class="form-control">
                        <option value="">Select...</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Others</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>DOB</th>
                <td>
                    <input type="text" placeholder="Select DOB (YYYY-MM-DD)" id="add_tenant_dob" class="form-control ymd">
                </td>
                <th class="add_tenant_marital-status-condition">Marital Status</th>
                <td class="add_tenant_marital-status-condition">
                    <select id="add_tenant_marital_status" class="form-control">
                        <option value="">Select</option>

                        <?php
                            foreach(json_decode(MARITAL_STATUS) as $marital):
                            ?>
                            <option value="<?=$marital->CODE?>"><?=$marital->NAME?></option>
                            <?php
                            endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>
                    <input type="text" id="add_tenant_mobile" placeholder="Enter Mobile number" class="form-control" maxlength="10">
                </td>
                <th>Permanent address</th>
                <td>
                    <input type="text" placeholder="Enter permanent address" id="add_tenant_per_address" class="form-control">
                </td>
            </tr>
            <tr>
                <th width="25%">Present address</th>
                <td width="25%">
                    <input type="text" placeholder="Enter present address" id="add_tenant_pre_address" class="form-control">
                </td>

                <th width="25%">Upload the NOC from the applicant for the inclusion of the left-out Rayat/Next of Kin (NOK)</th>
                <td width="25%">
                    <input type="file" placeholder="Upload NOC" id="add_tenant_upload_noc" class="form-control">
                </td>
            </tr>

        </table>
        
        <div class="row justify-content-center">
            <button type="button" onclick="addTenantApplicant();" class="btn btn-sm btn-danger col-3">ADD</button>
        </div>
    </p>
  </div>

</div>


<script src="<?php echo base_url();?>js/mb3/tenant/addTenantApplicantDetails.js"></script>
