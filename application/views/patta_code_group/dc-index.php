<style>
    li{
        list-style-type: none;
    }

    .sortable {
        border: 1px solid #eee;
        width: 100%;
        min-height: 20px;
        list-style-type: none;
        margin: 0;
        padding: 5px 0 0 0;
        float: left;
        margin-right: 10px;
    }
    .pattaTypeList {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        /* width: 120px; */
        /* cursor: move; */
    }
    .land_class_list_wrap, .pattacode_group_list_wrap{
        height: 800px;
        overflow-y: scroll;
    }
    .cos_block{
        max-width: 280px;
    }

    .ui-state-disabled{
        opacity: .80;
    }
    .download_block {
        border: 1px solid #eee;
        border-radius: 2px;
        box-shadow: 0px 0px 4px #eee;
        background: #fff;
        padding: 5px;
        margin-bottom: 7px;
        font-size: 22px;
    }
    .download_block a{
        text-decoration: none;
    }
    /* .accordion-button:not(.collapsed) {
        color: #0c63e4;
        background-color: #e7f1ff;
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.125);
    } */
</style>
<div class="row login">
        
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; font-size: 28px"> Patta Type Mapping </h2>
            </div>
            <?php if($this->session->flashdata('message')): ?>    
                <div class="alert alert-warning">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>    
            <div class="row mx-1">
                <div class="col-md-6 download_block">
                    <div class="row">
                        <div class="col-md-4 pl-5">
                            <img src="<?php echo base_url('assets/pdf-logo.png');?>" alt="Pdf Logo" width="28">    
                        </div>
                        <div class="col-md-8">
                           <a href="<?php echo base_url('assets/No_202_Ecf_No_352011_2023_Dated210424.pdf');?>" download="Official Document">
                                Download Offical Document 
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 download_block">
                    <div class="row">
                        <div class="col-md-4 pl-5">
                            <img src="<?php echo base_url('assets/pdf-logo.png');?>" alt="Pdf Logo" width="28">    
                        </div>
                        <div class="col-md-8">
                            <a href="<?php echo base_url('assets/Pattatype-mapping-Process-Flow-DC.pdf');?>" download="Process Flow">
                                Download Process FLow 
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Map Patta Types
                        <!--  -->
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="mb-3">Patta Type Group
                                <a href="<?= base_url('index.php/patta-type-groups'); ?>" class="btn btn-danger float-end">Reset</a>
                                <button class="btn btn-warning final_preview_btn float-end mr-2" style="display: none;" data-toggle="modal" data-target="#finalPreviewModal">Preview & Submit</button>
                            </h3>
                            <div class="accordion pattacode_group_list_wrap" id="accordionExample">
                                <?php foreach($pattacode_groups as $pattacode_group): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne_<?= $pattacode_group['id']; ?>">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_<?= $pattacode_group['id']; ?>" aria-expanded="true" aria-controls="collapseOne_<?= $pattacode_group['id']; ?>">
                                                <strong><?= $pattacode_group['name']; ?></strong>
                                            </button>
                                        </h2>
                                        <div id="collapseOne_<?= $pattacode_group['id']; ?>" class="accordion-collapse collapse show land_group_wrap" aria-labelledby="headingOne_<?= $pattacode_group['id']; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body" style="min-height: 62px;" data-group_id="<?= $pattacode_group['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="card">
                                                            <div class="card-title ml-2">
                                                                Final Mapped Patta Type
                                                            </div>
                                                            <div class="card-body final_mapped_classes final_map_group_<?= $pattacode_group['id']; ?>" data-group_id="<?= $pattacode_group['id']; ?>">
                                                                <?php 
                                                                    if(count((array) $pattacode_group['fixed_ptta_codes'])): 
                                                                        foreach($pattacode_group['fixed_ptta_codes'] as $fixed_ptta_code):
                                                                ?>
                                                                            <li class="ui-state-default pattaTypeList bg-gradient-lesspending ui-state-disabled" data-land_patta_code="<?= $fixed_ptta_code['type_code']; ?>">
                                                                                <i class="fa fa-check mr-1"></i>
                                                                                <?= $fixed_ptta_code['patta_type']; ?> (<?= $fixed_ptta_code['pattatype_eng']; ?>)
                                                                            </li>
                                                                <?php
                                                                        endforeach;
                                                                    endif; 
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <?php
                                                                    if(count((array) $pattacode_group['co_patta_codes'])):
                                                                ?>
                                                                        <div class="row">
                                                                <?php
                                                                            foreach($pattacode_group['co_patta_codes'] as $co_ins):
                                                                ?>
                                                                                <div class="col-md-4">
                                                                                    <div class="card cos_block">
                                                                                        <div class="card-title ml-2">
                                                                                            <?= $co_ins['username']; ?>
                                                                                        </div>
                                                                                        <div class="card-body">
                                                                                            <?php
                                                                                                    if(count((array) $co_ins['mapped_cases'])):
                                                                                                ?>
                                                                                                        <div class="connectedSortable sortable" data-group_id="<?= $pattacode_group['id']; ?>">
                                                                                                <?php
                                                                                                        foreach($co_ins['mapped_cases'] as $mapped_case):
                                                                                                ?>
                                                                                                            <li class="ui-state-default pattaTypeList bg-gradient-info land_class_<?= $mapped_case['type_code']; ?>" data-land_patta_code="<?= $mapped_case['type_code']; ?>">
                                                                                                                <a herf="javascript:void(0);" 
                                                                                                                    title="View and move to final mapped"
                                                                                                                    data-patta_code="<?= $mapped_case['type_code']; ?>" 
                                                                                                                    data-patta_type="<?= $mapped_case['patta_type']; ?> (<?= $mapped_case['pattatype_eng']; ?>)" 
                                                                                                                    data-group_id="<?= $pattacode_group['id']; ?>" 
                                                                                                                    data-group_name="<?= $pattacode_group['name']; ?>" 
                                                                                                                    data-co_name="<?= $co_ins['username']; ?>" 
                                                                                                                    class="land_class_move_confirmation"
                                                                                                                    data-toggle="modal" data-target="#previewModal"
                                                                                                                >
                                                                                                                    <i class="fa fa-arrow-circle-left mr-1"></i>
                                                                                                                </a>
                                                                                                                <?= $mapped_case['patta_type']; ?> (<?= $mapped_case['pattatype_eng']; ?>)
                                                                                                            </li>
                                                                                                <?php
                                                                                                        endforeach;
                                                                                                ?>
                                                                                                        </div>
                                                                                                <?php
                                                                                                    endif;
                                                                                                ?>
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                <?php
                                                                            endforeach;
                                                                ?>
                                                                        </div>
                                                                <?php
                                                                    endif; 
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                        
                    
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="previewModal" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="previewModalLabel">Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <strong class="text-danger p preview_patta_type"></strong>
            <div class="class_prev_body"></div>
            
        </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="finalPreviewModal" tabindex="-1" role="dialog" aria-labelledby="finalPreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="finalPreviewModalLabel">Final Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="landClassMapForm" action="<?= base_url('index.php/patta-type-group/patta-type-map/approve') ?>" method="POST">
                <div class="finalPrevModalBody"></div>
                <div class="form-group">
                    <label for="" class="form-label">Enter <span class="text-danger"><?= $patta_code_map_security_code; ?></span> in order to save</label>
                    <input class="form-control" type="text" placeholder="Enter the above code" required name="code">
                </div>
                <button type="submit" class="btn btn-success apprv_btn">Submit</button>
            </form>
            
        </div>
    </div>
  </div>
</div>

<script>
    var validRequest = true;
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    let groupWisePattaTyps = {};
    let tempGroupWisePattaTyps = {};
    const coCount = "<?= $co_count; ?>";

    $(document).ready(function() {
        $('.final_mapped_classes').each(function(){
            const groupId = $(this).data('group_id');
            groupWisePattaTyps = {...groupWisePattaTyps, [groupId]: []};
            tempGroupWisePattaTyps = {...tempGroupWisePattaTyps, [groupId]: []};
        });
        
        // $( ".sortable" ).sortable({
        //     connectWith: ".connectedSortable",
        //     update: function(event, ui){
        //         const targetElement = $(event.toElement);
        //         const closestGroup = targetElement.closest('.sortable');

        //         const groupId = closestGroup.data('group_id');
        //         const landClassCode = targetElement.data('land_patta_code');
        //         if(groupId != 0){
        //             targetElement.removeClass('bg-gradient-info');
        //             targetElement.addClass('bg-gradient-success');
        //             saveDataHandler(groupId, landClassCode);
        //         }else{
        //             targetElement.addClass('bg-gradient-info');
        //             targetElement.removeClass('bg-gradient-success');
        //             saveDataHandler(groupId, landClassCode);
        //         }
        //     }

        // }).disableSelection();

        $(document).on('click', '.land_class_move_confirmation', function(){
            // let tempInsGroupWisePattaTyps = tempGroupWisePattaTyps;
            const $this = $(this);
            const pattaCode = $this.data('patta_code');
            const pattaType = $this.data('patta_type');
            const groupId = $this.data('group_id');
            const groupName = $this.data('group_name');
            const coName = $this.data('co_name');

            // $('#previewModal').modal('show');

            // addToFinalMap(groupId, groupName, pattaCode, pattaType);

            $('.preview_patta_type').text(pattaType);

            Object.keys(tempGroupWisePattaTyps).forEach(key => {
                tempGroupWisePattaTyps[key] = [];
            });
            
            $(`.land_class_${pattaCode}`).each(function(){
                let closestLi = $(this);
                let grpId = $('.land_class_move_confirmation', closestLi).data('group_id');
                let grpName = $('.land_class_move_confirmation', closestLi).data('group_name');
                let co_name = $('.land_class_move_confirmation', closestLi).data('co_name');
                tempGroupWisePattaTyps[grpId] = [...tempGroupWisePattaTyps[grpId], {
                                                                                                groupName: grpName,
                                                                                                coName: co_name,
                                                                                            }];
            });

            $('.class_prev_body').html('');
            let html = '';
            $.each(tempGroupWisePattaTyps, function(grpid, details){
                if(details.length > 0){
                    let grpHtml = '';
                    let clsHtml = '';
                    $.each(details, function(ind, val){
                        if(ind == 0){
                            grpHtml = `<div class="col-md-12">
                                            <h3>GROUP - ${val.groupName}</h3>
                                        </div>`;
                        }

                        clsHtml += `<button class="btn btn-warning m-1" type="button">${val.coName}</button>`;
                    });

                    html += `<div class="row mb-2">
                                ${grpHtml}
                                <div class="col-md-12">
                                    <h5>CO Name(s)</h5>
                                    ${clsHtml}
                                </div>
                            </div>`;
                }
                
            });

            html += `<button type="button" data-group_id="${groupId}" 
                                            data-group_name="${groupName}" 
                                            data-patta_code="${pattaCode}" 
                                            data-patta_type="${pattaType}" 
                                            data-dismiss="modal"
                                            class="btn btn-success float-end confirm_btn">
                                            CONFIRM ("${pattaType}" to "${groupName}")
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>`;

            $('.class_prev_body').html(html);
        });

        $(document).on('click', '.confirm_btn', function(){
            const $this = $(this);
            const pattaCode = $this.data('patta_code');
            const pattaType = $this.data('patta_type');
            const groupId = $this.data('group_id');
            const groupName = $this.data('group_name');

            addToFinalMap(groupId, groupName, pattaCode, pattaType);

            $('#previewModal').modal('hide');
        });

        $('.final_preview_btn').on('click', function(){
            $('.finalPrevModalBody').html('');
            let html = '';
            console.log(groupWisePattaTyps);
            $.each(groupWisePattaTyps, function(groupId, landClasses){
                let landClassHtml = '';
                let groupName = '';
                $.each(landClasses, function(index, value){
                    if(index == 0){
                        groupName = value.group_name
                    }
                    landClassHtml += `<div class="col-md-3 mb-2">
                                            <a class="btn btn-success mr-2 text-wrap" href="javascript:void(0);">
                                                ${value.patta_type}
                                            </a>
                                            <input type="hidden" name="group[${groupId}][]" value="${value.patta_code}" class="form_input">
                                        </div>`;

                });

                if(groupName != ''){
                    html += `<div class="card">
                                <div class="card_body">
                                    <div class="row p-2">
                                        <div class="col-md-12 mb-2">
                                            <strong>${groupName}</strong>
                                        </div>
                                        ${landClassHtml}
                                    </div>
                                </div>
                            </div>`;
                }

            });

            $('.finalPrevModalBody').html(html);
        });

        $('#landClassMapForm').on('submit', function(e){
            e.preventDefault();
            $('.apprv_btn').attr('disabled', true);
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    $('.apprv_btn').attr('disabled', false);
                    if(response.success){
                        Toast.fire({
                            title: response.message,
                            icon: 'success'
                        });

                        setTimeout(() => {
                            location.reload(true);
                        }, 1500);

                    }else{
                        Toast.fire({
                            title: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(errors){
                    $('.apprv_btn').attr('disabled', false);
                    Toast.fire({
                        title: "Something went wrong. Please try again later",
                        icon: 'error'
                    });
                }
            });
        });
    });

    function addToFinalMap(groupId, groupName, pattaCode, pattaType){
        if(coCount != $(`.land_class_${pattaCode}`).length){
            Toast.fire({
                title: 'This patta type has not been mapped by some CO',
                icon: 'warning'
            });
            return false;
        }
        
        $('.final_preview_btn').show();
        let html = `<li class="ui-state-default pattaTypeList bg-gradient-success" data-land_patta_code="${pattaCode}">
                        ${pattaType}
                    </li>`;
        
        let pattaTypeDtl = {
                                group_id: groupId,
                                group_name: groupName,
                                patta_code: pattaCode,
                                patta_type: pattaType,
                            };
        groupWisePattaTyps[groupId] = [...groupWisePattaTyps[groupId], pattaTypeDtl];

        $(`.land_class_${pattaCode}`).hide();
        $(`.final_map_group_${groupId}`).append(html);
    }

</script>