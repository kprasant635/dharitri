<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Modify This Record?'))
            return (false);
        return (true);
    }
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Modify Dags & Patta (Junk Data)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?=$reverted==1?'Reverted':'All'?> Results 
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : All Dag's having any characters like (ক,খ..etc) might be genuine data. Please Check the chitha before Modifying. </h6>
                            <a href="<?php echo base_url('index.php/Utility/get_all_junk_dags?reverted=true'); ?>">Reverted List</a>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h4 class="center">
                            <code><?php echo $this->lang->line('district'); ?> : <?php echo $location['dist_code']; ?></code>&nbsp;&nbsp;&nbsp;&nbsp;
                            <code><?php echo $this->lang->line('subdivision'); ?> : <?php echo $location['subdiv_code']; ?></code>&nbsp;&nbsp;&nbsp;&nbsp;
                            <code><?php echo $this->lang->line('circle'); ?> : <?php echo $location['cir_code']; ?></code>
                        </h4>
                        <hr style="border-bottom: 2px solid #000;">
                        <table id="example" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td class="bold" width="5%"><?php echo $this->lang->line('action'); ?></td>
                                    <td class="bold" width="15%">Old Dag No</td>
                                    <td class="bold" width="10%">Dag No</td>
                                    <td class="bold" width="12%">Patta No</td>
                                    <td class="bold" width="15%">Patta Type</td>
                                    <td class="bold">Location details ( Mouza / Lot / Village )</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($junk as $key => $row1):
                                    //var_dump($row1);
                                    ?>
                                    <tr>
                                        <td class="center"><a class="btn btn-success btn-sm" onClick="return ConfDel()" href="<?php echo base_url() . 'index.php/LegacyDataUpdation/modifydagpatta?dag_no=' . 
                                                $row1['dag_no'] . '&patta_no=' . $row1['patta_no'] . '&patta_code=' . $row1['patta_code'] . '&dist_code=' . $row1['dist_code'] . '&subdiv_code=' . 
                                                $row1['subdiv_code'] . '&cir_code=' . $row1['cir_code'] . '&mouza_pargona_code=' . $row1['mouza_pargona_code'] . '&lot_no=' . 
                                                $row1['lot_no'] . '&village_code=' .$row1['vill_townprt_code'];?>" title="modify record"><span class="glyphicon glyphicon-edit" aria-hidden="true" style='color: red;'></span>&nbsp;<?=$button?></a></td>
                                        <td class="center"><?php echo $row1['old_dag_no']; ?></td>
                                        <td class="center"><?php echo $row1['dag_no']; ?></td>
                                        <td class="center"><?php echo $row1['patta_no']; ?></td>
                                        <td class="center"><?php echo $row1['patta_name']; ?></td>
                                        <td class="">
                                            <?php
                                            echo $mouza_pargona_code = $this->utilityclass->getMouzaName($row1['dist_code'], $row1['subdiv_code'], $row1['cir_code'], $row1['mouza_pargona_code']);
                                            echo " / ".$lot_no = $this->utilityclass->getLotName($row1['dist_code'], $row1['subdiv_code'], $row1['cir_code'], $row1['mouza_pargona_code'], $row1['lot_no']);
                                            echo " / ".$vill_townprt_code = $this->utilityclass->getVillageName($row1['dist_code'], $row1['subdiv_code'], $row1['cir_code'], $row1['mouza_pargona_code'], $row1['lot_no'], $row1['vill_townprt_code']);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                        <div class="form-group center">
                            <div class="col-lg-12">
                                <a href="<?php echo base_url(); ?>index.php/utility/districtDetails" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>


