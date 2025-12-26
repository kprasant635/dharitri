<div class="container-fluid">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/home/index">Home</a></li>

        
      </ol>
</nav>
 <div class="dash_content_area">
<h4>Time taken for each process</h4>
<center>
<table class="table table-sm" style="width: 50%;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th>Process Type</th>
       <th scope="col">Min</th>
        <th scope="col">Max</th>
        <th scope="col">Average</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
      foreach($citizen as $key => $citizen){ ?>
    <tr>
      <th scope="row"><?php echo $key+1 ?></th>
        <td><a><?php echo ($citizen['type']);?></a></td>
        <td><a><?php echo $citizen['min']<0?0:$citizen['min']; ?></a></td>
        <td><a><?php echo $citizen['max'];?></a></td>
        <td><a><?php echo round($citizen['avg']);?></a></td>
    </tr>
  <?php }?>   
  </tbody>
</table>
</center>
</div>         
</div>