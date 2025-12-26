<!-- added by hriday - 25-04-2024 -->
<div class="container-fluid form-top login">
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <?php 
                echo '<div class="col-lg-12">
                    <p style="color:red;">'.$this->session->flashdata('message').'</p>
                </div>';
            ?>
        <?php endif; ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><p><b>Application</b></p></div>
                </div>
                <?php echo form_open_multipart(base_url("index.php/LMconversionPartha/submitApplication"), array('method' => 'post', 'id'=>'form_submit')); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <input type="hidden" name="dist_code" id="dist_code" value="<?php echo $location['dist_code']; ?>">
                            <input type="hidden" name="subdiv_code" id="subdiv_code" value="<?php echo $location['subdiv_code']; ?>">
                            <input type="hidden" name="cir_code" id="cir_code" value="<?php echo $location['cir_code']; ?>">
                            <input type="hidden" name="mouza_pargona_code" id="mouza_pargona_code" value="<?php echo $location['mouza_pargona_code']; ?>">
                            <input type="hidden" name="lot_no" id="lot_no" value="<?php echo $location['lot_no']; ?>">
                            <input type="hidden" id="originalbigha">
                            <input type="hidden" id="originalkatha">
                            <input type="hidden" id="originallessa">
                            <input type="hidden" id="partialpatta" value="0">
                            <input type="hidden" id="pattadarcount" value="0">
                            <div class="form-group">
                                <label for="">Village *</label>
                                <select name="vill_townprt_code" id="vill_townprt_code" class="form-control">
                                    <option value="">---Select Village---</option>
                                    <?php foreach($villages as $vill) { ?>
                                        <option value="<?php echo $vill->vill_townprt_code ?>"><?php echo $vill->loc_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Dag No. *</label>
                                <select name="dag_no" id="dag_no" class="form-control">
                                    <option value="">---Select Dag No.---</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Area to be converted *</label>
                                <div style="display: flex; justify-content: space-between;">
                                    <input type="number" id="bigha" name="bigha" placeholder="Bigha" max="">
                                    <input type="number" id="katha" name="katha" placeholder="Katha" max="4">
                                    <input type="number" id="lessa" name="lessa" placeholder="Lessa" max="19">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">Select Pattadars *</label>
                                <select name="pattadars[]" id="pattadars" class="form-control" multiple>
                                    <option value="">---Select Pattadars---</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Land Details: *</td>
                                        <td><input type="file" name="landdetails" id="landdetails"></td>
                                    </tr>
                                    <tr>
                                        <td>Upto date Land Revenue Receipt: *</td>
                                        <td><input type="file" name="landrevenue" id="landrevenue"></td>
                                    </tr>
                                    <tr>
                                        <td>Copy of Annual Patta: *</td>
                                        <td><input type="file" name="annualpatta" id="annualpatta"></td>
                                    </tr>
                                    <tr>
                                        <td>Trace Map of the Scheduled land: *</td>
                                        <td><input type="file" name="scheduleland" id="scheduleland"></td>
                                    </tr>
                                    <tr>
                                        <td>Chitha copy: *</td>
                                        <td><input type="file" name="chitha" id="chitha"></td>
                                    </tr>
                                    <tr>
                                        <td>ID Proof: *</td>
                                        <td><input type="file" name="idproof" id="idproof"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">Select Circle Officer *</label>
                                <select name="circleofficer" id="circleofficer" class="form-control">
                                    <option value="">---Select Circle Officer---</option>
                                    <?php foreach($users as $user) { ?>
                                            <option value="<?php echo $user['user_code']; ?>"><?php echo $user['username']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url(); ?>';

    $('#vill_townprt_code').on('change', (e) => {
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var cir_code = $('#cir_code').val();
        var mouza_pargona_code = $('#mouza_pargona_code').val();
        var lot_no = $('#lot_no').val();
        var vill_townprt_code = e.currentTarget.value;

        if(dist_code != '' && subdiv_code != '' && cir_code != '' && mouza_pargona_code != '' && lot_no != '' && vill_townprt_code != '') {
            $.ajax({
                url: base_url + 'index.php/AjaxController/getVillageDags',
                method: 'POST',
                data: {dist_code:dist_code, subdiv_code:subdiv_code, cir_code:cir_code, mouza_pargona_code:mouza_pargona_code, lot_no:lot_no, vill_townprt_code:vill_townprt_code},
                success: function(response) {
                    $('#dag_no').html('');
                    var result = JSON.parse(response);
                    // console.log(result);
                    if(result.length >0) {
                        $('#dag_no').append('<option value="">---Select Dag---</option>');
                        for(var i=0; i<result.length; i++) {
                            $('#dag_no').append('<option value='+result[i].dag_no+'>'+result[i].dag_no+'</option>');
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    $('#dag_no').on('change', (e)=> {
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var cir_code = $('#cir_code').val();
        var mouza_pargona_code = $('#mouza_pargona_code').val();
        var lot_no = $('#lot_no').val();
        var vill_townprt_code = $('#vill_townprt_code').val();
        var dag_no = e.currentTarget.value;

        if(dist_code != '' && subdiv_code != '' && cir_code != '' && mouza_pargona_code != '' && lot_no != '' && vill_townprt_code != '' && dag_no != '') {
            $.ajax({
                url: base_url + 'index.php/AjaxController/getDagDetails',
                method: 'POST',
                data: {dist_code:dist_code, subdiv_code:subdiv_code, cir_code:cir_code, mouza_pargona_code:mouza_pargona_code, lot_no:lot_no, vill_townprt_code:vill_townprt_code, dag_no:dag_no},
                success: function(response) {
                    var result = JSON.parse(response);
                    // console.log(result);
                    $('#bigha').val(result.dag_details.dag_area_b);
                    $('#katha').val(result.dag_details.dag_area_k);
                    $('#lessa').val(result.dag_details.dag_area_lc);

                    $('#originalbigha').val(result.dag_details.dag_area_b);
                    $('#originalkatha').val(result.dag_details.dag_area_k);
                    $('#originallessa').val(result.dag_details.dag_area_lc);



                    $('#pattadars').html('');
                    var pattadarcount = 0;
                    result.pattadar_details.forEach(element => {
                        pattadarcount += 1;
                        $('#pattadars').append('<option value='+element.pdar_id+'>'+element.pdar_name+' ('+element.pdar_father+')</option>');
                    });
                    $('#pattadarcount').val(pattadarcount);
                    
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    $('#bigha').on('change', (e) => {
        var currentBigha = e.currentTarget.value;
        var currentKatha = $('#katha').val();
        var currentLessa = $('#lessa').val();
        var originalBigha = $('#originalbigha').val();
        var originalKatha = $('#originalkatha').val();
        var originalLessa = $('#originallessa').val();
        var partialpatta = $('#partialpatta').val();

        var totallessa = (currentBigha * 5 * 20) + (currentKatha * 20) + currentLessa;
        var totalOriginalLessa = (originalBigha * 5 * 20) + (originalKatha * 20) + originalLessa;

        if(totallessa > totalOriginalLessa) {
            alert("Converted Area cannot be greater than the original Area.");
            $('#bigha').val(originalBigha);
            $('#katha').val(originalKatha);
            $('#lessa').val(originalLessa);
        }
        else if(totallessa == totalOriginalLessa) {
            $('#partialpatta').val('0');
        }

        if(currentBigha != originalBigha || currentKatha != originalKatha || currentLessa != originalLessa) {
            if(partialpatta == '0') {
                $('#partialpatta').val('1');
            }
        }
    });
    $('#katha').on('change', (e) => {
        var currentBigha = $('#bigha').val();
        var currentKatha = e.currentTarget.value;
        var currentLessa = $('#lessa').val();
        var originalBigha = $('#originalbigha').val();
        var originalKatha = $('#originalkatha').val();
        var originalLessa = $('#originallessa').val();
        var partialpatta = $('#partialpatta').val();

        var totallessa = (currentBigha * 5 * 20) + (currentKatha * 20) + currentLessa;
        var totalOriginalLessa = (originalBigha * 5 * 20) + (originalKatha * 20) + originalLessa;

        if(totallessa > totalOriginalLessa) {
            alert("Converted Area cannot be greater than the original Area.");
            $('#bigha').val(originalBigha);
            $('#katha').val(originalKatha);
            $('#lessa').val(originalLessa);
        }
        else if(totallessa == totalOriginalLessa) {
            $('#partialpatta').val('0');
        }

        if(currentBigha != originalBigha || currentKatha != originalKatha || currentLessa != originalLessa) {
            if(partialpatta == '0') {
                $('#partialpatta').val('1');
            }
        }
    });
    $('#lessa').on('change', (e) => {
        var currentBigha = $('#bigha').val();
        var currentKatha = $('#katha').val();
        var currentLessa = e.currentTarget.value;
        var originalBigha = $('#originalbigha').val();
        var originalKatha = $('#originalkatha').val();
        var originalLessa = $('#originallessa').val();
        var partialpatta = $('#partialpatta').val();

        var totallessa = (currentBigha * 5 * 20) + (currentKatha * 20) + currentLessa;
        var totalOriginalLessa = (originalBigha * 5 * 20) + (originalKatha * 20) + originalLessa;

        if(totallessa > totalOriginalLessa) {
            alert("Converted Area cannot be greater than the original Area.");
            $('#bigha').val(originalBigha);
            $('#katha').val(originalKatha);
            $('#lessa').val(originalLessa);
        }
        else if(totallessa == totalOriginalLessa) {
            $('#partialpatta').val('0');
        }

        if(currentBigha != originalBigha || currentKatha != originalKatha || currentLessa != originalLessa ) {
            if(partialpatta == '0') {
                $('#partialpatta').val('1');
            }
        }
    });

    // $('#pattadars').on('change', (e) => {
    //     console.log($('#partialpatta').val());
    //     console.log(e.currentTarget.value);
    // });

    $('#form_submit').on('submit', (e) => {
        e.preventDefault();

        var partialpatta = $('#partialpatta').val();
        var originalpattadarcount = $('#pattadarcount').val();
        var pattadars = $('#pattadars').val();
        var pattadarcount = pattadars.length;

        if(partialpatta == 1) {
            // if(originalpattadarcount == pattadarcount) {
            //     alert("No of pattadars selected must be lesser than the original no. of pattadars for a partial conversion");
            //     return;
            // }
        }
        else if(partialpatta == 0) {
            if(originalpattadarcount > pattadarcount) {
                alert("All pattadar must be selected in case of full conversion");
                return;
            }
        }

        // console.log(pattadarcount, originalpattadarcount);
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var cir_code = $('#cir_code').val();
        var mouza_pargona_code = $('#mouza_pargona_code').val();
        var lot_no = $('#lot_no').val();
        var vill_townprt_code = $('#vill_townprt_code').val();
        var dag_no = $('#dag_no').val();
        var bigha = $('#bigha').val();
        var katha = $('#katha').val();
        var lessa = $('#lessa').val();
        var circleofficer = $('#circleofficer').val();
        var landdetails = document.getElementById('landdetails').files[0];
        var landrevenue = document.getElementById('landrevenue').files[0];
        var annualpatta = document.getElementById('annualpatta').files[0];
        var scheduleland = document.getElementById('scheduleland').files[0];
        var chitha = document.getElementById('chitha').files[0];
        var idproof = document.getElementById('idproof').files[0];

        if(pattadarcount > 0 && dist_code != '' && subdiv_code != '' && cir_code != '' && mouza_pargona_code != '' && lot_no != '' && vill_townprt_code != '' && dag_no != '' && bigha != '' && katha != '' && lessa != '' && circleofficer != '' && landdetails != undefined && landrevenue != undefined && annualpatta != undefined && scheduleland != undefined && chitha != undefined && idproof != undefined) {
            // console.log(landdetails);
            e.currentTarget.submit();
        }
        else{
            alert("Required inputs are not filled");
            return;
        }
    });
</script>
<!-- end added -->