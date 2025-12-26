 <?php 
   $dist_code=$this->session->userdata('dist_code');
   include APPPATH.'views/time_left.php';
 ?>

<?php if(ESCALATION_MODAL_OPEN == 1){ include 'escalation_lm.php'; }?>
<?php if(EKHAJANA_LM_PENDING_CONTROL == '1' && $ekhajana_pending_lm_cases>0): ?>
    <div class="bg-dark text-danger h5 col-lg-10 offset-1 mt-5 text-center p-3">
        NO OF EKHAZANA PENDING CASES (TILL-YESTERDAY): <?=$ekhajana_pending_lm_cases?><br>
        AFTER CLEARING THE PENDING CASES, THE REST OF THE DHARITREE MODULES CAN BE ACCESSED. 
    </div>
<?php else: ?>  
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

  <?php if ($this->session->flashdata('error_data')): ?>
    <div class="container-fluid">
      <div class='col-lg-12'>
        <div class="alert alert-danger alert-dismissible" role="alert" style="text-align: center;" >
          <strong>
            <?php
            echo $this->session->flashdata('error_data'); 
            ?>
          </strong>
        </div>
      </div>
    </div>

  <?php endif; ?>

  <?php if ($this->session->flashdata('message_success')): ?>
    <div class="container-fluid">
      <div class='col-lg-12'>
        <div class="alert alert-info alert-dismissible" role="alert" style="text-align: center;" >
          <strong>
            <?php
            echo $this->session->flashdata('message_success'); 
            ?>
          </strong>
        </div>
      </div>
    </div>

  <?php endif; ?>

  <div class="dash_content_area">
    <div class="col-lg-12">
      <div class="row"> <!--Second Row Start-->
        <div class="col-lg-4">
          <div class="card bg-info text-white">
            <div class="card-body text-white">
              <h5 class="card-title"><img src="<?php echo base_url('assets/recieved.png');?>" style="height:22px;width:22px;" alt="New Applications"> New Applications received on today</h5>
            </div>
            <div class="card-footer">
             <small class="text-white"> Cases: <span class="" style="font-size: 22px"><?=$all_field ?></span> </small>
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
            <h5 class="card-title"><img src="<?php echo base_url('assets/completed.png');?>" style="height:22px;width:22px;" alt="Completed Applications"> Disposed Applications</h5>
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
          <a href="" title="Click here for a detailed view" class="card-title">Mutation</a>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Office: <span class="" style="font-size: 22px"><a href="#"><?=$o_mut?></span></a></small>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/fieldnew.png');?>" alt="Field"> Field:<span class="" style="font-size: 22px"><a href="#"> <?=$field_mut?></span></a></small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <a href="" title="Click here for a detailed view" class="card-title">Partition</a>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Office: <span class="" style="font-size: 22px"><a href="#"><?=$o_part?></span></a></small>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/fieldnew.png');?>" alt="Field"> Field: <span class="" style="font-size: 22px"><a href="#"><?=$field_part?></span></small></a>
        </div>
      </div>
    </div>
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
          <a href="" title="Click here for a detailed view" class="card-title">Reclassification</a>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases:<span class="" style="font-size: 22px"> <a href="#"><?=$reclassification?></span></a></small>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src=""> </small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <a href="" title="Click here for a detailed view" class="card-title">Citizen Certificate</a>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases:<span class="" style="font-size: 22px"> <a href="#"><?=$certificate?></span></a></small>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src=""> </small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <a href="" title="Click here for a detailed view" class="card-title">AP Cancellation</a>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="#"><?=$apcases?></span></a></small>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src=""></small>
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
          <a href="" title="Click here for a detailed view" class="card-title">Settlement</a>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="#"><?=$settlement?></span></a></small>
        </div>
        <div class="card-footer">
          <small class="text-muted"><img src=""> </small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <a href="" title="Click here for a detailed view" class="card-title">Misc Case</a>
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
<input type="hidden" value="<?=$stateCadre?>" id='stateCadre'>
<?php //include 'lm_state_cadre.php'; ?>

<?php endif ?>  