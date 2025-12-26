<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">List Of Newly added Pattadar(s) Count</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="form-group">
                        <a class="btn btn-primary" 
                            href="<?= base_url('index.php/ReportController/downloadExcel?perm=pattadar') ?>"><i class="fa fa-download"></i> Export to Excel
                        </a>
                    </div>
                    
                    <table class="table table-striped tab1">
                        <thead>
                            <tr>
                                <th>SL. No.</th>
                                <th>District Name</th>
                                <th>Circle Name</th>
                                <th>Village Name</th>
                                <th>uuid</th>
                                <th>Count(two years)</th>
                                <th>Count(bari)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- "district_name"	"circle_name"	"village_name"	"uuid"	"cnt" -->
                        <tbody>
                            <?php foreach($records as $key=>$rec): ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $rec->district_name ?></td>
                                    <td><?= $rec->circle_name ?></td>
                                    <td><?= $rec->village_name ?></td>
                                    <td><?= $rec->uuid ?></td>
                                    <td><?= $rec->two_years_count ?></td>
                                    <td><?= $rec->bari_count ?></td>
                                    <td>
                                        <a href="<?= base_url('index.php/ReportController/PattadarDetails?uuid=' . $rec->uuid) ?>" class="btn btn-primary btn-sm">
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


