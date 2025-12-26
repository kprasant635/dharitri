<div class="container-fluid form-top login">
    <div class='row'>
        <?php //var_dump($data);?>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                <p class="text-center uni_text">আবেদন পঞ্জীকৰণ ফৰ্ম (<?php echo $this->utilityclass->getCertName($this->session->userdata('cert_codeNo')); ?> ৰ আবেদন) </p>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-4"><p class="uni_text text-center">আবেদন নং :<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center">আবেদনৰ তাং :<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date'))); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center">দিবলগীয়া তাং :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date'))); ?> </p></div>
                </div>
                <hr>
                <form class="form-horizontal" action="<?php echo base_url();?>index.php/CitizenController/LMSubmitLV" method="POST">
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">1st Deed Reg. No *</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="FDeedReg">
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label">1st Deed Value *</label>
                        <div class="col-lg-3">
                            <input type="number" class="form-control deed_value_new" id="xyz" name="FDeedVal" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">2nd Deed Reg. No </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="SDeedReg">
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label">2nd Deed Value </label>
                        <div class="col-lg-3">
                            <input type="number" class="form-control deed_value_new" id="abc" name="sDeedVal" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">3rd Deed Reg. No </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="TDeedReg">
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label">3rd Deed Value </label>
                        <div class="col-lg-3">
                            <input type="number" class="form-control deed_value_new" id="pqr" name="TDeedVal" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Land Price (per Katha) *</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" id="TotLandPric" readonly="" name="LandPrice">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">CO Order Number *</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="COOrderNo">
                        </div>
                        <label for="inputEmail" class="col-lg-2 control-label">CO Order Date *</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" id="ddmmyy" name="COOrderdate">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Purpose *</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="purpose">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Memo Number *</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="memonumber" readonly="" value="<?php echo $this->session->userdata('cert_no'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Copies to</label>
                        <div class="col-lg-6">
                            <textarea class="form-control" name="lv_copies" rows="3" cols="4"></textarea>
                            <span class="help-block text-danger">Put - at the end of each recipient name.Otherwise it will be consider as one recipient.  </span>
                        </div>
                        
                    </div>
                    <div class="form-group ">
                            <button class="btn btn-primary col-lg-offset-4" type="submit">Get the Certificate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

