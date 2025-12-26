<style>
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
        cursor: move;
    }
    .land_class_list_wrap, .pattacode_group_list_wrap{
        height: 800px;
        overflow-y: scroll;
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
                            <a href="<?php echo base_url('assets/Pattatype-mapping-process-flow-CO.pdf');?>" download="Process Flow">
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
                        <?php if($is_freezed == 0): ?>
                            <button class="btn btn-warning float-end" data-toggle="modal" data-target="#freezeModal"><i class="fa fa-lock mr-2"></i>Freeze Your Mapping</button>
                        <?php else: ?>
                            <button class="btn btn-outline-warning float-end"><i class="fa fa-lock mr-2"></i>Freezed Your Mapping</button>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Patta Type Group</h3>
                            <div class="accordion pattacode_group_list_wrap" id="accordionExample">
                                <?php foreach($pattacode_groups as $pattacode_group): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne_<?= $pattacode_group->id; ?>">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_<?= $pattacode_group->id; ?>" aria-expanded="true" aria-controls="collapseOne_<?= $pattacode_group->id; ?>">
                                                <strong><?= $pattacode_group->name; ?></strong>
                                            </button>
                                        </h2>
                                        <div id="collapseOne_<?= $pattacode_group->id; ?>" class="accordion-collapse collapse show" aria-labelledby="headingOne_<?= $pattacode_group->id; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body connectedSortable sortable" style="min-height: 62px;" data-group_id="<?= $pattacode_group->id; ?>">
                                                <?php 
                                                    if(count((array) $pattacode_group->fixed_classes)): 
                                                        foreach($pattacode_group->fixed_classes as $fixed_class):
                                                ?>
                                                            <li class="ui-state-default landClassList bg-gradient-lesspending ui-state-disabled" data-type_code="<?= $fixed_class->type_code; ?>">
                                                                <i class="fa fa-check mr-1"></i>
                                                                <?= $fixed_class->patta_type; ?> (<?= $fixed_class->pattatype_eng; ?>)
                                                            </li>
                                                <?php
                                                        endforeach;
                                                    endif; 
                                                ?>
                                                <?php 
                                                    if(count((array) $pattacode_group->children)): 
                                                        foreach($pattacode_group->children as $child):
                                                ?>
                                                            <li class="ui-state-default landClassList bg-gradient-success <?= $is_freezed == 1 ? 'ui-state-disabled' : ''; ?>" data-type_code="<?= $child->type_code; ?>">
                                                                <i class="fa fa-arrows mr-1"></i>
                                                                <?= $child->patta_type; ?> (<?= $child->pattatype_eng; ?>)
                                                            </li>
                                                <?php
                                                        endforeach;
                                                    endif; 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Patta Types To Be Mapped</h3>
                            <ul id="sortable2" class="connectedSortable sortable land_class_list_wrap" data-group_id="0">
                                <?php foreach($pattacodes as $pattacode): ?>
                                    <li class="ui-state-default landClassList bg-gradient-info" data-type_code="<?= $pattacode->type_code; ?>">
                                        <i class="fa fa-arrows mr-1"></i>
                                        <?= $pattacode->patta_type; ?> (<?= $pattacode->pattatype_eng; ?>)
                                    </li>
                                <?php endforeach; ?>
                                <!-- <li class="ui-state-highlight">Item 2</li>
                                <li class="ui-state-highlight">Item 3</li>
                                <li class="ui-state-highlight">Item 4</li>
                                <li class="ui-state-highlight">Item 5</li> -->
                            </ul>
                        </div>
                    </div>
                        
                    
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="freezeModal" tabindex="-1" role="dialog" aria-labelledby="freezeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="freezeModalLabel">Freeze Mapping</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <strong class="text-danger p">NB: Are you sure? You will not be able to revert once you freeze!</strong>
            <form action="<?= base_url('index.php/patta-type-group/patta-type-map/freeze') ?>" id="freezeForm" method="POST">
                <div class="form-group">
                    <label for="" class="form-label">Enter <span class="text-danger"><?= $patta_code_map_security_code; ?></span> in order to freeze mapping</label>
                    <input class="form-control" type="text" placeholder="Enter the above code" required name="code">
                </div>
                <button class="btn btn-success">Freeze It</button>
            </form>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
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
    $(document).ready(function() {
        $( ".sortable" ).sortable({
            items: "li:not(.ui-state-disabled)",
            connectWith: ".connectedSortable",
            update: function(event, ui){
                const targetElement = $(event.toElement);
                const closestGroup = targetElement.closest('.sortable');

                const groupId = closestGroup.data('group_id');
                let pattaTypeItem = targetElement;
                if(!targetElement.hasClass('landClassList')){
                    // if draging with .fa-arrow
                    pattaTypeItem = targetElement.closest('.landClassList');
                }

                const pattaTypeCode = pattaTypeItem.data('type_code');

                if(groupId != 0){
                    pattaTypeItem.removeClass('bg-gradient-info');
                    pattaTypeItem.addClass('bg-gradient-success');
                    saveDataHandler(groupId, pattaTypeCode);
                }else{
                    pattaTypeItem.addClass('bg-gradient-info');
                    pattaTypeItem.removeClass('bg-gradient-success');
                    saveDataHandler(groupId, pattaTypeCode);
                    // Toast.fire({
                    //     title: 'You cannot remove land class from group',
                    //     icon: 'error'
                    // });

                    // setTimeout(() => {
                    //     location.reload(true);
                    // }, 1000);
                }
            }

        }).disableSelection();

        $('#freezeForm').on('submit', function(e){
            e.preventDefault();
            $('.freeze_btn').attr('disabled', true);
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    $('.freeze_btn').attr('disabled', false);
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
                    $('.freeze_btn').attr('disabled', false);
                    Toast.fire({
                        title: "Something went wrong. Please try again later",
                        icon: 'error'
                    });
                }
            });
        });

        $('#freezeModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });
    });

    function saveDataHandler(groupId, pattaTypeCode){
        if(groupId == undefined || pattaTypeCode == undefined){
            Toast.fire({
                title: "Something went wrong. Please try again later",
                icon: 'error'
            });

            setTimeout(() => {
                location.reload(true);
            }, 1500);
        }else{
            if(validRequest){
                validRequest = false;
                let formData = new FormData();
                    formData.append('group_id', groupId);
                    formData.append('type_code', pattaTypeCode);
    
                $.ajax({
                    method: 'POST',
                    url: "<?= base_url('index.php/patta-type-group/patta-type/update') ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        validRequest = true;
                        if(response.success){
                            Toast.fire({
                                title: response.message,
                                icon: 'success'
                            });
                        }else{
                            Toast.fire({
                                title: response.message,
                                icon: 'error'
                            });

                            setTimeout(() => {
                                location.reload(true);
                            }, 1500);
                        }
                    },
                    error: function(errors){
                        validRequest = true;
                        Toast.fire({
                            title: 'Something went wrong. Please try again later.',
                            icon: 'error'
                        });
                    }
                });
            }
        }

    }
</script>