<?php if(!empty($nominee)) { ?>
    <div class="tableCard">
        <table class="table table-bordered" id="listNextOfKin">
            <tr>
                <th>Nominee name</th>
                <th>Relation with Applicant</th>
                <th>Address of Nominee</th>
                <th>Mobile number</th>
            </tr>
            <?php $i = 1;foreach ($nominee as $kin): ?>
                <tr id="sp<?=$kin->id?>">
                    <td>
                        <input type="text" readonly name="kin_name" value="<?=$kin->nominee_name?>" class="form-control">
                    </td>
                    <td>
                        <input type="text" readonly name="kin_relation" value="<?=$this->utilityclass->appRelationbyIDMB2($kin->relation)?>" class="form-control">
                    </td>
                    <td>
                        <input type="text" readonly class="form-control" value="<?=$kin->address?>" name="kin_address">
                    </td>
                    <td>
                        <input type="text" readonly name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control">
                    </td>

                    <?php if (in_array($this->session->userdata('user_desig_code'), OFFLINE_SETTLEMENT_EDIT_OPTION_ACCESS)): ?>
                        <td>
                            <?php if(OFFLINE_SETTLEMENT_ENABLE_FAMILY_BUTTON_LM == 1){?>
                                <!-- <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add</button>-->
                                <button type="button" onclick="confirmDeleteFamily(<?=$kin->id?>);" class="btn btn-sm btn-danger">Delete</button>
                            <?php } ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php $i++;?>
            <?php endforeach;?>
        </table>
    </div>
<?php } else { ?>
    <div class="tableCard familyVisibleHide">
        <table class="table table-bordered" id="listNextOfKin">
            <tr>
                <th>Name</th>
                <th>Relation</th>
                <th>Address</th>
                <th>Mobile number</th>
            </tr>
        </table>
    </div>
<?php } ?>