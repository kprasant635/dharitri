<div class='row'>
    <div class='col-lg-12'  style='min-height:400px'>
   
                        <?php
                            if(isset($message)){
                        ?>
                         <div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $message; ?>
                                </strong>
                            </div>
                            </div>
                            <center>
                              <a href="<?php echo base_url() ?>index.php/home" class='btn btn-danger'>Go Back to Home</a>
                            </center>
                        <?php
                            }else{
                        ?>
                    
        <center>
            <h2>No Jamabandi Found for This Patta</h2>
            <a href="<?php echo base_url() ?>index.php/home" class='btn btn-danger'>Go Back to Home</a>
        </center>
        <?php } ?>
    </div>
</div>