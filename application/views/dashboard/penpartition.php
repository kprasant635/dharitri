<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Home</a></li>
<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Pending applications</a></li>
        
      </ol>
</nav>
 <div class="dash_content_area">
<h4>Role wise list of pending Partition applications</h4>
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
        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$part?></span></h5>
                  
                      </td>

        <?php if($type=='mutation' or $type=='partition') { ?>

          <td class="text-sm"> 

       
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$fmut?></span></h5>
                 
                      </td>


            <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$omut?></span></h5>
                  
                      </td>

                      <?php  }?>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td><a>LM</a></td>
        <td class="text-sm">
                        <h5><a href="<?php echo base_url(); ?>index.php/DashboardController/pendingLMPart"><span class="badge badge-primary"><?=$lmpart?></span></a></h5>
                      </td>

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
                        <h5><span class="badge badge-sm bg-gradient-success"><?=$skpart?></span></h5>
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
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$astpart?></span></h5>
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
                    </tr>
   
  </tbody>
</table>
</center>
</div>         
                      
                    </div>