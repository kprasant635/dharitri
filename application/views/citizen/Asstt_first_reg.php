<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-8' style="margin: 0 auto;float: none;">
                <?php
                if ($this->session->flashdata('message')):
                ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?php echo $this->session->flashdata('message');?></strong>
                </div>
                <?php endif; ?>
            <div class="panel panel-primary">
                <div class="panel-heading">Single Window for Citizen Centric Certificate</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                <a href="<?php echo base_url().'index.php/CitizenController/RegisterApplicant'; ?>"><span class="uni_text green">Register New Application</span></a>
                                <p class="text-info small">(Register a new Application for Citizen Centric Certificate and issue Money Receipt)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?php echo base_url().'index.php/CitizenController/SecondAssttStep1'; ?>"><span class="uni_text green">Print Certificate for CO's Signature</span></a>
                                <p class="text-info small">(Take Printouts of Certificate already issued by CO , and get them signed by the CO)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?php echo base_url().'index.php/CitizenController/CheckStatus'; ?>"><span class="uni_text green">Check Certificate Status</span></a>
                                <p class="text-info small">(Check the Status of Certificate - e.g. Pending, Delivered etc)</p>
                            </td>
                        </tr>
                    </table>
                    <div class="btn btn-info uni_text col-lg-offset-4" id="MainIndex">Go Back to Home</div>
                </div>
            </div>


        </div>
    </div>
</div>