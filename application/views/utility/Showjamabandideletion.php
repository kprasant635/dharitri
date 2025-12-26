<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Delete This Record?'))
            return (false);
        return (true);
    }
</script>
<div class="row login panel-form" style="min-height: 500px;">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <center>
                <table width="918" cellpadding="2" border="1" bordercolor="#99CCFF" style="border-collapse: collapse" cellspacing="0">
                    <tr>	
                        <td bgcolor="#6699FF" colspan=2 align=center style="border-left-color: #99CCFF; border-left-width: 1; border-right-color: #99CCFF; border-right-width: 1; border-top-color: #99CCFF; border-top-width: 1" width="912">
                            <p dir="ltr">
                            <font face="Arial" size="4">All The Dags Associated With Patta No : <?php echo $msg['patta_no'];?></font>
                        </td>
                    </tr>	
                    <tr>
                        <td style="font-family:ASBW-TTBidisha; font-size:18pt" align="center" width="100%">
                            <?php
                            $dist_name = $this->utilityclass->getDistrictName($msg['dist_code']);
                            $subdiv_name = $this->utilityclass->getSubDivName($msg['dist_code'], $msg['subdiv_code']);
                            $cir_name = $this->utilityclass->getCircleName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code']);
                            $mouza_pargona_code_name = $this->utilityclass->getMouzaName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code'], $msg['mouza_pargona_code']);
                            $lot_no = $this->utilityclass->getLotName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code'], $msg['mouza_pargona_code'], $msg['lot_no']);
                            $vill_townprt_code_name = $this->utilityclass->getVillageName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code'], $msg['mouza_pargona_code'], $msg['lot_no'], $msg['vill_code']);
                            ?>
                            <?php echo $dist_name; ?>  / 
                            <?php echo $subdiv_name; ?>	/ 
                            <?php echo $cir_name; ?> / 
                            <?php echo $mouza_pargona_code_name; ?> / 
                            <?php echo $lot_no; ?> / 
                            <?php echo $vill_townprt_code_name; ?>
                            <font face="Arial" size="3"> (<?php echo $msg['dist_code']; ?> / 
                            <?php echo $msg['subdiv_code']; ?> / 
                            <?php echo $msg['cir_code']; ?> / 
                            <?php echo $msg['lot_no']; ?> / 
                            <?php echo $msg['vill_code']; ?> / 
                            <?php echo $msg['mouza_pargona_code']; ?>)</font>
                    </tr>
                </table>
            </center>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>Note : Here you can see all the dags associated with this patta. Click on <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span>
                                to delete the associated dag / dag's. The patta will automatically get deleted if its not linked with any dag's.</b></h6>
                        </div>
                        <table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td class="bold center">Dag No</td>
                                    <td class="bold center">Patta No</td>
                                    <td class="bold center">Patta Type</td>
                                    <td class="bold center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if($msg['status'] == "")
                                {
                                    foreach($details as $d)
                                    {
                                        $patta_type = $d['patta_type_code'];
                                        //$pattaname = $d['patta_name'];
                                        ?>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php 
                                                foreach($d['dag_no'] as $dag_no){
                                                    echo $dag_no->dag_no.", ";
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: center;"><?php echo $d['patta_no'];?></td>
                                            <td style="text-align: center;"><?php echo $patta_type;?></td>
                                            <td style="text-align: center;">
                                                <a onClick="return ConfDel()" href="<?php echo base_url() . 'index.php/utility/one_buy_dag_no_delete?dist_code=' . $msg['dist_code'] . '&subdiv_code=' . $msg['subdiv_code'] . '&cir_code=' . $msg['cir_code'] . '&mouza_pargona_code=' . $msg['mouza_pargona_code'] . '&lot_no=' . $msg['lot_no']. '&patta_no=' . $d['patta_no']."&village=".$msg['vill_code']."&patta_type=".$patta_type ?>" title="Delete Dag"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <a href="<?php echo base_url(); ?>index.php/utility/districtDetails_junk" class="btn btn-danger" style="color:#ffffff;">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>