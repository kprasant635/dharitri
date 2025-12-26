<?php
    if(isset($lmnotes)):
        if($lmnotes):
            foreach($lmnotes as $lmnote):
                if(trim($lmnote->vgr_dag_availability) != 'y'):
                    ?>

<style>
        /* modal css */
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 90%;
    }
    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<h5 class="reza-title" style="margin-top: 50px">
    <i class="fa fa-map" aria-hidden="true"></i> Vgr Area Reservation
</h5>
<div class="row p-2">
    <div class="col-md-6 bg-danger text-white">
        <span>
            <strong><?=$sl_count++?>.</strong>
            Filling of Reservation / De Reservation Proposal
        </span>
        <?=form_error('re_dereservation')?>
    </div>
    <div class="col-md-6">
        <div class="form-check form-check-inline">
            <input
                    class="form-check-input <?php if(form_error('re_dereservation')){echo 'lm_invalid';}?>"
                    type="radio"
                    name="re_dereservation"
                    id="reservation_vgr"
                    onclick="reserve();"
                    value="RESERVATION"
                    <?php if(set_value('re_dereservation') == 'RESERVATION'){ echo "checked";} ?>
            />
            <label for="inlineRadio1">Reserve area</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input <?php if(form_error('re_dereservation')){echo 'lm_invalid';}?>" type="radio" name="re_dereservation" onclick="dereserve();" value="n" <?php if(set_value('re_dereservation') == 'n'){ echo "checked";} ?>>
            <label for="">Dag not available for reservation</label>
        </div>
    </div>
</div>


<div class="px-5 alert-info" id="area_details_div" style="display: none;">
    <div class="row p-2 px-5">
        <div class="col-md-6">
            <span>
                <?php
                $sl_char = 'a';
                ?>
                <strong><?=$sl_char++?>)</strong>
                Select District
            </span>
            <?=form_error('district_code_vgr')?>
        </div>
        <div class="col-md-6">
            <select name="district_code_vgr" class="form__input form_select mselect form-control <?php if(form_error('district_code_vgr')){echo 'lm_invalid';}?>"
                    id='district_code_select' data-placeholder="<?php echo $this->lang->line('district');?>"
                    data-allow-clear="1">
                <option value="<?php echo $basic['dist_code']; ?>" 
                <?php if(isset($err_return)){ if (set_value('district_code_vgr') == $basic['dist_code']) { echo "selected"; }}?>>
                    <?=$this->utilityclass->getDistrictName($basic['dist_code'])?>
                </option>
            </select>
        </div>
    </div>

    <div  class="row p-2 px-5">
        <div class="col-md-6">
            <strong><?=$sl_char++?>)</strong>
            Select Sub division
            <?=form_error('sub_div_code_vgr')?>
        </div>
        <div class="col-md-6">
            <select name="sub_div_code_vgr" class="form__input form_select ps-3 mselect form-control <?php if(form_error('sub_div_code_vgr')){echo 'lm_invalid';}?>" id="sub_div_code" data-placeholder="<?php echo $this->lang->line('circle');?>" data-allow-clear="1">
                <option value="<?=$basic['subdiv_code'];?>" 
                    <?php if(isset($err_return)){ if (set_value('sub_div_code_vgr') == $basic['subdiv_code']) { echo "selected"; }}?>>
                    <?=$this->utilityclass->getSubDivName($basic['dist_code'],$basic['subdiv_code'])?>
                </option>
            </select>
        </div>
    </div>


    <div  class="row p-2 px-5">
        <div class="col-md-6">
            <strong><?=$sl_char++?>)</strong>
            Select Circle
            <?=form_error('circle_code_vgr')?>
        </div>
        <div class="col-md-6">
            <select name="circle_code_vgr" class="form__input form_select ps-3 mselect form-control <?php if(form_error('circle_code_vgr')){echo 'lm_invalid';}?>" id="circle_code" data-placeholder="<?php echo $this->lang->line('circle');?>" data-allow-clear="1">
                <option value="">Select...</option>
                <option value="<?=$basic['cir_code'];?>" 
                <?php if(isset($err_return)){ if (set_value('circle_code_vgr') == $basic['cir_code']) { echo "selected"; }}?>
                
                ><?=$this->utilityclass->getCircleName($basic['dist_code'],$basic['subdiv_code'],$basic['cir_code'])?></option>
            </select>
        </div>
    </div>



    <hr>



    <div class="row p-2 px-5">
        <div class="row p-2 px-5">
            <div class="col-md-12 text-center">
                <strong><?=$sl_char++?>) Dag Details</strong>
            </div>
        </div>
        <table id="dag_table" class="table table-bordered">
        </table>
    </div>
    <input type="hidden" name="select_village_vgr" id="select_village" value="<?php if(isset($err_return)){ echo set_value('select_village_vgr');} ?>">

    <input type="hidden" name="dag_no_vgr" id="dag_no_vgr" value="<?php if(isset($err_return)){ echo set_value('dag_no_vgr');} ?>">

    <div class="row p-2 px-5 mt-4">
        <div class="col-md-6">
            <strong><?=$sl_char++?>)</strong>
            Patta No
        </div>
        <div class="col-md-6">
            <input type="text" name="patta_no_dropdown" class="form__input form-control"
                placeholder="" id='patta_no_dropdown' readonly value="<?php if(isset($err_return)){echo set_value('patta_no_dropdown');} ?>">
        </div>
    </div>

    <div class="row p-2 px-5">
        <div class="col-md-6">
            <strong><?=$sl_char++?>)</strong>
            Patta type
        </div>
        <div class="col-md-6">
            <input type="hidden" name="patta_code_dropdown" id='patta_code_dropdown' value="<?php if(isset($err_return)){echo set_value('patta_code_dropdown');}?>">
            <input type="text" name="patta_type_dropdown" class="form__input form-control" placeholder="" id='patta_type_dropdown' readonly value="<?php if(isset($err_return)){echo set_value('patta_type_dropdown');}?>">
        </div>
    </div>

    <div class="row p-2 px-5">
        <div class="col-md-6">
            <strong><?=$sl_char++?>)</strong>
            Area under this dag
        </div>
        <div class="col-md-6">
            <div class="form__div row mt-2">
                <div class="col-md-4">
                    <label for="bigha" class="form__label">Bigha</label>&nbsp;<span style="color: red;">*</span>
                </div>
                <div class="col-md-8">
                    <input type="text" name="bigha_dropdown" class="form__input form-control"
                        placeholder="<?php echo $this->lang->line('bigha');?>" id='bigha_dropdown' value="<?php if(isset($err_return)){echo set_value('bigha_dropdown');}?>" readonly>
                </div>
            </div>
            <div class="form__div row mt-2">
                <div class="col-md-4">
                    <label for="katha" class="form__label">Katha</label>&nbsp;<span style="color: red;">*</span>
                </div>
                <div class="col-md-8">
                    <input type="text" name="katha_dropdown" class="form__input form-control"
                        placeholder="<?php echo $this->lang->line('katha');?>" id='katha_dropdown' value="<?php if(isset($err_return)){echo set_value('katha_dropdown');}?>" readonly>
                </div>

            </div>
            <div class="form__div row mt-2" id='lessa_div'>
                <div class="col-md-4">
                    <label for="lessa" class="form__label">Lessa</label>&nbsp;<span style="color: red;">*</span>
                </div>
                <div class="col-md-8">
                    <input type="text" name="lessa_dropdown" class="form__input form-control" placeholder="<?php echo $this->lang->line('lessa');?>" id='lessa_dropdown' value="<?php if(isset($err_return)){echo set_value('lessa_dropdown');}?>" readonly>
                </div>
            </div>

            <?php if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))): ?>
                <div class="form__div row mt-2" id='ganda_div'>
                    <div class="col-md-4">
                        <label for="ganda" class="form__label">Ganda</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="ganda_dropdown" class="form__input form-control" placeholder="Ganda" id='ganda_dropdown' value="<?php if(isset($err_return)){echo set_value('ganda_dropdown');}?>" readonly>
                    </div>
                </div>

                <div class="form__div row mt-2" id='kranti_div'>
                    <div class="col-md-4">
                        <label for="kranti" class="form__label">Kranti</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="kranti_dropdown" class="form__input form-control" value="0" placeholder="Kranti" id='kranti_dropdown' readonly>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>



<div id="lotModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="close-enc-modal px-4">&times;</span>
        </div>
        <p>
        <div class="container px-5">
            <div class="row p-2 px-5">
                <div class="col-md-12 text-center">
                    <strong><?=$sl_char++?>) Lot Details</strong>
                </div>
            </div>
            <table id="lotTable" class="table table-bordered">
                <thead >
                    <tr>
                        <th>Mouza</th>
                        <th>Lot</th>
                        <th>Total Area in Lot</th>
                        <th>Total Applied Area (By applicant)</th>
                        <th>Available Area <br> (Total Chitha Area - Total Applied Area)</th>
                    </tr>
                </thead>

                <tbody id="lotWiseData">

                </tbody>

            </table>
        </div>
    </div>
</div>

<div id="villageModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="close-enc-modal px-4">&times;</span>
        </div>
        <p>
        <div class="container px-5">
            <div class="row p-2 px-5">
                <div class="row p-2 px-5">
                    <div class="col-md-12 text-center">
                        <strong><?=$sl_char++?>) Village Details</strong>
                    </div>
                </div>
                <table id="villageTable" class="table table-bordered">
                    <thead >
                        <tr>
                            <th>Village Name</th>
                            <th>Total Area in Village</th>
                            <th>Total Applied Area (By applicant)</th>
                            <th>Available Area <br> (Total Chitha Area - Total Applied Area)</th>
                        </tr>
                    </thead>

                    <tbody id="villageWiseData">

                    </tbody>

                </table>
            </div>
        </div>
        </p>
    </div>
</div>

<script>
    $(document).on('change', '#circle_code', function(){

        if($('#circle_code').val() != '')
        {
            var lotModal = document.getElementById("lotModal");
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close-enc-modal")[0];
            lotModal.style.display = "block";

            span.onclick = function() {
                lotModal.style.display = "none";
                // table.destroy();
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == lotModal) {
                    lotModal.style.display = "none";
                    // table.destroy();
                }
            }
            
            var dist_code = $('#district_code_select').val();
            var subdiv_code = $('#sub_div_code').val();
            var cir_code = $('#circle_code').val();

            getLotsInCircle(dist_code, subdiv_code, cir_code);
        }
    })
</script>

<script>
    function getLotsInCircle(dist_code, subdiv_code, cir_code)
    {
        var postData = {
                'dist_code': dist_code, 
                'subdiv_code': subdiv_code, 
                'cir_code': cir_code, 
            };
    
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl+'SettlementVgrCo/getLotsFromInCircle',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);

                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }
                var table = $('#lotTable').DataTable();
                table.destroy();

                var tbodyData = '';
                for(var i = 0; i < arr.content.length; i++)
                {
                    tbodyData += '<tr style="font-size: 12px;">'+
                    '<td>'+arr.content[i].mouza_name+'</td>'+

                    '<td><span style="text-decoration:underline; color:blue; cursor:pointer;" onclick="getVillageData(\''+arr.content[i].dist_code+'\', \''+arr.content[i].subdiv_code+'\', \''+arr.content[i].cir_code+'\', \''+arr.content[i].mouza_pargona_code+'\', \''+arr.content[i].lot_no+'\')">'+arr.content[i].lot_name+'</span></td>'+

                    '<td>'+arr.content[i].total_area_in_lot+'</td>'+
                    '<td>'+arr.content[i].total_applied_area+'</td>'+
                    '<td>'+arr.content[i].total_available_area+'</td></tr>'
                }

                $('#lotWiseData').html(tbodyData);

                $('#lotTable').dataTable({
                    "aaSorting": [],
                    "pageLength": 10,
                    "bDestroy": true
                });
            }
        });
    }
</script>

<script>
    function getVillageData(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no)
    {
        //******closing the previous modal */
        var lotModal = document.getElementById("lotModal");
        lotModal.style.display = "none";


        var villageModal = document.getElementById("villageModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-enc-modal")[0];
        villageModal.style.display = "block";

        span.onclick = function() {
            villageModal.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == villageModal) {
                villageModal.style.display = "none";
                // table.destroy();
            }
        }





        postData = {
            'dist_code': dist_code, 
            'subdiv_code': subdiv_code, 
            'cir_code': cir_code, 
            'mouza_pargona_code': mouza_pargona_code, 
            'lot_no': lot_no, 
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementVgrCo/getVillageData',
            type: "POST",
            data: postData,
            success: function(data)
            {
                $.unblockUI();
                arr = JSON.parse(data);
                
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }
                var table = $('#villageTable').DataTable();
                table.destroy();

                var tbodyData = '';
                for(var i = 0; i < arr.content.length; i++)
                {
                    tbodyData += '<tr style="font-size: 12px;">'+

                    '<td><span style="text-decoration:underline; color:blue; cursor:pointer;" onclick="getDagDetails(\''+arr.content[i].vil_uuid+'\')">'+arr.content[i].vil_name+'</span></td>'+

                    '<td>'+arr.content[i].total_area_in_village+'</td>'+
                    '<td>'+arr.content[i].total_applied_area+'</td>'+
                    '<td>'+arr.content[i].total_available_area+'</td></tr>'
                }

                $('#villageWiseData').html(tbodyData);

                $('#villageTable').dataTable({
                    "aaSorting": [],
                    "pageLength": 10,
                    "bDestroy": true
                });

            }
        })

    }
</script>















<script>
    $('#village_list').DataTable( {
        "pageLength": 10
    });
</script>

<script>

    $( document ).ready(function() {
        <?php
            if(isset($err_return))
            {
                ?>
                    var vil_uuid = $('#select_village').val();
                    getDagDetails(vil_uuid);

                <?php
            }
        
        ?>
        
        var dist_code = $('#district_code_select').val();
        var subdiv_code = $('#sub_div_code').val();
        var cir_code = $('#circle_code').val();

        getLotsInCircle(dist_code, subdiv_code, cir_code);
    });

    


   



    function getDagDetails(uuid)
    {   
        $('#select_village').val(uuid);

        var postData = {
                'uuid' : uuid,
            };
   
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementVgrCo/getAvailabilityDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }

                var table_head = null;
                
                $('#dag_table thead').remove();
                $('#dag_table tbody').remove();

                table_head =  "<thead><tr>"+
                            "<th>Dag No</th>"+
                            "<th>Total Area in Dag</th>"+
                            "<th>Total Applied Area</th>"+
                            "<th>Total Available Area</th>"+
                        "</tr></thead>";

                $('#dag_table').append(table_head);

                var table = null;
                for(i=0; i<arr.content.length; i++)
                {
                    table += "<tr>"+
                                "<td><span onclick=\"getDagInfo('"+ arr.content[i].dag_no +"', '"+ arr.content[i].b +"', '"+ arr.content[i].k +"', '"+ arr.content[i].l +"', '"+ arr.content[i].g +"')\" style=\"text-decoration:underline; cursor:pointer;\">"+ arr.content[i].dag_no +"</span></td>"+
                                "<td style='white-space: nowrap;'>"+ arr.content[i].total_area_in_dag +"</td>"+
                                "<td style='white-space: nowrap;'>"+ arr.content[i].total_applied_area_in_dag +"</td>"+
                                "<td style='white-space: nowrap;'>"+ arr.content[i].total_available_area_in_dag +"</td>"+
                            "</tr>";

                }

                $('#dag_table').append('<tbody>'+table+'</tbody>');

                $('#dag_table').DataTable({
                    "aaSorting": [],
                    "pageLength": 10,
                    "bDestroy": true
                });
                
            }
        });
    }
</script>

<script>
    function getDagInfo(dag_no, b, k, l, g)
    {
        $('#dag_no_vgr').val(dag_no);

        var uuid = $("#select_village").val();
        var postData = {
                'uuid' : uuid,
                'dag_no' : dag_no
            };
   
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementVgr/getPattaDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);

                $('#patta_no_dropdown').val(arr.patta_no);
                $('#patta_type_dropdown').val(arr.patta_type);
                $('#patta_code_dropdown').val(arr.patta_type_code);

                $('#bigha_dropdown').val(b);
                $('#katha_dropdown').val(k);
                $('#lessa_dropdown').val(l);
                $('#ganda_dropdown').val(g);
            }

        });

    }


    $('#btnLmSubmit').on('click',function(e){
        e.preventDefault();
        var form = $('.lmForm');
        var encData;
        var encDataAll =[];

        <?php
        if($applicants_encroacher == true)
        {
        foreach($applicants_encroacher as $encroacher_ext){
        ?>
        $(".clsencdata").each(function () {
            encData = "Dag No: "+<?=$encroacher_ext->dag_no?>+ " : " + $('#encroacher_exist_vlb<?=$encroacher_ext->id?> option:selected').text();
            // var encDagno= $(this).attr("data-id");
            // var encDagno =  $(this).attr("data-id");
            // var enchDataAll="Dag No: "+encDagno+ "; Encroacher Exists in VLB: " +encData;
            // alert( encData );


        })
        // alert( encData );
        encDataAll.push(encData);

        <?php } } ?>


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {

                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                'error'
            )
        }
    })
    });
</script>

<script>
    function reserve()
    {
        $('#area_details_div').show();
    }

    function dereserve()
    {
        $('#area_details_div').hide();
    }
</script>


<?php
                endif;
            endforeach;
        endif;
    endif;

?>