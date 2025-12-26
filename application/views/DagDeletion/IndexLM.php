<!-- Masud's CSS-->
<style>
    .error
    {
        color: red;
    }
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard {
        margin: 10px auto;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
        padding-top: 10px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }


    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005B96 !important;
        text-decoration: none;
    }
    .wizard li.active{
        background: #005B96;
        padding: 0px;
        box-shadow: 1px 0px 1px 1px;

    }

    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 45%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #ffffff;
    }

    .wizard .nav-tabs > li a {
        text-align: center;
        /* width: 90%; */
        margin-bottom: 10px;
        /* padding: 0; */
    }
    .wizard .nav-tabs > li a:hover {
        background-color: transparent !important;
    }


    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }



</style>

<style>
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

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
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
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }

    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        text-transform: capitalize;
        margin-left: 25px;
    }
    .reza-body{
        padding-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 10px;
        margin: 10px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
    .labDiv{
        margin-bottom: 15px;
    }
    .lab{
        margin-bottom: 5px;
    }
    .landDetails{
        display: none;
    }
    td{
        font-size: 16px;
    }
</style>


<div class="row" style='padding: 30px 40px 30px 10px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
            <br>
        <?php } ?>


        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
            DAG DELETION REQUEST
        </h5>

        <div class="reza-card">
            <div class="reza-body">
                <div class="tableCard">
                    <table class="table table-striped table-hover" >
                        <tbody style="font-size: 18px!important;">
                        <tr>
                            <td>Dag Deletion Request</td>
                            <td>

                            </td>
                            <td>
                                <a href="<?php echo base_url() . 'index.php/DagDeletionController/dagDeletionViewPageLm' ?>" class="rezaButt buttDanger" style="float:right">
                                    <i class="fa fa-pencil-square-o"></i> CREATE REQUEST
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Pending Dag Deletion Request </td>
                            <td>
                                <?php
                                if ($pending_count != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$pending_count</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$pending_count</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . 'index.php/DagDeletionController/viewPendingRequestDetailsLm' ?>" class="rezaButt buttInfo" style="float:right">
                                    <i class="fa fa-eye"></i> view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Approved Dag Deletion Request </td>
                            <td>
                                <?php
                                if ($approve_count != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$approve_count</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$approve_count</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . 'index.php/DagDeletionController/viewApproveRequestDetailsLm' ?>" class="rezaButt buttInfo" style="float:right">
                                    <i class="fa fa-eye"></i> view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Rejected Dag Deletion Request</td>
                            <td>
                                <?php
                                if ($rejected_count != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$rejected_count</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$rejected_count</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . 'index.php/DagDeletionController/viewRejectedRequestDetailsLm' ?>" class="rezaButt buttInfo" style="float:right">
                                    <i class="fa fa-eye"></i> view
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
