<div class="container-fluid">
<div class="row">
    <nav class="navbar navbar-default menu">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand brand" href="<?php echo base_url();?>index.php/home/"><i class='fa fa-home red'></i> Dharitee</a>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Report <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>index.php/chithareport">Chitha Report</a></li>
                            <li><a href="<?php echo base_url();?>index.php/chithareportkamrup">Chitha Report ( Kamrup Metro )</a></li>
                            <li><a href="<?php echo base_url();?>index.php/JamabandiControllerBondita/menu">Jamabandi Report</a></li>
                            <li><a href="<?php echo base_url();?>index.php/MisReport">MIS Report </a></li>
                            <li class="divider"></li>
                            <li><a href="#">Allotment Register</a></li>
                            <li><a href="#">Encroachment Register</a></li>
                            <li><a href="#">Khatian ( Tenant Register )</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>
                       </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Maintenance <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Jamabandi Auto-update</a></li>
                            <li><a href="#">Inconsistent Jamabandi View / Delete</a></li> 
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Query <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">location Codes</a></li>
                            <li><a href="#">Master Codes</a></li>
                            <li><a href="#">Field Mutation Case Status</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Data Size</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Utility <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" class="not-active">Delete Pattadar</a></li>
                            <li><a href="#" class="not-active">Delete Dag Information</a></li>
                            <li><a href="#" class="not-active">Delete Office Half Done Case</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="not-active">Dag No. Enumeration</a></li>
                            <li><a href="#" class="not-active">Duplicate Pattadar Management</a></li>
                            <li><a href="#" class="not-active">Corresponding SK Code Correction</a></li>
                        </ul>
                    </li>
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
                    </li>
                </ul>
                   
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="#">Link</a></li>-->
                    <li><a href="#">Logged in as Office Controller</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <i class="fa fa-cog"></i></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Change Password</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/login/logout">Logout</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
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
