<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Composite Service Case Details</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <div class="col-lg-12 center">
                                    <div class="form-group" style="text-align: center">
                                        <a class="btn btn-success uni_text astreport"
                                           href="<?php echo base_url() . "index.php/officemutation/asstReport1?case_no=" . $pb->case_no . "&dist_code=" . $pb->dist_code . "&subdiv_code=" . $pb->subdiv_code . "&cir_code=" . $pb->cir_code . "&mouza_pargona_code=" . $pb->mouza_pargona_code . "&lot_no=" . $pb->lot_no . "&vill_townprt_code=" . $pb->vill_townprt_code; ?>"><i
                                                    class='fa fa-list-alt'></i>&nbsp; View Assistant Report</a>
                                    </div>
                                </div>

                                <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                     id='skmodal'>
                                    <div class="modal-dialog modal-lg" style=" overflow-y: auto;">
                                        <div class="modal-content" style=" overflow-y: auto;">
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <th colspan="6" style="background-color: #136a6f; color: #fff">Location
                                        Details
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>District</td>
                                        <td>
                                            <?php echo $this->utilityclass->getDistrictName($pb->dist_code); ?>
                                        </td>
                                        <td>Subdivision</td>
                                        <td>
                                            <?php echo $this->utilityclass->getSubDivName($pb->dist_code,
                                                $pb->subdiv_code); ?>
                                        </td>
                                        <td>Circle</td>
                                        <td>
                                            <?php echo $this->utilityclass->getCircleName($pb->dist_code,
                                                $pb->subdiv_code, $pb->cir_code); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mouza</td>
                                        <td><?php echo $this->utilityclass->getMouzaName($pb->dist_code,
                                                $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code) ?>
                                        </td>
                                        <td>Lot No</td>
                                        <td><?php echo $this->utilityclass->getLotName($pb->dist_code,
                                                $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code,
                                                $pb->lot_no); ?>
                                        </td>
                                        <td>Village / Town</td>
                                        <td><?php echo $this->utilityclass->getVillageName($pb->dist_code,
                                                $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code,
                                                $pb->lot_no, $pb->vill_townprt_code); ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <th style="background-color: #136a6f; color: #fff" colspan="4">Basic Order
                                        Details
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>NOC No:</td>
                                        <td>
                                                <span class="text-danger">
                                                    <?= $pb->noc_no ?>
                                                </span>
                                        </td>
                                        <td>NOC Entry Date:</td>
                                        <td class="text-danger"><?= $noc_case->appdate; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mutation</td>
                                        <td class="text-danger">YES</td>
                                        <td>Partition</td>
                                        <td class="text-danger"><?= ($noc_case->automut == 'P') ? 'YES' : 'NO'; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?php if ($pb->trans_code == '03'): ?>
                                    <table class="table table-striped table-bordered text-bold">
                                        <thead>
                                        <th colspan="3" style="background-color: #136a6f; color: #fff">Deed
                                            Details
                                        </th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="text-bold text-danger">Deed No. : <?= $pb->deed_no ?></span>
                                            </td>
                                            <td>
                                                <span class="text-bold text-danger">Deed Date : <?= $pb->deed_date ?></span>
                                            </td>
                                            <td>
                                                <span class="text-bold text-danger">Deed Value :<?= $pb->deed_value ?></span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                <?php endif; ?>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                    <th style="background-color: #136a6f; color: #fff" colspan="4">Mutation Case Details
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Mutation Case No:</td>
                                        <td><span class="text-danger"><?= $pb->case_no ?></span></td>
                                        <td>Order Status:</td>
                                        <td>
                                                <span class="text-danger">
                                                    <?php if ($pb->status == "F"): ?>
                                                        Passed
                                                    <?php elseif ($pb->status == "P"): ?>
                                                        Pending
                                                    <?php elseif ($pb->status == "H"): ?>
                                                        Holded
                                                    <?php elseif ($pb->status == "R"): ?>
                                                        Rejected
                                                    <?php endif; ?>
                                                </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mutation Type:</td>
                                        <td>
                                                <span class="text-danger">
                                                    <?= $this->utilityclass->getOfficeMutType($pb->mut_type) ?>
                                                </span>
                                        </td>
                                        <td>Transfer Type:</td>
                                        <td>
                                            <span class="text-danger"><?= $this->utilityclass->getTransferType($pb->trans_code) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>LM Name:</td>
                                        <td>
                                                <span class="text-danger">
                                                <?php $lmcode = $lm_code;
                                                $lms = $this->utilityclass->getDefinedMondalsName($pb->dist_code,
                                                    $pb->subdiv_code, $pb->cir_code,
                                                    $pb->mouza_pargona_code, $pb->lot_no, $lmcode);
                                                echo $lms->lm_name;
                                                ?>
                                                </span>
                                        </td>
                                        <td>LM Sign Date:</td>
                                        <td>
                                            <span class="text-danger"><?= date('d-m-Y', strtotime($lm_note_date)) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CO Name:</td>
                                        <td>
                                                <span class="text-danger">
                                                <?php $coname = $this->utilityclass->getCOCode($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->add_off_name);
                                                echo $coname->username;
                                                ?>
                                                </span>
                                        </td>
                                        <td>CO Sign Date:</td>
                                        <td><span class="text-danger"><?php if (isset($pb->date_of_order)) {
                                                    echo date('d-m-Y', strtotime($pb->date_of_order));
                                                } ?></span></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <?php if ($pb->status == 'H'): ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="100%">
                                            Holding Reason
                                        </th>
                                        </thead>
                                        <thead style="white-space:nowrap; width:100%">
                                        </thead>
                                        <tbody>
                                        <tr class="text-bold table-success">
                                            <th> <?= $hold_reason ?></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                <?php elseif ($pb->status == 'D'): ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="100%">
                                           Mutation Rejected Reason
                                        </th>
                                        </thead>
                                        <thead style="white-space:nowrap; width:100%">
                                        </thead>
                                        <tbody>
                                        <tr class="text-bold table-success">
                                            <th> <?= $rejected_reason ?></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                <?php endif; ?>

                                <?php if ($noc_case->automut == "P" && $pb->status == "F"): ?>
                                    <?php foreach ($part_cases as $key => $p): ?>
                                        <table class="table table-striped table-bordered text-bold">
                                            <thead>
                                            <th style="background-color: #136a6f; color: #fff" colspan="4">#<?= ++$key; ?>.
                                                Partition Case Details
                                            </th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Partition Case No:</td>
                                                <td><span class="text-danger"><?= $p->case_no ?></span></td>
                                                <td>Order Status:</td>
                                                <td>
                                                <span class="text-danger">
                                                    <?php if ($p->status == "F"): ?>
                                                        Passed
                                                    <?php elseif ($p->status == "P"): ?>
                                                        Pending
                                                    <?php elseif ($p->status == "D"): ?>
                                                        Rejected
                                                    <?php endif; ?>
                                                </span>
                                                </td>
                                            </tr>
                                            <?php if($p->status == 'D'): ?>
                                            <tr>
                                                <td>Rejected Reason:</td>
                                                <td colspan="3"><span class="text-danger"><?= $p->remarks ?></span></td>
                                            </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                            </div>


                            <div class="col-lg-12">
                                <center>
                                    <a href="<?= base_url() ?>index.php/CompositeService/compServiceCaseSearch"
                                       class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;Back To Previous Page
                                    </a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.panel').on('click', '.astreport', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#skmodal .modal-content').html(data);
                    $('#skmodal').modal('show');
                }
            });
        });

        $('#skmodal').on('hidden.bs.modal', function () {
            $('body').css('padding-right', 0);
        })
    });
</script>