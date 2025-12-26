<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
         
            <div class="">
                <div class="panel-heading">
                    <h3 class="panel-title">Patta List of &nbsp;&nbsp;&nbsp; Mouza: <kbd><?=$mouza_name;?></kbd> &nbsp;&nbsp;&nbsp; Lot : <kbd><?=$lot_name;?></kbd> &nbsp;&nbsp;&nbsp; Village : <kbd><?=$vill_name?> </kbd>  &nbsp;&nbsp;&nbsp; Patta : <kbd><?=$patta_name?> </kbd>  &nbsp;&nbsp;&nbsp; Patta No. : <kbd><?=$patta_no?> </kbd> <h3>
                </div>


                <div class="" >
                    
                    <form id="myForm" method="post">
                        <div style="max-height: 350px;overflow-x: scroll;">
                        <input type="hidden" class="" name="dist_code" id="dist_code" value="<?php echo $dist_code; ?>">
                        <input type="hidden" class="" name="subdiv_code" id="subdiv_code" value="<?php echo $subdiv_code; ?>">
                        <input type="hidden" class="" name="cir_code" id="cir_code" value="<?php echo $cir_code; ?>">
                        <input type="hidden" class="" name="mouza_code" id="mouza_code" value="<?php echo $mouza_pargona_code; ?>">
                        <input type="hidden" class="" name="lot_no" id="lot_no" value="<?php echo $lot_no; ?>">
                        <input type="hidden" class="" name="vill_code" id="vill_code" value="<?php echo $vill_code; ?>">
                        <input type="hidden" class="" name="patta_code" id="patta_code" value="<?php echo $patta_code; ?>">
                        <input type="hidden" class="" name="patta_no" id="patta_no" value="<?php echo $patta_no; ?>">
                        
                        <div class="table-responsive">
                           <table class="table table-bordered">
                            <tr  style="background-color:#f2ff2f">
                                <th>ক্ৰমিক নং</th>
                                <th>দাগ নং</th>
                                <th>মাটিৰ শ্ৰেণী</th>
                                <th>বিঘা</th>
                                <th>কঠা</th>
                                <th>লেচা</th>
                                <th>দাগৰ ৰাজহ</th>
                                <th>স্হানীয় কৰ</th>
                                <th>&nbsp;</th>
                            </tr>
                        <?php $s=1;
                        foreach ($zero_revenue_dags as $res) {
                            ?>
                            <tr class="block">
                                <td><?php echo $s++; ?></td>
                                <td><?php echo $res['dag_no']; ?></td>
                                <td><?php echo $res['land_class_name']; ?></td>
                                <td><?php echo $res['bigha']." বি"; ?></td>
                                <td><?php echo $res['ktha']." ক"; ?></td>
                                <td><?php echo round($res['lessa'],2)." লে"; ?></td>
                                <td><input type='text' class='form-control' id="<?php echo $res['dag_no']."dag_revenue"; ?>" value="<?php echo $res['dag_revenue']; ?>" style="width: 100px;"/></td>
                                <td><input type='text' class='form-control' id="<?php echo $res['dag_no']."local_tax";?>" value="<?php echo $res['local_tax']; ?>" style="width: 100px;"/></td>
                                <td>
                                <input type="hidden" class="form-control" id="<?php echo $res['dag_no']."dag_no"; ?>" value="<?php echo $res['dag_no']; ?>" readonly>
                                <input type="button" class="btn btn-sm btn-warning update_dag_revenue_mouza"  id="<?php echo $res['dag_no']; ?>" value='Update Details'>
                                <a class="btn btn-sm btn-success" target="_blank" href="<?php  echo base_url() . "index.php/LegacyDataUpdation/generateChitha?dist_code=".$dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" .$mouza_pargona_code. "&lot_no=".$lot_no."&vill_townprt_code=".$vill_code."&patta_type=" .$patta_code."&dag_no=" .$res['dag_no']; ?>">View Chitha</a>
                                    <br><span class="badge badge-danger <?php echo $res['dag_no']."blink_me"; ?>" style="margin-top: 10px;"></span>
                                </td>
                            </tr>
                        <?php }?>
                        </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    $('.update_dag_revenue_mouza').click(function (e) {
        var id = $(this).attr("id");
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var circle_code = $('#cir_code').val();
        var mouza_pargona_code = $('#mouza_code').val();
        var lot_no = $('#lot_no').val();
        var vill_townprt_code = $('#vill_code').val();
        var patta_type_code = $('#patta_code').val();
        var patta_no = $('#patta_no').val();
        var dag_no = $('#'+id+'dag_no').val();
        var dag_revenue = $('#'+id+'dag_revenue').val();
        var local_tax = $('#'+id+'local_tax').val();

        $.ajax({
            url: baseurl + "GenerateDoul/UpdateDagRevenueSpecialPatta/",
            type: 'post',
            dataType: 'json',
            data: {dist_code: dist_code,
                subdiv_code: subdiv_code ,
                circle_code: circle_code ,
                mouza_pargona_code: mouza_pargona_code ,
                lot_no: lot_no ,
                vill_townprt_code: vill_townprt_code ,
                patta_type_code: patta_type_code ,
                patta_no: patta_no ,
                dag_no: dag_no,
                dag_revenue: dag_revenue,
                local_tax: local_tax },
            success: function (data) {
                $('.'+id+'blink_me').html(data.success);
            },error: function (error) {
                alert('Something went wrong.');
            }
        });
    });

    $('.numeric').on('input', function (event) { 
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>