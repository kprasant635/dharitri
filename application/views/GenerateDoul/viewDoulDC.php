<?php 
$first_year = (doul_year_no -1) ;
$second_year = doul_year_no ;
?>
<div class="row">
    <div class="col-lg-12 ">
        <div class="col-lg-12">
            <div class="panel panel-info">
                
                <div class="panel-heading" style="background-color:#5f8523">
                    <h3 class="panel-title text-center">Circle wise Doul Details for the Session (<?=$first_year?>-<?=$second_year?>)</h3>
                </div>
                <div class="panel-body">
                  
                        <table class="table table-bordered" id="datatable">
                            <tr style="background-color: #fff0a4;">
                                <th>Sl no.</th>
                                <th>Year</th>
                                <th>Circle</th> 
                                <th>Status</th>
                                <th>Approval Remark</th> 
                                <th>Approval Date</th>                             
                                <th>Action</th>

                            </tr>
                        <?php $s=1;
                        foreach ($doulData as $res) {
                            // var_dump($res)
                            ?>
                            <tr class="block">
                                <td><?php echo $s++; ?></td>
                                <td><?php echo $res->yeardoul; ?></td>
                                <td><?php echo $res->loc_name; ?></td>
                                <td><?php echo ($res->status=='A') ? " <h6 style='color:green'><i class='fas fa-check-double'></i> Approved</h6>" : ($res->status == 'R' ? "<b style='color:red'><i class='fa fa-times'></i> Reverted</b>" : "<b style='color:#ffb81d'><i class='fa fa-spinner fa-spin'></i> Pending</b") ?></td>
                                <td><?php echo $res->dc_adc_remark== null ? "N/A" : $res->dc_adc_remark; ?></td>
                                <td><?php echo $res->dc_adc_approve_date == null ? "N/A" : $res->dc_adc_approve_date; ?></td>
                                <td>
                                
                                <a class="btn btn-primary" href="<?php echo base_url().'index.php/GenerateDoul/CircleWiseDoulViewDC?subdiv_code='.$res->subdiv_code.'&cir_code='.$res->cir_code;?>"> View Doul Details <i class="fa fa-arrow-right"></i></a>
                               
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
 

    // $('.numeric').on('input', function (event) { 
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });

    $(document).ready(function () {
    $('#datatable').DataTable({
        
    });
});
</script>