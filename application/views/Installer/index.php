<div class="row">
<div class="col-lg-8 col-lg-offset-2">
<div class="panel panel-primary">
  <div class="panel-heading">
    <div class="panel-title">
      <p class="">Installation</p>
    </div>
  </div>
  <div class="panel-body">
            <form action="<?php echo base_url().'index.php/Installer/index';?>" method="post" >
              <div class="form-group">
                <label for="email">IP Address/Hostname of the Server</label>
                <input type="text" name="ip" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="pwd">Full Path to Folder of the app</label>
                <input type="text" name="folder" class="form-control" id="pwd">
              </div>
             
              <button type="submit" class="btn btn-default">Install</button>
            </form>               
   </div>
</div>


</div>
</div>