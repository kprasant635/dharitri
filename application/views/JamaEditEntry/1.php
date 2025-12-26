<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 ">

            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location'); ?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" >
                        <?php $i = 0;
                        for ($i = 0; $i < sizeof($fields); $i = $i + 2): ?>
                            <div class="form-group" style="width: 100%;">
                                
                               
                                <?php if($fields[$i]->column_name=='land_class_code'):?>
                                    
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'><?php echo strtoupper(implode(' ',explode("_",$fields[$i]->column_name))); ?></label>
                                    <div class="col-sm-4">
                                        <select class="form-control"><option>select land class code</option></select>
                                    </div>
                                    <?php elseif($fields[$i]->column_name=='patta_type_code'):?>
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'><?php echo strtoupper(implode(' ',explode("_",$fields[$i]->column_name))); ?></label>
                                    <div class="col-sm-4">
                                        <select class="form-control"><option>Patta Type</option></select>
                                    </div>
                                    <?php else:?>
                                   
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'><?php echo strtoupper(implode(' ',explode("_",$fields[$i]->column_name))); ?></label>
                                    <div class="col-sm-4">
                                         <input type="text" class="form-control"  required minlength="2" name="<?php echo $fields[$i]->column_name; ?>" id="applicantNam" required
                                           placeholder="">
                                    </div>
                                <?php endif;?>
                              
                                
                                <?php if(isset($fields[$i + 1])):?>
                                
                                 
                                <?php if($fields[$i+1]->column_name=='land_class_code'):?>
                                    
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'><?php echo strtoupper(implode(' ',explode("_",$fields[$i+1]->column_name))); ?></label>
                                    <div class="col-sm-4">
                                        <select class="form-control"><option>Land Class</option></select>
                                    </div>
                                    <?php elseif($fields[$i+1]->column_name=='patta_type_code'):?>
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'><?php echo strtoupper(implode(' ',explode("_",$fields[$i+1]->column_name))); ?></label>
                                    <div class="col-sm-4">
                                        <select class="form-control"><option>Patta Type</option></select>
                                    </div>
                                    <?php else:?>
                                   
                                    <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'><?php echo strtoupper(implode(' ',explode("_",$fields[$i+1]->column_name))) ?></label>
                                    <div class="col-sm-4">
                                         <input type="text" class="form-control"  required minlength="2" name="<?php echo $fields[$i + 1]->column_name; ?>" id="applicantNam" required
                                           placeholder="">
                                    </div>
                                <?php endif;?>
                                <?php endif;?>
                            </div>
                            <hr>
                            <?php endfor; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>