<div class="container">
    
        
            <div class="col-lg-8 col-lg-offset-2">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php  echo $this->lang->line('various_types_of_jamabandi_report')?></h2>
                </div>
            </div>
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Jamabandi Report
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info hide" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b><p style="font-size: 1.5em;"></p></b></h6>
                        </div>
                        <center>
                        <table class="table table-condensed">
                            <?php 
                            $user_desig_code=$this->session->userdata('user_desig_code');
                            if (($user_desig_code == 'DC') || ($user_desig_code == 'ADC') || ($user_desig_code == 'LAO') || ($user_desig_code == 'ADM') || ($user_desig_code == 'RKG') || ($user_desig_code == 'JAD')  ||  ($user_desig_code == 'SAD')||  ($user_desig_code == 'BO')) {
                            ?>
                            <tr>
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetails_r"><?php echo $this->lang->line('display_jamabandi_by_selecting_a_pattanumber')?> </a></td>
                            </tr>
                            <tr>
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetailsForEnteringPattano_r"><?php echo $this->lang->line('display_jamabandi_by_entering_a_pattanumber')?> </a></td>
                            <tr>
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetailsBYselectingPattatype_r"><?php echo $this->lang->line('display_jamabandi_by_selecting_a_pattatype')?> </a></td>
                            </tr>
                            <tr class="hide">
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetailsBYpattadarname_r"><?php echo $this->lang->line('display_jamabandi_by_entering_pattadarname')?> </a></td>
                            </tr>
                            <?php }
                            else{
                            ?>
                            <tr>
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetails"><?php echo $this->lang->line('display_jamabandi_by_selecting_a_pattanumber')?>  </a></td>
                            </tr>
                            <tr>
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetailsForEnteringPattano"><?php echo $this->lang->line('display_jamabandi_by_entering_a_pattanumber')?> </a></td>
                            <tr>
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetailsBYselectingPattatype"><?php echo $this->lang->line('display_jamabandi_by_selecting_a_pattatype')?> </a></td>
                            </tr>
                            <tr class="hide">
                                <td>&gt;&gt;<a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/districtDetailsBYpattadarname"><?php echo $this->lang->line('display_jamabandi_by_entering_pattadarname')?> </a></td>
                            </tr>
                            <?php    
                            }
                            ?>
                        </table>
                        </center>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-5">
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      
    
</div>