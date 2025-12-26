<?php if($validation_bypass == 0):?>
    <h5 class="bg-warning p-2" style="margin-top: 45px">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        Encroacher Eligibility
    </h5>

    <div class="reza-card">
        <div class="reza-body">
            <?php foreach($applicants_encroacher as $encroacher_eligibility) { ?>
                <h5 class="mt-2">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    <span class="alert-warning">
                        *Note [DAG NO: <?=$encroacher_eligibility->dag_no?>]- Encroacher
                        <?php foreach(json_decode(ENC_VARIFICATION_LIST) as $enc_exist_list)
                        {
                            if($enc_exist_list->CODE == $encroacher_eligibility->encroacher_exist_vlb){
                                echo $enc_exist_list->NAME. '.';
                            }
                        } ?>
                    </span>

                </h5>
            <?php }  ?>
        </div>
    </div>

<?php endif; ?>



