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
    td{
        color:red !important;
    }
</style>
<?php $errorFlag = FALSE; ?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Information regarding chitha and jamabandi Discrepancy</h3>
                </div>
                <div class="panel-body">
                    <table class='table'>
                        <tr>
                            <th>District</th>
                            <th>Subdiv</th>
                            <th>Circle</th>
                            <th>Mouza</th>
                            <th>Lot</th>
                            <th>Village</th>
                            <th class="info center">Patta NO</th>
                            <th class="warning center">JAMABANDI (Pattadar Count)</th>
                            <th class="center warning">CHITHA (Pattadar Count)</th>
                            <th class="center success">Action</th></tr>
                        <?php foreach ($values as $val): ?>
                            <tr>
                                <td><?php echo $this->utilityclass->getDistrictName($val['dist']); ?></td>
                                <td><?php echo $this->utilityclass->getSubDivName($val['dist'], $val['sub']); ?></td>
                                <td><?php echo $this->utilityclass->getCircleName($val['dist'], $val['sub'], $val['cir']) ?></td>
                                <td><?php echo $this->utilityclass->getMouzaName($val['dist'], $val['sub'], $val['cir'], $val['mouza']); ?> </td>
                                <td><?php echo $val['lot']; ?></td>
                                <td><?php echo $this->utilityclass->getVillageName($val['dist'], $val['sub'], $val['cir'], $val['mouza'], $val['lot'], $val['village']) ?></td>
                                <td class="info center"><?php echo $val['patta_no']; ?></td>
                                <td class="warning center"><?php echo $val['jcount']; ?></td>
                                <td class="warning center"><?php echo $val['ccount']; ?></td>
                                <td class="success center">
                                    <form action="<?php echo base_url();?>index.php/ChithaJamaCompare/compareedit" method="post">
                                        <input name="patta_no" type="hidden" value="<?php echo $val['patta_no']?>">
                                        <button type="submit" class="btn btn-sm btn-danger">sync</button>
                                    </form>
                                    
                                    
                                    <!--<a href="<?php echo base_url(); ?>index.php/ChithaJamaCompare/compareedit/<?php echo urlencode($val['patta_no']);?>/<?php echo $val['patta_type_code'];?>">Sync</a>-->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>