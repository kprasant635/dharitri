<script type="text/javascript">
    var KARIMGANJ_DIST_CODE = "<?php echo KARIMGANJ_DIST_CODE ?>";
    var DIST_CODE = "<?php echo $this->session->userdata('dist_code');?>";
</script>
<style>
    :root {
        --loader-size: 50px;
        --dot-size: 6px;
        --loader-bg: #e1e6e2;
        --dot-color: black;
    }

    .loader {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(1, 18, 64, 0.2);
        transition: opacity 0.3s ease-out, top 0.3s step-end;
        z-index: 99;
    }

    .loader.trans {
        transition: opacity 0.5s ease-out, top 0.5s step-start;
        opacity: 1;
        top: 0;
    }

    .loader .loaderview {
        position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        height: auto;
        padding: 10px 40px;
        border-radius: 5px;
        top: 0;
        left: 0;
        z-index: 100;
        flex-flow: column;
        background-color: var(--loader-bg);
    }

    h1 {
        color: var(--dot-color);
        font-size: 1.2em;
        animation: fading 1.5s ease-in-out infinite;
        font-family: "Comfortaa", cursive;
    }

    .Loader-box {
        margin: 20px;
        flex: 0 0 auto;
        height: var(--loader-size);
        width: var(--loader-size);
    }

    .box {
        position: absolute;
        height: var(--loader-size);
        width: var(--loader-size);
        animation: rotating 4s ease-in infinite;
        animation-delay: calc(var(--id) * 0.5s);
    }

    .dot {
        background-color: var(--dot-color);
        height: var(--dot-size);
        width: var(--dot-size);
        border-radius: 100%;
    }

    @keyframes rotating {
        0% {
            opacity: 0;
            transform: rotateZ(0);
        }
        25% {
            opacity: 100%;
            transform: rotateZ(160deg);
        }

        75% {
            opacity: 200%;
            opacity: 100;
        }
        80% {
            transform: rotateZ(300deg);
            opacity: 100;
        }
        100% {
            transform: rotateZ(350deg);
            opacity: 0;
        }
    }

    @keyframes fading {
        0% {
            opacity: 40%;
        }
        50% {
            opacity: 90%;
        }
        100% {
            opacity: 40%;
        }
    }

</style>
<div class="hide loader" id="loader">
    <div class="loaderview">
        <h1>Don't refresh the page until the process is completed...</h1>
        <div class="Loader-box">
            <div class="box" style="--id:1">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:2">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:3">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:4">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:5">
                <div class="dot"></div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="well well-sm">
                <h2 style="text-align: center;"> Composite Service. NOC No.: <?php echo $case->noc_no ?> </h2>
            </div>

            <div class="panel panel-info">
                <div class="panel-body">
                    <table class="table table-striped table-bordered text-bold">
                        <thead>
                        <th colspan="100%" style="background-color: #2E6B99; color: #fff">Location Details
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>District</td>
                            <td class="red"><?php echo $location['dist_code']; ?></td>
                            <td>Subdivision</td>
                            <td class="red"><?php echo $location['subdiv_code']; ?></td>
                            <td>Circle</td>
                            <td class="red"><?php echo $location['cir_code']; ?></td>
                        </tr>
                        <tr>
                            <td>Mouza</td>
                            <td class="red"><?php echo $location['mouza_pargona_code']; ?></td>
                            <td>Lot No</td>
                            <td class="red"><?php echo $location['lot_no']; ?></td>
                            <td>Village / Town</td>
                            <td class="red"><?php echo $location['vill_townprt_code']; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered text-bold">
                        <thead>
                        <th colspan="100%" style="background-color: #2E6B99; color: #fff">Case Details
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>NOC No.: </td>
                            <td class="red"><?php echo $case->noc_no ?></td>
                            <td>Mutation</td>
                            <td class="red">YES</td>
                            <td>Partition</td>
                            <td class="red"><?= ($noc_case->automut == 'P')? 'YES': 'NO'; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered text-bold">
                        <thead>
                        <th colspan="100%" style="background-color: #2E6B99; color: #fff">Dag Details
                        </th>
                        </thead>
                        <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Dag No.</th>
                            <th>Patta No.</th>
                            <th>Patta Type</th>
                            <?php if($this->session->userdata('dist_code') == KARIMGANJ_DIST_CODE): ?>
                                <th>Mutated Land Area (B-K-C-G-Kr)</th>
                            <?php else: ?>
                                <th>Mutated Land Area (B-K-L)</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dag_details)){ foreach ($dag_details as $key=>$dag): ?>
                        <tr>
                            <td><?= ++$key; ?></td>
                            <td><?php echo $dag->dag_no; ?></td>
                            <td><?php echo $dag->patta_no; ?></td>
                            <td><?php echo $this->utilityclass->getPattaName($dag->patta_type_code); ?></td>
                            <?php if($this->session->userdata('dist_code') == KARIMGANJ_DIST_CODE): ?>
                                <td><?= $dag->m_dag_area_b ?>B-
                                    <?= $dag->m_dag_area_k ?>K-
                                    <?= $dag->m_dag_area_lc ?>C-
                                    <?= $dag->m_dag_area_g ?>G-
                                    <?= $dag->m_dag_area_kr ?>Kr
                                </td>
                            <?php else: ?>
                                <td><?= $dag->m_dag_area_b ?>B-
                                    <?= $dag->m_dag_area_k ?>K-
                                    <?= $dag->m_dag_area_lc ?>L
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; } ?>
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered text-bold">
                        <thead>
                        <th colspan="100%" style="background-color: #2E6B99; color: #fff">First Party
                        </th>
                        </thead>
                        <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Guardian Name</th>
                            <th>Mobile No.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($petitioners)){ foreach ($petitioners as $key=>$pet): ?>
                            <tr>
                                <td><?= ++$key; ?></td>
                                <td><?php echo $pet->pet_name; ?></td>
                                <td><?php echo $this->utilityclass->getGender($pet->pet_gender); ?></td>
                                <td><?php echo $pet->guard_name; ?></td>
                                <td><?php echo $pet->pdar_mobile; ?></td>
                            </tr>
                        <?php endforeach; } ?>
                        </tbody>
                    </table>
                </div>


                <div class="panel-body">
                    <table class="table table-striped table-bordered text-bold">
                        <thead>
                        <th colspan="100%" style="background-color: #2E6B99; color: #fff">Second Party
                        </th>
                        </thead>
                        <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Guardian Name</th>
                            <th>Mobile No.</th>
                            <th>Alongwith/Inplace</th>
                            <th>Dag No.</th>
                            <th>Patta No.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($pattadars)){ foreach ($pattadars as $key=>$pattadar): ?>
                            <tr>
                                <td><?= ++$key; ?></td>
                                <td><?php echo $pattadar->pdar_name; ?></td>
                                <td><?php
                                if($pattadar->pdar_gender != NULL){
                                    echo $this->utilityclass->getGender($pattadar->pdar_gender);
                                    } ?>
                                </td>
                                <td><?php echo $pattadar->pdar_guardian; ?></td>
                                <td><?php echo $pattadar->pdar_mobile; ?></td>
                                <td><?php if($pattadar->striked_out == 'i')
                                    {
                                        echo "Inplace";
                                    }
                                    else
                                    {
                                        echo "Alongwith";
                                    }?>
                                </td>
                                <td><?php echo $pattadar->dag_no; ?></td>
                                <td><?php echo $pattadar->patta_no; ?></td>
                            </tr>
                        <?php endforeach; } ?>
                        </tbody>
                    </table>
                </div>
                <form id="form_submit">
                <div class="form-group row mx-4 mt-3 bg-info pt-1 rounded">
                    <label for="inputPassword" class="col-sm-3 col-form-label required">Select Circle Officer (CO)</label>
                    <div class="col-sm-4">
                        <select name="co_code" id="co_code" class="form-control" required>
                            <option selected value="">Select Circle Officer</option>
                            <?php foreach ($co_code as $co): ?>
                            <option value="<?=$co->user_code ?>"><?=$co->username ?> (<?=$co->user_desig_code ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div id="error_co_code"></div>
                    </div>
                </div>
                <div id="error_u_message"></div>
                <div class="center py-3" id="submit_btn">
                    <input type="hidden" name="noc_no" value="<?= $case->noc_no ?>">
                    <button class="btn btn-success" type="submit">
                    <i class="fa fa-print"> </i> Proceed to Print Notice</button>
                    <a href="<?php echo base_url(); ?>index.php/CompositeService/getPendingCases" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                    </a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //// Submit Form ///
    $("#form_submit").submit(function (e) {
        e.preventDefault();
        if ( ! confirm('Are you sure want to generate notice?')){
            return;
        }
        var co_code = $('#co_code').val();
        if(co_code == '' || co_code == null)
        {
            $('#error_co_code').html("<p class='bold red'>Please select a Circle Officer...!</p>");
            return;
        }
        $.ajax({
            url: baseurl + "CompositeService/RegisterByAST",
            type: 'POST',
            data: $("#form_submit").serialize(),
            dataType: 'json',
            beforeSend: function () {
                $('.loader').addClass('trans');
                $('.loader').removeClass('hide');
                $('#submit_btn').hide();
                $('#error_u_message').html('');
            },
            success: function (data) {
                console.log(data);
                $('.loader').addClass('hide');
                $('.loader').removeClass('trans');
                if(data.error === false)
                {
                    $('#error_u_message').html('');
                    $('#error_u_message')
                        .html('<div class="green bold p-2 center">' + data.msg +
                            '<br><br>'+
                            '<a href="'+baseurl +'CompositeService/issueNotice'+data.url+'"> <button type="button" class="btn btn-primary">' +
                            '<i class="fa fa-view"></i> View Notice</button></a>'+
                            '</div>');
                    window.location.href = baseurl + "CompositeService/issueNotice"+data.url;
                    return;
                }
                if(data.error === true)
                {
                    $('#submit_btn').show();
                    $('#error_u_message').html('');
                    $('#error_u_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">' +data.msg +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');

                    return;
                }
            },
            error: function (jqXHR, exception) {
                $('#submit_btn').show();
                $('.loader').addClass('hide');
                if(jqXHR.status == 403){
                    $('#error_u_message').html(`<div class="bg-gradient-danger p-2 rounded">${ jqXHR.responseJSON.errors }<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>`);
                }else{
                    alert('Error [##AUTOM0101]: Could not Complete your Request (AJAX ERROR)..!');
                }
            }
        });
    });

</script>