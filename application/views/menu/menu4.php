
<div class="row">
    <nav class="navbar navbar-default menu">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand brand" href="<?php echo base_url();?>index.php/home/"><i class='fa fa-home red'></i> <?php echo $this->lang->line('dharitree');?></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Data Entry / Edit <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Chitha Register Entry / Edit</a></li>
                            <li><a href="#">Jamabandi Remark Entry / Edit</a></li>
                            <li><a href="#">Complete Jamabandi View / Edit</a></li>                              
                        </ul>
                    </li>-->
					
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>index.php/chithareport/districtDetails"><?php echo $this->lang->line('chitha_report');?></a></li>
                            <li><a href="<?php echo base_url();?>index.php/chithareportnew"><?php echo $this->lang->line('chitha_report');?> New</a></li>
                            <li><a href="<?php echo base_url();?>index.php/chithareportkamrup"><?php echo $this->lang->line('chitha_report_kamrup');?></a></li>
                            <li><a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report');?></a></li>
                            <li><a href="<?php echo base_url();?>index.php/MisReport"><?php echo $this->lang->line('mis_report');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo $this->lang->line('allotment_register');?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('encroachment_register');?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('khatian_tenant_register');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>
                       </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>index.php/Jamabandi"> <?php echo $this->lang->line('jamabandi_auto_update');?></a></li>
                            <li><a href="#"> <?php echo $this->lang->line('inconsistance_jamabandi_view_delete');?></a></li> 
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('query');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><?php echo $this->lang->line('location_code');?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('master_code');?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('field_mutation_case_status');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo $this->lang->line('data_size');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('utility');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" class="not-active"><?php echo $this->lang->line('delete_pattadar');?></a></li>
                            <li><a href="#" class="not-active"><?php echo $this->lang->line('delete_dag_info');?></a></li>
                            <li><a href="#" class="not-active"><?php echo $this->lang->line('delete_office_half_done_case');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="not-active"><?php echo $this->lang->line('dag_no_enumeration');?></a></li>
                            <li><a href="#" class="not-active"><?php echo $this->lang->line('duplicate_pattadar_management');?></a></li>
                            <li><a href="#" class="not-active"><?php echo $this->lang->line('corresponding_sk_code_correction');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('initialisation');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>index.php/initialization/location"><?php echo $this->lang->line('location');?></a></li>
                            <li><a href="<?php echo base_url();?>index.php/initialization/master_code"><?php echo $this->lang->line('other_master_code');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo $this->lang->line('revenue_location');?> </a></li>
                            <li><a href="#"><?php echo $this->lang->line('certificate_type');?></a></li>
                        </ul>
                    </li>
                </ul>
                   
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="#">Link</a></li>-->
                    <li>
                        <a><?php echo $this->lang->line('welcome');?>  <?php echo $this->session->userdata('user_code')."(".$this->session->userdata('user_desig_code').")";?></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings');?> <i class="fa fa-cog"></i></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>index.php/initialization/useraccount "><?php echo $this->lang->line('new_account');?></a></li>
                            <li><a href="<?php echo base_url();?>index.php/initialization/viewaccount "><?php echo $this->lang->line('view_account');?></a></li>
                            <li><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code='.$this->session->userdata('user_code'); ?>"><?php echo $this->lang->line('my_account');?></a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout');?></a></li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>

<style>
    .not-active {
    pointer-events: none;
    cursor: default;
    }
</style>
