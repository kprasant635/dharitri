<style>
    .rezaInfo {
        color: #FFF!important;
        background-color: #03a9f4!important;
    }
    .rezaPrint {
        color: #FFF!important;
        background-color: #673AB7!important;
    }
    .rezaButt:hover {
        color: #0c0c0c!important;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px!important;
        min-width: 150px!important;
        line-height: 35px!important;
        padding: 0 1rem;
        font-size: 15px!important;
        font-weight: 600!important;
        font-family: "Roboto", sans-serif;
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
</style>
<div class="container-fluid">

    <?php if($this->session->userdata('user_desig_code') == 'CO') : ?>
        <div class="col-lg-12" style="margin-top: 25px">
            <div class="row">
                <div class="card-body" style="background-color: white">
                    <p style="font-size: 18px;font-weight: bold">Total No. of Basundhara 2.0 Chitha Update  </p>

                    <?php if($countReport == 0): ?>
                        No data found !
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <td>Application No</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($reports as $report): ?>
                                    <tr>
                                        <td><?php echo $report->case_no ?></td>
                                        <td>
                                            <a class="rezaButt rezaInfo" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=<?php echo $report->case_no; ?>" >
                                                <i class="fa fa-eye"></i>&nbsp;view
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>


