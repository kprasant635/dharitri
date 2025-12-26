<div class="tableCard">
    <table class="table table-bordered">
        <tr>
            <th style="width: 25%">Application No.</th>
            <td style="width: 25%; font-weight: bold"><?php echo $case_no ?></td>
            <th style="width: 25%">Basundhara Application No.</th>
            <td style="width: 25%; font-weight: bold"><?php echo $application_no ?></td>

        </tr>
        <tr>
            <th style="width: 25%">Reference No.</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->ref_no ?></td>
            <th style="width: 25%">Application Status.</th>
            <td style="width: 25%; font-weight: bold">
                <?php if($basic->status == 'S'): ?>
                    Not Register
                <?php elseif($basic->status == 'F'): ?>
                    Delivered
                <?php else: ?>
                    Under Process
                <?php endif; ?>
            </td>

        </tr>
        <tr>
            <th style="width: 25%">Pending Office </th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->pending_office ?></td>
            <th style="width: 25%">Pending Officer </th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->pending_officer ?></td>
        </tr>
        <tr>
            <th style="width: 25%">Applied On</th>
            <td style="width: 25%; font-weight: bold">
                <?php echo date('d-m-Y', strtotime($basic->submission_date)); ?>
            </td>
            <th style="width: 25%">LM Note </th>
            <td style="width: 25%; font-weight: bold">
                <?php if($basic->status == 'Z'): ?>
                    Submitted
                <?php else: ?>
                    Submitted
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%">Applied For</th>
            <td style="width: 25%; font-weight: bold">
                <?php if($basic->relinquish_id == 1) : ?>
                    JJM
                <?php elseif($basic->relinquish_id == 2) : ?>
                    Tea Garden
                <?php elseif($basic->relinquish_id == 99) : ?>
                    Others
                <?php else : ?>
                    --
                <?php endif; ?>
            </td>
            <th style="width: 25%">Department Name</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->dept_name; ?></td>
        </tr>
    </table>
</div>
