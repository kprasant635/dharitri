<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">Mouzadari Demand Notice</li>
    </ol>
</nav>

<input type="hidden" id="dist_code" name="dist_code" value="<?php echo $dist_code; ?>">
<input type="hidden" id="subdiv_code" name="subdiv_code" value="<?php echo $subdiv_code; ?>">
<input type="hidden" id="cir_code" name="cir_code" value="<?php echo $cir_code; ?>">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mouza">Mouza:</label>
                        <select class="form-control" id="mouza" name="mouza" required>
                            <option value="">Select Mouza</option>
                            <?php foreach ($mouzas as $mouza): ?>
                                <option value="<?php echo $mouza['mouza_pargona_code']; ?>">
                                    <?php echo $mouza['mouza_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="village">Village:</label>
                        <select class="form-control" id="village" name="village" required>
                            <option value="">Select Village</option>
                        </select>
                    </div>
                </div>


                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary" id="searchBtn" >Search</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Function to update form state
        function updateFormState() {
            const districtSelected = $('#dist_code').val() !== '';
            const subdivisionSelected = $('#subdiv_code').val() !== '';
            const circleSelected = $('#cir_code').val() !== '';
            const mouzaSelected = $('#mouza').val() !== '';
            const villageSelected = $('#village').val() !== '';

            // alert(villageSelected);
            

            $('#village').prop('disabled', !mouzaSelected);
            $('#searchBtn').prop('disabled', !villageSelected);

            // Update URL parameters
            if (mouzaSelected && villageSelected) {
                // $('#searchBtn').prop('enable');
                const baseUrl = '<?php echo base_url('index.php/EkhajanaDemandNoticeController/index'); ?>';
                const url = `${baseUrl}?dist_code=${$('#dist_code').val()}&subdiv_code=${$('#subdiv_code').val()}&cir_code=${$('#cir_code').val()}&mouza_pargona_code=${$('#mouza').val()}&village_pargona_code=${$('#village').val()}`;
                $('#searchBtn').off('click').on('click', function() {
                    window.location.href = url;
                });
            }
        }

        // When district changes, load subdivisions
        $('#mouza').change(function() {
            var dist_code = $(this).val();
            // alert('ok');
            if (dist_code) {
                $.ajax({
                    url: '<?php echo base_url('index.php/EkhajanaDemandNoticeController/getVillages'); ?>',
                    type: 'POST',
                    data: {
                        dist_code: $('#dist_code').val(),
                        subdiv_code: $('#subdiv_code').val(),
                        cir_code: $('#cir_code').val(),
                        mouza_pargona_code: $('#mouza').val()
                    },
                    success: function(response) {
                        var villages = JSON.parse(response);
                        var $village = $('#village');
                        $village.empty().append('<option value="">Select Village</option>');
                        $.each(villages, function(index, village) {
                            $village.append(
                                $('<option></option>')
                                .attr('value', village.vill_townprt_code)
                                .text(village.village_name)
                            );
                        });
                        updateFormState();
                    }
                });
            } else {
                $('#village').empty().append('<option value="">Select Village</option>').prop('disabled', true);
                updateFormState();
            }
        });

        $('#village').change(function(){
            updateFormState();
        });


        // Initialize form state
        updateFormState();
    });
</script>