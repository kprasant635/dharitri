<div class="col-lg-12 ">
    <?php if($this->session->flashdata('validation_msg')):?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class="rasid text-left" style="color:red !important">
                <?php
                    foreach($this->session->flashdata('validation_msg') as $error){
                        echo "Validation-Error : ". $error;
                    }                                                         
                ?>
            </strong>
        </div>
    <?php endif;?>
</div>