<script language="javascript" type="text/javascript">
     $(document).ready(function() {

                $('.butn').click(function() {
                    
                    var method = $(this).attr('id');
                    var users = document.getElementById(method).value;
                    var controller = $('#con').val();
                    //alert(method+" "+users+" "+controller);
                    if(users != '')
                    {
                        $.ajax({
                        url: baseurl + "login/set_users/" + controller + '/' + method + '/' + users,
                        success: function (data) {
                        var code = JSON.parse(data);
                        for (var i = 0; i < code.length; i++) {
                        alert(code[i].msg);
                        setTimeout("location.reload(true);", '1000');
                        }
                        }
                        });
                    }
                    else
                    {
                        alert('Oopps...! Please Enter a user code');
                    }
                    //location.reload(); 
                });

            });
</script>
<div class="row login">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'>Assign Authority To Users for each Functions / Methods of <font color=red><?php echo $controllers; ?></font></p>
                </div>
            </div>
            <p class='center'><font color=red>Note : After Selecting the controller from the drop down you will be redirected to the page consisting all the functions of that particular controller.</font></p>	

            <hr>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                            <table class='table table-bordered'> 
                                <?php
                                foreach ($methodes as $r => $v): {
                                        ?>
                                        <tr>
                                            <td><?php echo $v; ?></td>
                                            <td>
                                                <div class='input-group'>
                                                    <input type='hidden' class='form-control' value='<?php echo $controllers; ?>' id='con'>
                                                    <input type='text' class='form-control' id='<?php echo $v; ?>' name='users_nm' placeholder='Add Users'>
                                                    <span class='input-group-btn'>
                                                        <button class='btn btn-default butn' id='<?php echo $v; ?>'  type='button'>Add</button>
                                                    </span>
                                                </div><!-- /input-group -->
                                                <label>Note : use a comma separator (eg : ast, co, lm, sk, dc, adc)</label>
                                            </td>
                                            <td><?php
                                            $user_status = $this->utilityclass->get_user_status($controllers, $v);
                                            //var_dump($user_status);
                                            ?></td>
                                        </tr>
                                        <?php
                                    }
                                endforeach;
                                ?>

                            </table>
                            [ <a href="<?php echo base_url(); ?>index.php/login/my_so_auth">Move To Login Page</a> ]
                        </center>
<!--onClick="add_data('<?php //echo $controllers; ?>', '<?php //echo $v; ?>')"-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



