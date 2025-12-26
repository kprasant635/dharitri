<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel panel-default panel-body">
            <table class="table table-striped table-bordered" width="100%">

                <tr class="active">
                    <td colspan="5" class="text-center">
                        <h2>Village-Wise Tenants List for Village : 
                            <code> <?php echo $namedata[5]->village; ?></code>
                        </h2>
                    </td>
                </tr>
                <tr class="success">
                    <td class="text-center"><h6><?php echo $this->lang->line('district'); ?> : <?php echo $namedata[0]->district; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('subdivision'); ?> : <?php echo $namedata[1]->subdiv; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('circle'); ?> : <?php echo $namedata[2]->circle; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('mouza'); ?> : <?php echo $namedata[3]->mouza; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('lot_no'); ?>: <?php echo $namedata[4]->lot_no; ?></h6></td>
                </tr>



                <tr class="success">
                    <td  class="text-center"><?php echo $this->lang->line('dag_no'); ?></td>
                    <td  class="text-center">Tenant ID</td>
                    <td  class="text-center">Tenant Name</td>
                    <td  class="text-center">Tenant Father</td>
                    <td  class="text-center">Type of Tenant</td>


                </tr>
                <?php
                $howmany = sizeof($tenant);

                $i = 1;
                if ($howmany > 0) {
                    
                    //create an array to insert all the dag nos 
                    $noArr=array();
                    foreach ($tenant AS $row1){
                        $dag_no = $row1->dag_no;
                        $noArr[].=$dag_no;
                    }
                    
                    //convert this array into an unique array
                    $noArr1=array_unique($noArr);
                    //var_dump($noArr1);
                    //counting the no of ocurance in  $noArr Array
                    $countArr=array();
                    for($i=0;$i< count($noArr1);$i++){
                            $countArr[].=count(array_keys($noArr, $noArr1[$i]));
                    }
                    //var_dump($countArr);
                    //no of count in the unique key
                    $count= count($countArr);
                    
                    $dagArr = array();
                    $c=0;
                    foreach ($tenant AS $row):

                        $dag_no = $row->dag_no;

                        $key = in_array($dag_no, $dagArr);

                        if ($key == "") {
                            $dagArr[].=$dag_no;
                            $d = $dag_no;
                        } elseif ($key == 1) {

                            $d = "";
                        }
                        //print_r(array_unique($dagArr));
                        $row2 = count($dagArr);
                        ?>
                        <tr>
                            <?php if($c<$count){ ?>
                            <td style="text-align: center;vertical-align:middle;" rowspan="<?php echo $countArr[$c];?>">
                                <?php echo $d; ?>
                            </td>
                            <?php }?>
                            <td class="text-center">
                                <?php echo $row->tenant_id; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $row->tenant_name; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $row->tenants_father; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $row->tenant_type; ?>
                            </td>
                        </tr>
                        <?php
                        $c++;
                    endforeach;
                    //print_r($dagArr);
                } else {
                    ?>
                    <tr class="danger">
                        <td colspan="5" style="color: red;text-align: center;">No records found.</td>
                    </tr>

                <?php } ?>
                <tr>
                    <td class="text-center" colspan="5">
                        <button id="backButton" class="btn  btn-danger"><i class="fa fa-home"></i>&nbsp;Back to Main Meu</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        window.location = "<?php echo base_url(); ?>index.php/MisReportController1/village_wise_tenants";
    };
</script>