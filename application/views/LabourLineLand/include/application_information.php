<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8">
        <table class="table">
            <?php if($applicants != false) { ?>
                <?php foreach($applicants as $row) { ?>
                    <?php if($row->is_applicant == 1){ ?>
                        <tr>
                            <th>Name of the Applicant (<?=$row->identity_type?>)</th>
                            <td class="res-out"><?=$row->eng_pdar_name?></td>
                        </tr>
                        <tr>
                            <th>Occupation or Profession of the applicant</th>
                            <td class="res-out"><?= $basic != false ? $basic->occupation_applicant : $fetch_err ?></td>
                        </tr>
                        <tr>
                            <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                            <td class="res-out">
                                <?=$row->under_tribe_belts == 0 ? 'No':'Yes'?>
                            </td>

                        </tr>
                        <tr>
                            <th>Caste</th>
                            <td class="res-out">
                                <?php foreach (json_decode(CASTE) as $caste) {
                                    if ($caste->CODE == $basic->caste) {
                                        echo $caste->NAME;
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Applications applied by this applicant</th>
                            <td>
                                <a type="button" target="_blank" class="btn btn-sm btn-info" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$basic->applid;?>">
                                    <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View</small>
                                </a>
                            </td>
                        </tr>

                    <?php }?>

                    <?php if($row->is_applicant == 0 && $row->pdar_type == 'EN'){ ?>
                        <?php $encro = 1; ?>
                    <?php } ?>

                <?php }?>
            <?php }?>
        </table>
    </div>

    <?php if(isset($aadhaar_photo)) : ?>

        <div class="col-lg-4 col-md-4 col-sm-4">
            <?=$aadhaar_photo;?>
        </div>

    <?php else: ?>

    <?php endif; ?>
</div>



