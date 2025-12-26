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
    .landClassList {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        /* width: 120px; */
        /* cursor: move; */
    }
    .land_class_list_wrap, .land_class_group_list_wrap{
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
        
    <div class="col-lg-12">
        <div class="well well-sm mis_report">
            <h2 style="text-align: center; font-size: 28px"> Land Class Mapping </h2>
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
                        <a href="<?php echo base_url('assets/Revision-of-land-classes.pdf');?>" download="Official Document">
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
                        <a href="<?php echo base_url('assets/Landclass-Mapping-Process-Flow-DC.pdf');?>" download="Process Flow">
                            Download Process FLow 
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">Map Land Classes
                    <!--  -->
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if(count($pattacode_groups) > 0): ?>
                        <h3 class="mb-3">Land Class Group
                            <!-- <a href="<?= base_url('index.php/land-class-groups'); ?>" class="btn btn-danger float-end">Reset</a> -->
                            <button class="btn btn-success final_preview_btn float-end mr-2" data-toggle="modal" data-target="#finalPreviewModal">Preview & Submit</button>
                        </h3>
                        <?php endif; ?>

                        <?php if(count($pattacode_groups) > 0): ?>
                        <div class="accordion land_class_group_list_wrap" id="accordionExample">
                            <?php foreach($pattacode_groups as $land_class_group): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne_<?= $land_class_group['id']; ?>">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_<?= $land_class_group['id']; ?>" aria-expanded="true" aria-controls="collapseOne_<?= $land_class_group['id']; ?>">
                                            <strong><?= $land_class_group['name']; ?></strong>
                                        </button>
                                    </h2>
                                    <div id="collapseOne_<?= $land_class_group['id']; ?>" class="accordion-collapse collapse show land_group_wrap" aria-labelledby="headingOne_<?= $land_class_group['id']; ?>" data-bs-parent="#accordionExample">
                                        <div class="accordion-body" style="min-height: 62px;" data-group_id="<?= $land_class_group['id']; ?>">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php 
                                                        if(count((array) $land_class_group['land_classes'])): 
                                                            foreach($land_class_group['land_classes'] as $land_class):
                                                    ?>  
                                                                <button class="btn btn-warning m-2"><?= $land_class['patta_type']; ?> (<?= $land_class['patta_code_eng_name']; ?>)</button>
                                                    <?php
                                                            endforeach;
                                                        endif; 
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                            <h3 class="text-center p-2 bg-gradient-teal">No Pending Cases Found <i class="fa fa-smile"></i></h3>
                        <?php endif; ?>
                    </div>
                </div>
                    
                
            </div>
        </div>
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="finalPreviewModal" tabindex="-1" role="dialog" aria-labelledby="finalPreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="finalPreviewModalLabel">Final Submit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="landClassMapForm" action="<?= base_url('index.php/PattacodegroupController/finalApprove') ?>" method="POST">
                <input type="hidden" name="batch" value="<?= $batch; ?>">
                <div class="finalPrevModalBody"></div>
                <div class="form-group">
                    <label for="" class="form-label">Enter <span class="text-danger"><?= $land_cls_map_security_code; ?></span> in order to save</label>
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

    // let groupWiseLandClasses = {};
    // let tempGroupWiseLandClasses = {};

    $(document).ready(function() {
        // $('.final_mapped_classes').each(function(){
        //     const groupId = $(this).data('group_id');
        //     groupWiseLandClasses = {...groupWiseLandClasses, [groupId]: []};
        //     tempGroupWiseLandClasses = {...tempGroupWiseLandClasses, [groupId]: []};
        // });
        
        // $( ".sortable" ).sortable({
        //     connectWith: ".connectedSortable",
        //     update: function(event, ui){
        //         const targetElement = $(event.toElement);
        //         const closestGroup = targetElement.closest('.sortable');

        //         const groupId = closestGroup.data('group_id');
        //         const landClassCode = targetElement.data('land_class_code');
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

        // $(document).on('click', '.land_class_move_confirmation', function(){
        //     // let tempInsGroupWiseLandClasses = tempGroupWiseLandClasses;
        //     const $this = $(this);
        //     const classCode = $this.data('class_code');
        //     const className = $this.data('class_name');
        //     const groupId = $this.data('group_id');
        //     const groupName = $this.data('group_name');
        //     const coName = $this.data('co_name');

        //     // $('#previewModal').modal('show');

        //     // addToFinalMap(groupId, groupName, classCode, className);

        //     $('.preview_class_name').text(className);

        //     Object.keys(tempGroupWiseLandClasses).forEach(key => {
        //         tempGroupWiseLandClasses[key] = [];
        //     });
            
        //     $(`.land_class_${classCode}`).each(function(){
        //         let closestLi = $(this);
        //         let grpId = $('.land_class_move_confirmation', closestLi).data('group_id');
        //         let grpName = $('.land_class_move_confirmation', closestLi).data('group_name');
        //         let co_name = $('.land_class_move_confirmation', closestLi).data('co_name');
        //         tempGroupWiseLandClasses[grpId] = [...tempGroupWiseLandClasses[grpId], {
        //                                                                                         groupName: grpName,
        //                                                                                         coName: co_name,
        //                                                                                     }];
        //     });

        //     $('.class_prev_body').html('');
        //     let html = '';
        //     $.each(tempGroupWiseLandClasses, function(grpid, details){
        //         if(details.length > 0){
        //             let grpHtml = '';
        //             let clsHtml = '';
        //             $.each(details, function(ind, val){
        //                 if(ind == 0){
        //                     grpHtml = `<div class="col-md-12">
        //                                     <h3>GROUP - ${val.groupName}</h3>
        //                                 </div>`;
        //                 }

        //                 clsHtml += `<button class="btn btn-warning m-1" type="button">${val.coName}</button>`;
        //             });

        //             html += `<div class="row mb-2">
        //                         ${grpHtml}
        //                         <div class="col-md-12">
        //                             <h5>CO Name(s)</h5>
        //                             ${clsHtml}
        //                         </div>
        //                     </div>`;
        //         }
                
        //     });

        //     html += `<button type="button" data-group_id="${groupId}" 
        //                                     data-group_name="${groupName}" 
        //                                     data-class_code="${classCode}" 
        //                                     data-class_name="${className}" 
        //                                     data-dismiss="modal"
        //                                     class="btn btn-success float-end confirm_btn">
        //                                     CONFIRM ("${className}" to "${groupName}")
        //             </button>
        //             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>`;

        //     $('.class_prev_body').html(html);
        // });

        // $(document).on('click', '.confirm_btn', function(){
        //     const $this = $(this);
        //     const classCode = $this.data('class_code');
        //     const className = $this.data('class_name');
        //     const groupId = $this.data('group_id');
        //     const groupName = $this.data('group_name');

        //     addToFinalMap(groupId, groupName, classCode, className);

        //     $('#previewModal').modal('hide');
        // });

        // $('.final_preview_btn').on('click', function(){
        //     $('.finalPrevModalBody').html('');
        //     let html = '';
        //     console.log(groupWiseLandClasses);
        //     $.each(groupWiseLandClasses, function(groupId, landClasses){
        //         let landClassHtml = '';
        //         let groupName = '';
        //         $.each(landClasses, function(index, value){
        //             if(index == 0){
        //                 groupName = value.group_name
        //             }
        //             landClassHtml += `<div class="col-md-3 mb-2">
        //                                     <a class="btn btn-success mr-2 text-wrap" href="javascript:void(0);">
        //                                         ${value.class_name}
        //                                     </a>
        //                                     <input type="hidden" name="group[${groupId}][]" value="${value.class_code}" class="form_input">
        //                                 </div>`;

        //         });

        //         if(groupName != ''){
        //             html += `<div class="card">
        //                         <div class="card_body">
        //                             <div class="row p-2">
        //                                 <div class="col-md-12 mb-2">
        //                                     <strong>${groupName}</strong>
        //                                 </div>
        //                                 ${landClassHtml}
        //                             </div>
        //                         </div>
        //                     </div>`;
        //         }

        //     });

        //     $('.finalPrevModalBody').html(html);
        // });

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

    // function addToFinalMap(groupId, groupName, classCode, className){
    //     if(coCount != $(`.land_class_${classCode}`).length){
    //         Toast.fire({
    //             title: 'This land class has not been mapped by some CO',
    //             icon: 'warning'
    //         });
    //         return false;
    //     }
        
    //     $('.final_preview_btn').show();
    //     let html = `<li class="ui-state-default landClassList bg-gradient-success" data-land_class_code="${classCode}">
    //                     ${className}
    //                 </li>`;
        
    //     let landClassDtl = {
    //                             group_id: groupId,
    //                             group_name: groupName,
    //                             class_code: classCode,
    //                             class_name: className,
    //                         };
    //     groupWiseLandClasses[groupId] = [...groupWiseLandClasses[groupId], landClassDtl];

    //     $(`.land_class_${classCode}`).hide();
    //     $(`.final_map_group_${groupId}`).append(html);
    // }

</script>