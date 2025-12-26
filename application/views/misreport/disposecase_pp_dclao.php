<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-10 col-lg-offset-2" >  
            <div class="well col-lg-10 well-sm"><h2 class="uni_text text-center"><?php echo $this->lang->line('registered_disposed_pending_cases_of'); ?> (<?php echo $this->lang->line('mutation'); ?>  / <?php echo $this->lang->line('partition'); ?>  / <?php echo $this->lang->line('conversion'); ?> )</h2></div>
            <div class="col-lg-10">
                <div class="panel ">
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>index.php/MisReport/DisposeForPPSubmitdist">
                            <fieldset>
                               
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('starting_date'); ?></label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control stdate"  name="sdate"  placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('end_date'); ?></label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control endate" name="edate" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8 col-lg-offset-4">
                                        <button type="submit" class="btn btn-primary" onclick="LoadData();"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?> </button>
                                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                                    </div>
                                </div>
                                <span class="help-block text-danger">Note : Please follow the date in correct format "dd-mm-yyyy"</span>

                            </fieldset></form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport' ?>";
    };
</script>
<script language="javascript" type="text/javascript">
    $(window).load(function () {
        $('#loading').hide();
    });
    function LoadData() {
        $("#loading").show('show');
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        });
    }
</script>  
<div class="modal fade modal-transparent" style="margin-top: 250px" id='myModal' >
    <div class="" role="document"> 

        <center>
            <img id="loading-image" style="" width="100px" src= "<?php echo base_url(); ?>application/views/images/load.gif" alt="Loading..." />
            <h2 style="color:#fff" >Please Wait ! </h2>
            <h5 style="color: #fff">Generating disposed pending cases of (Mutation / Partition / Conversion ). </h5>
        </center>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
