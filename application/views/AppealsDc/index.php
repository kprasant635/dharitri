<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Appeals Cases</h3>
                </div>
                <div class="panel-body">
                   <table class="table table-striped">
                   <thead>
                    <tr>
                        <th>Case No</th>
                        <th>Date of Appeal</th>
                        <th>Action</th>
                    </tr>
                   </thead>
                   <tbody>
                      <?php foreach($data as $d):?>
                          <tr>
                            <td><?php echo $d->case_no;?></td>
                            <td><?php echo $d->case_no;?></td>
                            <td><a href="">First proceeding</a></td>
                          </tr>
                      <?php endforeach;?>
                   </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
