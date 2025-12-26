$(document).ready( function () {
    //data table initialisation
    $('#mouzdar_view_doul_table').dataTable({
        "scrollX": true,
        aLengthMenu: [
            [2, 4, 8, 16, -1],
            [2, 4, 8, 16, "All"]
        ],
        paging: false,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download"></i> Download As Excel',
                titleAttr: 'Excel',
                title: "Mouza Wise Doul",
            }, 
            // {
            //     extend:    'csvHtml5',
            //     text:      '<i class="fa fa-download"></i> Download As CSV',
            //     titleAttr: 'CSV',
            //     title: "Mouza Wise Doul",
            // },
        ],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-info btn-sm');
            btns.removeClass('dt-button');
        }
    });
});