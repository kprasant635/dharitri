<!-- test -->
<!-- test -->
<div class="container-fluid home-bg" >
    <div class="row">
        <div class="col-lg-12 login" style="z-index: 1;">
            <div class="col-lg-8 col-md-8 col-sm-6">
                <div class="map">
                    <img src="<?php echo base_url(); ?>application/views/images/assammapfull.png" width='100%'>
                </div>
            </div>

            <div class="col-lg-4 login-form col-md-4">
                <p style="color:#ff0;font-size: 14px; font-weight:bolder;padding:5px; border-bottom: 1px solid #ffffff "><i class="fa fa-lock"></i>  <b>Sign-in Using Your Username & Password</b></p>
                <p class='' style="color:#ff0 ; font-weight: bolder; line-height: 150%; font-size:14px">Before Sign-in  please select the district from the image by clicking on the desired region or select the district directly from the drop down select box.</p> 
                <p class="regular" style="color:#edac6f;text-align: center;"> <?php echo $this->session->flashdata('msg'); ?></p>
                <div class="panel" style="margin-top:0px">                                                   
                    <div class="panel-body">
                        <form class="no-trigger" action="<?php echo base_url(); ?>index.php/login/doLogin" method="post" onsubmit="return check();">
                            <input type="hidden" name='districtname' id='districtname'/>

                            <div class="form-group" style='margin-top:-20px;'>
                                <div class='col-lg-6' >
                                    <label for="" class='green_label'>Select Language</label>
                                    <div class="form-search search-only">
                                        <i class="search-icon fa fa-user red"></i>
                                        <select name="language" id="language" class="form-control search-query">
                                            <!--<option disabled selected>Language</option>-->
                                            <option value="english" selected>English</option>
                                            <!--<option value="assamese">অসমীয়া</option>
                                            <option value="bengali">বেংগলী</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class='col-lg-6 '>
                                </div>
                                <div class='col-lg-6 hide'>
                                    <label for="exampleInputEmail1" class='green_label'>Select District</label>

                                    <div class="form-search search-only">
                                        <i class="search-icon fa fa-user red"></i>

                                        <select name="district" id="distr" class="form-control search-query">
                                            <option value='14'>golaghat_test</option>
                                            <!--<option value="24" selected>Kamrup Metro</option>-->
                                            <?php foreach ($disttt as $rey => $value): ?>
                                                <option value="<?php echo $value->district_code; ?>"><?php echo $value->district_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1" class="green_label">Username</label>
                                <div class="form-search search-only">
                                    <i class="search-icon fa fa-user red"></i>
                                    <input type="text" class="form-control search-query" placeholder="Type User Name" name="uname">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputPassword1" class="green_label">Password</label>
                                <div class="form-search search-only">
                                    <i class="search-icon fa fa-key red"></i>
                                    <input type="password" class="form-control search-query" placeholder="Type Password" name="pwd">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="alt_change">
                                            <?php echo($image); ?>
                                        </div>
                                        <span><a href="#" style="color:#ff0000; font-size:14px"  class="refresh">Reload Captcha</a></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <input id="captcha" class="form-control captcha" required="" placeholder="Captcha Type Here" value=""  name="captcha" type="text"/>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-8" style="vertical-align:center">
                                        <a href='<?php echo base_url(); ?>index.php/login/all_active_users' style='margin-bottom:0px; font-weight:bold !important; color:#e00b44'>Click Here : Active User List.</a>   
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" name="B1" id="ruless" class="btn btn-primary " onsubmit="return check();"><i class="fa fa-unlock"></i> Login</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <input class="squaredTwo red" id="toggle" type="checkbox"/><label for="exampleInputPassword1" style="color:#e0480b">Please Read This Login/Password Guidelines</label>
                    </div>
                    <div class="col-sm-12">
                        <a href="<?php echo base_url(); ?>application/views/img/process_flow.pdf" target="_blank" style="color:#e0480b;">
                            <span class="glyphicon glyphicon-link" aria-hidden="true" style='color: blue;'></span> <b>Download Process Work Flow</b> <span class="glyphicon glyphicon-link" aria-hidden="true" style='color: blue;'></span>
                        </a>
						<a href="<?php echo base_url(); ?>application/views/img/SOP1-ILRMS-RectificationLegacyData.docx" download>Download SOP for Legacy Updation</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="boxes" class="hide">
    <div id="dialog" class="window">
        <center><label class='red uni_text'>Notice</label></center>
        <p>we are integrating the new conversation process...so these few days there will be a problem in the ongoing conversation processes...</p>
        <p><label class='red uni_text'>1)</label> LM's are requested not to give any further report on any conversion cases until the new process is merged with the old one.</p>
        <p><label class='red uni_text'>2)</label> By monday all the pending cases will be visible along with the new and modified Conversion Process</p>
    
  </div>
  <div id="mask"></div>
</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    $('.refresh').click(function (event) {
        event.preventDefault();
        $.ajax({
            url: base_url + 'index.php/login/reload_captcha',
            success: function (data) {
                $('.alt_change').html(data);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        //$("#myModal").modal('show');
        $('#toggle').click(function () {

            if ($(this).is(':checked')) {
                $('#myModal').modal();
                //$('#rules').removeAttr('disabled'); //enable input
            } else {
                //$('#rules').attr('disabled', true); //disable input
            }
        });
    });
</script>
<div id="myModal" class="modal fade" style="z-index:1000000000">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title red">Guidelines For Dharitree User Account and Password: </h4>
            </div>
            <div class="modal-body">
                <p style="font-size:1.2em">1. If a new User Account for a person of the Revenue Administration 
                    ( DC, ADC, BO(ADC, Assistant Commissioner) CO, SK, LM, and Assistant etc.) is required to be 
                    created then his Bio-data (profile) in the Prescribed Form(sent to DIO, NIC)  along with complete 
                    location details, duly signed with office seal by the concerned authority (DC, ADC, CO) is required to be sent to the in-charge 
                    of the data centre for creating his profile and user account and password.<br><br>
                    <span style="color:#dc7329">Shri Dhiraj Saud, Deputy Secretary to the Revenue & DM Department, Govt. of Assam( e-mail: dhirajsaud@yahoo.com) is the in-charge of the Data Centre.</span></p>
                <p style="font-size:1.2em">2. Initially, for the first time, default user account and password will be created for all users. 
                    The list is provided in the Login Page of CLR(Dharitree). Please use it accordingly for login. </p>

                <p style="font-size:1.2em">3. For the first time login, you will be forced to change your password to make it 
                    secret to you only. <i class="green"> It is a security risk to share this password with others. So, you are advised not to share it with others.</i></p>
                <p style="font-size:1.2em">4. For the first time, only the Circle Officer’s, Deputy Commissioner’s and Additional Dy. Commissioner’s login 
                    account will be enabled for login into CLR(Dharitree). All other users’( LM, SK, Assistant ) login account will be made disable initially and forbidden from login.
                    <br>
                    The concerned Circle Officer(CO), after login into CLR(Dharitree) will enable only one user for a particular location; that is one Circle 
                    Officer for a Circle, one LM for a lot, one SK and one Assistant for a Circle. In case there are  more than one SK in a Circle then 
                    they can be enabled,  but then the proper association between LM and SK ( that is which LM reports to which SK) is to be established 
                    by the Circle Officer(CO) by editing each LM’s login account details. This provisions are available under the ‘Enabled Users’ and ‘Disabled Users’ 
                    items under the ‘Settings Menu’ of Dharitree. The users can be enabled and disabled by the Circle Officer only using these two(2) items.
                    <br>
                    If more than one Assistant for a Circle is to be created/enabled then that can also be done. Then , the assistant who registers a particular case should complete all the activities related to the case from his/her login account only. 
                </p>
                <p style="font-size:1.2em">5. If a user wants to change his user account name and password then he/she can do that by selecting the ‘My Account’ 
                    item under the Settings Menu.</p>
                <p style="font-size:1.2em">6. It is better to change password regularly, just like PIN number of Bank Account for the sake of security. CLR(Dharitree) 
                    will alert an user to change his/her password after the password becomes thirty(30) days old.</p>
                <p style="font-size:1.2em">7. When an official( DC, ADC, BO, Circle Officer, SK, LM or Assistant) is transferred from the place of present working 
                    to other place  or  goes on leave for a long duration then he/she should leave CLR(Dharitree) by disabling his own account.
                    <br>
                    The new official’s details are to be sent to the Data Centre for creating his/her account , as mentioned in the point number 1. above in the Prescribed Format.
                </p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

