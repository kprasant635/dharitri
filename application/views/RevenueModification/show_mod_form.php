<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location'); ?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/RevenueModification/showLandClasses"; ?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('urban_rural'); ?></label>
                            <div class="col-lg-9">
                                <label class="checkbox-inline"><input type="radio" id="u"   name="urban" >Urban</label>
                                <label class="checkbox-inline"><input type="radio" id="r" name="urban" >Rural</label>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('land_type'); ?></label>
                            <div class="col-lg-9">
                                <select disabled="" class="form-control districtselect" id="LmMutationSelectDistrict" name="landclass" required>
                                    <option selected disabled>Select Land Class</option>
                                    <?php foreach ($landclasses as $landclass): ?>
                                        <option value="<?php echo $landclass->class_code ?>"><?php echo $landclass->land_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('existing_revenue'); ?></label>
                            <div class="col-lg-9">
                                <input type="number" readonly="" name="existing" class="form-control" required="required"/>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text control-label"><?php echo $this->lang->line('land_revenue'); ?></label>
                            <div class="col-lg-9">
                                <input type="number" name="revenue" class="form-control" required="required"/>
                            </div> 
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>