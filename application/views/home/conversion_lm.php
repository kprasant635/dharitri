<div class="row login" style='margin-top:40px'>
	

    <?php if(ESCALATION_ENABLE == 1){ include(APPPATH."views/common/esc_user_allocated_days.php");} ?>

                <div class="col-lg-5 col-lg-offset-2">
                    <div class="panel casedisplay">
                        
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                               <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">OFFICE MUTATION / CONV</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Mutation</td>
                                    <td><?php
                                        if ($omutation != '0') {
                                            echo "<span class=\"badge badge-primary\">$omutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/getPendingOfficeMutationCases' ?>" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report On Office Conversion </td>
                                    <td><?php
                                        if ($oconv != '0') {
                                            echo "<span class=\"badge badge-primary\">$oconv</span>";
                                        }
                                        ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LMconversionPartha/GoToLM?pro=1" class="green" style="float:right"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Generate Application For Conversion </td>
                                    <td><?php
                                        // if ($appconv != '0') {
                                        //     echo "<span class=\"badge badge-primary\">$oppconv</span>";
                                        // }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>index.php/LMconversionPartha/generateApplication" class="green" style="float:right"><?php echo $this->lang->line('generate') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
         
				
				
</div>