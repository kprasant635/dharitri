<div class="container">
    <?php if ($success == 0) { ?>
        <h4 class="text-center bg-danger"><?= $error_msg ?></h4>
        <?php } elseif ($success == 1) {
        if ($certmnemonic == 'SD') {
        ?>
            <div class="sale_deed">
                <h4>General Details</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Document no.:</th>
                        <td><?= $trans_data->document_no ?></td>
                    </tr>
                    <th>Receipt no.:</th>
                    <td><?= $trans_data->receipt_no ?></td>
                    </tr>
                    <th>Applicant name:</th>
                    <td><?= $trans_data->applicant_name ?></td>
                    </tr>
                    <th>Deed type:</th>
                    <td><?= $trans_data->deed_type ?></td>
                    </tr>
                    <th>Submission date:</th>
                    <td><?= $trans_data->submission_date ?></td>
                    </tr>
                    <th>Approved date:</th>
                    <td><?= $trans_data->approved_date ?></td>
                    </tr>
                </table>


                <h4>Land Details</h4>
                <table class="table table-bordered">
                    <?php foreach ($trans_data->land_details as $key => $land) { ?>
                        <tr>
                            <th colspan="2"># <?= $key + 1 ?></th>
                            <td><?= $land->bigha ?>B-<?= $land->katha ?>K-<?= $land->lessa ?>L</td>
                        </tr>
                    <?php } ?>
                </table>

                <h4>Party Details</h4>
                <table class="table table-bordered">
                    <?php foreach ($trans_data->party_details as $key1 => $party) {
                        $party_address = $party->house . ', ' . $party->village . ', ' . $party->po . ', ' . $party->ps . ', ' . $party->district . ', ' . $party->state;
                    ?>
                        <tr>
                            <th colspan="2"># <?= $key1 + 1 ?></th>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td><?= $party->name ?></td>
                        </tr>
                        <tr>
                            <th>Father name:</th>
                            <td><?= $party->father_name ?></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><?= $party_address ?></td>
                        </tr>
                        <tr>
                            <th>Type:</th>
                            <td><?= $party->type ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <h4>Witness Details</h4>
                <table class="table table-bordered">
                    <?php foreach ($trans_data->witness_details as $key1 => $witness) {
                    ?>
                        <tr>
                            <th colspan="2"># <?= $key1 + 1 ?></th>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td><?= $witness->name ?></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><?= $witness->address ?></td>
                        </tr>
                        <tr>
                            <th>Type:</th>
                            <td><?= $witness->type ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>পট্টাদাৰৰ নাম</th>
                        <th>পিতাৰ নাম</th>
                    </tr>
                </thead>

                <?php
                $cuurentPdarscount = sizeof($current_trans_pdars);
                foreach ($trans_data->pid as $pattadar) {
                    $i = 0;

                ?>
                    <?php if ($certmnemonic == 'MUT' || $certmnemonic == 'PRT') {
                    ?>
                        <?php foreach ($current_trans_pdars as $current_pdar) {
                            $bg_class = "";

                            // var_dump(trim($current_pdar->pet_name));

                        ?>
                            <?php if ($pattadar->pdarid == $current_pdar->pdar_id || trim($pattadar->pdarname) == trim($current_pdar->pdar_name) || trim($pattadar->pdarname) == trim($current_pdar->pdar_name)) {
                                $bg_class = "";
                            ?>
                                <?php //if (++$i == $cuurentPdarscount) { 
                                ?>
                                <tr class="<?= $bg_class ?>">
                                    <td>
                                        <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                            <s class="text-danger"><?= $pattadar->pdarname ?></s>
                                        <?php } else { ?>
                                            <?= $pattadar->pdarname ?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                            <s class="text-danger"><?= $pattadar->pdarfather ?></s>
                                        <?php } else { ?>
                                            <?= $pattadar->pdarfather ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php //} 
                                ?>
                                <?php
                            } else {
                                $bg_class = "bg-secondary";
                                if (++$i == $cuurentPdarscount) {
                                ?>
                                    <tr class="<?= $bg_class ?>">
                                        <td>
                                            <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                                <s class="text-danger"><?= $pattadar->pdarname ?></s>
                                            <?php } else { ?>
                                                <?= $pattadar->pdarname ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                                <s class="text-danger"><?= $pattadar->pdarfather ?></s>
                                            <?php } else { ?>
                                                <?= $pattadar->pdarfather ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php }
                            }
                            ?>

                        <?php } ?>
                    <?php } else {
                    ?>
                        <tr>
                            <td>
                                <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                    <s class="text-danger"><?= $pattadar->pdarname ?></s>
                                <?php } else { ?>
                                    <?= $pattadar->pdarname ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                    <s class="text-danger"><?= $pattadar->pdarfather ?></s>
                                <?php } else { ?>
                                    <?= $pattadar->pdarfather ?>
                                <?php } ?>
                            </td>
                        </tr>
                <?php  }
                } ?>
            </table>
    <?php }
    } ?>
</div>

<style>
    .deed_sale>.table>tr>td {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .table {
        max-width: 100%;
    }
</style>