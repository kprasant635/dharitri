<style>
    body{
        padding-right: 0 !important;
    }
    .table thead tr:first-child {
    background: #E6E1E1 ;
}
</style>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<div class="col-lg-12">
    <hr>
    <div class="container bg-info text-white p-1 shadow-lg">
       <h5 style="text-align:center">MOUZA WISE CFR BOOK ENTRIES</h5>
    </div>
    <hr>
    <div class="container mb-5">
    <table class="table table-hover table-bordered" style="width:100%!important;background-color:#e6e1e1;font-size:12px;!important" id="mouz_wise_cfr_books_table">
        <thead>
        <tr class="bg-dark text-white">
            <th class="text-center">District</th>
            <th class="text-center">Circle</th>
            <th class="text-center">Mouza</th>
            <th class="text-center">CFR BOOK NO</th>
            <th class="text-center">NO OF PAGES <br>IN THE CFR BOOK</th>
            <th class="text-center">CFR PAGE SERIAL<br>NO START</th>
            <th class="text-center">CFR PAGE SERIAL<br>NO END</th>
            <th class="text-center">BOOK-STATUS</th>
            <th class="text-center">ENTRY-YEAR</th>
        </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($cfr_book_entries as $row): ?>
                <?php
                    if (
                        trim($row->district) == "" ||
                        trim($row->district) == "." ||
                        trim($row->circle) == "" ||
                        trim($row->circle) == "." ||
                        trim($row->mouza) == "" ||
                        trim($row->mouza) == "."
                    ) {
                        continue;
                    }
                ?>
                <tr>
                    <td>
                        <?=$row->district?>
                    </td>
                    <td>
                        <?=$row->circle?>
                    </td>
                    <td>
                        <?=$row->mouza?>
                    </td>
                    <td>
                        <?=$row->cfr_book_number?>
                    </td>
                    <td>
                        <?=$row->no_of_cfr_pages_in_the_book?>
                    </td>
                    <td>
                        <?=$row->cfr_page_serial_no_start?>
                    </td>
                    <td>
                        <?=$row->cfr_page_serial_no_end?>
                    </td>
                    <td>
                        <?=$row->book_status?>
                    </td>
                    <td>
                        <?=$row->entry_year?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <hr>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script> 
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_report.js"></script>