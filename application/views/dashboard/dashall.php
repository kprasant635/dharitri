<?php 
   $dist_code=$this->session->userdata('dist_code');?>

<style type="text/css">
  col-lg-3.a.test:hover{
    color: #ffff;
    text-decoration:none ;
  }



</style>

 <div class="container-fluid">

  <h3>Detail information about Circle</h3>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background-color: #ffffff !important">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</nav>
 <?php if ($this->session->flashdata('message')): ?>
  <?php include 'message.php'; ?>
  <?php endif; ?>
<div class="dash_content_area">
<div class="col-lg-12">
<div class="row"> <!--Second Row Start-->
  <div class="col-lg-4">
    <div class="card bg-info text-white" style="background-color: #f79924b8 !important">
            <div class="card-body text-white" style="color: #000000 !important;">
                <h5 class="card-title"><img src="<?php echo base_url('assets/recieved.png');?>" style="height:22px;width:22px;" alt="New Applications"> New Applications as on
                  <?php echo date("Y-m-d")?></h5>
              </div>
        <div class="card-footer">
        <small class="text-white" style="color: #000000 !important;"> Cases: <?=$all_field?> </small>
      </div>
      <div class="card-footer">
        <small class="text-white"></small>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card bg-warning text-white" style="background-color: #2ea4f7b3 !important">
            <div class="card-body" style="color: #000000 !important;">
                <h5 class="card-title"><img src="<?php echo base_url('assets/processing.png');?>" style="height:22px;width:22px;" alt="Pending Applications"> Pending Applications</h5>
              </div>
        <div class="card-footer">
        <small class="text-white" style="color: #000000 !important;">Cases: <?=$pen_field?> </small>
      </div>
      <div class="card-footer">
        <small class="text-white"></small>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card bg-success text-white" style="background-color: #12a2688f !important">
            <div class="card-body" style="color: #000000 !important;">
                <h5 class="card-title"><img src="<?php echo base_url('assets/completed.png');?>" style="height:22px;width:22px;" alt="Completed Applications"> Completed Applications</h5>
              </div>
        <div class="card-footer">
        <small class="text-white" style="color: #000000 !important;">Cases: <?=$del_field?> </small>
      </div>
      <div class="card-footer">
        <small class="text-white"></small>
      </div>
    </div>
  </div>
  </div>
    </div>
</div><!--Second Row End-->

    
  <p>Detailed breakdown of pending cases:</p>
  <div class="col-lg-12">
  <div class="row ban-min-cards"> <!--Second Row Start-->
  <div class="col-lg-3">
   <a href="<?php echo base_url(); ?>index.php/DashboardController/pending" class="test text-decoration-none  text-decoration-none "> 
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold font-weight-bold">Mutation</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Office: <?=$o_mut?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/fieldnew.png');?>" alt="Field"> Field: <?=$field_mut?></small>
      </div>
    </div></a>
  </div>
  <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingPart" class="test text-decoration-none ">

    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">Partition</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Office: <?=$o_part?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/fieldnew.png');?>" alt="Field"> Field: <?=$field_part?></small>
      </div>
    </div>

  </a>
  </div>
  <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingConv" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">Conversion</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$conversion?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src="" > </small>
      </div>
    </div>
  </a>
  </div>
  <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingReclass" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">Reclassification</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$reclassification?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </a>
  </div>
    <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCitizen" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">Citizen Certificate</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$certificate?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </a>
  </div>
   <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingApcancel" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">AP Cancellation</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$apcases?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""></small>
      </div>
    </div>
  </a>
  </div>
<div class="col-lg-3">
   <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingAcPp" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">AC to PP</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$acpp?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </a>
  </div>
   <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingSettle" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">Settlement</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$settlement?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </a>
  </div>
   <div class="col-lg-3">
    <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingMisc" class="test text-decoration-none ">
    <div class="card">
            <div class="card-body">
        <p title="Click here for a detailed view" class="card-title font-weight-bold">Misc Case</p>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <?=$misccases?></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </a>
  </div>
                                                    
  </div>
</div><!--Second Row End-->
                    </div>
                    </div>  
                </div>