<style>
    /* The Close Button */
    .closefamily {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .closefamily:hover,
    .closefamily:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div id="addFamilyData" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
        <span class="closefamily px-4">&times;</span>
    </div>
    <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>Add Family Details</h5>
            </div>
        </div>

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
        
        <div class="row justify-content-center">
            <button type="button" onclick="addFamilyDetails();" class="btn btn-sm btn-danger col-3">Add</button>
        </div>
    </p>
  </div>

</div>
