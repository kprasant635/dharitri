<script>
    $(function () {
        $('#patta_no').change(function (e) {

            var dist_code = $('#dist').val();
            var patta_type = $('#type_code').val();
            var subdiv_code = $('#sub').val();
            console.log(subdiv_code);
            var cir_code = $('#cir').val();
            console.log(cir_code);
            var lot_no = $('#lot').val();
            console.log(lot_no);
            var mouza_pargona_code = $('#mouza').val();
            console.log(mouza_pargona_code);
            var vill_code = $('#vill').val();
            console.log(vill_code);
            pno = $('#patta_no').val();
            console.log(pno);
            var values = patta_type + "/" + dist_code + "/" + subdiv_code + "/" + cir_code + "/" + mouza_pargona_code + "/" + lot_no + "/" + vill_code + "/" + pno;
            console.log(values);
            $.ajax({
                url: 'http://10.177.15.232/dharitree/index.php/chithareport/getDagMiscCase/' + values,
                success: function (d) {
                    var object = JSON.parse(d);
                    var template = "<option disabled selected>Select</option>";
                    for (var i = 0; i < object.length; i++) {
                        template += "<option value='" + object[i].dag + "'>" + object[i].dag + "</option>";
                    }
                    $("#dag_no").html(template);
                }
            })
        });
    });
</script>
<div class="row login form-top">

    <div class="col-lg-12 ">
        <div class="col-lg-8 col-lg-offset-2">

            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Location Select</li>
                <li class="secondtick">Applicant Details</li>
                <li class="thirdtick">Land Area</li>
                <li class="fourthtick">Pattadar Details</li>
            </ol>

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location') ?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method='post' action="">
                        <input name="mutationclass" value="office" id="mutationclass" type="hidden"/>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('district') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control districtselect" id="dist" name="dist_code" required>

                                    <option value="<?php echo $d; ?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($d); ?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('subdivision') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control subdivselect" id="sub" name="subdiv_code" required>
                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                    <option value="<?php echo $subdiv_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($d, $subdiv_code); ?>
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('circle') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="cir" required name="circle_code">
                                    <?php $cir_code = $this->session->userdata('cir_code'); ?>
                                    <option value="<?php echo $cir_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($d, $subdiv_code, $cir_code); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('mouza') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="mouza" required name="mouza_code">
                                    <option disabled selected><?php echo $this->lang->line('select') ?></option>
                                    <?php foreach ($mouzas as $d): ?>
                                        <option value='<?php echo $d->mouza_pargona_code; ?>'><?php echo $d->loc_name; ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('lot_no') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="lot" required name="lot_no">
                                    <option disabled selected><?php echo $this->lang->line('select') ?></option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('vill_town') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="vill" required name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select') ?></option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('patta_type') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control " id='type_code' required name="patta_type_code">
                                    <option disabled selected>Select Patta Type</option>
                                    <?php foreach ($type as $t): ?>
                                        <option value='<?php echo $t->type_code; ?>'> <?php echo $t->patta_type; ?></option>
                                    <?php endforeach;
                                    ; ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('patta_no') ?></label>
                            <div class="col-lg-9">
                                <input name='patta_no' placeholder="Patta Number" id='patta_no' class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('dag_no') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control " id="dag_no" required name="dag_no">


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label">Select Action</label>
                            <div class="col-lg-9">
                                <select class="form-control " id="action" required name="action">
                                    <option value="1">Add Pattadar</option>
                                    <option value="2">Remove Pattadar</option>
                                    <option value="3">Correct Name</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>