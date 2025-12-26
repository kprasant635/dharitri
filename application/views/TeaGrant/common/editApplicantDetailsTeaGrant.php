<style>
    /* The Close Button */
    .close-edit-applicant {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-edit-applicant:hover,
    .close-edit-applicant:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<div id="editTeaApplicantDetails" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="close-edit-applicant px-4 tea_close_modal">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>Edit Applicant Details</h5>
            </div>
        </div>

        <table class="table">
            <input type="hidden" id="applicant_tea_id">
            <input type="hidden" id="applicant_tea_is_applicant">
            <tr>
                <th>Applicant Name (Assamese)</th>
                <td>
                    <input type="text" id="applicant_tea_applicant_name_ass" class="form-control">
                </td>

                <th>Applicant Name (English)</th>
                <td>
                    <input type="text" id="applicant_tea_applicant_name_eng" class="form-control" >
                </td>
            </tr>
            <tr>
                <th>Guardian Name (Assamese)</th>
                <td>
                    <input type="text" id="applicant_tea_guardian_name_ass" class="form-control">
                </td>
                <th>Guardian Name (English)</th>
                <td>
                    <input type="text" id="applicant_tea_guardian_name_eng" class="form-control">
                </td>
            </tr>
            <tr>
                <th>Relation</th>
                <td>
                    <select id="applicant_tea_relation" class="form-control">
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
                    <select id="applicant_tea_gender" class="form-control">
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
                    <input type="text" readonly id="applicant_tea_dob" class="form-control">
                </td>
                <th class="marital-status-condition">Marital Status</th>
                <td class="marital-status-condition">
                    <select id="applicant_tea_marital_status" class="form-control">
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
                    <input type="number" id="applicant_tea_mobile" class="form-control" readonly>
                </td>
                <th>Permanent address</th>
                <td>
                    <input type="text" id="applicant_tea_per_address" class="form-control">
                </td>
            </tr>
            <tr>
                <th>Present address</th>
                <td>
                    <input type="text" id="applicant_tea_pre_address" class="form-control">
                </td>
            </tr>
        </table>
        
        <div class="row justify-content-center">
            <button type="button" onclick="updateTeaApplicantDetails();" class="btn btn-sm btn-danger col-3">UPDATE</button>
        </div>
    </p>
  </div>

</div>

<script src="<?php echo base_url();?>js/mb3/teaGrant/editTeaApplicantDetails.js"></script>
