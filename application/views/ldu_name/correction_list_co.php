    <?php $user_desig_code = $this->session->userdata('user_desig_code');
    if ($this->session->userdata('user_desig_code') == 'CO') { ?>
        <h2>Correction Requests from LRA</h2>
    <?php }
    if ($this->session->userdata('user_desig_code') == 'ADC') { ?>
        <h2>Correction Requests from CO</h2>
    <?php } ?>
    <label for="filter_status">Filter by Status:</label>
    <select id="filter_status">
        <option value="">All</option>
        <option value="Approved" <?php echo (isset($_GET['status']) && $_GET['status'] == "Approved") ? 'selected' : ''; ?>>Approved</option>
        <option value="Forwarded" <?php echo (isset($_GET['status']) && $_GET['status'] == "Forwarded") ? 'selected' : ''; ?>>Forwarded</option>
        <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] == "Pending") ? 'selected' : ''; ?>>Pending</option>
        <option value="Rejected" <?php echo (isset($_GET['status']) && $_GET['status'] == "Rejected") ? 'selected' : ''; ?>>Rejected</option>
    </select>
    <br><br>

    <div class="panel-body">
        <table class="table table-striped table-bordered" width="100%">
            <tr>
                <th>ID</th>
                <th>Case NO</th>
                <th>Patta No</th>
                <th>Old Father Name</th>
                <th>New Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php $row = count($corrections);
            if ($row > 0) {
                $c = 1;
                foreach ($corrections as $cases) {
            ?>
                    <tr class="text-center">
                        <td><?php echo $cases->id; ?></td>
                        <td><?php echo $cases->case_no; ?></td>
                        <td><?php echo $cases->patta_no; ?></td>
                        <td><?php echo $cases->old_pdar_father; ?></td>
                        <td><?php echo $cases->new_pdar_father; ?></td>
                        <td><?php echo $cases->status; ?></td>
                        <td>
                            <button style="
                                background-color: blue;
                                color: white;
                                padding: 8px 12px;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;"
                                onclick="viewCaseDetails(<?php echo $cases->id; ?>)">
                                View Case
                            </button>
                        </td>
                    </tr>
                <?php $c++;
                }
            } else { ?>
                <tr class="text-center">
                    <td colspan="7" style="color: red;">No Record found
                        <br /><br />
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                            <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php
        echo $pagination;
        //$this->pagination->create_links(); 
        ?>
    </div>
    <input type="hidden" name="" id="user_desig" value="<?= $user_desig_code ?>">
    <div id="corrections_data"></div>


    <script type="text/javascript">
        // Reload when filter changes
        $(document).on("change", "#filter_status", function() {
            const status = document.getElementById('filter_status').value;

            <?php $user_desig_code = $this->session->userdata('user_desig_code');
            if ($this->session->userdata('user_desig_code') == 'CO') { ?>

                window.location.href = baseurl + 'CorrectionController/listCOCorrections?status=' + encodeURIComponent(status)
            <?php }
            if ($this->session->userdata('user_desig_code') == 'ADC') { ?>

                window.location.href = baseurl + 'CorrectionController/listADCCorrections?status=' + encodeURIComponent(status)
            <?php } ?>

        });


        function viewCaseDetails(id) {

            window.location.href = baseurl + 'CorrectionController/viewCaseDetailsbyId/' + encodeURIComponent(btoa(id));
            // $.ajax({
            //     type: 'POST', 
            //     url: baseurl + 'CorrectionController/viewCaseDetailsbyId/'+id,
            //     dataType: 'json', 
            //     beforeSend: function(){
            //         $("#loading").html("Validating ...Please wait...");
            //         $('.alert').hide();
            //         $('.disable_forward').hide();
            //     },
            //     success: function(data){
            //         console.log(data);
            //         $("#loading").hide();
            //         // if(data.success)
            //         // {
            //         //    $('#pdfData').val(data.data); 
            //         //    $('#signPdf').show();
            //         //    $('#print').hide();
            //         // } 
            //         // else if(data.error) 
            //         // {
            //         //     $('.btn-block').show();
            //         //     $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
            //         //     $('.disable_forward').show();
            //         // }
            //     },
            //     error: function(xhr, status, error) {
            //         console.error("AJAX Error:", error);
            //         console.log(xhr.responseText);  // Log server response
            //     }
            // });   
        }
    </script>