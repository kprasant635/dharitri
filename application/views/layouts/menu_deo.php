<style>
.fa, .fas {
    font-weight: 900 !important;
}
.hide{
	display: none;
}
.main-sidebar{
	background:#0360a2;
}
.sidebar a{
	color:#f2f2f2 !important;
}
</style>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style='width: 235px !important;'>
    
    <!-- Sidebar -->
    <div class="sidebar">
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview ">
            <a href="<?php echo base_url(); ?>index.php/home/index" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                 
              </p>
            </a>
			</li>
		 
		    <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left:15px">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails" class="nav-link">
                  <i class="far fa fa-newspaper-o nav-icon"></i>
                  <p>Chitha Reports</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu" class="nav-link">
                  <i class="far fa fa-newspaper-o nav-icon"></i>
                  <p>Jamabandi Reports</p>
                </a>
              </li>
			   
			  
            
            </ul>
          </li>
		  

		   

          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left:15px">
              
              <li class="nav-item">
                <a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change password</p>
                </a>
              </li>
            </ul>
          </li>
       
		  <!-- <li class="nav-item has-treeview ">
            <a href="<?php echo base_url(); ?>index.php/login/logout" class="nav-link ">
              <i class="nav-icon fa fa-sign-out"></i>
              <p>
              Log Out
              </p>
            </a>
          </li> -->
		  </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>