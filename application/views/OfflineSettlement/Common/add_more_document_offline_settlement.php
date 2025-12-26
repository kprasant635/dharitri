<h5 class="reza-title" style="margin-top: -10px">
    <i class="fa fa-upload" aria-hidden="true"></i> &nbsp;
    Want to add more document ? &nbsp;
    <button class="rezaButt btn btn-sm btn-warning" type="button" id="addMoreFileDocFun" >
        <i class="fa fa-plus-circle" aria-hidden="true"></i>
        Click to add
    </button>
</h5>

<div id="fieldList" class="mt-3 <?php if(form_error('additional_doc_err') || form_error('fileText[]')){echo 'lm_invalid';}?>">
    <?=form_error('additional_doc_err')?>
    <?=form_error('fileText[]')?>
</div>


<script>
    $(document).ready(function () {

        <?php
        if(!isset($fileCount)){
            $fileCount = 0;
        }
        if(isset($err_return)){
        for($i = 0; $i < $fileCount; $i++)
        {
        ?>
        $("#fieldList").append(
            "<div id=\"deleteMe.(counter++)\" class=\"row\">\n" +
            "<div class=\"col-md-6\">\n" +
            "<div class=\"form-group\">\n" +
            "<label id=\"formControlFile\">Document Title <span style=\"color: red;font-weight: bold;\"> *</span></label>\n" +
            "<input type=\"text\" value=\"<?=set_value('fileText[]');?>\" placeholder=\"Please enter the name of the document\" class=\"form-control\" id=\"uploadFile\" name=\"fileText[]\" required minlength=\"3\" maxlength=\"99\">\n" +
            "</div>\n" +
            "</div>\n" +
            "<div class=\"col-md-4\">\n" +
            "<div class=\"form-group\">\n" +
            "<label id=\"formControlFile\">Select File <span style=\"color: red;font-weight: bold;\"> *</span></label>\n" +
            "<input type=\"file\" class=\"form-control\" id=\"uploadFile\" name=\"fileUpload[]\" required >\n" +
            "</div>\n" +
            "</div>\n" +
            "<div class=\"col-md-2\">\n" +
            "<label id=\"formControlFile\"></label>\n" +
            "<button class=\"btn btn-danger form-control deleteAddMore\" type=\"button\" id=\"deleteAddMore\" class=\"form-control\">\n" +
            "<i class=\"count fa fa-trash\" id=\"count\"> </i>\n" +
            "</button>\n" +
            "</div>\n" +
            "</div>"
        );

        <?php } } ?>

        var counter = 0;
        $("#addMoreFileDocFun").click(function (e)
        {

            counter++;
            console.log(counter);
            $('#fileCounter').val(counter);
            e.preventDefault();
            $("#fieldList").append(
                "<div id=\"deleteMe(counter++)\" class=\"row\">\n" +
                "<div class=\"col-md-6\">\n" +
                "<div class=\"form-group\">\n" +
                "<label id=\"formControlFile\">Document Title <span style=\"color:red\" id=\"document"+counter+"Err\"></span> <span style=\"color: red;font-weight: bold;\"> *</span></label>\n" +
                "<input type=\"text\" placeholder=\"Please enter the name of the document\" class=\"form-control\" id=\"document"+counter+"\" name=\"document"+counter+"\" required minlength=\"3\" maxlength=\"99\">\n" +
                "</div>\n" +
                "</div>\n" +
                "<div class=\"col-md-4\">\n" +
                "<div class=\"form-group\">\n" +
                "<label id=\"formControlFile\">Select File <span style=\"color:red\" id=\"uploadFile"+counter+"Err\"></span> <span style=\"color: red;font-weight: bold;\"> *</span></label>\n" +
                "<input type=\"file\" class=\"form-control\" id=\"uploadFile"+counter+"\" name=\"uploadFile"+counter+"\" required >\n" +
                "</div>\n" +
                "</div>\n" +
                "<div class=\"col-md-2\">\n" +
                "<label id=\"formControlFile\"></label>\n" +
                "<button class=\"btn btn-danger form-control deleteAddMore\" type=\"button\" id=\"deleteAddMore\" class=\"form-control\">\n" +
                "<i class=\"count fa fa-trash\" id=\"count\"> </i>\n" +
                "</button>\n" +
                "</div>\n" +
                "</div>"
            );

        });

        $(document).on('click', '.deleteAddMore', function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });

    });
</script>