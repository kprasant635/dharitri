<?php 
   $dist_code=$this->session->userdata('dist_code');
   // include APPPATH.'views/time_left.php';
   ?>

<?=GLOBAL_CASE_SEARCH?>

<input type="hidden" name="doul_info" id="doul_info" value="<?=$doul_info?>">
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
      <div class="row">
        <?php if(ESCALATION_ENABLE == 1 ) 
        { 
            include(APPPATH."views/common/dc/dc_escalate_list.php"); 
        }
        ?>
    </div>
<div class="col-lg-12">
<div class="row"> <!--Second Row Start-->
  <div class="col-lg-4">
    <div class="card bg-info text-white">
            <div class="card-body text-white">
                <h5 class="card-title"><img src="<?php echo base_url('assets/recieved.png');?>" style="height:22px;width:22px;" alt="New Applications"> New Applications received on today</h5>
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
  </div>
</div><!--Second Row End-->
  </div>
  </div>  
</div>
<script type="text/javascript">
    $( document ).ready(function() {
      var doul_info = $('#doul_info').val();
      //alert(doul_info);
      if(doul_info >= 1)
      {
        $('#rejectCO').show();
      }
      else
      {
        $('#rejectCO').hide();
      }
     $(document).on('click','.btnYes', function(){
        // $('#rejectCO').hide();
        location.href = baseurl + "GenerateDoul/viewDoulInDC"
    });
});
</script>
<style>
    .modal {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background-color: #fff;
        opacity: 1; /* Fully opaque content */
    }
</style>
<div id="rejectCO" class="modal" style="display: flex;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height: 300px;">
            <div class="modal-header">
                <h3 class="modal-title">Warning!!</h3>
            </div>
            <form id='' action="" method="post" >
                <div class="modal-body">
                    <div>
                       <h5>
                        Doul generation is pending in your A/C. Kindly approve the douls by following the process flow - <br><br><kbd>Menu -> Process -> Doul -> Indirect Paying Doul</kbd>
                       </h5>               
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-primary btnYes">Ok</button>
                </div>
            </form> 
        </div>
    </div>
</div>