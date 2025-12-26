<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Home</a></li>
<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Pending applications</a></li>
        
      </ol>
</nav>
 <div class="dash_content_area">
<h4>Role wise list of pending Reclassification applications</h4>
<center>
<table class="table table-sm" style="width: 50%;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Role</th>
       <th scope="col">No of cases</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><a>CO</a></td>
        <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$recl?></span></h5>
                  
                      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td><a>LM</a></td>
        <td class="text-sm">
                        <h5><a href="<?php echo base_url(); ?>index.php/DashboardController/pendingReclassLM"><span class="badge badge-primary"><?=$lmrecl?></span></a></h5>
                      </td>
      
    </tr>
     <tr>
      <th scope="row">3</th>
      <td><a>SK</a></td>
        <td class="text-sm">
                        <h5><span class="badge badge-sm bg-gradient-success"><?=$skrecl?></span></h5>
        </td>
      
    </tr>
    <tr>
      <th scope="row">4</th>
      <td><a>AST</a></td>
       <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$astrecl?></span></h5>
                      </td>
                    </tr>

     <!--  <tr>
      <th scope="row">4</th>
      <td><a>DC</a></td>
       <td class="text-sm">
                       <h5> <span class="badge badge-sm bg-gradient-success"><?=$dcrecl?></span></h5>
                      </td>
                    </tr> -->
   
  </tbody>
</table>
</center>
</div>         
                      
                    </div>