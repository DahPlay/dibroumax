let dataTable;
let columsDB;
let route;
let dom;
let buttons;
let columnDefs;
let order;
let pageLength = 10;
let lengthMenu = [];
let pagingType = "simple_numbers";
let arrayColumns = new Array();
let arrayOrder = new Array();
let arrayColumnDefs = new Array();
let arrayLengthMenu = new Array();
let drawCallback;
let rowCallback;

let configDatatable = function (table_) {
    "use strict"

    dataTable = $(table_).DataTable({
        colReorder: true,
        dom: dom,
        buttons: buttons,
        columnDefs: columnDefs,
        order: order,
        autoWidth: false,
        responsive: true,
        pageLength: pageLength,
        lengthMenu: lengthMenu,
        pagingType: pagingType,
        processing: true,
        serverSide: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json'
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: route,
            data: function (d) {
                d.type_transaction_receita = function () {

                    var type_transaction = $("input[name='type_transaction[]']");

                    for (var i = 0; i < type_transaction.length; i++) {
                        if ($(type_transaction[i]).is(':checked')) {
                            if ($(type_transaction[i]).data('type-transaction') == 'receita') {
                                return $(type_transaction[i]).data('type-transaction');
                            }
                        }
                    }

                    return '';
                };
                d.type_transaction_despesa = function () {

                    var type_transaction = $("input[name='type_transaction[]']");

                    for (var i = 0; i < type_transaction.length; i++) {
                        if ($(type_transaction[i]).is(':checked')) {
                            if ($(type_transaction[i]).data('type-transaction') == 'despesa') {
                                return $(type_transaction[i]).data('type-transaction');
                            }
                        }
                    }

                    return '';
                };
                d.document = $('#document_search').is(':checked') ? 1 : 0;
                d.overdue = $('#overdue_search').is(':checked') ? 1 : 0;
                d.status = $('#status_search').val();
                d.status_transaction = $('#status_transaction_search').val();
                d.bank_id = $('#bank_id_search').val();
                d.due_date = $('#due_date_search').length == 0 ? '' : $('#due_date_search').val();
                d.category_id = $('#category_id_search').val();
                d.payment_type = $('#payment_type_search').val();
                d.patient_id = $('#patient_id_search').val();
                d.due_date_from = $('#due_date_from_search').val();
                d.due_date_to = $('#due_date_to_search').val();
            }
        },
        columns: columsDB,
        drawCallback: drawCallback,
        rowCallback: rowCallback,
    });
};

let tableManage = function () {
    "use strict"

    let table;

    return {
        setName: function (name) {
            return table = name;
        },
        setColumns: function (columns) {
            for (let i in columns) {
                arrayColumns.push({
                    data: columns[i].data,
                    orderable: columns[i].orderable,
                    searchable: columns[i].searchable,
                    className: columns[i].className,
                    visible: columns[i].visible,
                })
            }

            return columsDB = arrayColumns;
        },
        setButton: function (orderable = false, searchable = false) {
            return arrayColumns.push({
                data: 'action',
                orderable: orderable,
                searchable: searchable,
                className: 'align-middle'
            });
        },
        setRoute: function (name) {
            return route = name;
        },
        setPerPage: function (value) {
            return pageLength = value;
        },
        setPagingType: function (value) {
            return pagingType = value;
        },
        setLengthMenu: function (listOne, listTwo) {
            arrayLengthMenu.push(listOne);
            arrayLengthMenu.push(listTwo);

            return lengthMenu = arrayLengthMenu;
        },
        setOrder: function (columns) {

            for (let i in columns) {
                arrayOrder.push(columns[i]);
            }

            return order = arrayOrder;
        },
        setColumnDefs: function (columns) {

            for (let i in columns) {
                arrayColumnDefs.push({
                    targets: columns[i].targets,
                    orderable: columns[i].orderable,
                })
            }

            return columsDB = arrayColumnDefs;
        },
        setPluginButtonsDom: function (value) {
            return dom = value;
        },
        setPluginButtons: function (list) {
            return buttons = list;
        },
        setDrawCallback: function (code) {
            return drawCallback = code;
        },
        setRowCallback: function (code) {
            return rowCallback = code;
        },
        render: function () {
            return configDatatable(table);
        },
        refresh: function () {
            return dataTable.ajax.reload(null, false);
        },
        filter: function (show, table, hide) {
            if (show) {
                // $(table).find('thead tr').clone(true).appendTo('thead');
                $(table).find('thead tr:eq(1) th').each(function (i) {
                    var title = $(this).text();

                    for (let j in hide) {
                        if (!hide.includes(title)) {
                            $(this).html('<input style="width: 100%" type="text" placeholder="' +
                                title +
                                '" />');

                            $('input', this).on('keyup change', function () {
                                if (dataTable.column(i).search() !== this.value) {
                                    dataTable
                                        .column(i)
                                        .search(this.value)
                                        .draw();
                                }
                            });
                        } else {
                            $(this).html('');
                        }
                    }
                });
            }

            $.fn.dataTable.ext.errMode = 'none';
        },
    }
}();
