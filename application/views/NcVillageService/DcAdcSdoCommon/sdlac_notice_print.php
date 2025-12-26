<?php

echo $base64_decoded_notice_file;



?>
<div class="container">
    <div class="row mt-4 mb-5 justify-content-center text-center">
        <div class="col-6">
            <button
                type="button"
                onclick="printDiv('print_direct');"
                id="print"
                class="btn btn-success text-white"
            >
                Print Notice
            </button>
        </div>
    </div>
</div>

<script>
    // -js-to print notice
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML
        var originalContents = document.body.innerHTML

        document.body.innerHTML = printContents

        window.print()

        document.body.innerHTML = originalContents
    }
</script>
