<div class="row login panel-form" style="min-height: 500px;">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php
                        if($msg['status'] == "")
                        {
                            ?>
                            <p class='center bold uni_text'><u>Thank You ( ধন্যবাদ ).</u></p>
                            <?php
                        }
                        else
                        {
                            ?>
                            <p class='center bold'><span class="rasid"><u>Sorry ( দুঃখিত )...!!!!</u></span></p>
                            <?php
                        }
                    ?>
                     
                </div>
                <div class="col-lg-6 uni_text">Dag Details Deletion</div>
                <div class="col-lg-6 uni_text"><span style="float:right;"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></div>
                <hr style="border-bottom: 2px solid #000;">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="rasid table">
                            <?php
                                $dist_name = $this->utilityclass->getDistrictName($msg['dist_code']);
                                $subdiv_name = $this->utilityclass->getSubDivName($msg['dist_code'], $msg['subdiv_code']);
                                $cir_name = $this->utilityclass->getCircleName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code']);
                                $mouza_pargona_code_name = $this->utilityclass->getMouzaName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code'], $msg['mouza_pargona_code']);
                                $lot_no = $this->utilityclass->getLotName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code'], $msg['mouza_pargona_code'], $msg['lot_no']);
                                $vill_townprt_code_name = $this->utilityclass->getVillageName($msg['dist_code'], $msg['subdiv_code'], $msg['cir_code'], $msg['mouza_pargona_code'], $msg['lot_no'], $msg['vill_code']);
                                if($msg['status'] == "")
                                {
                                    ?>
                                    <tr>
                                        <td style="text-align: center; font-size: 30px;">
                                            দাগ নং : <?php echo $msg['dag_no']; ?> / পট্টা নং : <?php echo $msg['patta_no']; ?> <br>
                                            জিলা <?php echo $dist_name; ?>,
                                            <?php echo $subdiv_name; ?> মহকুমা,
                                            <?php echo $cir_name; ?> ৰাজহ চক্রৰ, 
                                            <?php echo $mouza_pargona_code_name; ?>  মৌজাৰ,
                                            <?php echo $lot_no; ?> নং লাট'ৰ,
                                            <?php echo $vill_townprt_code_name; ?> গাঁওৰ পৰা নিষ্পত্তি কৰা হল | 
                                        </td>
                                    </tr>
                                    <?php
                                }
                                else 
                                {
                                    ?>
                                    <tr>
                                        <td style="text-align: center; font-size: 28px;">
                                            <p>
                                            <font face="Verdana" color="#FF0000">
                                            <?php 
                                            $first_word = explode(' ', $msg['status']);
                                            $first_word[0];
                                            echo $first_word[0]; ?> case is going on / was done on this Dag.
                                            </font>
                                            <p><font face="Verdana" size="2" color="#FF0000">Deletion of this Dag is not permitted this way!</font><p>
                                            <p><font face="Verdana" size="2"><?php echo $msg['status']; ?></font></p>
                                            <i><font face="Verdana" size="2">Note: However, you can delete a <?php echo $first_word[0];?> case on this Dag, if the case fails in Chitha Updation.</font></i>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <a href="<?php echo base_url(); ?>index.php/utility/districtselect" class="btn btn-danger" style="color:#ffffff;">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>