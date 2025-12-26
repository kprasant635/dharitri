<?php foreach ($settlements as $settlement): ?>
    <?php if($settlement->is_applicant == 1): ?>
        <?php if($settlement->relinquish_id == 1) : ?>

            <?php
            $schemeData = json_decode($schemeData[0]->scheme_json, true);
            $scheme     = $schemeData['data'];
            ?>

            <div class="tableCard">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 25%">Scheme ID</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['scheme_id']; ?></td>
                        <th style="width: 25%">Scheme Name</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['scheme_name']; ?></td>
                    </tr>
                    <tr>
                        <th style="width: 25%">Division</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['division']; ?></td>
                        <th style="width: 25%">District</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['district']; ?></td>

                    </tr>
                    <tr>
                        <th style="width: 25%">Blocks</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['blocks']; ?></td>
                        <th style="width: 25%">Panchayat</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['panchayats']; ?></td>

                    </tr>
                    <tr>
                        <th style="width: 25%">Habitations</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['habitations']; ?></td>
                        <th style="width: 25%">Villages</th>
                        <td style="width: 25%; font-weight: bold"><?php echo $scheme['villages']; ?></td>
                    </tr>
                    <tr>
                        <th>Section Officers</th>
                        <td>
                            <?php foreach ($scheme['section_officers'] as $officer): ?>
                                <b><?= $officer['name']; ?> (<?= $officer['phone']; ?>)</b>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
            </div>

        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>