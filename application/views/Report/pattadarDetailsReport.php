<div class="row login">
    <div class="col-lg-12 ">
        <div>
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">List Of Newly added Pattadar(s) List</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="form-group">
                        <a class="btn btn-primary" 
                            href="<?= base_url('index.php/ReportController/downloadExcel?perm=pattadar-details&uuid='.$uuid) ?>"><i class="fa fa-download"></i> Export to Excel
                        </a>
                    </div>
                    
                    <table class="table table-striped tab1">
                        <thead>
                            <tr>
                                <th>dist_name</th>
                                <th>cir_name</th>
                                <th>village_name</th>
                                <th>patta_type</th>
                                <th>patta_no</th>
                                <th>dag_no</th>
                                <th>land_type</th>
                                <th>uuid</th>
                                <th>pdar_name</th>
                                <th>pdar_father</th>
                            </tr>
                        </thead>
                        <!-- "district_name"	"circle_name"	"village_name"	"uuid"	"cnt" -->
                        <tbody>
                            <?php foreach($records as $key=>$rec): ?>
                                <tr>
                                    <td><?=$rec->dist_name?></td>
                                    <td><?=$rec->cir_name?></td>
                                    <td><?=$rec->village_name?></td>
                                    <td><?=$rec->patta_type?></td>
                                    <td><?=$rec->patta_no?></td>
                                    <td><?=$rec->dag_no?></td>
                                    <td><?=$rec->land_type?></td>
                                    <td><?=$rec->uuid?></td>
                                    <td><?=$rec->pdar_name?></td>
                                    <td><?=$rec->pdar_father?></td>
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


