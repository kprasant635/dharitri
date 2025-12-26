<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaLmController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-list)</li>
  </ol>
</nav>
<nav class="navbar navbar-light bg-light">
  <form class="form-inline" action="<?php echo base_url();?>index.php/findCases/autoFetchIniPay" method="POST">
    <input class="form-control mr-sm-2" name="application_no" autocomplete="off" type="search" placeholder="Find cases here" aria-label="Search">
    <input type="hidden" name="app_type" autocomplete="off" value="EKH">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>
</nav>
<?php
    $alert_var = $this->session->flashdata('message');
?>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-secondary text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajna-(Pending-List)</b><br>
            </u>                        
        </h3>
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_lm_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>RTPS-APPLICATION-NO</td>
                                <td>VILLAGE-NAME</td>
                                <td>PATTA-NO</td>
                                <td>PATTADAR-NAME</td>
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($pending_list as $row):?>                                    
                                <tr>                                    
                                    <td>
                                        <span class="font-weight-bold text-danger">
                                            <?= $row->ld_application_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getVillageName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code, 
                                            $row->lot_no, $row->vill_townprt_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-danger">
                                            <?= $row->patta_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                        <?= $row->pdar_name?>
                                        <span>
                                    </td>
                                    <td>
                                         <a class="btn btn-success btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/EkhajanaLmController/pendingCaseDetails/'.$row->ld_id?>" role="button" style="font-size: 14px;">
                                            View Details
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    const alertMsg = "<?=$alert_var;?>";
    if(alertMsg.length > 0){
        Toast.fire({
                    title: alertMsg,
                    icon: 'error'
                });
    }
</script>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_lm.js"></script>