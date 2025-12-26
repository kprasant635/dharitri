<div class="row" style='margin-top:40px'>
                 <div class="col-lg-4 col-lg-offset-2">
                    <div class="panel casedisplay">
                        
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                 <div class="panel-title">
                                    <p class="regular">FIELD MUTATION / PARTITION</p>
                                    
                                </div>
                                <tr>
                                    <td>Write Note on Field Mutation</td>
                                    <td>
                                        <?php
                                        if ($fmutation != '0') {
                                            echo "<span class=\"badge badge-primary\">$fmutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingFMCases?mut=01' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Note on Field Partition</td>
                                    <td><?php
                                        if ($fpartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$fpartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingFMCases?mut=02' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Reverted Back From CO</td>
                                    <td><?php
                                        if ($reverted != '0') {
                                            echo "<span class=\"badge badge-primary\">$reverted</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/lmmutation/SKrevertedcases' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
					<!-- <div class="col-lg-4 col-lg-offset-1">
                    <div class="panel casedisplay">
                       
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                 <tr class="bg-info" style="background: #17a2b8 !important;">
                                    <td colspan="2">OFFICE MUT / PART / CONV</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Mutation</td>
                                    <td>
                                        <?php
                                        if ($omutation != '0') {
                                            echo "<span class=\"badge badge-primary\" >$omutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=03' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Partition</td>
                                    <td>
                                        <?php
                                        if ($opartition != '0') {
                                            echo "<span class=\"badge badge-primary\" >$opartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/skmutation/getPendingOfficeCases?mut=04' ?>" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write Report on Office Conversion </td>
                                    <td>
                                        <?php
                                        if ($cases != '0') {
                                            echo "<span class=\"badge badge-primary\">$cases</span>";
                                        }
                                        ?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/SKconversionPartha/GoToSK?pro=1" class="green" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> -->
                        </div>
             
           


<script>
    $(function () {
        $('.msg').click(function (e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function (e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>