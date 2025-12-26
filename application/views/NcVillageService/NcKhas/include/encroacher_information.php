<?php if(isset($encroachers)) : ?>
    <?php $encro = count($encroachers); $distCode = $this->session->userdata('dist_code'); ?>
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 30%;" rowspan="2">Name of the Encroacher</th>
                    <th style="width: 30%;" rowspan="2">Name of Guardian</th>
                    <th style="width: 10%;" rowspan="2">Dag No.</th>
                    <th style="width: 15%;" rowspan="2">Date of Possession</th>
                    <th style="width: 15%;" rowspan="2">Action</th>
                </tr>
                </thead>
                <?php foreach($encroachers as $row) { ?>
                    <?php if($row->is_applicant == 0 && $row->pdar_type == 'EN'){ ?>
                        <tr>
                            <td class="res-out"> <?= $row->pdar_name?> </td>
                            <td class="res-out"> <?= $row->pdar_guardian?> </td>
                            <td class="res-out"> <?= $row->dag_no?> </td>
                            <td class="res-out"> <?= $row->period_possession?> </td>
                            <td>
                                <?php if($row->dag_no == '0'): ?>
                                    <button class="rezaButt buttBrust" style="height: 32px!important;"  onclick="updateEncroacherDetailsWithDag('<?php echo $row->id ?>')">
                                        Update
                                    </button>
                                <?php else : ?>
                                    <button class="rezaButt buttCust" style="height: 32px!important;"  onclick="viewEncroacherDetailsWithDag('<?php echo $row->id ?>')">
                                        View
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php }?>
                <?php }?>
            </table>
        </div>

        <?php if($appView == 1): ?>
            <div class="col-lg-12 col-md-12 col-sm-12" align="right" style="margin-top: 25px">
                <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/NcKhasLand/applicationKhaslandRegistration?app='
                    . $this->utilityclass->encryptJwtcase($application_no) ?>">
                    <i class="fa fa-cog"></i> Application Process
                </a>
            </div>
        <?php endif;?>
    </div>

<?php else: ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" style=" padding-left: 25px">
            Please Add Dag Details
        </div>
    </div>
<?php endif; ?>

