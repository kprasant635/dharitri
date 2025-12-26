<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Jamabandi Edit Entry Module </h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Update Utility
                        </h3>
                    </div>
                    <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
              <?php endif; ?>     
                    <div class="panel-body">
                        <!--<h2 class="red">Update Revenue & Local Tax of Particular Village Dag</h2>-->
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $location['dist']; ?></td>
                                <td colspan="2">Subdivision : <?php echo $location['sub']; ?></td>
                                <td colspan="2">Circle : <?php echo $location['cir']; ?></td>
                                <td colspan="2">Mouza Pargona : <?php echo $location['mouza']; ?></td>
                            </tr>
                            <tr class="hope">
                                <td colspan="2">Lot : <?php echo $location['lot']; ?></td>
                                <td colspan="2">Town / Village : <?php echo $location['vill']; ?></td>
                                <td colspan="2">Patta No : <?php echo $location['patta_no']; ?></td>
                                <td colspan="2">Patta Type : <?php echo $this->utilityclass->getPattaName($location['patta_type_code']); ?></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="col-sm-12">
                            <a href="<?php echo base_url();?>index.php/JamaEditEntry/dagList" class="btn hide btn-danger">Jamabandi Dag Edit/View</a>
                            <a href="<?php echo base_url();?>index.php/JamaEditEntry/pattadarlist" class="btn btn-danger">Jamabandi Pattadar Edit/View Module</a>
                            <a href="<?php echo base_url();?>index.php/JamaEditEntry/remarks" class="btn btn-danger">Jamabandi Remark Edit/View Module</a>
                            <a href="<?php echo base_url();?>index.php/JamaEditEntry/dagsRemove" class="btn btn-danger">Remove Dag(s) from this Patta Module</a>
                            <a href="<?php echo base_url();?>index.php/JamaEditEntry/remarks" class="btn hide btn-danger">Remove this Patta</a>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
