<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm bg-info">
                    <h2 style="text-align: center;">
                        <?php 
                        if($this->session->userdata('mut_type')==01){
                            echo "Field Mutation Process";
                        }else{
                            echo "Field Partition Process";
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php 
                            if($this->session->userdata('mut_type')==01){
                                echo "Select Type Of Mutation ( Single dag or multiple dag )";
                            }else{
                                echo "Select Type Of Partition ( Single dag )";
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/lmmutation/isMultiple"; ?>" method="post">

                            <div class="form-group">
                                <div class="col-lg-6" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;text-align: center">
                                    <label class="radio-inline uni_text"><input type="radio" name="ismultiple" value="false" onclick="$('form').submit()"><?php echo $this->lang->line('single_dag') ?></label>
                                    <?php if (!($this->session->userdata('mut_type') === '02')): ?>

                                        <label class="radio-inline uni_text "><input type="radio" name="ismultiple" value="true" onclick="$('form').submit()"><?php echo $this->lang->line('multiple_dag') ?></label>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




