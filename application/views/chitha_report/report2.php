

    <div class="col-lg-12 blur_div ">

        <div class="col-lg-6">
            <div class="well well-sm">
                <h4 style="text-align: center;">Location Details</h4>
            </div>
            <table class="table table-striped table-hover ">
                <tbody>
                    <tr class="info">
                        <td><?php echo $this->lang->line('district') ?></td>
                        <td>:</td>
                        <td><strong><?php echo $namedata[0]->district; ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('subdivision') ?></td>
                        <td>:</td>
                        <td><strong><?php echo $namedata[1]->subdiv; ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('circle') ?></td>
                        <td>:</td>
                        <td><strong><?php echo $namedata[2]->circle; ?></strong></td>
                    </tr>
                    <tr class="success">
                        <td><?php echo $this->lang->line('mouza') ?></td>
                        <td>:</td>
                        <td><strong><?php echo $namedata[3]->mouza; ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('lot_no') ?></td>
                        <td>:</td>
                        <td><strong><?php echo $namedata[4]->lot_no; ?></strong></td>
                    </tr>
                    <tr class="info">
                        <td><?php echo $this->lang->line('vill_town') ?></td>
                        <td>:</td>
                        <td><strong><?php echo $namedata[5]->village; ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <form class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/chithareport/generateChitha' ?>">
                <div class="panel">
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text">Select patta type and single dag or a range of dag from the drop down below.</h6>
                        </div>
                        <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type') ?></label>
                        <div class="col-lg-9">
                            <select class="form-control" id="select_patta_type" name="patta_code" required >
                                <option disabled selected>Select Pattatype</option>
                                <option value='0000'>All</option>
                                <?php foreach ($pattatype as $patta): ?>
                                    <?php
                                    $typeCode = $patta->type_code;
                                    $pattatype = $patta->patta_type;
                                    ?>
                                    <option value="<?php echo $typeCode; ?>"><?php echo $pattatype; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-heading"><span class="panel-title uni_text"><?php echo $this->lang->line('select_multiple_dag') ?></span></div>
                    <div class="panel-body">
                        <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('from') ?> :</label>
                        <div class="col-lg-3">
                            <select class="form-control dag_no_lower" id="selectlw" name="dag_no_lower">
                                <option>Lower Range</option>
                            </select>
                        </div>
                        <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('to') ?> :</label>
                        <div class="col-lg-3">
                            <select class="form-control" id="selectup" name="dag_no_upper">
                                <option>Upper Range</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" onclick="LoadData();" class="btn btn-primary"><?php echo $this->lang->line('generate') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


<script language="javascript" type="text/javascript">
    $(window).load(function () {
        $('#loading').hide();
    });
    function LoadData() {
        $("#loading").show();
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
            <h2 style="color:#fff   " >Please Wait ! </h2>
            <h5 style="color: #fff   ">The Generation of Chitha Report might take some time. </h5>
        </center>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





