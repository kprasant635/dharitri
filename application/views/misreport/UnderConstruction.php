<div class="container-fluid"  style="min-height:400px;">
    <div class="row">
        <br>
        <div class='center'>
            <img src="<?php echo base_url(); ?>application/views/img/UnderConstruction.jpg" />
        </div>
        <center><button id="backButton" class="btn  btn-danger center"><i class="fa fa-home"></i>&nbsp;Back to Main Meu</button></center>
        <br>
    </div>
     
     <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/MisReport' ?>";
        };
    </script>
    
</div>
