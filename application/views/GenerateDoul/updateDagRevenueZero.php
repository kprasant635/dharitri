
<div class="row">
    <div class="col-lg-12 ">
        <div class="col-lg-12">
            <div class="panel panel-info">
                
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Dag wise Revenue Details</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger">
                      <strong>Warning!  Below mentioned dags having zero revenue, please update the details
                    </strong></div>
                        <table class="table table-bordered">
                            <tr style="background-color: #fff0a4;">
                                <th>ক্ৰমিক নং</th>
                                <th>মৌজা</th>
                                <th>গাঁও</th>
                                <th>দাগ নং</th>
                                <th class="bg bg-danger">পাট্টা নং</th>
                                <th>পট্টাৰ প্রকাৰ</th>
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
                            //var_dump($res)
                            ?>
                            <tr class="block">
                                <td><?php echo $s++; ?></td>
                                <td><?php echo $res['mouza_name']; ?></td>
                                <td><?php echo $res['village_name'] . " <br><b style='color:red'>(" .$res['village_type']. ")" ?></td>
                                <td><?php echo $res['dag_no']; ?></td>
                                <td class="bg bg-danger"><?php echo $res['patta_no']; ?></td>
                                <td><?php echo $res['patta_name']; ?></td>
                                <td><?php echo $res['land_class_name']; ?></td>
                                <td><?php echo $res['bigha']." বি"; ?></td>
                                <td><?php echo $res['ktha']." ক"; ?></td>
                                <td><?php echo round($res['lessa'],2)." লে"; ?></td>
                                <td><input type='text' class='form-control' id="<?php echo $s."dag_revenue"; ?>" value="<?php echo $res['dag_revenue']; ?>" style="width: 100px;"/></td>
                                <td><input type='text' class='form-control' id="<?php echo $s."local_tax";?>" value="<?php echo $res['local_tax']; ?>" style="width: 100px;"/></td>
                                <td>
                                  <input type="hidden" class="form-control" id="dist_code" value="<?php echo $res['dist_code']; ?>" readonly>
                                <input type="hidden" class="form-control" id="subdiv_code" value="<?php echo $res['subdiv_code']; ?>" readonly>
                                <input type="hidden" class="form-control" id="circle_code" value="<?php echo $res['cir_code']; ?>" readonly>
                                <input type="hidden" class="form-control" id="<?php echo $s."mouza_pargona_code";?>" value="<?php echo $res['mouza_code']; ?>" readonly>
                                <input type="hidden" class="form-control" id="<?php echo $s."lot_no"; ?>" value="<?php echo $res['lot_no']; ?>" readonly>
                                <input type="hidden" class="form-control" id="<?php echo $s."vill_townprt_code"; ?>" value="<?php echo $res['vill_townprt_code']; ?>" readonly>
                                <input type="hidden" class="form-control" id="<?php echo $s."patta_type_code"; ?>" value="<?php echo $res['patta_type_code']; ?>" readonly>
                                <input type="hidden" class="form-control" id="<?php echo $s."patta_no"; ?>" value="<?php echo $res['patta_no']; ?>" readonly>
                                <input type="hidden" class="form-control" id="<?php echo $s."dag_no"; ?>" value="<?php echo $res['dag_no']; ?>" readonly>
                                
                                <input type="button" class="btn btn-sm btn-warning update_dag_revenue_mouza"  id="<?php echo $s; ?>" value='Update Details'>
                                <a class="btn btn-sm btn-success" target="_blank" href="<?php  echo base_url() . "index.php/LegacyDataUpdation/generateChitha?dist_code=".$res['dist_code'] . "&subdiv_code=" . $res['subdiv_code'] . "&cir_code=" . $res['cir_code'] . "&mouza_pargona_code=" .$res['mouza_code']. "&lot_no=".$res['lot_no']."&vill_townprt_code=".$res['vill_townprt_code']."&patta_type=" .$res['patta_type_code']."&dag_no=" .$res['dag_no']; ?>">View Chitha</a>
                                    <br><span class="badge badge-danger <?php echo $s."blink_me"; ?>" style="margin-top: 10px;"></span>
                                </td>
                            </tr>
                        <?php }?>
                        </table>
                    </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $('.update_dag_revenue_mouza').click(function (e) {
        var id = $(this).attr("id");
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var circle_code = $('#circle_code').val();
        var mouza_pargona_code = $('#'+id+'mouza_pargona_code').val();
        var lot_no = $('#'+id+'lot_no').val();
        var vill_townprt_code = $('#'+id+'vill_townprt_code').val();
        var patta_type_code = $('#'+id+'patta_type_code').val();
        var patta_no = $('#'+id+'patta_no').val();
        var dag_no = $('#'+id+'dag_no').val();
        var dag_revenue = $('#'+id+'dag_revenue').val();
        var local_tax = $('#'+id+'local_tax').val();
        //alert(dist_code+'-'+subdiv_code+'-'+circle_code+'-'+mouza_pargona_code+'-'+lot_no+'-'+vill_townprt_code+'-'+patta_type_code+'-'+patta_no+'-'+dag_no);
        
        $.ajax({
            url: baseurl + "GenerateDoul/UpdateDagRevenue/",
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