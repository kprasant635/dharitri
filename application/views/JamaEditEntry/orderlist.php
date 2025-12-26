<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Add/Modify Order</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3 pull-right">
                            <a href="<?php echo base_url();?>index.php/chithaeditentry/colEightOrderAdd" class="btn btn-danger btn-lg">Add New Order</a>
                            <hr>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Order Cron No</th>
                            <th>Case No</th>
                            <th>Order Type</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($orders as $order):?>
                        <tr>
                            <td><?php echo $order->col8order_cron_no;?></td>
                            <td><?php echo $order->case_no;?></td>
                            <td>
                           <?php switch($order->order_type_code){
                                case 01:
                                    echo "Mutation";
                                    break;
                                case 02:
                                    echo 'Partition';
                                    break;
                            }?>
                            </td>
                            <td><?php echo date('d-M-Y',strtotime($order->co_ord_date));?></td>
                            <td>
                                <a href="<?php echo base_url() . '/index.php/chithaeditentry/colEightOrderEdit/' . $order->col8order_cron_no; ?>" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-primary">Delete</a>
                                <a href="#" class="btn btn-primary">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <div style="text-align: center">
                        <input type="submit" name="next" value="Next" class="btn btn-danger"/>
                        <input type="submit" name="submit" value="Submit" class="btn btn-danger"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
