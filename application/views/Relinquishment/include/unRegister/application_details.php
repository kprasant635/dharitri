<div class="tableCard">
    <table class="table table-bordered">
        <tr>
            <th style="width: 25%">Application No.</th>
            <td style="width: 25%; font-weight: bold"><?php echo $case_no ?></td>
            <th style="width: 25%">Reference No.</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->ref_no ?></td>

        </tr>
        <tr>
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
            <th style="width: 25%">Pending Office</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->pending_at_office ?></td>
        </tr>
        <tr>
            <th style="width: 25%">Applied On</th>
            <td style="width: 25%; font-weight: bold">
                <?php echo date('d-m-Y', strtotime($basic->date_submission)); ?>
            </td>
            <th style="width: 25%">Applied In</th>
            <td style="width: 25%; font-weight: bold"><?php echo $basic->app_from ?></td>
        </tr>
        <?php foreach ($settlements as $settlement): ?>
            <?php if($settlement->is_applicant == '1'): ?>
                <tr>
                    <th style="width: 25%">Applied For</th>
                    <td style="width: 25%; font-weight: bold">

                        <?php if($settlement->relinquish_id == 1) : ?>
                            JJM
                        <?php elseif($settlement->relinquish_id == 2) : ?>
                            Tea Garden
                        <?php elseif($settlement->relinquish_id == 99) : ?>
                            Others
                        <?php else : ?>
                            --
                        <?php endif; ?>

                    </td>
                    <th style="width: 25%">Department Name</th>
                    <td style="width: 25%; font-weight: bold"><?php $deptName = $settlement->dept_name; echo $deptName ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

    </table>
</div>
