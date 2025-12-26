<div class="row">
    <div class="col-lg-12 parition-basu">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="card">
            
                <div class="card-header bg-danger">
                    <h3>
                        Error Occured
                    </h3>
                    
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <strong>#<?= $error_code; ?></strong>: This error can't be handled. Please contact <strong>Portal Administrator</strong>.
                    </div> 
                    
                </div>
                <small class="ml-3 text-secondary" style="font-size: 12px;">
                    NB: Parameters to be whitelisted "<?= $not_whitelisted_params; ?>"
                </small>
            </div>
        </div>
    </div>
</div>