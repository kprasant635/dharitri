<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <table class="table table-striped table-bordered" width="100%">
                <tr class="active">
                    <td colspan="3" class="text-center">
                        <h2>Mouza wise village List: 
                            <code>  <?php echo $namedata[3]->mouza; ?></code>
                        </h2>
                    </td>
                </tr>
                <tr class="success">
                    <td class="text-center"><h6><?php echo $this->lang->line('district');?> : <?php echo $namedata[0]->district; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <?php echo $namedata[1]->subdiv; ?></h6></td>
                    <td class="text-center"><h6><?php echo $this->lang->line('circle');?> : <?php echo $namedata[2]->circle; ?></h6></td>


                </tr>
                <tr class="danger">
                    <td  class="text-center"><?php echo $this->lang->line('sl_no');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('vill_town');?></td>
                    <td  class="text-center"><?php echo $this->lang->line('lot_no');?></td>
                </tr>
                <?php
                $c = 1;
                /*
                $this->load->library('pagination');

                $config['base_url'] = base_url();
                $config['total_rows'] = 200;
                $config['per_page'] = 20;

                $this->pagination->initialize($config);

                echo $this->pagination->create_links();
                
                 * 
                 */
                foreach ($village AS $row):
                    ?>
                    <tr>

                        <td class="text-center">
                            <?php echo $c; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $row->village; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $row->lot_no; ?>
                        </td>
                    </tr>
                <?php
                $c++;
                endforeach;
                ?>
                <tr>
                    <td class="text-center" colspan="3">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        window.location = "<?php echo base_url(); ?>index.php/MisReportController1/mouzawise_villages";
    };
</script>