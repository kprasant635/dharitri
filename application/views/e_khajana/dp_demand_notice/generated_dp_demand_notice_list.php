<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaDemandNoticeController/landing_page' ?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajna-Demand Notice(Pending-List)</li>
    </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajna-Dp Demand Notice(Generated-List)</b><br>
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
                            <?php foreach ($generated_list as $row): ?>
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
                                            <a class="btn btn-success btn-sm text-white" target ="_blank"
                                                href="<?php echo base_url() . 'index.php/EkhajanaDemandNoticeController/viewDemandNotice/'.$row->id?>" role="button" style="font-size: 14px;">
                                                View Notice
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
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