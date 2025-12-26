<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">


            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $this->lang->line('enter_modify_lm_note') ?>(Column 31)</h2>
                    <h2 class="panel-title"><?php echo $this->lang->line('patta_no') . ':' . $this->session->userdata('patta_no') . ',' . '&nbsp;' . $this->lang->line('patta_type') . ':' . $this->session->userdata('pattatype') . ',' . '&nbsp;' . $this->lang->line('dag_no') . ':' . $this->session->userdata('dagnum');
?></h2>
                </div>
                <div class="panel-body">
                    

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
                                    <td colspan="12"><h2><?php echo $this->lang->line('select_remark_type') ?></h2></tr>
                            </table>               
                            <div> 
                                <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/LmEntryChitha/wantToenterlmnote' ?>">
                               
                                            <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('remark_type_hist_no') ?>:</label>  
                                            <div class="col-sm-4">
                                            <input type="text" name="histnumbr" value="<?php echo $Histslno['histno_id'] ?>">
                                            </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('remark_type') ?>:</label> 
                                                <div class="col-sm-4">

                                                    <select class="form-control fruitselect" id="select" name="rmktyp" required> 
                                                        <option disabled selected><?php echo $this->lang->line('select') ?></option>
                                                        <option value='02'>মণ্ডলৰ টোকা</option>
                                                                
                                                        <?php //foreach ($rmktype as $rmktyp): ?>
                                                            <?php
//                                                            $type_code = $rmktyp->type_code;
//                                                            $content = $rmktyp->content_type;
//                                                            // session_start();
//                                                            // $_SESSION['DBname']= $location;
//                                                            ?>
                                                                                                            <!--<option value="//<?php echo $type_code ?>"><?php echo $content ?></option>-->
                                                        <?php //endforeach; ?>
                                                    </select>

                                                </div>

                                            </div>

                                   
                                            <div class="form-group" >
                                                <div class="col-sm-2 col-lg-offset-4" >
                                                    <button type="submit"  name="show" class="btn btn-primary">Submit</button>

                                                </div>
                                            </div>
                                      

                                </table>
                                     </form>
                            </div>
                                <center> 
                        <button id="next"  class="btn btn-primary">&nbsp;Return to Menu</button>
                        <button type="submit" id="exit" class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Exit</button>
                        <button type="" id="backButton" class="btn btn-danger"><i class='fa fa-home'></i>&nbsp;<?php echo $this->lang->line('previous') ?></button>   
                    </center>
                        </div>
                       
                   
                    
                </div>
            </div>
        </div>
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


</script>
<script type="text/javascript">
    document.getElementById("addlmnote").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/LmEntryChitha/addAlmnote' ?>";
    };

</script>



