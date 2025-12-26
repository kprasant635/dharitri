    <h2>Correction Requests</h2>
    <label for="filter_status">Filter by Status:</label>
    <select id="filter_status">
        <option value="">All</option>
        <option value="Pending">Pending</option>
        <option value="Forwarded">Forwarded</option>
        <option value="Rejected">Rejected</option>
        <option value="Approved">Approved</option>
    </select>
    <div id="corrections_data"></div>
    <script>
        function loadCorrections(page = 0, status = '') {
            $.ajax({
                url: baseurl +"CorrectionController/listCorrections/" + page,
                type: "GET",
                data: { status: status },
                dataType: "json",
                success: function (response) {
                    var html = '<table class="table table-bordered" border="1"><tr><th>ID</th><th>Old Name</th><th>New Name</th><th>Status</th><th>Action</th></tr>';
                    $.each(response.corrections, function (index, row) {
                        html += `<tr>
                                    <td>${row.id}</td>
                                    <td>${row.old_pdar_name}</td>
                                    <td>${row.new_pdar_name}</td>
                                    <td>${row.status}</td>
                                    <td><button onclick="reviewCorrection(${row.id})">Review</button></td>
                                </tr>`;
                    });
                    html += '</table>';
                    html += response.pagination;
                    $('#corrections_data').html(html);
                }
            });
        }
        $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();
            var page = $(this).attr("href").split("/").pop();
            loadCorrections(page, $("#filter_status").val());
        });
        $("#filter_status").change(function () {
            loadCorrections(0, $(this).val());
        });
        $(document).ready(function () {
            loadCorrections();
        });
    </script>
