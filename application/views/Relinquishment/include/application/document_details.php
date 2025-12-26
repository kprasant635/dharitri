<div class="tableCard">
    <table class="table table-bordered">
        <?php foreach ($document as $d): ?>
            <tr>
                <th>
                    <a target='download' href="<?php echo base_url(); ?>index.php/basundhara2/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                    <input type="hidden" name="file_name" value="<?=$d->name;?>">
                    <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                    <input type="hidden" name="file_path" value="<?=$d->path;?>">
                    <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                    <input type="hidden" name="mut_type" value="<?=$basic->service_code?>">
                </th>
            </tr>
        <?php endforeach;?>
    </table>
</div>