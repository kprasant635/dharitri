
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center; text-transform:uppercase">Out of Escalation / De-escalation<i class='fa fa-undo'></i></h2>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="error_container">                    
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $message ?>
                        </strong>
                    </div>
                </div>

                <a href="<?=$go_back?>"><button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Go Back</button></a>
                
            </div>
        </div>
    </div>
</div>