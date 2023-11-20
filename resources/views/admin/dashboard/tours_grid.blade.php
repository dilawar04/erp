
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon2-line-chart"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                Individual Column Search
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <div class="dropdown dropdown-inline">
                        <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-download"></i> Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="kt-nav">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <span class="kt-nav__section-text">Choose an option</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-print"></i>
                                        <span class="kt-nav__link-text">Print</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-copy"></i>
                                        <span class="kt-nav__link-text">Copy</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                        <span class="kt-nav__link-text">Excel</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-file-text-o"></i>
                                        <span class="kt-nav__link-text">CSV</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                        <span class="kt-nav__link-text">PDF</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    &nbsp;
                    <a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                        New Record
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">

        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
            <thead>
            <tr>
                <th>Record ID</th>
                <th>Order ID</th>
                <th>Country</th>
                <th>Ship City</th>
                <th>Company Agent</th>
                <th>Ship Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Record ID</th>
                <th>Order ID</th>
                <th>Country</th>
                <th>Ship City</th>
                <th>Company Agent</th>
                <th>Ship Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </tfoot>
        </table>

        <!--end: Datatable -->
    </div>
</div>


@section('scripts')
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset_url("vendors/custom/datatables/datatables.bundle.js", 1) }}" type="text/javascript"></script>
    <!--end::Page Vendors -->
    <script !src="">
    var table = $('.data_table').DataTable({
        responsive: true,

        // Pagination settings
        dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        // read more: https://datatables.net/examples/basic_init/dom.html

        lengthMenu: [5, 10, 25, 50],

        pageLength: 10,

        language: {
            'lengthMenu': 'Display _MENU_',
        },

        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
            url: 'https://keenthemes.com/metronic/tools/preview/api/datatables/demos/server.php',
            type: 'POST',
            data: {
                // parameters for custom backend script demo
                columnsDef: [
                    'RecordID', 'OrderID', 'Country', 'ShipCity', 'CompanyAgent', 'ShipDate', 'Status', 'Type', 'Actions',],
            },
        },
        columns: [
            {data: 'RecordID'},
            {data: 'OrderID'},
            {data: 'Country'},
            {data: 'ShipCity'},
            {data: 'CompanyAgent'},
            {data: 'ShipDate'},
            {data: 'Status'},
            {data: 'Type'},
            {data: 'Actions', responsivePriority: -1},
        ],
        initComplete: function() {
            var thisTable = this;
            var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

            this.api().columns().every(function() {
                var column = this;
                var input;

                switch (column.title) {
                    case 'Record ID':
                    case 'Order ID':
                    case 'Ship City':
                    case 'Company Agent':
                        input = $(`<input type="text" class="form-control form-control-sm form-filter kt-input" data-col-index="` + column.index() + `"/>`);
                        break;

                    case 'Country':
                        input = $(`<select class="form-control form-control-sm form-filter kt-input" title="Select" data-col-index="` + column.index() + `">
										<option value="">Select</option></select>`);
                        column.data().unique().sort().each(function(d, j) {
                            $(input).append('<option value="' + d + '">' + d + '</option>');
                        });
                        break;

                    case 'Status':
                        var status = {
                            1: {'title': 'Pending', 'class': 'kt-badge--brand'},
                            2: {'title': 'Delivered', 'class': ' kt-badge--danger'},
                            3: {'title': 'Canceled', 'class': ' kt-badge--primary'},
                            4: {'title': 'Success', 'class': ' kt-badge--success'},
                            5: {'title': 'Info', 'class': ' kt-badge--info'},
                            6: {'title': 'Danger', 'class': ' kt-badge--danger'},
                            7: {'title': 'Warning', 'class': ' kt-badge--warning'},
                        };
                        input = $(`<select class="form-control form-control-sm form-filter kt-input" title="Select" data-col-index="` + column.index() + `">
										<option value="">Select</option></select>`);
                        column.data().unique().sort().each(function(d, j) {
                            $(input).append('<option value="' + d + '">' + status[d].title + '</option>');
                        });
                        break;

                    case 'Type':
                        var status = {
                            1: {'title': 'Online', 'state': 'danger'},
                            2: {'title': 'Retail', 'state': 'primary'},
                            3: {'title': 'Direct', 'state': 'success'},
                        };
                        input = $(`<select class="form-control form-control-sm form-filter kt-input" title="Select" data-col-index="` + column.index() + `">
										<option value="">Select</option></select>`);
                        column.data().unique().sort().each(function(d, j) {
                            $(input).append('<option value="' + d + '">' + status[d].title + '</option>');
                        });
                        break;

                    case 'Ship Date':
                        input = $(`
							<div class="input-group date">
								<input type="text" class="form-control form-control-sm kt-input" readonly placeholder="From" id="kt_datepicker_1"
								 data-col-index="` + column.index() + `"/>
								<div class="input-group-append">
									<span class="input-group-text"><i class="la la-calendar-o glyphicon-th"></i></span>
								</div>
							</div>
							<div class="input-group date">
								<input type="text" class="form-control form-control-sm kt-input" readonly placeholder="To" id="kt_datepicker_2"
								 data-col-index="` + column.index() + `"/>
								<div class="input-group-append">
									<span class="input-group-text"><i class="la la-calendar-o glyphicon-th"></i></span>
								</div>
							</div>`);
                        break;

                    case 'Actions':
                        var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
							  <span>
							    <i class="la la-search"></i>
							    <span>Search</span>
							  </span>
							</button>`);

                        var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
							  <span>
							    <i class="la la-close"></i>
							    <span>Reset</span>
							  </span>
							</button>`);

                        $('<th>').append(search).append(reset).appendTo(rowFilter);

                        $(search).on('click', function(e) {
                            e.preventDefault();
                            var params = {};
                            $(rowFilter).find('.kt-input').each(function() {
                                var i = $(this).data('col-index');
                                if (params[i]) {
                                    params[i] += '|' + $(this).val();
                                }
                                else {
                                    params[i] = $(this).val();
                                }
                            });
                            $.each(params, function(i, val) {
                                // apply search params to datatable
                                table.column(i).search(val ? val : '', false, false);
                            });
                            table.table().draw();
                        });

                        $(reset).on('click', function(e) {
                            e.preventDefault();
                            $(rowFilter).find('.kt-input').each(function(i) {
                                $(this).val('');
                                table.column($(this).data('col-index')).search('', false, false);
                            });
                            table.table().draw();
                        });
                        break;
                }

                if (column.title !== 'Actions') {
                    $(input).appendTo($('<th>').appendTo(rowFilter));
                }
            });

            // hide search column for responsive table
            var hideSearchColumnResponsive = function () {
                thisTable.api().columns().every(function () {
                    var column = this
                    if(column.responsiveHidden()) {
                        $(rowFilter).find('th').eq(column.index()).show();
                    } else {
                        $(rowFilter).find('th').eq(column.index()).hide();
                    }
                })
            };

            // init on datatable load
            hideSearchColumnResponsive();
            // recheck on window resize
            window.onresize = hideSearchColumnResponsive;

            $('#kt_datepicker_1,#kt_datepicker_2').datepicker();
        },
        columnDefs: [
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function(data, type, full, meta) {
                    return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                            </div>
                        </span>
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a>`;
                },
            },
            {
                targets: 5,
                width: '150px',
            },
            {
                targets: 6,
                render: function(data, type, full, meta) {
                    var status = {
                        1: {'title': 'Pending', 'class': 'kt-badge--brand'},
                        2: {'title': 'Delivered', 'class': ' kt-badge--danger'},
                        3: {'title': 'Canceled', 'class': ' kt-badge--primary'},
                        4: {'title': 'Success', 'class': ' kt-badge--success'},
                        5: {'title': 'Info', 'class': ' kt-badge--info'},
                        6: {'title': 'Danger', 'class': ' kt-badge--danger'},
                        7: {'title': 'Warning', 'class': ' kt-badge--warning'},
                    };
                    if (typeof status[data] === 'undefined') {
                        return data;
                    }
                    return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                },
            },
            {
                targets: 7,
                render: function(data, type, full, meta) {
                    var status = {
                        1: {'title': 'Online', 'state': 'danger'},
                        2: {'title': 'Retail', 'state': 'primary'},
                        3: {'title': 'Direct', 'state': 'success'},
                    };
                    if (typeof status[data] === 'undefined') {
                        return data;
                    }
                    return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                        '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                },
            },
        ],
    });
</script>
@endsection
