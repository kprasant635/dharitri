<style>
    .panel-heading {
    padding: 6px 10px !important; /* reduce padding */
    background-color: #17a2b8 !important; /* keep Bootstrap info color */
    color: #fff;
    text-align: center;
}

.panel-heading h4 {
    font-size: 16px; /* smaller text */
    margin: 0; /* remove top-bottom margin */
    line-height: 1.2; /* tighter line spacing */
}

</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">

                <div class="panel-heading text-center">
                    <h4 class="mb-0 fw-bold">Approved Data Entry</h4>
                </div>
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Mouza</th>
                            <th>Village</th>
                            <th>Dag No</th>
                            <th>Patta</th>
                            <th>Patta No</th>
                            <th>Land Class</th>
                            <th>Area<br>(B-K-L)</th>
                            <th>Revenue</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <th></th> <!-- Mouza dropdown -->
                            <th></th> <!-- Village dropdown -->
                            <th><input type="text" placeholder="Search Dag No" class="form-control form-control-sm" /></th>
                            <th></th> <!-- Patta dropdown -->
                            <th><input type="text" placeholder="Search Patta No" class="form-control form-control-sm" /></th>
                            <th></th> <!-- Land class dropdown -->
                            <th><input type="text" placeholder="Search Area" class="form-control form-control-sm" /></th>
                            <th><input type="text" placeholder="Search Revenue" class="form-control form-control-sm" /></th>
                            <th><input type="date" class="form-control form-control-sm" /></th> <!-- Date filter -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($basic as $b): ?>
                        <tr>
                            <td><?=$this->utilityclass->getMouzaName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code);?></td>
                            <td><?=$this->utilityclass->getVillageName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code,$b->lot_no,$b->vill_townprt_code);?></td>
                            <td><kbd><?=$b->dag_no;?></kbd></td>
                            <td><?=$this->utilityclass->getPattaName($b->patta_type_code);?></td>
                            <td><?=$b->patta_no;?></td>
                            <td><?=$this->utilityclass->getLandClassCode($b->land_class_code);?></td>
                            <td><?=$b->dag_area_b."-".$b->dag_area_k."-".$b->dag_area_lc;?></td>
                            <td><?=$b->dag_revenue;?></td>
                            <td><?=date('Y-m-d', strtotime($b->date_entry))?></td>
                            <td><a class='btn btn-xs btn-danger acb' href='<?php echo base_url() . 'index.php/chitha_basic_deo/coview?d='. $b->dist_code .'&s='.$b->subdiv_code .'&c='.$b->cir_code .'&m='.$b->mouza_pargona_code .'&l='.$b->lot_no .'&v='.$b->vill_townprt_code .'&dg='.$b->dag_no .'&p='.$b->patta_no .'&pc='.$b->patta_type_code.'&cn=0'   ?>'>Details</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        initComplete: function () {
            var api = this.api();
            // Dropdown filters
            createDropdown(api, 0); // Mouza
            createDropdown(api, 1); // Village
            createDropdown(api, 3); // Patta
            createDropdown(api, 5); // Land Class
        }
    });

    // Text filters (other columns)
    $('#example thead tr:eq(1) th').each(function(i) {
        var input = $('input', this);
        if (input.length && input.attr('type') !== 'date') {
            input.on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table.column(i).search(this.value).draw();
                }
            });
        }
    });

    // Date filter
    $('#example thead tr:eq(1) th input[type="date"]').on('change', function() {
        var selectedDate = this.value; // in format YYYY-MM-DD
        table.column(8).search(selectedDate).draw();
    });

    // Function to create dropdown filters
    function createDropdown(api, colIndex) {
        var column = api.column(colIndex);
        var select = $('<select class="form-control form-control-sm"><option value="">All</option></select>')
            .appendTo($(column.header()).closest('thead').find('tr:eq(1) th').eq(colIndex))
            .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
            });

        // Populate unique values
        column.data().unique().sort().each(function(d) {
            if (d) select.append('<option value="' + d + '">' + d + '</option>');
        });
    }

    $(document).off('click', '.acb').on('click', '.acb', function(e) {
    e.preventDefault();
    var modal = $('.bs-example-modal-lg');
    
    modal.find('.modal-content').html('<img src="' + baseUrl + 'application/views/images/load.gif">');

    $.ajax({
        url: $(this).attr('href'),
        success: function (data) {
            modal.find('.modal-content').html(data);
            modal.modal('show');
        }
    });
});
});
</script>
