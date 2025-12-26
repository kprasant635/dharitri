<div class="tableCard">
    <table class="table table-bordered" >
        <tr>
            <th style="width: 10%;">SL No.</th>
            <th style="width: 60%;">File Name</th>
            <th style="width: 30%;">Download</th>
        </tr>
        <tbody>
        <tr>
            <td><?php $slNo = 1;  echo $slNo?></td>
            <td>Copy of the proposal with all supportive documents</td>
            <td>
                <a href="<?php echo base_url(); ?>index.php/OfflineSettlementCommonController/getViewOfflineUploadedMinutes/?fileId=<?php echo $caseDetails->id; ?>&type=1"
                   class="rezaButt buttCust btn-sm " target="ViewDocument">
                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download
                </a>
            </td>
        </tr>
        <tr>
            <td><?php echo $slNo += 1; ?></td>
            <td>Copy of the Minutes of SDLAC Meeting</td>
            <td>
                <a href="<?php echo base_url(); ?>index.php/OfflineSettlementCommonController/getViewOfflineUploadedMinutes/?fileId=<?php echo $caseDetails->id; ?>&type=2"
                   class="rezaButt buttCust btn-sm " target="ViewDocument">
                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download
                </a>
            </td>
        </tr>
        <?php if(count($documents) != 0): ?>
        <?php $slNo += 1; foreach ($documents as $document): ?>
            <tr>
                <td><?php echo $slNo ; ?></td>
                <td><?php echo $document->file_name ?></td>
                <td>
                    <a href="<?php echo base_url(); ?>index.php/OfflineSettlementCommonController/getViewSupportiveDocs/?fileId=<?php echo $document->id; ?>"
                       class="rezaButt buttCust btn-sm " target="ViewDocument">
                        <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download
                    </a>
                </td>
            </tr>
            <?php $slNo = $slNo += 1; endforeach;?>
        <?php endif; ?>
        </tbody>
    </table>
</div>