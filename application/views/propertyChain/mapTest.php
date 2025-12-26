<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
    <!-- <script src="<?php echo base_url(); ?>homePage/js/jquery.min.js" defer></script> -->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>JSP Page</title>

</head>

<body>
    <!-- <a href="javascript:DoPost()">GO</a> -->
    <input type="hidden" name="geoJson" id="geoJson" value='<?= $data['geoJson'] ?>'>
    <input type="hidden" name="state" id="state" value="<?= $data['state'] ?>">
</body>
<script type="text/javascript">
    function DoPost() {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");

        form.method = "POST";
        form.action = "<?= BHUNAKSHA_VIEW_MAP ?>";

        element1.value = '<?= $data['geoJson'] ?>';
        element1.type = 'hidden';
        element1.name = "mapData";
        form.appendChild(element1);

        element2.value = '<?= $data['state'] ?>';
        element2.type = 'hidden';
        element2.name = "state";
        form.appendChild(element2);

        document.body.appendChild(form);

        form.submit();

    }

    window.onload = DoPost();
    // $(document).ready(function() {
    //     DoPost();
    // })
</script>

</html>