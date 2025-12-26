<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaDemandNoticeController/landing_page' ?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajna-Demand Notice(Pending-List)</li>
    </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-secondary text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajna-Dp Demand Notice(Pending-List)</b><br>
            </u>
        </h3>
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">
                <div class="card-body">
                    <table id="demand_list" class="table table-hover text-center" style="width:100%">
                        <thead class="thead-dark">
                            <tr style="background-color: black; color: #fff;">
                                <td>District</td>
                                <td>Circle</td>
                                <td>Mouza</td>
                                <td>Village</td>
                                <td>Patta Type</td>
                                <td>Patta No</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_list as $row): ?>
                                <tr>
                                    
                                        <td>
                                            <span class="font-weight-bold text-danger">
                                                <?= $this->utilityclass->getDistrictName($row->dist_code) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                <?= $this->utilityclass->getCircleName($row->dist_code, $row->subdiv_code, $row->cir_code) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-danger">
                                                <?= $this->utilityclass->getMouzaName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                <?= $this->utilityclass->getVillageName($row->dist_code, $row->subdiv_code, $row->cir_code, $row->mouza_pargona_code, $row->lot_no, $row->vill_townprt_code) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-danger">
                                                <?= $this->utilityclass->getPattaType($row->patta_type_code) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                <?= $row->patta_no ?>
                                            </span>
                                        </td>
                                        <td>
                                        <form method="post" action="<?= base_url('index.php/EkhajanaDemandNoticeController/generateDpDemandNotice') ?>">
                                                <!-- Hidden Fields to Send Data -->
                                                <input type="hidden" name="dist_code" value="<?= $row->dist_code ?>">
                                                <input type="hidden" name="subdiv_code" value="<?= $row->subdiv_code ?>">
                                                <input type="hidden" name="cir_code" value="<?= $row->cir_code ?>">
                                                <input type="hidden" name="mouza_pargona_code" value="<?= $row->mouza_pargona_code ?>">
                                                <input type="hidden" name="lot_no" value="<?= $row->lot_no ?>">
                                                <input type="hidden" name="vill_townprt_code" value="<?= $row->vill_townprt_code ?>">
                                                <input type="hidden" name="patta_type_code" value="<?= $row->patta_type_code ?>">
                                                <input type="hidden" name="patta_no" value="<?= $row->patta_no ?>">

                                                <button type="submit" class="btn btn-success btn-sm text-white" style="font-size: 14px;">
                                                    Generate Notice
                                                    <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </form>
                                            
                                            <br>
                                        
                                                <!-- <form method="post" action="<?= base_url('index.php/EkhajanaDemandNoticeController/generateDpDemandNoticeAssamese') ?>">
                                                    <input type="hidden" name="dist_code" value="<?= $row->dist_code ?>">
                                                    <input type="hidden" name="subdiv_code" value="<?= $row->subdiv_code ?>">
                                                    <input type="hidden" name="cir_code" value="<?= $row->cir_code ?>">
                                                    <input type="hidden" name="mouza_pargona_code" value="<?= $row->mouza_pargona_code ?>">
                                                    <input type="hidden" name="lot_no" value="<?= $row->lot_no ?>">
                                                    <input type="hidden" name="vill_townprt_code" value="<?= $row->vill_townprt_code ?>">
                                                    <input type="hidden" name="patta_type_code" value="<?= $row->patta_type_code ?>">
                                                    <input type="hidden" name="patta_no" value="<?= $row->patta_no ?>">

                                                    <button type="submit" class="btn btn-success btn-sm text-white" style="font-size: 14px;">
                                                        Generate Notice (Assamese)
                                                        <i class="fa fa-arrow-right"></i>
                                                    </button>
                                                </form> -->
                                            </td>
                                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //data table initialisation
        $('#demand_list').dataTable({
            "scrollX": true,
            "lengthMenu": [
                [2, 4, 8, -1],
                [2, 4, 8, "All"]
            ],
            "pageLength": 4,
            //"autoWidth":false,
            responsive: true
        });
    });
</script>