<div class="row login panel-form" style="min-height: 500px;">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class='center bold'><span class="rasid"><u>Sorry..!</u></span></p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="rasid table">
                                <tr>
                                    <td style="text-align: center;">There are no notice available for case no : <?php echo $case_no; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                            <a href="<?php echo base_url();?>index.php/AsistantMutationPartha/regenerate_notice" class="btn btn-danger" id=""><span class="ass-btn">Try Again Using Different Case No</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>