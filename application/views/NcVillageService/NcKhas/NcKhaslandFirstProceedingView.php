<style>
    .head{
        font-size:18px;
        font-weight: 700;
        color: #0C4358;
        padding: 15px;
        margin-bottom: 10px;
        text-transform: capitalize;
    }
    .res-out{
        font-weight: 700;
    }
    .warning-color{
        color:#B08500;
        font-weight: 600;
    }
    .reza-title{
        font-size:18px;
        font-weight: 700;
        color: #0C4358;
        padding-left: 15px;
        padding-right: 15px;
        padding-bottom: 10px;
        padding-top: 1px;
        margin-bottom: 10px;
        text-transform: capitalize;
    }

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
        padding: 15px;
        margin-top: 13px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #4CAF50;
    }
    .buttBrust {
        color: #FFF;
        background-color: #795548;
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


    #dagDetailsModal {
        /* display: flex; */
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        min-width: 700px!important;
    }
</style>

<div class="wrapper reza-card ">
    <div class="row">
        <div class="col-md-12 text-center" style="margin-top: 15px">
            <h4><?php echo $this->lang->line('ncKhasLandTitle')?></h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 reza-title" >
            Application Information
        </div>
    </div>
    <?php include(APPPATH."views/NcVillageService/NcKhas/include/application_information.php");?>

    <hr>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="row">
                <div class="col-md-12 reza-title">
                    Main Applicant Details
                </div>
                <div class="col-md-12" id="mainApplicant">

                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-4 col-sm-4 ">
            <div class="col-md-12 reza-title">
                Location
            </div>
            <div class="col-12">
                <?php include(APPPATH."views/NcVillageService/NcKhas/include/location_details.php");?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="col-md-12 reza-title text-left" style="margin-top: 15px;">
                Self Declaration Details
            </div>
            <div class="col-12">
                <?php include(APPPATH."views/NcVillageService/NcKhas/include/self_dec_details.php");?>
            </div>
        </div>
    </div>
</div>



<div class="wrapper reza-card " style="margin-top: 15px; margin-bottom: 15px">

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="col-md-12 reza-title" >
                Encroacher Details
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right">
            <button class="rezaButt buttPrimary" onclick="dagDetails('<?php echo $_GET['an']?>')">
                <i class="fa fa-plus-circle"></i> Add Dag Details
            </button>
        </div>
    </div>

    <?php include(APPPATH."views/NcVillageService/NcKhas/include/encroacher_information.php");?>

    <?php include(APPPATH."views/NcVillageService/NcKhas/include/dag_info_insert.php");?>

    <?php include(APPPATH."views/NcVillageService/NcKhas/include/dag_info_view.php");?>

    <?php include(APPPATH."views/NcVillageService/NcKhas/include/dag_info_update.php");?>




</div>



<script>
    $(document).ready(function(){
        var application_no = "<?php echo $_GET['an']?>"
        getIsApplicant(application_no);
    })
</script>

<script src="<?php echo base_url();?>js/NcVillage/lm/get_is_applicant.js"></script>
<script src="<?php echo base_url();?>js/NcVillage/lm/dag_info_insert.js"></script>