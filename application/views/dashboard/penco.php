<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Home</a></li>
<!-- <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/DashboardController/dashAll">Pending applications</a></li> -->
        
      </ol>
</nav>
 <div class="dash_content_area">
<h4>CO wise list of pending applications</h4>
<center>
<table class="table table-sm" style="width: 50%;">
  <thead>
    <tr>
      <th scope="col">#</th>
      
       
        <th scope="col">Circle</th>
        <th scope="col">Mouza</th>
        <th scope="col">No of cases</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 

    if (is_array($citizen)) {

      foreach($citizen as $key => $citizen){ ?>
    <tr>
      <th scope="row"><?php echo $key+1 ?></th>
       <td><a><?php echo $citizen['cir_name'];

                                         
                                            ?></a>
                  
         </td>
      
        <td><a><?php echo $citizen['mouza_name'];

                                         
                                            ?></a>
                  
         </td>

         
         

         <td><a><?php echo $citizen['case_no'];

                                         
                                            ?></a></td>



    </tr>


  <?php
    }
   }?>

     <!-- <tr>
      <th scope="row">1</th>
      <td><a>mouzaname2</a></td>
        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"></span></h5>
                  
                      </td>
    </tr>
    

 <tr>
      <th scope="row">1</th>
      <td><a>mouzaname3</a></td>
        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"></span></h5>
                  
                      </td>
    </tr>
       -->
   
  </tbody>
</table>
</center>
</div>         
                      
                    </div>