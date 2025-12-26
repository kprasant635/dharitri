<div class="container-fluid">
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('query');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><?php echo $this->lang->line('location_code');?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('master_code');?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('field_mutation_case_status');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo $this->lang->line('data_size');?></a></li>
                        </ul>
                    </li>
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Initialization <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">locations</a></li>
                            <li><a href="#">User Account</a></li>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Other Master Code</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Revenue Location </a></li>
                            <li><a href="#">Certificate Type</a></li>
                        </ul>
                    </li>-->
                </ul>
                   
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="#">Link</a></li>-->
                    <li>
                        <a><?php echo $this->lang->line('welcome');?> <?php echo $this->session->userdata('user_code')."(".$this->session->userdata('user_desig_code').")";?></a>
                    </li>
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings');?> <i class="fa fa-cog"></i></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><?php echo $this->lang->line('password_settings');?></a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout');?></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><?php echo $this->lang->line('separated_link');?></a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
</div>
<style>
    .not-active {
        pointer-events: none;
        cursor: default;
    }
</style>
