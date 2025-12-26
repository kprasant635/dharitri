<div class="row login">

    <div class="col-lg-10 col-lg-offset-1">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm ">
                <h3 style="text-align: center; font-size: 28px">Delete Col 8 and 31 Order(Conversion,Naamjari and Partition)</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>

            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location') ?></h3>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url() . "index.php/Utility/generateDagChitha"; ?>">
                        <div class="form-group">
                            <lavel class="col-lg-12" style="color: red; text-align: center"><?php echo validation_errors(); ?></lavel>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('district') ?></label>
                            <div class="col-sm-4">
                                <select  class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>

                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                    <option value="<?php echo $dist_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('subdivision') ?></label>
                            <div class="col-sm-4">
                                <select  class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                    <option value="<?php echo $subdiv_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                    </option>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('circle') ?></label>
                            <div class="col-sm-4">
                                <?php
                                $d = $this->utilityclass->getAllCircleName($dist_code, $subdiv_code);
                                ?>
                                <select  class="form-control circleselect" id="select" required name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                    <?php foreach ($d as $name) { ?>
                                        <option value="<?php echo $name->cir_code; ?>"  >
                                            <?php echo $name->loc_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('mouza') ?></label>
                            <div class="col-sm-4">
                                <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach ($mouzas as $d): ?>
                                        <option value='<?php echo $d->mouza_pargona_code; ?>'><?php echo $d->loc_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('lot_no') ?></label>
                            <div class="col-sm-4">
                                <select class="form-control lotselect" id="select" required name="lot_no">
                                    <option disabled selected>Select Lot Number</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('vill_town') ?></label>
                            <div class="col-sm-4">
                                <select class="form-control villageselect" id="select" required name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button') ?></button>
                                <button type="" class="btn btn-danger uni_text"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>