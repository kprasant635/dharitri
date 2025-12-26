<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">
                        <?php 
                        if($this->session->userdata('ismultiple')==true){
                            $type_of_dag = "( Multiple Dag )";
                        }else{
                            $type_of_dag = "( Single Dag )";
                        }
                        
                        if($this->session->userdata('mut_type')==01){
                            echo "Field Mutation Transfer Type Form For ".$type_of_dag;
                        }else{
                            echo "Field Partition Transfer Type Form For ".$type_of_dag;
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="center col-lg-12">
                            <h1 class="red">Click on the button for Final Submission of the case.</h1>
                            <a href='<?php echo base_url(); ?>index.php/lmmutation/saveall' onclick="return confirm('<?php echo $this->lang->line('are_you_sure_you_want_to_submit_this_case')?>')"
                               class="btn btn-danger btn-lg"><i class='fa fa-save'></i><?php echo $this->lang->line('save_all')?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
 $(window).on('beforeunload', function () {
        return 'Are you sure you want to quit? Any unsaved data will be lost';
    });
</script>