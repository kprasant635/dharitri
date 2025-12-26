<?php ?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">


            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('enter_modify_non-agricultural_land_use_details') ?>(Column 12-13 & 18-20 & 24-25)</h2>

                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no') . ':' . $this->session->userdata('patta_no') . ',' . '&nbsp;' . $this->lang->line('patta_type') . ':' . $this->session->userdata('pattatype') . ',' . '&nbsp;' . $this->lang->line('dag_no') . ':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/showAndmodifynonagri' ?>">

<?php
$dist_name = $this->session->userdata('distname');
$subdiv_name = $this->session->userdata('sub_divname');
$cir_name = $this->session->userdata('cir_codename');
$mouza_name = $this->session->userdata('mouza_codename');
$lot_name = $this->session->userdata('lot_noname');
$villname = $this->session->userdata('villname');
// echo  $dist_name.'<br>'.$subdiv_code.'<br>'.$cir_code.'<br>'.$mouza_code.'<br>'.$lot_no.'<br>'.$villname;                             
?>
                        <div align="center">
                            <br>
                            <table class="table table-bordered" align="center" width="100%" >
                                <tr>
                                    <td align="center">
<?php echo $this->lang->line('district'); ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $dist_name; ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $this->lang->line('subdivision'); ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $subdiv_name; ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $this->lang->line('circle'); ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $cir_name; ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $this->lang->line('mouza'); ?>  
                                    </td>
                                    <td align="center">
                                        <?php echo $mouza_name; ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $this->lang->line('lot_no'); ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $lot_name; ?> 
                                    </td>
                                    <td align="center">
                                        <?php echo $this->lang->line('vill_town'); ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $villname; ?> 
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="12"><h2><?php echo $this->lang->line('select_one_non_agricultural_use_name_and_click_on_show_details_to_modify_non_agricultural_details_name') ?></h2>
                                </tr>
                            </table>               
                            <div> 
                                <table class="table table-bordered" align="center" width="50%" >

                                    <tr>
                                        <td width="50%">

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('non_agricultural_use_name') ?> </label>
                                                <div class="col-sm-4">

                                                    <select class="form-control cropselect" id="selectnonagri" name="noncrop_name" required>
                                                        <option disabled selected><?php echo $this->lang->line('select') ?></option>
<?php
$resultnoncrp = count($nonagridetails);
if ($resultnoncrp === 0) {
    $n = $this->lang->line('there_are_no_nonagri_info_on_this_dag');
    $message = $n;
    echo "<script type='text/javascript'>alert('$message');</script>";
}
foreach ($nonagridetails as $nonagri):
    ?>
                                                            <?php
                                                            $noncrp_code = $nonagri->used_noncrop_type_code;
                                                            $noncrp_id = $nonagri->noncrop_use_id;
                                                            $noncropname = $nonagri->noncrop_type;
                                                            // session_start();
                                                            // $_SESSION['DBname']= $location;
                                                            ?>
                                                            <option value="<?php echo $noncrp_id; ?>"><?php echo $noncropname; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-sm-4 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                                    <button type="submit" name="show" class="btn btn-primary">&nbsp;<?php echo $this->lang->line('show_details') ?></button>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form> 

                    <div class="form-group" align="center">
                        <div class="col-sm-6" style="float: none;margin-top: 20px;margin-bottom: 20px;">
<!--                            <button id="addCrop" type="submit" name="add" class="btn btn-primary">&nbsp;<?php //echo $this->lang->line('add_a_non_agricultural_detail') ?></button>-->


                            <button id="backButton" align="center" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('previous');?></button>
                            <button type="submit" id="next" name="next" class="btn btn-primary">&nbsp;Return to Menu</button>
                            <button type="submit" id="exit" name="exit" class="btn btn-danger">&nbsp;<?php echo $this->lang->line('exit') ?></button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>



    </div>
</div>





<script type="text/javascript">
    document.getElementById("next").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/menuforSelectingOption' ?>";
    };

  document.getElementById("backButton").onclick = function () {
       javascript:history.back();
    };
    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };

//    document.getElementById("addCrop").onclick = function () {
//        location.href = "<?php //echo base_url() . 'index.php/LmEntryChitha/addnonagri' ?>";
//    };
    $('#aa').keyup(function () {
        var val = $('#aa').val();
        console.log(val);

        var conv = parseInt(val);

        if (isNaN(conv)) {
            alert("Please enter valid numeric number");
        }
        if (conv >= 5)
        {
            alert("The value entered must be less than 5");
        }
    });
</script>

