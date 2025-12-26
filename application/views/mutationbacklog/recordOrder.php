<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Select Location</li>
                <li class="progtrckr-done secondtick">Transfer Type</li>
                <li class="progtrckr-done thirdtick">Applicant Details</li>
                <li class="fourthtick">Mutation Land Area</li>
            </ol>
        </div>
    </div>
    <?php //var_dump($this->session->all_userdata()); ?>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'>
                                Mutation/Partition Back Log Entry
                            </p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/mutationbacklog/recordOrder"; ?>" method="post">
                            <?php if($this->session->userdata('mut_type')=='02'):?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label">New Dag No</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="new_dag" id="mother_name" placeholder="new dag" value="<?php echo $new_dag;?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label">New Patta No</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="new_patta"  value="<?php echo $new_patta;?>" id="mother_name" placeholder="new patta">
                                </div>

                            </div>
                             <?php endif;?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label">Order</label>
                                <div class="col-sm-10">
                                    <textarea rows="5" style="width:100%" name="order"></textarea>
                                </div>
                            </div>
                           
                            <div class="form-group" style="text-align: center;">
                                <input type="submit" value="Submit" class="btn btn-info"/>
                            </div>
                           
                            <hr>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




