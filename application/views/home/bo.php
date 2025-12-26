<?php 
   $dist_code=$this->session->userdata('dist_code');
   include APPPATH.'views/time_left.php';
   ?>


 <div class="container-fluid">
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
    <div class="card bg-info text-white">
            <div class="card-body text-white">
                <h5 class="card-title"><img src="<?php echo base_url('assets/recieved.png');?>" style="height:22px;width:22px;" alt="New Applications"> New Applications as on
                  <?php echo date("Y-m-d")?></h5>
              </div>
        <div class="card-footer">
       <small class="text-white"> Cases: <span class="" style="font-size: 22px"><?=$all_field?></span> </small>
      </div>
      <div class="card-footer">
        <small class="text-white"></small>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title"><img src="<?php echo base_url('assets/processing.png');?>" style="height:22px;width:22px;" alt="Pending Applications"> Pending Applications</h5>
              </div>
        <div class="card-footer">
        <small class="text-white">Cases: <span class="" style="font-size: 22px"><?=$pen_field?> </span> </small>
      </div>
      <div class="card-footer">
        <small class="text-white"></small>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title"><img src="<?php echo base_url('assets/completed.png');?>" style="height:22px;width:22px;" alt="Completed Applications"> Completed Applications</h5>
              </div>
        <div class="card-footer">
        <small class="text-white">Cases: <span class="" style="font-size: 22px"><?=$del_field?></span> </small>
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
    <div class="card">
            <div class="card-body">
        <a href="" title="Click here for a detailed view" class="card-title">Conversion</a>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases:<span class="" style="font-size: 22px"><a href="#"> <?=$conversion?></span></a></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src="" > </small>
      </div>
    </div>
  </div>
  
  
<div class="col-lg-3">
    <div class="card">
            <div class="card-body">
        <a href="" title="Click here for a detailed view" class="card-title">AC to PP</a>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="#"><?=$acpp?></span></a></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </div>
   

   <div class="col-lg-3">
    <div class="card">
            <div class="card-body">
        <a href="" title="Click here for a detailed view" class="card-title">Appeal cases</a>
              </div>
        <div class="card-footer">
        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="#"><?=$misccases?></span></a></small>
      </div>
      <div class="card-footer">
        <small class="text-muted"><img src=""> </small>
      </div>
    </div>
  </div>
                                                    
  </div>
</div><!--Second Row End-->
                    </div>
                    </div>  
                </div>