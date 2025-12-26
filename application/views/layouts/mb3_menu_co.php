

<?php if($this->session->userdata('user_desig_code') == 'CO' && MB3_LIVE != 0) { ?>

  <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB 3.0</a>
  
  <div class="dropdown-container">
    <a href="<?php echo base_url(); ?>index.php/Home/TeaGrantLandCo?service=<?=TEA_SERVICE_CODE?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tea Grant</a>
    <a href="<?php echo base_url(); ?>index.php/Home/ReclassSuiteLandCo?service=<?=RECLASS_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Reclassification Suite</a>
    <a href="<?php echo base_url(); ?>index.php/SettlementInstitutionCo/index?service=<?=SLIJE_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Juridical Entities</a>

    <a href="<?php echo base_url(); ?>index.php/Home/BhoodanCo?service=<?=BHODDAN_SERVICE_CODE?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Bhoodan/Gramdan</a>
    <a href="<?php echo base_url("index.php/mb3_conversion_co"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP to PP Conversion</a>
    <?php
    if(TENANT_URBAN != CLOSE){
    ?>
        <a href="<?php echo base_url(); ?>index.php/home/TenantUrbanCoLanding?service=<?=SETTLEMENT_TENANT_URBAN_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Settlement of Tenant Urban</a>

    <?php  }?>

    <?php if(NC_LIVE != 0)
          {
        ?>
        <a href="<?php echo base_url(); ?>index.php/NcVillageHomeController/NcKhasLandCo?service=<?=NC_KHAS_LAND_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Svamitva NC Village</a>
              
    <?php  }?>

  </div>


<?php }?>









