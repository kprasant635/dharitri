<div class="container-fluid form-top">
    <div class="row login">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center; ">Pattadar Details Entry Form for A.P. Cancellation Petition (NR Cases)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Case No(গোছৰ নং) : <?php echo $caseno; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . "index.php/APCancellation/ASTStep5"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Pattadar No (পট্টাদাৰৰ নং)</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" name="pattadar_no" value="<?php echo $pdar_id + 1; ?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Pattadar Name (পট্টাদাৰৰ নাম)</label>
                                <div class="col-lg-4">
                                    <select class="form-control pdar_id" id="select" name="pattadar" required>
                                        <option value="" selected>Select Pattadar (পট্টাদাৰ বাচনি কৰক)</option>
                                        <?php
                                        foreach ($pdar_info AS $pdar) {
                                            $val = $pdar->pdar_id . "#" . $pdar->pdar_name;
                                            ?>
                                            <option value="<?php echo $val; ?>"><?php echo $pdar->pdar_name; ?></option>                                       
                                        <?php } ?>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label">Guardian's Name (অভিভাৱকৰ নাম)</label>
                                <div class="col-lg-4 pdar_father">
                                    <input type="text" class="form-control" name="pdar_father" value="" placeholder="অপৰিচিত" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Relation (সম্বন্ধ)</label>
                                <div class="col-lg-4 pdar_guard_reln">
                                    <input type="text" class="form-control" name="pdar_guard_reln" value=""  placeholder="অপৰিচিত"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Address 1 (ঠিকনা ১)</label>
                                <div class="col-lg-10 pdar_add1">
                                    <textarea class="form-control" name="pdar_add1"  placeholder="অপৰিচিত"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Address 2 (ঠিকনা ২)</label>
                                <div class="col-lg-10 pdar_add2">
                                    <textarea class="form-control" name="pdar_add2" placeholder="অপৰিচিত"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-9 col-lg-offset-3">
                                    <button type="submit" name="ASTStep5Submit" class="btn btn-primary"><i class='fa fa-check'></i>Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp;Back to Main Menu
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
