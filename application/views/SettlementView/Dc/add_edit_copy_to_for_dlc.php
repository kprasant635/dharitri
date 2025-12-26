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
    .rezaS{
        background-color: #ECEFF1;
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
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
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
    .btn-info{

    }
    .form-checkbox-input
    {
        width: 18px!important;
        height: 18px!important;
    }
    .me-1
    {
        width: 18px!important;
        height: 18px!important;
    }

    .field-group {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    .field-group input {
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .delete-btn {
        background-color: #ff4d4d;
        color: white;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 5px;
    }
    .rezaStar{
        font-weight: bold;
        font-size: 18px;
        color: red;
    }
</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="font-size: 20px;">
            <strong>Add / Edit  Members For Minutes Copy to for DLC :-</strong>

        </div>

        <div class="reza-card">
            <div class="reza-title"></div>
            <div class="reza-body">

                <form method="post" action="<?=base_url().'index.php/SettlementCommonDc/saveCcDataForDLC'?>">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <h3 class="alert-warning text-center"><?=$this->session->flashdata('message')?></h3>

                            <div id="fieldContainer">
                                <div class="field-group">
                                    <?php if($isInserted == true): ?>
                                        <?php foreach ($inserted_data as $data) : ?>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>SL. No. <span class="rezaStar">*</span></label>
                                                    <br>
                                                    <input type="number" class="form-control" name="slno[]"  value="<?php echo $data->sl_no ?>" required placeholder="Enter number">
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Name<span class="rezaStar">*</span></label>
                                                    <br>
                                                    <input type="text" class="form-control" name="name[]" value="<?php echo $data->user_name ?>" required placeholder="Enter Name">
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Designation<span class="rezaStar">*</span></label>
                                                    <br>
                                                    <input type="text" class="form-control" name="designation[]" value="<?php echo $data->user_desg ?>" required placeholder="Enter Designation">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>SL. No. <span class="rezaStar">*</span></label>
                                            <br>
                                            <input type="number" class="form-control" name="slno[]" required placeholder="Enter number">
                                        </div>
                                        <div class="col-md-5">
                                            <label>Name<span class="rezaStar">*</span></label>
                                            <br>
                                            <input type="text" class="form-control" name="name[]" required placeholder="Enter Name">
                                        </div>
                                        <div class="col-md-5">
                                            <label>Designation<span class="rezaStar">*</span></label>
                                            <br>
                                            <input type="text" class="form-control" name="designation[]" required placeholder="Enter Designation">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="rezaButt buttPrimary" type="button" onclick="addMore()">Add More</button>
                            <br><br>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4">
                                <button type="submit" class="rezaButt pull-right"
                                        id="saveData">Save Data
                                </button>
                            </div>
                            <br><br>

                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>


<script>
    function addMore() {
        const container = document.getElementById('fieldContainer');

        const newGroup = document.createElement('div');
        newGroup.className = 'field-group';

        newGroup.innerHTML = `
        <div class="row">
            <div class="col-md-2">
                <label>SL. No. <span class="rezaStar">*</span></label>
                <br>
                <input type="number" class="form-control" name="slno[]" required placeholder="Enter number">
            </div>
            <div class="col-md-5">
                <label>Name<span class="rezaStar">*</span></label>
                <br>
                <input type="text" class="form-control" name="name[]" required placeholder="Enter Name">
            </div>
            <div class="col-md-5">
                <label>Designation<span class="rezaStar">*</span></label>
                <br>
                <input type="text" class="form-control" name="designation[]" required placeholder="Enter Designation">
            </div>
        </div>

        <button type="button" class="delete-btn" onclick="removeGroup(this)">Delete</button>
    `;

        container.appendChild(newGroup);
    }

    function removeGroup(button) {
        const group = button.parentElement;
        group.remove();
    }
</script>

