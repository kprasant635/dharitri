<style>
    .c-dashboardInfo {
        margin-bottom: 15px;
    }

    .c-dashboardInfo .wrap {
        background: #ffffff;
        box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
        border-radius: 7px;
        text-align: center;
        position: relative;
        overflow: hidden;
        padding: 40px 25px 20px;
        height: 100%;
    }

    .c-dashboardInfo__title,
    .c-dashboardInfo__subInfo {
        color: #6c6c6c;
        font-size: 1.18em;
    }

    .c-dashboardInfo span {
        display: block;
    }

    .c-dashboardInfo__count {
        font-weight: 600;
        font-size: 2.5em;
        line-height: 64px;
        color: #323c43;
    }

    .c-dashboardInfo .wrap:after {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        content: "";
    }

    .c-dashboardInfo:nth-child(1) .wrap:after {
        background: linear-gradient(82.59deg, #0084f4 0%, #00a173 100%);
    }

    .c-dashboardInfo:nth-child(2) .wrap:after {
        background: linear-gradient(81.67deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo:nth-child(3) .wrap:after {
        background: linear-gradient(69.83deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo:nth-child(4) .wrap:after {
        background: linear-gradient(81.67deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo:nth-child(5) .wrap:after {
        background: linear-gradient(81.67deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo:nth-child(6) .wrap:after {
        background: linear-gradient(81.67deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo__title svg {
        color: #d7d7d7;
        margin-left: 5px;
    }

    .MuiSvgIcon-root-19 {
        fill: currentColor;
        width: 1em;
        height: 1em;
        display: inline-block;
        font-size: 24px;
        transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        user-select: none;
        flex-shrink: 0;
    }
</style>
  <?php include APPPATH.'views/time_left.php'; ?>
<?=GLOBAL_CASE_SEARCH?>


<div id="root">
    <div class="container pt-5">
        <div class="row align-items-stretch">
            <?php foreach ($servicecount as $row) : ?>
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title"><?= $row['service']; ?></h4>
                        <?php if($row['service_code']=='13') {?>
                          <!-- <a href="<?php //echo base_url()?>index.php/SettlementVgrPgrSdo/viewAllTenantFirstProceedingDCCaseList"><span class="hind-font caption-12 c-dashboardInfo__count"><?php //echo $row['count'] ?></span></a> -->
                          
                        <?php } else if($row['service_code']=='14') {?>
                        <a href="<?php echo base_url()?>index.php/SettlementApSdo/SettlementApLandDc"><span class="hind-font caption-12 c-dashboardInfo__count"><?= $row['count'] ?></span></a>
                        <?php } else if($row['service_code']=='15') {?>
                        <a href="<?php echo base_url()?>index.php/SettlementTribalSdo/SettlementTribalLandSdo"><span class="hind-font caption-12 c-dashboardInfo__count"><?= $row['count'] ?></span></a>
                        <?php } else if($row['service_code']=='16') {?>
                        <a href="<?php echo base_url()?>index.php/SettlementMbSdo/SettlementKhasLandDc"><span class="hind-font caption-12 c-dashboardInfo__count"><?= $row['count'] ?></span></a>
                        <?php } else if($row['service_code']=='17') {?>
                        <a href="<?php echo base_url()?>index.php/SettlementVgrPgrSdo/SettlementVgrPgrLandSdo"><span class="hind-font caption-12 c-dashboardInfo__count"><?= $row['count'] ?></span></a>
                        <?php } else if($row['service_code']=='18') {?>
                        <a href="<?php echo base_url()?>index.php/SettlementTeaSdo/SettlementTeaLandDc"><span class="hind-font caption-12 c-dashboardInfo__count"><?= $row['count'] ?></span></a>
                        <?php }?>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>