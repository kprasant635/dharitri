<!--<?php // KKB0007: Improvement of Land Share Details 
    ?> -->
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Update Land Share Information
                        </h3>
                    </div>
                    <form class='form-horizontal' method="post" action="">
                        <div class="panel-body">
                            <div id="dynamic_field">
                                <div class="form-group mb-2">
                                    <label for="inputEmail3" class="col-sm-4 uni_text control-label required">Indivisual Land Share Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" title="Enter Per Bigha Land Revenue" name="revenuebigha" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 uni_text control-label required">Area </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" placeholder="Bigha">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" placeholder="Katha">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" placeholder="Lessa">
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="inputEmail3" class="col-sm-4 uni_text control-label required">English Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" title="Enter Per Bigha Land Revenue" name="revenuebigha" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 uni_text control-label required" id='gender'>Gender</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="RuralUrban" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <button type="button" name="add" id="addPerson" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                </div>
                                <hr style="border-bottom: 2px dashed #000;  background-color: #fff">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 center">
                                    <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?> & Save</button> &nbsp;&nbsp; | &nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var i = 1;
        $('#addPerson').click(function() {
            i++;
            $('#dynamic_field').append('<div id="row' + i + '"> <div class="form-group"><label for="inputEmail3" class="col-sm-4 uni_text control-label required">Indivisual Land Share Name</label><div class="col-sm-6"><input type="text" class="form-control" title="Enter Per Bigha Land Revenue" name="revenuebigha" required></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 uni_text control-label required">Area </label><div class="col-sm-2"><input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" placeholder="Bigha"></div><div class="col-sm-2"><input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" placeholder="Katha"></div><div class="col-sm-2"><input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" placeholder="Lessa"></div></div><div class="form-group mb-2"><label for="inputEmail3" class="col-sm-4 uni_text control-label required">English Name</label><div class="col-sm-6"><input type="text" class="form-control" title="Enter Per Bigha Land Revenue" name="revenuebigha" required></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 uni_text control-label required" id="gender">Gender</label><div class="col-sm-4"><select class="form-control" name="RuralUrban" required><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div><button type="button" name="add" class="btn btn-danger btn_remove" id="' + i + '"><i class="fa fa fa-trash"></i></button></td> </div><hr style="border-bottom: 2px dashed #000; background-color: #fff;"> </div>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");

            $('#row' + button_id + '').remove();
        });
    });
</script>