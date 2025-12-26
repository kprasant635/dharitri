<?php
?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

       
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h2 class="panel-title"><?php echo $this->lang->line('enter_modify_remark')?></h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':'.$this->session->userdata('patta_no').','.'&nbsp;'.$this->lang->line('patta_type').':'.$this->session->userdata('pattatype').','.'&nbsp;'.$this->lang->line('dag_no').':'.$this->session->userdata('dagnum');
                                 ?></h2>
            </div>
            <div class="panel-body">
                <form class='form-horizontal' method="post" action="">

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
                                <td colspan="12"><h2>Click On One Remark Content Type To Modify Details Corresponding To That Content Type</h2>
                            </tr>
                        </table>               
                    <div class="panel-body">
                        <div class="well well-sm" style="font-size: 30px;">
                            <a href="<?php echo base_url();?>index.php/LmEntryChitha/LMnote">1)<?php echo $this->lang->line('lm_note')?> </a>
                        </div>
                        <div class="well well-sm" style="font-size: 30px;">
                            <a href="<?php echo base_url();?>index.php/LmEntryChitha/Encrocherdetails">2)<?php echo $this->lang->line('encroacher_details')?></a>
                        </div>
                       
                     


                    </div>
                    </div>
                    </form>
					                      
            </div>
        </div>
    </div>

    <hr>
    

         
            </div>
</div>
                 
                        
  <script type="text/javascript">
    document.getElementById("next").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
   

    document.getElementById("exit").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/Home/index' ?>";
    };
   
</script>

                                  
