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
<div class="container-fluid home" style="min-height:500px;">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="uni_text">Edit Pattadars</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Sl. No</th>
                            <th>Pattadar Name</th>
                            <th>Guardian</th>
                            <th>Address1</th>
                            <th>Address2</th>
                            <th>Address3</th>
                            <th>Actions</th>
                        </tr>
                        <?php $count=0;foreach($pattadars as $p):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $p->pdar_name;?></td>
                            <td><?php echo $p->pdar_father;?></td>
                            <td><?php echo $p->pdar_add1;?></td>
                            <td><?php echo $p->pdar_add2;?></td>
                            <td><?php echo $p->pdar_add3;?></td>
                            <th><a href="<?php echo base_url().'index.php/RecordCorrectionController/editForm/'.$p->pdar_id;?>">Edit</a></th>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>