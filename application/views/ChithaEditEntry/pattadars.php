<script>
    $(function () {
        $('.delete').click(function (e) {
            e.preventDefault();
            var saveObj = $(this);
            var id = $(this).attr('data-attr');

            if (!(confirm("Are you sure to delete this pattadar"))) {
                return false;
            }
            $.ajax({
                url: baseurl + "chithaeditentry/deletepattadars",
                data: {
                    id: id,
                },
                method: 'post',
                success: function () {
                    alert("Deleted Pattadar");
                    saveObj.parent().parent().remove();
                },
                error: function () {
                    alert("Error Occured. Could not delete Pattadar");
                }
            });

        });

        $('.strike').click(function (e) {
            e.preventDefault();
            var saveObj = $(this);
            var id = $(this).attr('data-attr');

            if (!(confirm("Are you sure to delete this pattadar"))) {
                return false;
            }
            $.ajax({
                url: baseurl + "chithaeditentry/strikeoutPattadar",
                data: {
                    id: id,
                },
                method: 'post',
                success: function () {
                    alert("Deleted Pattadar");
                    saveObj.parent().parent().remove();
                },
                error: function () {
                    alert("Error Occured. Could not delete Pattadar");
                }
            });

        });
        
        
        
         $('.unstrike').click(function (e) {
            e.preventDefault();
            var saveObj = $(this);
            var id = $(this).attr('data-attr');

            if (!(confirm("Are you sure to delete this pattadar"))) {
                return false;
            }
            $.ajax({
                url: baseurl + "chithaeditentry/unstrikeoutPattadar",
                data: {
                    id: id,
                },
                method: 'post',
                success: function () {
                    alert("Deleted Pattadar");
                    saveObj.parent().parent().remove();
                },
                error: function () {
                    alert("Error Occured. Could not delete Pattadar");
                }
            });

        });
    });
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Add/Modify Pattadar</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <p><h3  style="color:red">Dag Basic information has been saved/updated.</h3></p>
                        </div>
                        <div class="col-lg-3 pull-right">
                            <a href="<?php echo base_url(); ?>index.php/chithaeditentry/pdaradd" class="btn btn-primary btn-lg">Add New Pattadar</a>

                        </div>
                    </div>
                    <hr>
                    <table class="table table-bordered">
                        <tr>
                            <th>PDAR ID</th>
                            <th>PDAR NAME</th>
                            <th>PDAR GUARDIAN</th>
                            <th>ACTION</th>
                        </tr>
                        <?php foreach ($pattadars as $p): ?>

                            <tr>
                                <?php if (isset($p->newFlag)): ?>
                                    <td style="color:red;" class="id"><?php echo $p->pdar_id; ?></td>
                                    <td style="color:red;"><?php echo $p->pdar_name; ?></td>
                                    <td style="color:red;"><?php echo $p->pdar_father; ?></td>
                                <?php endif; ?>
                                <?php if (!isset($p->newFlag)): ?>
                                    <td ><?php echo $p->pdar_id; ?></td>
                                    <td><?php 
                                      
                                        if($p->p_flag=='0'):?>
                                        
                                            <p><?php echo $p->pdar_name;?> </p>
                                        
                                        <?php endif;?>
                                        <?php if($p->p_flag=='1'):?>
                                        
                                            <p style="text-decoration: line-through;color:red"><?php echo $p->pdar_name;?> </p>
                                        
                                        <?php endif;?>
                                        
                                        </td>
                                    <td><?php 
                                      
                                        if($p->p_flag=='0'):?>
                                        
                                            <p><?php echo $p->pdar_father;?> </p>
                                        
                                        <?php endif;?>
                                        <?php if($p->p_flag=='1'):?>
                                        
                                            <p style="text-decoration: line-through;color:red"><?php echo $p->pdar_father;?> </p>
                                        
                                        <?php endif;?>
                                        
                                        </td>
                                <?php endif; ?>
                                <td>
                                    <a class="btn btn-primary" href="<?php echo base_url() . '/index.php/chithaeditentry/pdaredit/' . $p->pdar_id; ?>">Edit</a>
                
                                    <a data-attr="<?php echo $p->pdar_id; ?>" title="Pattadar Strike Out." class="btn btn-danger " href="<?php echo base_url() . '/index.php/chithaeditentry/strikeoutPattadar/' . $p->pdar_id; ?>">Strike Out</a>
                                    <a data-attr="<?php echo $p->pdar_id; ?>" title="Pattadar Un Strike." class="btn btn-danger " href="<?php echo base_url() . '/index.php/chithaeditentry/unstrikeoutPattadar/' . $p->pdar_id; ?>">Un Strike Out</a>
                                    <a data-attr="<?php echo $p->pdar_id; ?>" class="btn btn-danger delete" href="<?php echo base_url() . '/index.php/chithaeditentry/deletePattadar/' . $p->pdar_id; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div style="text-align: center">
                    <div style="text-align: center">
                        <a class="btn btn-primary " href="<?php echo base_url(); ?>index.php/chithaeditentry/orderList">Next</a>
                        <a href="<?php echo base_url().'index.php/chithaeditentry/basicdetails';?>" class="btn btn-danger">Prev</a>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>