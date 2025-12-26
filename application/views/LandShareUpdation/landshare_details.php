<!-- Implementation of Land Share Details -->
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Radio Navigation -->
<style>
    article {
        height: 200px;
        display: none;
    }

    article.on {
        display: block;
    }

    /* body {
        padding-right: 0 !important
    } */
</style>
<center>
    <div class="panel-body mb-2">
        <input type="radio" id="radioTab1" name="tab" checked>
        <label for="radioTab1" class="mr-4">Land Share Details Pending List(Dag Wise)</label>
        <input type="radio" id="radioTab2" name="tab">
        <label for="radioTab2" class="mr-4">Land Share Details Added List(Dag Wise)</label>
        <input type="radio" id="radioTab3" name="tab">
        <label for="radioTab3" class="mr-4">Revert Back from CO</label>
    </div>
    <div class="panel panel-danger panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">
                Village Name :
                <?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code); ?>
            </h3>
        </div>
    </div>
</center>
<article>
    <!-- Pending Zonal Details -->
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Land Share Details Not Added List(Dag Wise)
                </h3>
            </div>
            <div id="land_share_details_not_added_list" class="tab-pane in active">
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' class="display nowrap" id='datatable-pending' width="100%">
                        <thead>
                            <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                            <th scope="col" class="center"><label class="control-label">Patta No</label></th>
                            <th scope="col" class="center"><label class="control-label">Patta Type</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Bigha)</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Katha)</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Lessa)</label></th>
                            <th scope="col" class="center"><label class="control-label">Action</label></th>

                        </thead>
                        <tbody>
                            <?php foreach ($pendinglandsharedetials as $details) : ?>
                                <tr>
                                    <td width="10%" class="center"><b><?php echo  $details['dag_no'] ?></b></td>
                                    <td width="10%" class="center"><?php echo  $details['patta_no'] ?></td>
                                    <td width="20%" class="center"><?= $this->utilityclass->getPattaName($details['patta_type_code']) ?></td>
                                    <td class="center"><?php echo $details['dag_area_b'] ?></td>
                                    <td class="center"><?php echo $details['dag_area_k'] ?></td>
                                    <td class="center"><?php echo $details['dag_area_lc'] ?></td>
                                    <td width="25%" class="center">
                                        <button class="btn btn-success btn-sm" onclick="getLandShareAddFormModal('<?= $details['dag_no'] ?>','<?= $details['patta_no'] ?>','<?= $details['dag_area_b'] ?>','<?= $details['dag_area_k'] ?>','<?= $details['dag_area_lc'] ?>')">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            Add Land Share Details
                                        </button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Zonal Details End -->
</article>
<article>
    <!-- Already Filled Zonal Details -->
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Land Share Details Already Added List(Dag Wise)
                </h3>
            </div>
            <div id="land_share_details_added_list" class="tab-pane in active">
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable-filled' width="100%">
                        <thead>
                            <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                            <th scope="col" class="center"><label class="control-label">Patta Type</label></th>
                            <th scope="col" class="center"><label class="control-label">Details</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Bigha)</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Katha)</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Lessa)</label></th>
                            <th scope="col" class="center"><label class="control-label">Status</label></th>
                        </thead>
                        <tbody>
                            <?php foreach ($updatedlandsharedetials as $details) : ?>
                                <tr>
                                    <td width="10%" class="center"><?php echo  $details['dag_no'] ?></td>
                                    <td width="20%" class="center"><?= $this->utilityclass->getPattaName($details['patta_type_code']) ?></td>
                                    <td class="center"><button class="btn btn-secondary btn-sm" onclick="viewLandShareDetailsForm('<?= $details['dag_no'] ?>','<?= $details['dag_area_b'] ?>','<?= $details['dag_area_k'] ?>','<?= $details['dag_area_lc'] ?>')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            View Details
                                        </button>
                                    </td>
                                    <td class="center"><?php echo $details['dag_area_b'] ?></td>
                                    <td class="center"><?php echo $details['dag_area_k'] ?></td>
                                    <td class="center"><?php echo $details['dag_area_lc'] ?></td>
                                    <td width="20%" class="text-center">
                                        <!-- <button class="btn btn-warning btn-sm" onclick="getLandShareEditFormModal('<?= $details['dag_no'] ?>')">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                            edit
                                        </button> -->
                                        <?php if ($details['flag'] == 0) : ?>
                                            <span class="center text-primary">Sent For CO Approval</span>
                                        <?php elseif ($details['flag'] == 1) : ?>
                                            <span class="center text-success">Approved</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Already Filed Zonal Details  End -->
</article>
<article>
    <!-- Table Data of Reverted Back by CO -->
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Reverted Land Share List(Dag Wise)
                </h3>
            </div>
            <div id="land_share_details_reverted_list" class="tab-pane in active">
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable-reverted' width="100%">
                        <thead>
                            <th scope="col" class="center"><label class="control-label">Dag No</label></th>
                            <th scope="col" class="center"><label class="control-label">Patta Type</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Bigha)</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Katha)</label></th>
                            <th scope="col" class="center"><label class="control-label">Dag Area(Lessa)</label></th>
                            <th scope="col" class="center"><label class="control-label">Action</label></th>
                        </thead>
                        <tbody>
                            <?php foreach ($revertedlandsharedetials as $details) : ?>
                                <tr>
                                    <td width="10%" class="center"><?php echo  $details['dag_no'] ?></td>
                                    <td width="20%" class="center"><?= $this->utilityclass->getPattaName($details['patta_type_code']) ?></td>
                                    <td class="center"><?php echo $details['dag_area_b'] ?></td>
                                    <td class="center"><?php echo $details['dag_area_k'] ?></td>
                                    <td class="center"><?php echo $details['dag_area_lc'] ?></td>
                                    <td width="30%" class="text-center">
                                        <button class="btn btn-warning btn-sm" onclick="getLandShareEditFormModal('<?= $details['dag_no'] ?>','<?= $details['dag_area_b'] ?>','<?= $details['dag_area_k'] ?>','<?= $details['dag_area_lc'] ?>')">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                            Reupdate Land Share
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Table Data of Reverted back by CO -->
</article>
<!-- Modal for Zonal Details ReUpdate by LM -->

<!-- Modal for Zonal Details ReUpdate by LM  End-->

<!-- Radio Nav End -->

<!-- Datatable Script -->
<script>
    $(document).ready(function() {

        $('#datatable-pending').DataTable({
            "pageLength": 20,
            "order": [1, "asc"],

        });
        $('#datatable-filled').DataTable({
            "pageLength": 20,
            "order": [0, "asc"]
        });
        $('#datatable-reverted').DataTable({
            "pageLength": 20,
            "order": [0, "asc"]
        });

    });
</script>
<!-- Datatable Script End -->
<!-- Radio Button Alter Tab Function Start -->
<script>
    $('[name=tab]').each(function(i, d) {
        var p = $(this).prop('checked');
        //   console.log(p);
        if (p) {
            $('article').eq(i)
                .addClass('on');
        }
    });

    $('[name=tab]').on('change', function() {
        var p = $(this).prop('checked');
        var i = $('[name=tab]').index(this);

        $('article').removeClass('on');
        $('article').eq(i).addClass('on');
    });
</script>
<!-- Radio Button Alter Function End -->
<!-- land share details add modal  -->
<?php include 'land_share_details_add_form.php'; ?>
<!-- land share view modal  -->
<?php include 'land_share_details_view_form.php'; ?>
<!-- land share update modal  -->
<?php include 'land_share_details_update_form.php'; ?>

<script src="<?php echo base_url(); ?>application/views/js/land_share/land_share.js"></script>