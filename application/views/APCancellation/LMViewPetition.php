<div class="container py-4">
    <!-- Header -->
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-success text-white text-center">
            <?php echo $this->lang->line('view_petition'); ?>
        </div>
    </div>

    <!-- Case Number -->
    <div class="case-box">
        <?php echo $this->lang->line('case_no'); ?> : <strong><?php echo $_GET['case_no']; ?>
    </div>

    <!-- Top Details -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4"><strong>District:</strong> <?php echo $namedata[0]->district; ?></div>
                <div class="col-md-4"><strong>Sub-Division:</strong> <?php echo $namedata[1]->subdiv; ?></div>
                <div class="col-md-4"><strong>Circle:</strong> <?php echo $namedata[2]->circle; ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><strong>Mouza:</strong> <?php echo $namedata[3]->mouza; ?></div>
                <div class="col-md-4"><strong>Lot No:</strong> <?php echo $namedata[4]->lot_no; ?></div>
                <div class="col-md-4"><strong>Village/Town:</strong><?php echo $namedata[5]->village; ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><strong>Submission Date:</strong> <span class="text-primary"><?php
                                                                                                    $d = $_GET['submission_date'];
                                                                                                    echo date("d-m-Y", strtotime($d));
                                                                                                    ?></span></div>
                <div class="col-md-4"><strong>Patta Type:</strong><?php echo $landtype->patta_type; ?></div>
                <div class="col-md-4"><strong>Addressing Officer:</strong><?php
                                                                            $co_name = $this->utilityclass->getSelectedCOName($locations['dist_code'], $locations['subdiv_code'], $locations['cir_code'], $landtype->add_off_name);
                                                                            echo $co_name->username;
                                                                            ?></div>
            </div>
        </div>
    </div>

    <!-- Petition Info -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Petition Information
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Sl No</th>
                        <th>Petitioner Name</th>
                        <th>Guardian Name</th>
                        <th>Relation</th>
                        <th>Address 1</th>
                        <th>Address 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $c = 1;
                    foreach ($petitioninfo as $petitioner) {
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $c; ?></td>
                            <td class="text-center"><?php echo $petitioner->pet_name; ?></td>
                            <td class="text-center"><?php echo $petitioner->guard_name; ?></td>
                            <td class="text-center"><?php echo $this->utilityclass->get_relation($petitioner->guard_rel); ?>
                            </td>
                            <td class="text-center"><?php echo $petitioner->add1; ?></td>
                            <td class="text-center"><?php echo $petitioner->add2; ?></td>
                        </tr>
                    <?php
                        $c++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pattadar Info -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Pattadar Information
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Name</th>
                        <th>Pattadar Name</th>
                        <th>Guardian Name</th>
                        <th>Address 1</th>
                        <th>Address 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //var_dump($pattadars);
                    foreach ($pattadars as $pdar) {
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $pdar->pdar_name; ?></td>
                            <td class="text-center"><?php echo $pdar->pdar_guardian; ?></td>
                            <td class="text-center"><?php echo $this->utilityclass->get_relation($pdar->pdar_rel_guar); ?>
                            </td>
                            <td class="text-center"><?php echo $pdar->pdar_add1; ?></td>
                            <td class="text-center"><?php echo $pdar->pdar_add2; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Dag Info -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Dag Information
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Dag No</th>
                        <th>Patta No</th>
                        <th>Patta Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($daginfo as $dag) { ?>
                        <tr>
                            <td class="text-center"><?php echo $dag->dag_no; ?></td>
                            <td class="text-center"><?php echo $dag->patta_no; ?></td>
                            <td class="text-center"><?php echo $landtype->patta_type; ?></td>
                            <td class="text-center hide">
                                <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $_GET['case_no']; ?>"
                                    target="_blank"><button type="submit" class="btn btn-xs"><span
                                            class="ass-btn"><?php echo $this->lang->line('show_chitha'); ?></span></button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Documents uploaded -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Documents uploaded
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Document</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $document) { ?>
                        <tr>
                            <td class="text-center"><?php echo $document->file_name; ?></td>
                            <td class="text-center">
                                <a href="<?php echo $document->file_path; ?>"
                                    class="btn btn-outline-primary me-2 btn-sm" target="_blank"><i class="bi bi-eye"></i>
                                    View Document</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="javascript:history.back();" class="btn btn-danger">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>