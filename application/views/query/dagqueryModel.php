 <style>
    .query-text{
        width:95%;
        margin: auto;
    }
    .query-button{
        width: 100%;
        display: flex;
        justify-content: end;
        margin-top: 10px;
    }
    
 </style>
<div class="query-button" id="query-button">
    
</div>

<div class="query-text" id="query-text">
    
</div>

<!-- Modal HTML -->
<div id="myDagModal" class="modal" tabindex="-1" style="z-index:9999">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form>
                
            </form>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/CaseAPI/querytouserforDagchange" method="post">
            <input type="hidden" class="form-control" name='application_no' id='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
                <?php
                    if($this->session->flashdata('query_mdl_message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('query_mdl_message'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
                <textarea name='query' class="form-control" placeholder="Please enter your query"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" id='querySend' class="btn query btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.query', function(e) {
    e.preventDefault();
    $('#myDagModal').modal('show');
});
$('.close').click(function() {
    $('#myDagModal').modal('hide');
});


$(document).ready(function() {
    var querysent = 'N';

    var application_no =  document.getElementById("application_no").value; 
    var queryText = document.getElementById("query-text");
    //alert(baseurl);

    $.ajax({
    url: baseurl + 'check-query-api',
    method: 'POST',
    data: {
        application_no: application_no,
    },
    dataType: 'JSON',
    success: function(response) {
        console.log("Full Response:", response);
        $.unblockUI();

        try {
            if (typeof response === "string") {
                response = JSON.parse(response); // Parse only if it's a string
            }

            if (response.query_sent === 'Y') {
                $("#query-text").css("visibility", "visible");

                const queryContainer = document.getElementById("query-button");
                queryContainer.innerHTML = '<button disabled class="btn btn-sm pull-right btn-danger">Query Sent <i class="fa fa-check"></i></button>';

                let queries = response.queries;

                // Debugging to check the type of queries
                // console.log("Raw Queries:", queries);
                // console.log("Type of queries:", typeof queries);

                // Ensure queries is parsed correctly
                if (typeof queries === "string") {
                    try {
                        queries = JSON.parse(queries);
                        // console.log("Parsed Queries:", queries);
                    } catch (parseError) {
                        // console.error("Error parsing queries:", parseError);
                        return; // Stop execution if parsing fails
                    }
                }

                if (Array.isArray(queries)) {
                    if (queries.length > 0) {
                        let queryTextHTML = "<div style='display: flex; flex-direction: column; gap: 10px; width:100%;'>";

                        queries.forEach(query => {
                            queryTextHTML += `
                                <div style="background-color: #ffd6d6; margin-top: 20px; border-top-left-radius: 50px; border-top-right-radius: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px; padding: 40px; width: 100%; position: relative;">
                                        <p style="margin: 0; font-weight: bold;">${query.query_text}</p>
                                        <div style="display: flex; width:100%;  justify-content: space-between; font-size: 12px; margin-top: 5px;">
                                            <span>${query.query_from_office} - ${query.query_from_officer}</span>
                                            <span style="color: gray;">${query.date_of_query}</span>
                                        </div>
                                    </div>`;

                            if (query.reply_text) {
                                queryTextHTML += `
                                     <div style="background-color: #b8f9ed; margin_top:20px; padding: 10px; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-left-radius: 0; border-bottom-right-radius: 50px; padding: 40px; width: 100%; position: relative;">
                                                <p style="margin: 0; font-weight: bold;">${query.reply_text}</p>
                                                <div style="display: flex; width:100%;  justify-content: space-between; font-size: 12px; margin-top: 5px;">
                                                    <span>Citizen - ${query.query_from_officer}</span>
                                                    <span style="color: gray;">${query.date_of_reply}</span>
                                                </div>
                                            </div>`;
                            }
                        });

                        queryTextHTML += "</div>";
                        $("#query-text").html(queryTextHTML);
                    } else {
                        console.warn("No queries available.");
                        $("#query-text").html("No queries available.");
                    }
                } else {
                    console.error("Unexpected queries format:", queries);
                    $("#query-text").html("Error: Unexpected data format.");
                }
            }
            else if (response.query_sent === 'QR') {
                $("#query-text").css("visibility", "visible");

                const queryContainer = document.getElementById("query-button");
                queryContainer.innerHTML = '<button class="btn query btn-sm pull-right btn-success"><i class="fa fa-hand-paper-o"></i> Query to Applicant(s)</button>';

                let queries = response.queries;

                // Debugging to check the type of queries
                // console.log("Raw Queries:", queries);
                // console.log("Type of queries:", typeof queries);

                // Ensure queries is parsed correctly
                if (typeof queries === "string") {
                    try {
                        queries = JSON.parse(queries);
                        // console.log("Parsed Queries:", queries);
                    } catch (parseError) {
                        // console.error("Error parsing queries:", parseError);
                        return; // Stop execution if parsing fails
                    }
                }

                if (Array.isArray(queries)) {
                    if (queries.length > 0) {
                        let queryTextHTML = "<div style='display: flex; flex-direction: column; gap: 10px; width:100%;'>";

                        queries.forEach(query => {
                            queryTextHTML += `
                                <div style="background-color: #ffd6d6; margin-top: 20px; border-top-left-radius: 50px; border-top-right-radius: 0; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px; padding: 40px; width: 100%; position: relative;">
                                        <p style="margin: 0; font-weight: bold;">${query.query_text}</p>
                                        <div style="display: flex; width:100%;  justify-content: space-between; font-size: 12px; margin-top: 5px;">
                                            <span>${query.query_from_office} - ${query.query_from_officer}</span>
                                            <span style="color: gray;">${query.date_of_query}</span>
                                        </div>
                                    </div>`;

                            if (query.reply_text) {
                                queryTextHTML += `
                                     <div style="background-color: #b8f9ed; margin_top:20px; padding: 10px; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-left-radius: 0; border-bottom-right-radius: 50px; padding: 40px; width: 100%; position: relative;">
                                                <p style="margin: 0; font-weight: bold;">${query.reply_text}</p>
                                                <div style="display: flex; width:100%;  justify-content: space-between; font-size: 12px; margin-top: 5px;">
                                                    <span>Citizen - ${query.query_from_officer}</span>
                                                    <span style="color: gray;">${query.date_of_reply}</span>
                                                </div>
                                            </div>`;
                            }
                        });

                        queryTextHTML += "</div>";
                        $("#query-text").html(queryTextHTML);
                    } else {
                        console.warn("No queries available.");
                        $("#query-text").html("No queries available.");
                    }
                } else {
                    console.error("Unexpected queries format:", queries);
                    $("#query-text").html("Error: Unexpected data format.");
                }
            } else {
                const queryContainer = document.getElementById("query-button");
                queryContainer.innerHTML = '<button class="btn query btn-lg pull-right btn-danger"><i class="fa fa-hand-paper-o"></i> Dag Change Query to Applicant(s)</button>';
            }
        } catch (e) {
            console.error("Error processing response:", e);
        }
    },
    error: function(error) {
        $.unblockUI();
        console.error("AJAX Error:", error);
    }
});



});



</script>

