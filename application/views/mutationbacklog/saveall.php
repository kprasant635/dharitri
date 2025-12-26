<div class="form-group login form-top">
    <div class="col-sm-8" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;text-align: center;">
        <h1 class="red">Click on the button for Final Submission of the case.</h1>
        <a href='<?php echo base_url(); ?>index.php/mutationbacklog/saveall' onclick="return confirm('<?php echo $this->lang->line('are_you_sure_you_want_to_submit_this_case') ?>')"
           class="btn btn-danger btn-lg"><i class='fa fa-save'></i><?php echo $this->lang->line('save_all') ?></a>
    </div>
</div>
<script>
    $(window).on('beforeunload', function () {
        return 'Are you sure you want to quit? Any unsaved data will be lost';
    });
</script>