$(document).ready(function() {
    $('body').on('hidden.bs.modal', '.modal', function (event) {
        $(this).removeData('bs.modal');
        $('.modal-content').html('');
    });
});

function initDataTable(class_table, total_row, sort_disable) {
    $('.' + class_table).dataTable( {
        "aaSorting" : [],
        "bRetrieve": true,
        "bSort" : true,
        "bFilter" : false,
        "bPaginate" : true,
        "bAutoWidth": true,
        "sScrollY": "400",
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse" : true,
        "bInfo" : false,
        "bLengthChange": false,
        "pagingType": "full_numbers",
        "iDisplayLength" : total_row,
        "aoColumnDefs": [
            {
                "bSortable" : false,
                "aTargets" : sort_disable
            }
        ]
    });
}

function initDataSortTable(class_table, total_row) {
    $('.' + class_table).dataTable( {
        "aaSorting" : [],
        "bRetrieve": true,
        "bSort" : false,
        "bFilter" : false,
        "bPaginate" : true,
        "bAutoWidth": true,
        "sScrollY": "400",
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse" : true,
        "bInfo" : false,
        "bLengthChange": false,
        "pagingType": "full_numbers",
        "iDisplayLength" : total_row
    });
}

function initDataTablePaging(table_class) {
    Table1 = $('.' + table_class).dataTable({
        "bSort" : false,
        "bFilter" : false,
        "bAutoWidth": true,
        "bInfo" : false,
        "bLengthChange": false,
        "sScrollY": "400px",
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bJQueryUI": false,
        "bPaginate": false
    });
    initDatePicker('date');
}

function initDatePicker(date_class) {
    $('.' + date_class).datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2,
        weekStart: 1
    });
}