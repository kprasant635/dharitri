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
                    <h2 style="text-align: center;"> Modify Pattadar Name In Chitha / Jamabandi </h2>
                    <h2 class="red" style="text-align: center;">Please select the name to be modified from both chitha and jamabandi for better correction.</h2>
                </div>
            </div>      
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
              <?php endif; ?>          
            <?php
            if ($existname) {
                echo'<div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                <p class="uni_text red">Some Of Already Requested Name(s) pending  for COs approval </p>';
                    foreach ($existname as $r):
                    ?>
                    <p class='uni_text'>New Name : <kbd><?= $r->pdar_name; ?> Gurdian Name: <?php echo  $r->pdar_father; ?></kbd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Old Name : <kbd><?= $r->pdar_old_name . " Gurdian Name :" . $r->pdar_old_father; ?></kbd> </p>
                    <?php
                endforeach;
                echo'</div></div>';
            }
            ?>
            <form class='form-horizontal' name="form" method="POST" action="<?php echo base_url() . "index.php/JamaeditEntry/modifypdarbothways"; ?>" enctype="multipart/form-data">
                <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Pattadar Name in Jamabandi
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 red control-label">Select Pattadar</label>
                                    <div class="col-sm-8">
                                        <select class='form-control pdar_dag' required name='pdar'>
                                            <option selected>Select Name Of Pattadar</option>
                                                <?php
                                                foreach($pattadar as $p):
                                                    if ($p->p_flag == 1) {
                                                        echo '<option value='.$p->pdar_id.' style="color:#ff0000;text-decoration: line-through;">'.$p->pdar_name .' ( '. $p->pdar_father .' )</option>';
                                                    } else {
                                                        echo '<option value='.$p->pdar_id.'>'.$p->pdar_name .' ( '. $p->pdar_father .' )</option>';
                                                    }
                                                endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 red control-label">Old Pattadar Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="oldpdar" id="oldpdar"  value="" readonly="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Suggested Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="dSuggest"  autocomplete="off" name='pname' placeholder='Write Here'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 red control-label">Old Gurdian Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control"  readonly name="oldguard" id="oldguard" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Suggested Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" autocomplete="off" required='' id='gSuggest' placeholder='Write Here' name='gurdian' class="form-control" >
                                    </div>
                                </div>
                                <p><mark>Lot Mondal's Note On Action</mark></p>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p>আবেদনকাৰী লিগেচী তথ্যৰ নাম <span id='oldpdart'></span> <span id='oldguardt'></span> পৰা <span id='output'></span> <span id='guardN'></span> সংশোধনী বিচাৰিছে | উপৰোক্ত তথ্য সংশোধন ৰ বাবে আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷</p>
                                        <input type='hidden' name='note_1' value='আবেদনকাৰী লিগেচী তথ্যৰ নাম ' />
                                        <input type='hidden' name='note_2' value=' সংশোধনী বিচাৰিছে | উপৰোক্ত তথ্য সংশোধন ৰ বাবে আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷' />
                                    </div>
                                </div>
                                <hr>
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
                                Pattadar Name in Chitha Based on Dags
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
    $(document).ready(function () {
        $(".pdar_dag").change(function () {
            var selectedVal = $(".pdar_dag option:selected").val();

            $.ajax({
                url: baseurl + "jamaeditentry/getPdarGurdianName/" + selectedVal,
                success: function (data) {
                    console.log(data);
                    var jama = JSON.parse(data);
                    $('#oldpdar').val(jama.pdar_name);
                    $('#oldguard').val(jama.pdar_father);
                    $('#oldpdart').text(jama.pdar_name);
                    $('#oldguardt').text(' ( '+jama.pdar_father+' ) ');
                }
            });

            $.ajax({
                url: baseurl + "jamaeditentry/getPdarDagDetails/" + selectedVal,
                success: function (data) {
                    var result = JSON.parse(data);
                    var template = "<tr><td>Dag No</td><td>Pattadar Name</td><td>Gurdian Name</td><td>Yes</td></tr>"
                    if ( result.length == 0 ) {
                        template += '<tr class="danger"><td colspan="4"><span style="Color:#ff0000;">This Pattadar Doesnot Exists in any Dag..!</span></td></tr>';
                    } else {
                        for (var i = 0; i < result.length; i++) {
                            if (result[i].p_flag == 1) {
                                var classa = 'danger';
                                var stylea = 'Color:#ff0000;text-decoration: line-through';
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

        $('#dSuggest').on("input", function () {
            var dInput = this.value;
            console.log(dInput);
            $('#output').text(dInput);
        });
        $('#gSuggest').on("input", function () {
            var dInput = this.value;
            console.log(dInput);
            $('#guardN').text(' ( '+dInput+' ) ');
        });
    });
</script>