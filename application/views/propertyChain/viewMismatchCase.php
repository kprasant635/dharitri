<style type="text/css">
    input[type=text] {
        border: 1px solid #000;
    }
</style>
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">
    <div id="loader" style="display:none;"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-body  bg-primary">
                <div class="row">
                    <div class="col-lg-6">
                        <h5>Case No: <?= $case_no ?></h5>
                    </div>
                    <div class="col-lg-6">
                        <?php if ($property_chain_status == 0) { ?>
                            <h5 class="text-danger">Property Id: <i class="fa fa-warning"></i> Error: unable to fetch property chain data</h5>
                        <?php } elseif ($property_chain_status == null) {
                        ?>
                            <h5 class="text-danger">Property Id: <i class="fa fa-warning"></i> Error: Unable to connect to property chain</h5>
                        <?php } else { ?>
                            <h5>Property Id: <?= $property_id ?></h5>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">

            <div class="panel panel-info">
                <div class="panel-header text-center">
                    <h1 class="text-primary">Chitha Data</h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h5>Land Details</h5>
                        <table class="table">
                            <tr>
                                <td>Dag No</td>
                                <td><?= $chitha_data['dag_no'] ?><?php if ($chitha_data['dag_no'] != $chain_data['dag_no']) {
                                                                        echo $error_span;
                                                                    } ?></td>
                            </tr>
                            <tr>
                                <td>Patta No</td>
                                <td><?= $chitha_data['patta_no'] ?><?php if ($chitha_data['patta_no'] != $chain_data['patta_no']) {
                                                                        echo $error_span;
                                                                    } ?></td>
                            </tr>
                            <tr>
                                <td>Patta Type</td>
                                <td><?= $this->utilityclass->getPattaName($chitha_data['patta_type_code']) ?><?php if ($chitha_data['patta_type_code'] != $chain_data['patta_type_code']) {
                                                                                                                    echo $error_span;
                                                                                                                } ?></td>
                            </tr>
                            <tr>
                                <td>Land Class</td>
                                <td><?= $this->utilityclass->getLandClassCode($chitha_data['landclass_code']) ?><?php if ($chitha_data['landclass_code'] != $chain_data['landclass_code']) {
                                                                                                                    echo $error_span;
                                                                                                                } ?></td>
                            </tr>
                            <tr>
                                <td>Bigha</td>
                                <td><?= $chitha_data['bigha'] ?><?php if ($chitha_data['bigha'] != $chain_data['bigha']) {
                                                                    echo $error_span;
                                                                } ?></td>
                            </tr>

                            <tr>
                                <td>Katha</td>
                                <td><?= $chitha_data['katha'] ?><?php if ($chitha_data['katha'] != $chain_data['katha']) {
                                                                    echo $error_span;
                                                                } ?></td>
                            </tr>
                            <tr>
                                <td>Lessa</td>
                                <td><?= $chitha_data['lessa'] ?><?php if ($chitha_data['lessa'] != $chain_data['lessa']) {
                                                                    echo $error_span;
                                                                } ?></td>
                            </tr>

                        </table>
                    </div>
                    <div class="row">
                        <h5>Pattadars <?php
                                        if ((sizeof($chain_data['pattadars']) != sizeof($chitha_data['pattadars'])) || base64_encode(json_encode($chain_data['pattadars'])) != base64_encode(json_encode($chitha_data['pattadars']))) {
                                            echo $error_span;
                                        } ?></h5>
                        <table class="table" id="chitha_pattadars">
                            <thead>
                                <tr>
                                    <th>Sl no#</th>
                                    <th>Pattadar</th>
                                    <th>Pattadar Father</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($chitha_data['pattadars'] as $key => $pattadar) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <?php if ($pattadar['pdarstrikeout'] == 1) { ?>
                                            <td><s class="text-danger"><?= $pattadar['pdarname'] ?></s></td>
                                            <td><s class="text-danger"><?= $pattadar['pdarfather'] ?></s></td>
                                        <?php } else { ?>
                                            <td><?= $pattadar['pdarname'] ?></td>
                                            <td><?= $pattadar['pdarfather'] ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6">

            <div class="panel panel-info">
                <div class="panel-header text-center">
                    <h1 class="text-primary">Property Chain Data</h1>
                </div>
                <div class="panel-body">
                    <?php if ($property_chain_status == 0) { ?>
                        <h1 class="text-danger"><i class="fa fa-warning"></i> Error: unable to fetch property chain data</h1>
                    <?php } elseif ($property_chain_status == null) {
                    ?>
                        <h1 class="text-danger"><i class="fa fa-warning"></i> Error: Unable to connect to property chain</h1>
                    <?php } else { ?>
                        <div class="row">
                            <h5>Land Details</h5>
                            <table class="table">
                                <tr>
                                    <td>Dag No</td>
                                    <td><?= $chain_data['dag_no'] ?><?php if ($chitha_data['dag_no'] != $chain_data['dag_no']) {
                                                                        echo $error_span;
                                                                    } ?></td>
                                </tr>
                                <tr>
                                    <td>Patta No</td>
                                    <td><?= $chain_data['patta_no'] ?><?php if ($chitha_data['patta_no'] != $chain_data['patta_no']) {
                                                                            echo $error_span;
                                                                        } ?></td>
                                </tr>
                                <tr>
                                    <td>Patta Type</td>
                                    <td><?= $this->utilityclass->getPattaName($chain_data['patta_type_code']) ?><?php if ($chitha_data['patta_type_code'] != $chain_data['patta_type_code']) {
                                                                                                                    echo $error_span;
                                                                                                                } ?></td>
                                </tr>
                                <tr>
                                    <td>Land Class</td>
                                    <td><?= $this->utilityclass->getLandClassCode($chain_data['landclass_code']) ?><?php if ($chitha_data['landclass_code'] != $chain_data['landclass_code']) {
                                                                                                                        echo $error_span;
                                                                                                                    } ?></td>
                                </tr>
                                <tr>
                                    <td>Bigha</td>
                                    <td><?= $chain_data['bigha'] ?><?php if ($chitha_data['bigha'] != $chain_data['bigha']) {
                                                                        echo $error_span;
                                                                    } ?></td>
                                </tr>

                                <tr>
                                    <td>Katha</td>
                                    <td><?= $chain_data['katha'] ?><?php if ($chitha_data['katha'] != $chain_data['katha']) {
                                                                        echo $error_span;
                                                                    } ?></td>
                                </tr>
                                <tr>
                                    <td>Lessa</td>
                                    <td><?= $chain_data['lessa'] ?><?php if ($chitha_data['lessa'] != $chain_data['lessa']) {
                                                                        echo $error_span;
                                                                    } ?></td>
                                </tr>

                            </table>
                        </div>
                        <div class="row">
                            <h5>Pattadars <?php
                                            if ((sizeof($chain_data['pattadars']) != sizeof($chitha_data['pattadars'])) || base64_encode(json_encode($chain_data['pattadars'])) != base64_encode(json_encode($chitha_data['pattadars']))) {
                                                echo $error_span;
                                            } ?></h5>

                            <table class="table" id="chain_pattadars">
                                <thead>
                                    <tr>
                                        <th>Sl no#</th>
                                        <th>Pattadar</th>
                                        <th>Pattadar Father</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($chain_data['pattadars'] as $key => $pattadar) { ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <?php if ($pattadar->pdarstrikeout == 1) { ?>
                                                <td><s class="text-danger"><?= $pattadar->pdarname ?></s></td>
                                                <td><s class="text-danger"><?= $pattadar->pdarfather ?></s></td>
                                            <?php } else { ?>
                                                <td><?= $pattadar->pdarname ?></td>
                                                <td><?= $pattadar->pdarfather ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#chain_pattadars').DataTable({
        "ordering": false,
        "lengthMenu": [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100]
        ],
    });

    $('#chitha_pattadars').DataTable({
        "ordering": false,
        "lengthMenu": [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100]
        ],
    });
</script>