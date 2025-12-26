<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Disable this User?'))
            return (false);
        return (true);
    }
    function Confadd() {
        if (!confirm('Really want to Enable this User?'))
            return (false);
        return (true);
    }
</script>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 class="text-center">All Disabled Users</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Users</h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info">
                            <h6 class="red uni_text">
                                <b>NOTE: ALL IN-ACTIVE USERS ||  
                                Click on <span class="glyphicon glyphicon-ok-circle" style="color: green;"></span> to enable a user, or  
                                <span class="glyphicon glyphicon-pencil" style="color: blue;"></span> to update profile details.</b>
                            </h6>
                        </div>

                        <hr style="border-bottom: 2px solid #000;">
                        <mark class="uni_text">
                            <img src="<?php echo base_url(); ?>application/views/images/Exclamation.gif" width="5%"> 
                            The exclamation means the Sk for the corresponding Lot Mondol is either not assigned or assigned with a disabled SK.
                        </mark>

                        <table id="disabledUsersTable" class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Full Name</th>
                                    <th>Login Name</th>
                                    <th>Disable Date</th>
                                    <th>Designation</th>
                                    <th>Circle</th>
                                    <th>Mouza (For LM Only)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function ConfDel() {
    return confirm('Really want to Disable this User?');
}
function Confadd() {
    return confirm('Really want to Enable this User?');
}

$(document).ready(function () {
    $('#disabledUsersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('index.php/initialization/get_inactive_disabled_users_ajax'); ?>",
            "type": "POST"
        },
        "pageLength": 10,
        "order": [],
        "columns": [
            { "data": "status" },
            { "data": "name" },
            { "data": "login" },
            { "data": "disable_date" },
            { "data": "designation" },
            { "data": "circle" },
            { "data": "mouza" },
            { "data": "action" }
        ]
    });
});
</script>
