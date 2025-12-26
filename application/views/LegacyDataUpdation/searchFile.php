<form method="post">
    <div class="row">
        <h4 style="text-align: center">Search Attachment</h4>
        <hr>
        <div class="col-lg-4 ">
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control" required=""  name="case_no" placeholder="Case No">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Search</button>
            </div>
        </div>
    </div>
</form>
<?php
if(isset($basundharaAttachment)){
echo '<hr><h2 class="red">Basundhara Attachments</h2> <ul>';
foreach ($basundharaAttachment  as $attachment):
?>
<li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
<?php 
endforeach; 
echo "</ul>";
}
?>

<?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
<hr><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    <center class='text-danger text-bold'><b>View Supportive Document</b></center>
    <table class="table table-striped table-bordered">
        <tbody>
            <?php foreach($sup_doc as $doc) { ?>
            <tr>
                <td><span class="text-bold"><?=$doc->file_name?></span></td>
                <td>
<a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?> 