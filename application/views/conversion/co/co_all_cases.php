
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-center">
                <h5>Case No: <?= $case_no; ?></h5>
                <input type="hidden" id="case_no" value="<?php echo $case_no; ?>">
                <input type="hidden" id="baseurl_doc" value="<?php echo base_url(); ?>">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <!-- <label for="inputEmail4">Geo tagged photo</label> -->
                            <?php include APPPATH . 'views/multipleUploadMB3.php'?>
                        </div>
                        
                            <?php
                                if (isset($geo_tag_doc_empty)) {
                                    echo $geo_tag_doc_empty;
                                }
                                if (isset($geo_tag_doc)) {
                                    foreach ($geo_tag_doc as $d):
                                ?>
                                <div class="row mt-1 mb-1">
                                    <div class="col-md-6">
                                        <a target='download' href="<?php echo base_url() ?>index.php/SettlementCommon/downloadDocument?doc_id=<?php echo $d->id?>"><i class="fa fa-paperclip mb-2"></i> <?php echo $d->file_name;?></a>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-danger doc-delete" id="<?php echo $d->id; ?>">Delete</button>
                                    </div>
                                </div>
                                <?php endforeach;
                                }
                            ?>
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Note</label>
                            <textarea name="note" id="note" class="form-control"></textarea>
                        </div> -->
                    </div>
                </div>
                
            </div>
            <!-- <div class="card-footer text-center">
                <button class="btn btn-success" id="uploadReport">Submit</button>
                <a href="<?php //echo base_url(''); ?>" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;<?php //echo $this->lang->line('back_to_main_menu'); ?>
                </a>
            </div> -->
        </div>
    </div>
</div>
<script>

    $(document).on('click', '.doc-delete', (e) => {
        var baseurl_doc = $('#baseurl_doc').val();
        var case_no = $('#case_no').val();
        var id = e.currentTarget.id;

        $.ajax({
            url: baseurl_doc + 'index.php/delete_conv_doc',
            dataType: 'JSON',
            method: 'POST',
            data: {case_no:case_no, id:id},
            success: (response) => {
                alert(response.msg);
                if(response.status == 'SUCCESS') {
                    window.location.reload();
                }
            },
            error: (error) => {
                console.log(error);
            }
        });
    });

    // $(document).on('click', '#uploadReport', () => {
    //     var baseurl_doc = $('#baseurl_doc').val();
    //     var case_no = $('#case_no').val();
    //     var note = $('#note').val();

    //     $.ajax({
    //         url: baseurl_doc + 'index.php/',
    //         dataType: 'JSON',
    //         method: 'POST',
    //         data: {case_no:case_no, note:note},
    //         success: (response) => {
    //             console.log(response);
    //         },
    //         error: (error) => {
    //             console.log(error);
    //         }
    //     });
    // });
</script>
