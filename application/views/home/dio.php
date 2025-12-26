<style>
    .casedisplay {
        min-height: 0px;
    }

    .casedisplay-small {
        min-height: 120px;
    }

    .casedisplay:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    td{
        font-size: .9em;
    }
</style>
<div class="container-fluid login home" style="min-height:500px;">
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        
        <div class="col-lg-12">
            <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> NATIONAL INFORMATICS CENTRE ( District Informatics Officer ) DASHBOARD</label></td>
                    <td><?php //include 'login_alert.php'; ?></td>
                </tr>
            </table>
            
            
        </div>
        <?php
        $change_password = $my_info->first_login;
        if($change_password == 'Y'): ?> 
            <?php include 'first_login.php'; ?>
        <?php endif; ?>
    </div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

