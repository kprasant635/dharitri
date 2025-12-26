<!-- View: land_class_update/village_landclass_update.php -->

<div class="container mt-4" style="max-width: 1400px; padding-left: 32px; padding-right: 32px;">
    <!-- Title Block -->
    <div style="background: #0a2342; color: #fff; border-radius: 1.2rem; padding: 1.5em 1em 1.2em 2em; margin-bottom: 1.5em; box-shadow: 0 4px 24px rgba(10,35,66,0.10); display: flex; align-items: center;">
        <div>
                <h3 style="margin: 0; font-weight: 700; font-size: 1.25em; letter-spacing: 0.2px;">Village Wise Land Class Updation</h3>
            <div style="font-size: 1.1em; color: #b3c6e0; margin-top: 0.2em;">Update and track land class status for each village</div>
        </div>
    </div>
    <style>
        .custom-tabs { margin-bottom: 1em; display: flex; border-bottom: 2.5px solid #0a2342; }
        .custom-tab-btn {
            padding: 13px 38px;
            background: #183153;
            color: #fff;
            border: none;
            border-bottom: 3px solid transparent;
            border-radius: 1.2rem 1.2rem 0 0;
            margin-right: 2px;
            cursor: pointer;
            font-size: 1.13em;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: background 0.2s, color 0.2s, border-bottom 0.2s;
            box-shadow: 0 2px 8px rgba(10,35,66,0.07);
        }
            .custom-tab-btn.active {
                background: #1b5e20;
                color: #fff;
                border-bottom: 3px solid #1b5e20;
                box-shadow: 0 -2px 12px rgba(27,94,32,0.08);
            }
        .custom-tab-btn:not(.active):hover {
            background: #25406b;
            color: #b3c6e0;
        }
        .custom-tab-pane { display: none; }
        .custom-tab-pane.active { display: block; background: #fff; border: 1.5px solid #0a2342; border-top: none; border-radius: 0 0 1.2rem 1.2rem; padding: 1.7em 1.2em; }
        /* Table Styling */
        table.dataTable {
            border-radius: 1.1em;
            overflow: hidden;
            background: #f8fafb;
            box-shadow: 0 2px 12px rgba(10,35,66,0.07);
        }
        table.dataTable thead th {
            background: #183153;
            color: #fff;
            font-weight: 700;
            border-bottom: 2.5px solid #1b5e20;
            font-size: 1.08em;
        }
        table.dataTable tbody tr {
            background: #fff;
            transition: background 0.2s;
        }
        table.dataTable tbody tr:hover {
            background: #e8f5e9;
        }
        table.dataTable td, table.dataTable th {
            padding: 0.7em 0.6em;
        }
        .dataTables_filter input {
            border-radius: 0.7em;
            border: 1.5px solid #1b5e20;
            padding: 0.4em 1em;
        }
        .column-filters input {
            border-radius: 0.7em;
            border: 1.5px solid #1b5e20;
            padding: 0.4em 1em;
            background: #f8fafb;
        }
        /* Progress Bar - Dark Green Theme */
        .progress-container .progress {
            background: #e8f5e9;
        }
            .progress-bar {
                background: linear-gradient(90deg, #145a1f 0%, #ff9800 100%);
                color: #fff;
                font-weight: bold;
                box-shadow: 0 2px 8px rgba(67,160,71,0.15);
                border-radius: 1.5rem 0 0 1.5rem;
                transition: width 0.3s cubic-bezier(.4,2,.6,1), background 0.3s;
            }
    </style>
    <div class="custom-tabs">
        <button id="pendingTabBtn" class="custom-tab-btn active">Pending</button>
        <button id="updatedTabBtn" class="custom-tab-btn">Updated</button>
    </div>
    <div id="pendingTabPane" class="custom-tab-pane active">
        <div class="mb-2 mt-2">
            <button id="updateLandClassBtn" class="btn btn-danger uni_text btn-wide" disabled>Update Land Class</button>
        </div>
        <div class="table-loader" id="pendingTableLoader" style="display:none;">
            <div class="loader-spinner"></div>
            <div class="loader-text">Loading pending villages...</div>
        </div>
        <div style="overflow-x:auto;">
        <table id="pendingVillagesTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAllPending"></th>
                    <th>District</th>
                    <th>Circle</th>
                    <th>Mouza</th>
                    <th>Lot</th>
                    <th>Village</th>
                    <th>Village Code</th>
                    <th>Status</th>
                </tr>
                <tr class="column-filters">
                    <th></th>
                    <th><input type="text" class="filter-input" placeholder="Filter District" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Circle" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Mouza" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Lot" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Village" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Code" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Status" style="width:100%"></th>
                </tr>
            </thead>
            <tbody>
                <!-- Data loaded via AJAX -->
            </tbody>
        </table>
        </div>
        <div id="progressContainer" class="progress-container" style="display:none;">
            <div class="progress mt-3" style="position: relative; height: 2.5rem;">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%; font-size: 1.3rem; line-height: 2.5rem;">0%</div>
                <div id="progressText" style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: #333; font-weight: bold; width: 100%; text-align: center; font-size: 1.3rem;">
                    0 / 0 processed
                </div>
                <div id="progressTime" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #007bff; font-weight: bold; text-align: right; font-size: 1.1rem; min-width: 120px;">
                    <span id="progressTimeText">Total Time: 0s | Last: 0s</span>
                </div>
            </div>
        </div>
    </div>
    <div id="updatedTabPane" class="custom-tab-pane">
        <div class="mb-2 mt-2">
            <!-- Re-Update button removed as per changes -->
        </div>
        <div class="table-loader" id="updatedTableLoader" style="display:none;">
            <div class="loader-spinner"></div>
            <div class="loader-text">Loading updated villages...</div>
        </div>
        <div style="overflow-x:auto;">
        <table id="updatedVillagesTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>District</th>
                    <th>Circle</th>
                    <th>Mouza</th>
                    <th>Lot</th>
                    <th>Village</th>
                    <th>Village Code</th>
                    <th>Status</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                </tr>
                <tr class="column-filters">
                    <th><input type="text" class="filter-input" placeholder="Filter District" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Circle" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Mouza" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Lot" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Village" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Code" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Status" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Updated By" style="width:100%"></th>
                    <th><input type="text" class="filter-input" placeholder="Filter Created At" style="width:100%"></th>
                </tr>
            </thead>
            <tbody>
                <!-- Data loaded via AJAX -->
            </tbody>
        </table>
        </div>
    </div>
</script>
<script>
// Make loader functions globally available before any DataTable or AJAX code
window.showLoader = function(loaderId) {
    $(loaderId).show();
};
window.hideLoader = function(loaderId) {
    $(loaderId).hide();
};

// Simple jQuery-based tab switching (no Bootstrap required)
$(function() {
    $('#pendingTabBtn').on('click', function() {
        $('#pendingTabBtn').addClass('active');
        $('#updatedTabBtn').removeClass('active');
        $('#pendingTabPane').addClass('active');
        $('#updatedTabPane').removeClass('active');
        // If using DataTables, adjust columns
        if ($.fn.dataTable) {
            $('#pendingVillagesTable').DataTable().columns.adjust();
        }
    });
    // Initialize updatedTable ONCE on page load
    var updatedTable = $('#updatedVillagesTable').DataTable({
        ajax: {
            url: "<?= base_url('index.php/lcu/get_updated_villages') ?>",
            dataType: 'json',
            dataSrc: function(json) {
                console.log('DEBUG updated villages response:', json);
                hideLoader('#updatedTableLoader');
                if (!json || typeof json !== 'object') return [];
                if (json.error) {
                    alert('Error loading updated villages: ' + json.error);
                    return [];
                }
                if (!Array.isArray(json.data)) return [];
                return json.data;
            },
            beforeSend: function() {
                showLoader('#updatedTableLoader');
            },
            error: function(xhr, status, error) {
                hideLoader('#updatedTableLoader');
                console.error('AJAX error:', status, error, xhr && xhr.responseText);
                alert('AJAX error: ' + status + ' - ' + error);
            }
        },
        columns: [
            { data: 'district' },
            { data: 'circle' },
            { data: 'mouza' },
            { data: 'lot' },
            { data: 'village' },
            { data: 'village_code' },
            { data: 'status' },
            { data: 'updatedby' },
            { data: 'createdat' }
        ],
        columnDefs: [],
        language: {
            emptyTable: "No updated villages found."
        },
        initComplete: function () {
            hideLoader('#updatedTableLoader');
            this.api().columns().every(function (colIdx) {
                var column = this;
                $('thead tr.column-filters th').eq(colIdx).find('input').on('keyup change', function () {
                    column.search(this.value).draw();
                });
            });
        },
        processing: false,
        dom: 'tip'
    });
    $('#updatedTabBtn').on('click', function() {
        $('#updatedTabBtn').addClass('active');
        $('#pendingTabBtn').removeClass('active');
        $('#updatedTabPane').addClass('active');
        $('#pendingTabPane').removeClass('active');
        setTimeout(function() {
            updatedTable.columns.adjust();
            updatedTable.ajax.reload();
        }, 100);
    });
});
</script>
</div>
<style>
.table-loader {
    position: absolute;
    left: 0; right: 0; top: 0; bottom: 0;
    background: rgba(255,255,255,0.8);
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 200px;
}
.loader-spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #007bff;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    animation: spin 1s linear infinite;
    margin-bottom: 10px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.loader-text {
    font-size: 1.1em;
    color: #007bff;
    font-weight: 500;
}
.custom-tab-pane { position: relative; }
.progress-container {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 2000;
    background: rgba(255,255,255,0.85);
    display: flex;
    align-items: center;
    justify-content: center;
}
.progress-container .progress {
    width: 98vw;
    max-width: 900px;
    min-width: 320px;
    margin: 0 auto;
    box-shadow: 0 4px 24px rgba(0,0,0,0.12), 0 1.5px 4px rgba(0,123,255,0.10);
    border-radius: 1.5rem;
    background: #e9ecef;
    overflow: hidden;
}
.progress-bar {
    background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
    color: #fff;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
    border-radius: 1.5rem 0 0 1.5rem;
    transition: width 0.3s cubic-bezier(.4,2,.6,1), background 0.3s;
}
.pending-checkbox, #selectAllPending {
    cursor: pointer;
}
#pendingVillagesTable td:first-child {
    cursor: pointer;
}
</style>
<script>
$(document).ready(function() {
    var pendingTable = $('#pendingVillagesTable').DataTable({
        ajax: {
            url: "<?= base_url('index.php/lcu/get_pending_villages') ?>",
            dataSrc: function(json) {
                hideLoader('#pendingTableLoader');
                if (!json || !json.data || json.data.length === 0) {
                    // DataTables will show 'No data available in table'
                    return [];
                }
                return json.data;
            },
            beforeSend: function() {
                showLoader('#pendingTableLoader');
            }
        },
        columns: [
            { data: null, render: function(data, type, row) {
                return '<input type="checkbox" class="pending-checkbox" value="' + row.village_code + '">';
            }, orderable: false },
            { data: 'district' },
            { data: 'circle' },
            { data: 'mouza' },
            { data: 'lot' },
            { data: 'village' },
            { data: 'village_code' },
            { data: 'status' }
        ],
        language: {
            emptyTable: "No pending villages found."
        },
        initComplete: function () {
            hideLoader('#pendingTableLoader');
            // Add column filter logic
            this.api().columns().every(function (colIdx) {
                var column = this;
                $('thead tr.column-filters th').eq(colIdx).find('input').on('keyup change', function () {
                    column.search(this.value).draw();
                });
            });
        },
        processing: false, // We'll use our own loader
        dom: 'tip' // Show table, info, and pagination only
    });

    // Show loader on initial load
    showLoader('#pendingTableLoader');
    showLoader('#updatedTableLoader');

    // Enable/disable update button
    function updateButtonState() {
        var selectedCount = $('#pendingVillagesTable .pending-checkbox:checked').length;
        $('#updateLandClassBtn').prop('disabled', selectedCount === 0);
    }

    // Row click toggles checkbox for user-friendliness
    $('#pendingVillagesTable tbody').on('click', 'tr', function(e) {
        // Prevent double toggle if clicking directly on checkbox
        if ($(e.target).is('input[type="checkbox"]')) return;
        var $checkbox = $(this).find('.pending-checkbox');
        $checkbox.prop('checked', !$checkbox.prop('checked'));
        updateButtonState();
    });
    // Use DataTables Select extension for cross-page selection
    if (!$.fn.dataTable.ext.select) {
        // fallback: select all checkboxes on all pages
        $('#pendingVillagesTable tbody').on('change', '.pending-checkbox', function() {
            updateButtonState();
        });
        $('#selectAllPending').on('change', function() {
            var checked = $(this).is(':checked');
            // Select all checkboxes on all pages
            pendingTable.rows().every(function() {
                var node = this.node();
                $(node).find('.pending-checkbox').prop('checked', checked);
            });
            updateButtonState();
        });
    } else {
        // If Select extension is available
        pendingTable.on('select deselect', function() {
            updateButtonState();
        });
        $('#selectAllPending').on('change', function() {
            var checked = $(this).is(':checked');
            if (checked) {
                pendingTable.rows({ search: 'applied' }).select();
            } else {
                pendingTable.rows().deselect();
            }
        });
    }

    // Update Land Class button click
    $('#updateLandClassBtn').on('click', function() {
        // Get all selected village codes across all pages
        var selected = [];
        pendingTable.rows().every(function() {
            var data = this.data();
            var node = this.node();
            if ($(node).find('.pending-checkbox').is(':checked')) {
                selected.push(data.village_code);
            }
        });
        var totalRows = pendingTable.data().length;
        if (selected.length === 0) return;
        // Stylish confirmation dialog
        var confirmBox = $(
            '<div id="customConfirmModal" style="position:fixed;z-index:3000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.35);display:flex;align-items:center;justify-content:center;">' +
            '<div style="background:#fff;padding:2em 2.5em;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.18);min-width:320px;text-align:center;">' +
            '<div style="font-size:1.2em;margin-bottom:1em;">You have selected <b>' + selected.length + '</b> out of <b>' + totalRows + '</b> villages for processing.<br>Do you want to continue?</div>' +
            '<button id="customYesBtn" style="margin:0 1em 0 0;padding:0.5em 2em;background:#007bff;color:#fff;border:none;border-radius:6px;font-size:1em;">Yes</button>' +
            '<button id="customNoBtn" style="padding:0.5em 2em;background:#e0e0e0;color:#333;border:none;border-radius:6px;font-size:1em;">No</button>' +
            '</div></div>'
        );
        $('body').append(confirmBox);
        $('#customNoBtn').on('click', function() {
            $('#customConfirmModal').remove();
        });
        $('#customYesBtn').on('click', function() {
            $('#customConfirmModal').remove();
            // Center and show progress bar overlay
            $('#progressContainer').show();
            var total = selected.length;
            var completed = 0;
            var failed = 0;
            var startTime = new Date();
            var totalElapsed = 0;
            $('#progressBar').css('width', '0%').text('0%');
            $('#progressText').text('0 / ' + total + ' processed');
            $('#progressTimeText').text('Total Time: 0s | Last: 0s');
            var successVillages = [];
            var failedVillages = [];
            function updateNext() {
                if (selected.length === 0) {
                    totalElapsed = Math.round((new Date() - startTime) / 1000);
                    $('#progressTimeText').text('Total Time: ' + totalElapsed + 's');
                    $('#progressContainer').hide();
                    pendingTable.ajax.reload(null, false); // reload pending list
                    // Ensure updatedTable is initialized before using
                    if (typeof updatedTable === 'undefined' || !updatedTable) {
                        if ($('#updatedVillagesTable').length) {
                            updatedTable = $('#updatedVillagesTable').DataTable();
                        }
                    }
                   
                    $('#updateLandClassBtn').prop('disabled', true);
                    // Show result summary with details
                    var resultHtml = '<div style="font-size:1.2em;margin-bottom:1em;">';
                    if (successVillages.length > 0) {
                        resultHtml += '<span style="color:#28a745;font-weight:bold;">' + successVillages.length + ' villages successfully updated.</span>';
                        //resultHtml += '<div style="max-height:120px;overflow:auto;font-size:0.98em;margin:0.5em 0 1em 0;padding:0.5em 0 0.5em 0.5em;background:#e8f5e9;border-radius:6px;">' + successVillages.map(function(v){return '<span style="color:#145a1f;">'+v+'</span>';}).join(', ') + '</div>';
                    }
                    if (failedVillages.length > 0) {
                        resultHtml += '<span style="color:#dc3545;font-weight:bold;">' + failedVillages.length + ' villages could not be updated.</span>';
                        resultHtml += '<div style="max-height:120px;overflow:auto;font-size:0.98em;margin:0.5em 0 1em 0;padding:0.5em 0 0.5em 0.5em;background:#ffebee;border-radius:6px;">' + failedVillages.map(function(v){return '<span style="color:#b71c1c;">'+v+'</span>';}).join(', ') + '</div>';
                    }
                    resultHtml += '</div>';
                    var resultBox = $(
                        '<div id="customResultModal" style="position:fixed;z-index=3000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.35);display:flex;align-items:center;justify-content:center;">' +
                        '<div style="background:#fff;padding:2em 2.5em;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.18);min-width:320px;text-align:center;">' +
                        resultHtml +
                        '<button id="customResultOkBtn" style="padding:0.5em 2em;background:#007bff;color:#fff;border:none;border-radius:6px;font-size:1em;">OK</button>' +
                        '</div></div>'
                    );
                    $('body').append(resultBox);
                    $('#customResultOkBtn').on('click', function() {
                        $('#customResultModal').remove();
                    });
                    return;
                }
                var village_code = selected.shift();
                var perStart = new Date();
                $.post("<?= base_url('index.php/lcu/update_land_class') ?>", {village_code: village_code}, function(resp) {
                    var isSuccess = false;
                    if (resp && typeof resp === 'string') {
                        try { resp = JSON.parse(resp); } catch(e) {}
                    }
                    if (resp && resp.success) {
                        completed++;
                        successVillages.push(village_code);
                    } else {
                        failed++;
                        failedVillages.push(village_code);
                    }
                    var percent = Math.round(((completed+failed)/total)*100);
                    $('#progressBar').css('width', percent+'%').text(percent+'%');
                    $('#progressText').text((completed+failed) + ' / ' + total + ' processed');
                    var perElapsed = Math.round((new Date() - perStart) / 1000);
                    window.lastPerElapsed = perElapsed;
                    totalElapsed = Math.round((new Date() - startTime) / 1000);
                    $('#progressTimeText').text('Total Time: ' + totalElapsed + 's | Last: ' + perElapsed + 's');
                    updateNext();
                }).fail(function() {
                    failed++;
                    failedVillages.push(village_code);
                    var percent = Math.round(((completed+failed)/total)*100);
                    $('#progressBar').css('width', percent+'%').text(percent+'%');
                    $('#progressText').text((completed+failed) + ' / ' + total + ' processed');
                    var perElapsed = Math.round((new Date() - perStart) / 1000);
                    window.lastPerElapsed = perElapsed;
                    totalElapsed = Math.round((new Date() - startTime) / 1000);
                    $('#progressTimeText').text('Total Time: ' + totalElapsed + 's | Last: ' + perElapsed + 's');
                    updateNext();
                });
            }
            updateNext();
        }); // End of $('#customYesBtn').on('click', ...)
    }); // End of $('#updateLandClassBtn').on('click', ...)
}); // End of $(document).ready
</script>

