<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">List Of Agriculture Pattas</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="form-group">
                        <a class="btn btn-primary" 
                            href="<?= base_url('index.php/AgricultureCountController/downloadExcel') ?>"><i class="fa fa-download"></i> Download Excel
                        </a>
                    </div>
                    
                    <table class="table table-striped tab1">
                        <thead>
                            <tr>
                                <th>SL. No.</th>
                                <th>Circle Name</th>
                                <th>Village Name</th>
                                <th>No. Of Agri Dags</th>
                                <th>No of Pattadar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($records as $key=>$rec): ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $rec->cir_name ?></td>
                                    <td><?= $rec->vill_name ?></td>
                                    <td><?= $rec->dags_count ?></td>
                                    <td><?= $rec->pattadars_count ?></td>
                                    <td>
                                        <a href="<?= base_url('index.php/AgricultureCountController/pattadarDetails?dist_code=' . $rec->dist_code . '&subdiv_code=' . $rec->subdiv_code . '&cir_code=' . $rec->cir_code . '&mouza_pargona_code=' . $rec->mouza_pargona_code . '&lot_no=' . $rec->lot_no . '&vill_code=' . $rec->vill_townprt_code) ?>" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View Pattadar(s)
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



<script type="text/javascript">
    $(document).ready(function() {
        $('.tab1').DataTable({
            pageLength: 100
        });
    });
</script>


