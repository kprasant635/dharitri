<div class="tableCard">
    <table class="table table-bordered">
        <tr>
            <th style="width: 25%">Application No.</th>
            <td style="width: 25%; font-weight: bold"><?php echo $case_no ?></td>
            <th style="width: 25%">Application Status.</th>
            <td style="width: 25%; font-weight: bold">
                <?php if($basic->status == 'D'): ?>
                    Rejected
                <?php elseif($basic->status == 'F'): ?>
                    Delivered
                <?php else: ?>
                    Under Process
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%">Pending Office</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->pending_office ?></td>
            <th style="width: 25%">Pending With</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->pending_officer ?></td>
        </tr>

        <tr>
            <th style="width: 25%">Applied For</th>
            <td style="width: 25%; font-weight: bold; text-transform: capitalize"><b><?php echo $caseDetails->applied_for ?></b></td>
            <th style="width: 25%">Applied On</th>
            <td style="width: 25%; font-weight: bold">
                <?php echo date('d-m-Y', strtotime($basic->date_entry)); ?>
            </td>
        </tr>


        <tr>
            <th style="width: 25%">Type of House</th>
            <td style="width: 25%; font-weight: bold; text-transform: capitalize"><?php echo $caseDetails->house_type  ?></td>
            <th style="width: 25%">Period & Nature of Possession</th>
            <td style="width: 25%; font-weight: bold; text-transform: capitalize"><?php echo $caseDetails->nature_of_possession  ?></td>
        </tr>

        <tr>
            <th style="width: 25%">SDLAC Recommendation</th>
            <td style="width: 25%; font-weight: bold">
                <?php if($caseDetails->sdlac_rec == 1): ?>
                    Recommended
                <?php elseif($caseDetails->sdlac_rec == 2): ?>
                    Not Recommended
                <?php else: ?>
                    Not Mention
                <?php endif; ?>
            </td>
            <th style="width: 25%">SDLAC Recommendation Date</th>
            <td style="width: 25%; font-weight: bold">
                <?php echo date('d-m-Y', strtotime($caseDetails->sdlac_rec_date )); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%">Zonal valuation </th>
            <td style="width: 25%; font-weight: bold"><?php echo $caseDetails->zonal_value  ?></td>
            <th style="width: 25%">Rate of premium </th>
            <td style="width: 25%; font-weight: bold"><?php echo $caseDetails->premium  ?></td>
        </tr>
        <tr>
            <th style="width: 25%">Accepted / Recommendation</th>
            <td style="width: 25%; font-weight: bold">
                <?php if($caseDetails->recommendation == 1): ?>
                    Accepted
                <?php elseif($caseDetails->recommendation == 2): ?>
                    Rejected
                <?php else: ?>
                    Not Mention
                <?php endif; ?>
            </td>
            <th style="width: 25%">Concession</th>
            <td style="width: 25%; font-weight: bold"><?php echo $caseDetails->concession  ?></td>
        </tr>
        <tr>
            <th style="width: 25%">Whether eligible as per Clause 14.4 of Land Policy, 2019</th>
            <td style="width: 25%; font-weight: bold; text-transform: capitalize"><?php echo $caseDetails->land_policy_status  ?></td>
            <th style="width: 25%">Checklist Submitted</th>
            <td style="width: 25%; font-weight: bold; text-transform: capitalize"><?php echo $caseDetails->checklist  ?></td>
        </tr>
        <tr>
            <th style="width: 25%">Remarks </th>
            <td style="width: 75%" colspan="3"><?php echo $caseDetails->remarks  ?></td>
        </tr>
    </table>
</div>

<?php if(trim($caseDetails->applied_for) == 'institution') : ?>
    <h5 class="reza-title" style="margin-top: 40px">
        <i class="fa fa-university"></i>  Institution Details
    </h5>

    <div class="tableCard">
        <table class="table table-bordered">
            <tr>
                <th style="width: 25%">New Land Class</th>
                <td style="width: 25%; font-weight: bold">
                    <?php $selected = '';
                    $land_types = LAND_TYPES;
                    foreach ($land_types as  $value)
                    {
                        $selected = '';
                        if($value['id'] == $caseDetails->land_class)
                        {
                            echo $value['name'];
                        }
                        ?>
                    <?php } ?>

                </td>

                <th style="width: 25%">Category of the Proposed Land Class</th>
                <td style="width: 25%; font-weight: bold">
                    <?php foreach ($land_class_groups as $key => $value) {
                        if($value->id == $caseDetails->proposed_land)
                        {
                            echo $value->name;
                        }
                        ?>
                    <?php }  ?>
                </td>
            </tr>
            <tr>
                <th style="width: 25%">Name of the Institution</th>
                <td style="width: 25%; font-weight: bold"><?php echo $caseDetails->ins_name ?></td>

                <th style="width: 25%">Department Name</th>
                <td style="width: 25%; font-weight: bold"><?php echo $caseDetails->dept_name ?></td>
            </tr>
            <tr>
                <th style="width: 25%">Directorate Name</th>
                <td style="width: 25%; font-weight: bold"><?php echo $caseDetails->directorate_name ?></td>

                <th style="width: 25%">Entity of</th>
                <td style="width: 25%; font-weight: bold">
                    <?php if($caseDetails->entity == 8): ?>
                        State Govt. Dept
                    <?php elseif($caseDetails->entity == 9): ?>
                        State Govt. Undertaking
                    <?php elseif($caseDetails->entity == 10): ?>
                        Central Govt Dept.
                    <?php elseif($caseDetails->entity == 11): ?>
                        Central Govt. Undertaking
                    <?php else: ?>
                        Non govt.
                    <?php endif; ?>
                </td>
            </tr>

        </table>
    </div>


<?php endif; ?>
