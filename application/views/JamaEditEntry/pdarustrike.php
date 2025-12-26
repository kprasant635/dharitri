<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <!-- <h2 style="text-align: center;"> Un-Strike Out Pattadar Name In Chitha / Jamabandi</h2>
                    <h2 class="red" style="text-align: center;">Please select the name to be un-stricked out from both chitha and jamabandi for better correction.</h2> -->
                    <h2 style="text-align: center;"> Un-Strike Out Pattadar Name In Chitha </h2>
                    <h2 class="red" style="text-align: center;">Please select the name to be un-stricked out from chitha.</h2>
                </div>
            </div> 
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
              <?php endif; ?>               
            <?php 
                if($insert){
                    echo'<div class="col-lg-10 col-lg-offset-1">
                            <div class="well well-sm">
                            <p class="uni_text red">Some Of Already Requested Un-Strike Out Name(s) pending  for COs approval </p>';
                            foreach($insert as $r):
                            ?>
                            <p class='uni_text'>New Name : <kbd><?=$r->pdar_name;?> Gurdian Name: <?=$r->pdar_father;?></kbd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dag No : <kbd><?=$r->dag_no;?></kbd> </p>
                            <?php 
                            endforeach;
                     echo'</div></div>';
                } 
            ?>
            <form class="form-horizontal" enctype="multipart/form-data" role="form" action='<?= base_url();?>index.php/jamaeditentry/deopdarustrikebothways' method="post">
            <div class="col-lg-5 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Request For Pattadar Name Un-Strike Out (Chitha) <!--(Jamabandi)!-->
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 red control-label">Pattadar List(s)</label>
                                <div class="col-sm-8">
                                    <select class='form-control pdar_dag' required name='pdar'>
                                        <option selected>Select Name Of Pattadar</option>
                                        <?php
                                        foreach($pattadars as $p):
                                            if ($p->p_flag == 1) {
                                                echo '<option value='.$p->pdar_id.' style="color:#ff0000;text-decoration: line-through;">'.$p->pdar_name .' ( '. $p->pdar_father .' )</option>';
                                            } else {
                                                echo '<option value='.$p->pdar_id.'>'.$p->pdar_name .' ( '. $p->pdar_father .' )</option>';
                                            }
                                        endforeach; ?>
		</select>
                                </div>
                            </div>
                            <p><mark>Lot Mondal's Note On Action</mark></p>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="lm_note" class="form-control" rows="5">হাতৰ জমাবন্দীৰ তথ্যৰ ভিত্তিত উক্ত জমাবন্দীত উপৰত দিয়া অনুসৰি লিগেচী তথ্যৰ সংশোধনী বিচাৰিছে | উপৰোক্ত সংশোধন কেইটা কৰা হল আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷ </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">Please Upload Hand Chitha/Jama Scan Copy</div>
                                <div class="col-sm-12">
                                    <div class="btn btn-primary btn-sm float-left btn-block">
                                        <input type="file" name="file_upload" id="fileupload" required="">
                                        <span>Only jpg,jpeg,png,doc,docx,pdf,txt type files are allowed</span>
                                    </div>
                                </div>
                            </div>	
                            <hr>
                            <div class="col-sm-12 center">
                                <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp; Submit</button>
                                <a class="btn btn-danger" href="<?php echo base_url();?>index.php/jamaeditentry/pattadarlist/"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Pattadar Name Un-Strike Out (Dag)
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                                <table class='table table-stripped table-hover dag'>
                                    
                                </table>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
$(".pdar_dag").change(function(){
    var selectedVal = $(".pdar_dag option:selected").val();
    $.ajax({
            url: baseurl + "jamaeditentry/getPdarDagDetails/" + selectedVal,
            success: function (data) {
                var result = JSON.parse(data);
                var template = "<tr><td colspan='4'><span style='Color:#ff0000;'>Do You want to Un-Strike from all the Dags in Chitha</span></td></tr>"
                template += "<tr><td>Dag No</td><td>Pattadar Name</td><td>Gurdian Name</td><td>Yes</td></tr>"
                if ( result.length == 0 ) {
                    template += '<tr class="danger"><td colspan="4"><span style="Color:#ff0000;">This Pattadar Doesnot Exists in any Dag..!</span></td></tr>';
                } else {
                    
                    for (var i = 0; i < result.length; i++) {
                        if (result[i].p_flag == 1) {
                            var classa = 'danger';
                            var stylea = 'Color:#ff0000;text-decoration: line-through';
                        } else{
                            var classa = '';
                            var stylea = '';
                        }
                        template += '<tr class="'+classa+'"><td><span style="'+stylea+'">' + result[i].dag + '</span></td><td><span style="'+stylea+'">' + result[i].pdar_name + '</span></td><td><span style="'+stylea+'">' + result[i].pdar_father + '</span></td><td><label><input type="checkbox" name="dag_dag_no[]" value="'+ result[i].dag +'" checked>&nbsp;</label><input type="hidden" name="dag_pdar_id['+ result[i].dag +']" value="'+ result[i].pdar_id +'"></td></tr>';
                        //console.log(template);
                    }
                }
                //console.log(template);
                $('.dag').html(template);
            }
    })
});

</script>