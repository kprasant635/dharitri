<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 ">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">EDIT ALONG WITH</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>Alongwith ID</td>
                            <td>Alongwith  Name</td>
                            <td>Guardian</td>
                            <td>Action</td>
                        </tr>
                        <?php foreach ($all as $a): ?>
                            <tr>
                                <td><?php echo $a->alongwith_id; ?></td>
                                <td><?php echo $a->alongwith_name; ?></td>
                                <td><?php echo $a->alongwith_guardian; ?></td>
                                <td><a href="<?php echo base_url();?>index.php/chithaeditentry/step3edit/<?php echo $a->alongwith_id;?>">Edit</a></td>
                                <td><a href="<?php echo base_url();?>index.php/chithaeditentry/step3delete/<?php echo $a->alongwith_id;?>">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                     <hr>
                    <div class="" style="text-align: center">
                        <a class="btn btn-danger" href="<?php echo base_url();?>index.php/chithaeditentry/step4list">NEXT</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>