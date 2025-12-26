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

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                <hr>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Process Name</th>
                        <th>Total No. Case</th>
                        <th style="width: 200px; text-align:center!important;" >Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">Cases forwarded by DC for Hearing</td>
                        <td>
                            <?php
                            if ($hearingAdcCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$hearingAdcCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$hearingAdcCount</span>";
                            }
                            ?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantAdc/viewAllApFirstProceedingDCCaseList'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">Cases list Rejected by DC</td>
                        <td>
                            <?php
                            if ($rejctedListCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$rejctedListCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$rejctedListCount</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDC/rejectedList?service='.SETTLEMENT_TENANT_ID.'&s=D&office='.MB_DEPUTY_COMM; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });
</script>

