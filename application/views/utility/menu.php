<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Utility Menu</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Utility Menu
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info hide" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b><p style="font-size: 1.5em;"></p></b></h6>
                        </div>
                        <center>
                            <table class="table table-condensed">
                                <tr>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/deletecase">Delete a Case No (Order not Passed by CO)</a></td>
                                </tr>
                                <tr>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/deletecaseAllField">Quick Delete a Case No for Field Mutation(Order not Passed by CO)</a></td>
                                </tr>
                                <tr class='hide'>
                                    <td  >&gt;&gt;<a href="<?php echo base_url(); ?>index.php/UtilityController/SelectLocationForSthalatLagat">Change <span class='red'>STHALAT</span> to <span class='red'>LAGAT</span> and Vice Versa</a></td>
                                </tr>
                                <tr>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/deletecaseAllOffice">Quick Delete a Case No for Office Mutation(Order not Passed by CO)</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/select_location_pattadar">Add Pattadar Names in Order of Col8(Field Mutation/Partition)&nbsp&nbsp</a><a href="./help/readme.html">Help</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/searchpattano">Generate list of Patta Nos. by Pattadar Names &nbsp&nbsp</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/select_locationGovtLand">Generate list of DAGS of Govt. Land &nbsp&nbsp</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/AutoJamaDistrict">Delete Col 8 and 31 Order(Conversion,Naamjari and Partition) &nbsp&nbsp</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td><input type="button" class="delJR" value=">>Delete Jamabandi Remarks.">
                                        <div class="panel">
                                            For deletetion of the Jamabandi remarks just delete the order no from Col 31 by this utility and then perform Autojamabandi Update from Dharitree. This will update all the jama remarks entered thorugh Mutation Process but not the remarks entered manually.
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/select_locationCol31">Add Pattadar Names in Column 31 Order(Office Mutation/Partition)</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/select_locationCol31_SthalatLagat">Change Sthalat to Lagat or Vice Versa in Column 31 Order</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/jamawasil/JamaWasilSingleLoc">Jamawasil for a Patta.</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/jamawasil/JamaWasilLoc">Jamawasil for a Whole Village.</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/jamawasil/PeriodicPattaLoc">Printing of Periodic Patta for a Patta.</a></td>
                                </tr>
                                <tr class="hidden">
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/jamawasil/PeriodicPattaLocAll">Printing of Periodic Patta for a Whole Village.</a></td>
                                </tr>
                            </table>
                        </center>

                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-5">
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
