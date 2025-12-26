
<?php if($this->session->userdata('user_desig_code') == 'LM' && MB3_LIVE != 0) { ?>

  <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB3</a>
  
  <div class="dropdown-container">
    <a href="<?php echo base_url(); ?>index.php/Home/TeaGrantLandLm?service=<?=TEA_SERVICE_CODE?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tea Grant</a>
     <a href="<?php echo base_url(); ?>index.php/Home/ReclassSuiteLm?service=<?=RECLASS_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Reclassification Suite</a>
     <a href="<?php echo base_url(); ?>index.php/SettlementInstitutionLm/menuLm?service=<?=SLIJE_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Juridical Entities</a>
     <a href="<?php echo base_url("index.php/mb3_conversion_lm"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP to PP Conversion</a>
     <a href="<?php echo base_url(); ?>index.php/NcVillageHomeController/NcKhasLandLm?service=<?=NC_KHAS_LAND_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Svamitva NC Village</a>
     <a href="<?php echo base_url(); ?>index.php/Home/SettlementTenantLmUrban?service=<?=SETTLEMENT_TENANT_URBAN_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Settlement of Tenant Urban</a>
     <a href="<?php echo base_url(); ?>index.php/Home/BhoodanLm?service=<?=BHODDAN_SERVICE_CODE?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Bhoodan Gramdan</a>
  </div>


<?php }?>

    