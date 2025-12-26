<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }
    #cases_wrapper {
        margin-top: 0px !important;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                        <span><?php echo $this->lang->line('sdlacCommitteeDetails') ?></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12" align="right">
                        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
                        <button class="rezaButt" id="editSdlacComm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            <?php echo $this->lang->line('sdlacComEdit') ?>
                        </button>
                    </div>
                </div>

                <hr>

            </div>

            <div class="reza-body" >


                <table class='table table-striped table-bordered '  width="100%">

                    <tbody>
                    <tr>
                        <td style="width: 35%">Member Name</td>
                        <td><?php echo $member->name; ?></td>
                    </tr>
                    <tr>
                        <td>Mobile Number</td>
                        <td><?php echo $member->phone; ?></td>
                    </tr>
                    <tr>
                        <td>Email Id</td>
                        <td><?php echo $member->email; ?></td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td><?php echo $member->designation; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <?php if($member->status == 1):  ?>
                                Active
                            <?php else: ?>
                                Inactive
                            <?php endif; ?>
                        </td>
                    </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Modal Revert to co -->
        <div class="modal" role="dialog" id="editSdlacCommMember">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit SDLAC Committee Member</h5>
                    </div>
                    <div class="modal-body" align="">
                        <form action="<?php echo base_url() . 'index.php/SettlementCommonDc/editSdlacMemberDetails'; ?>" method="post">
                            <input class="form-control" type="hidden" name="memId" value="<?php echo trim($member->id) ?>" required>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Name</label>
                                    <input class="form-control" name="name" value="<?php echo trim($member->name) ?>" required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Mobile Number </label>
                                    <input class="form-control" name="phone" value="<?php echo trim($member->phone) ?>"  required minlength="10" maxlength="10">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Email Id </label>
                                    <input class="form-control" name="email" value="<?php echo trim($member->email) ?>" required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Designation </label>
                                    <input class="form-control" name="designation" value="<?php echo trim($member->designation) ?>" required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Status </label>
                                    <select name="status" required class="form-control" >
                                        <?php if($member->status == 1): ?>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        <?php else: ?>
                                            <option value="1" >Active</option>
                                            <option value="0" selected>Inactive</option>
                                        <?php endif; ?>
                                    </select>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"  id="editSdlacCommMemberNo">CLOSE</button>
                                <button type="submit" class="btn btn-primary"   id="">UPDATE</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>





    </div>
</div>

<script>
    $(document).on('click','#editSdlacComm',function ()
    {
        $('#editSdlacCommMember').modal('show');
    });

    $(document).on('click','#editSdlacCommMemberNo',function ()
    {
        $('#editSdlacCommMember').modal('hide');
    });
</script>

