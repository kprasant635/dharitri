<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Home</a></li>

    <?php

      if($this->session->userdata('user_desig_code')=='CO') 
        {    
      ?>

<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/DashboardController/dashAll">Pending applications</a></li>

  <?php  }

  

  elseif ($this->session->userdata('user_desig_code')=='DC') { ?>

    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/DashboardController/dashAllDistrict">Pending applications</a></li>

 <?php  } ?>
        


      </ol>
</nav>
 <div class="dash_content_area">
<h4>Role wise list of pending <?= $type ?> applications</h4>
<center>
<table class="table table-sm" style="width: 50%;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Role</th>
       <th scope="col">No of cases</th>

       <?php 

       if($type=='mutation' or $type=='partition') { ?>

        <th scope="col">Field <?= $type ?></th>
         <th scope="col">Office <?= $type ?></th>

      <?php  } ?>

        
      
    </tr>
  </thead>
  <tbody>


    <tr>
      <th scope="row">1</th>
      <td><a>CO</a></td>

                  <!-- <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOconv"><span class=""><?=$mut?></span></a></h5>
                 
                      </td> -->

                       <?php if($type=='mutation' and $this->session->userdata('user_desig_code')=='CO') { ?>

                      <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$mut?></span></h5>
                      </td>

                      <td class="text-sm"> 

                       <h5><span class="badge badge-sm bg-gradient-success"><?=$fmut?></span></a></h5>
                 
                      </td>

                      <td class="text-sm"> 

                       <h5><span class="badge badge-sm bg-gradient-success"><?=$omut?></span></a></h5>
                 
                      </td>
                
                   <?php  } ?>





                      <?php if($type=='conversion') { ?>

                      <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOconv"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>
                
                   <?php  }

                    elseif($type=='reclassification')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOreclass"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>

                    <?php } 


                    elseif($type=='citizen certificate')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOcert"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>

                    <?php } 

                     elseif($type=='AP cancellation')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOapcancel"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>

                    <?php } 

                     elseif($type=='Allotment')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOalot"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>

                    <?php } 

                    elseif($type=='settlement')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOsettle"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>

                    <?php } 

                    elseif($type=='misccases')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOmisc"><span class="badge badge-primary"><?=$mut?></span></a></h5>
                 
                      </td>

                    <?php } 

                    ?>


                      <?php if($type=='mutation' and $this->session->userdata('user_desig_code')=='DC' )  { ?>

                      <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$mut?></span></h5>
                      </td>

                      <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOfm"><span class="badge badge-primary"><?=$fmut?></span></a></h5>
                 
                      </td>
                
                   <?php  } ?>

                  <?php   if($type=='partition' and  ($this->session->userdata('user_desig_code')=='DC' or $this->session->userdata('user_desig_code')=='ADC'))  { ?>

                      <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$mut?></span></h5>
                      </td>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOfp"><span class="badge badge-primary"><?=$fmut?></span></a></h5>
                 
                      </td>
                    <?php } ?>


                    <?php if($type=='mutation' and ($this->session->userdata('user_desig_code')=='DC' or $this->session->userdata('user_desig_code')=='ADC' )) { ?>

                      <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOom"><span class="badge badge-primary"><?=$omut?></span></a></h5>
                 
                      </td>
                
                   <?php  }

                    elseif($type=='partition' and $this->session->userdata('user_desig_code')=='DC')  { ?>

                     <td class="text-sm"> 

       
                       <h5> <a href="<?php echo base_url(); ?>index.php/DashboardController/pendingCOop"><span class="badge badge-primary"><?=$omut?></span></a></h5>
                 
                      </td>
                    <?php } ?>
          

    </tr>
    <tr>
      <th scope="row">2</th>
      <td><a>LM</a></td>
      <?php

      if($this->session->userdata('user_desig_code')=='CO') 
        {    
      ?>

        <td class="text-sm">
                        <h5><a href="<?php echo base_url(); ?>index.php/DashboardController/pendingLM"><span class="badge badge-primary"><?=$lmmut?></span></a></h5>
                      </td>

        <?php } 

        else { ?>
          <td class="text-sm">
                        <h5><a href=""><span class="badge badge-sm bg-gradient-success"><?=$lmmut?></span></a></h5>
                      </td>
       <?php  } ?>




          <?php if($type=='mutation' or $type=='partition') { ?>

           <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$lmfmut?></span></h5>
                  
                      </td>

            <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$lmomut?></span></h5>
                  
                      </td>
          <?php   }?>
      
    </tr>
     <tr>
      <th scope="row">3</th>
      <td><a>SK</a></td>
        <td class="text-sm">
                        <h5><span class="badge badge-sm bg-gradient-success"><?=$skmut?></span></h5>
        </td>
  <?php if($type=='mutation' or $type=='partition') { ?>
         <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$skfmut?></span></h5>
                  
                      </td>

            <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$skomut?></span></h5>
                  
                      </td>
      <?php   }?>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td><a>AST</a></td>
       <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$astmut?></span></h5>
                      </td>
         <?php if($type=='mutation' or $type=='partition') { ?>
                      <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$astfmut?></span></h5>
                  
                      </td>

            <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$astomut?></span></h5>
                  
                      </td>
                    </tr>

            <?php   }?> 


<?php

      if($this->session->userdata('user_desig_code')=='DC') 
        {    
      ?>
        <tr>
      <th scope="row">5</th>
      <td><a>DC</a></td>
       <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$dcmut?></span></h5>
                      </td>

             <?php if($type=='mutation' or $type=='partition') { ?>
            <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$dcmut?></span></h5>
                      </td>

                <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>
                <?php   }?>
                    </tr>


        <tr>
      <th scope="row">6</th>
      <td><a>ADC</a></td>
       <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>
 <?php if($type=='mutation' or $type=='partition') { ?>

        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>

        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>

                      <?php   }?>
                    </tr>


           <?php } ?>


    <?php

      if($this->session->userdata('user_desig_code')=='ADC') 
        {    
      ?>
    <tr>
      <th scope="row">6</th>
      <td><a>ADC</a></td>
       <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>
 <?php if($type=='mutation' or $type=='partition') { ?>

        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>

        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$adcmut?></span></h5>
                      </td>

                      <?php   }?>
                    </tr>


           <?php } ?>       



   
  </tbody>
</table>
</center>
</div>         
                      
                    </div>