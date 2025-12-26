<div class="modal modal-lg" role="dialog" id="addFamilyData">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header text-center" style="background-color: #4FC3F7; color: white">
                <h5 class="modal-title text-center" id="exampleModalLongTitle" style="line-height: 1!important;">
                    Add Family Details
                </h5>
            </div>
            <div class="modal-body" align="center" style="margin-bottom: 20px">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td>
                            <input type="text" id="add_kin_name" name="add_kin_name" placeholder="Name" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            <input type="text" id="add_kin_address" name="add_kin_address" placeholder="Address" class="form-control">
                        </td>

                    </tr>
                    <tr>
                        <th>Relation</th>
                        <td>
                            <select id="add_kin_relation" class="form-control" name="add_kin_relation">
                                <option value="">Select</option>
                                <?php foreach ($guar_rel as $guar_rel_list) {
                                    ?>
                                    <option value="<?=$guar_rel_list->id?>">
                                        <?=$guar_rel_list->guard_rel_desc_as?>
                                    </option>
                                <?php }?>
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <th>Mobile</th>
                        <td>
                            <input type="number" maxlength="10" id="add_kin_contact_no" class="form-control" name="add_kin_contact_no" placeholder="Mobile Number">
                        </td>

                    </tr>

                </table>
            </div>
            <div class="modal-footer" style="padding-right: 35px">
                <button type="button" class="rezaButt buttInfo" onclick="addFamilyDetails()" >
                    <i class="fa fa-check-square"></i> Submit
                </button>
                <button type="button" class="rezaButt buttDanger closefamily" id="">
                    <i class="fa fa-times-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>



