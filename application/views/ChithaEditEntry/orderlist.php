<script>
    $(function(){
        $('.delete').click(function(){
            var objSave = $(this);
            if(confirm("Delete Order?"))
           $.ajax({
               url:baseurl+'chithaeditentry/col31orderdelete',
               method:'post',
               data:{
                   ord_no:$(this).attr('data-attr1'),
                   ord_cron:$(this).attr('data-attr2'),
                   rmk_type_hist_no:$(this).attr('data-attr3')
               },
               success:function(){
                   alert('Order Deleted');
                   objSave.parent().parent().remove();
               }
           }) ;
        });
    });
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Add/Modify Order</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 pull-right" style="text-align: center">
                            <a href="<?php echo base_url(); ?>index.php/chithaeditentry/step1" class="btn btn-danger btn-lg">Add Column 31 Order</a>
                            <a href="<?php echo base_url(); ?>index.php/chithaeditentry/colEightOrderAdd" class="btn btn-danger btn-lg">Add Column 8 Order</a>
                            <hr>
                        </div>
                    </div>
                    <div class="well">
                        <h1>Col 8 Orders</h1>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Order Cron No</th>
                            <th>Case No</th>
                            <th>Order Type</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order->col8order_cron_no; ?></td>
                                <td><?php echo $order->case_no; ?></td>
                                <td>
                                    <?php
                                    switch ($order->order_type_code) {
                                        case 01:
                                            echo "Mutation";
                                            break;
                                        case 02:
                                            echo 'Partition';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('d-M-Y', strtotime($order->co_ord_date)); ?></td>
                                <td>
                                    <a href="<?php echo base_url() . '/index.php/chithaeditentry/colEightOrderEdit/' . $order->col8order_cron_no; ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo base_url() . '/index.php/chithaeditentry/col8OrderDelete/' . urlencode($order->dag_no)."/".$order->col8order_cron_no; ?>" class="btn hide btn-danger">Delete</a>
                                    
                                </td>
                            </tr>
<?php endforeach; ?>
                    </table>
                    <div class="well">
                        <h1>Col 31 Orders</h1>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Order No</th>
                            <th>Case No</th>
                            <th>Order Type</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        </tr>
<?php foreach ($orders31 as $order): ?>
                            <tr>
                                <td><?php echo $order->ord_no; ?></td>
                                <td><?php echo $order->case_no; ?></td>
                                <td>
                                    <?php
                                    switch ($order->ord_type_code) {
                                        case 01:
                                            echo "Conversion";
                                            break;
                                        case 02:
                                            echo 'Allotment';
                                            break;
                                        case 03:
                                            echo "Mutation";
                                            break;
                                        case 04:
                                            echo 'Partition';
                                            break;
                                        case 05:
                                            echo "Others";
                                            break;
                                        case 06:
                                            echo "Name Correction";
                                            break;
                                        case 07:
                                            echo "Name Ommission";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('d-M-Y', strtotime($order->co_ord_date)); ?></td>
                                <td>
                                    <a href="<?php echo base_url() . '/index.php/chithaeditentry/step1Edit/' . $order->ord_cron_no; ?>" class="btn btn-primary">Edit</a>
                                    <a  data-attr1="<?php echo $order->ord_no;?>" data-attr2="<?php echo$order->ord_cron_no;?>" 
                                        data-attr3="<?php echo $order->rmk_type_hist_no; ?>"
                                       class="btn btn-primary hide delete">Delete</a>
                                </td>
                            </tr>
<?php endforeach; ?>
                    </table>
                    <hr>
                        <div style="text-align: center">
                            <a href="<?php echo base_url().'index.php/chithaeditentry/pattadardetails';?>" class="btn btn-danger">PREV</a>
                            <a href="<?php echo base_url().'index.php/home';?>" class="btn btn-danger">NEXT</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
