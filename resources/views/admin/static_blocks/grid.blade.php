@php
    $status_column_data = DB_enumValues('static_blocks', 'status');

$form_buttons = ['new', 'delete', 'import', 'export'];
@endphp
@extends('admin.layouts.admin')

@section('content')

    <form action="{{ admin_url('', true) }}" method="get" enctype="multipart/form-data" id="static_blocks-form">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_static_blocks">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body kt-padding-0">
                            @php
                                $grid = new Grid();
                                $grid->status_column_data = $status_column_data;
                                $grid->ajax_grid = false;
                                $grid->filterable = $grid->sorting = false;
                                $grid->filterable = false;
                                //$grid->show_paging_bar = false;
                                $grid->grid_buttons = ['edit', 'delete', 'status' => ['status' => 'status'], 'view', 'duplicate'];

                                $grid->init($paginate_OBJ, $query);

                                $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
                                $grid->dt_column(['' => ['align' => 'center',
                                    'wrap' => function($value, $field, $row) use($_this) {
                                        if(user_do_action('edit')){
                                            return "<a href='".admin_url("form/{$row['id']}", 1)."'>{$value}</a>";
                                        }
                                    }
                                ]]);

                                $grid->dt_column(['status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true],
                                    'wrap' => function($value, $field, $row, $grid) {
                                        return status_options($value, $row, $field, $grid);
                                    }
                                ]]);
                                $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center',
                                    'wrap' => function($value, $field, $row, $grid) {
                                        return ordering_input($value, $row, $field, $grid);
                                    }
                                ]]);

                                $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);
                                $grid->dt_column(['grid_actions' => ['width' => '150',
                                    'check_action' => function($row, $html, $button){
                                        //if($button != 'delete')
                                        {
                                            return $html;
                                        }
                                    }
                                ]]);

                                echo $grid->showGrid();
                            @endphp



                            {{--<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                <?php echo $grid->getTHead();;?>
                                </thead>
                            </table>--}}

                        </div>
                        <div class="kt-portlet__foot">
                            <!--begin: Pagination(sm)-->
                            <div class="kt-pagination kt-pagination--sm kt-pagination--danger">
                                @php
                                    //echo $grid->getTFoot();
                                @endphp
                            </div>
                            <!--end: Pagination-->
                            &nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

{{-- Scripts --}}
@section('scripts')
    {{--{!! $grid->grid_script() !!}}--}}

    {{--<script !src="">
        var KTDatatablesSearchOptionsColumnSearch = function () {

            $.fn.dataTable.Api.register('column().title()', function () {
                return $(this.header()).text().trim();
            });

            var initTable1 = function () {
                // begin first table
                var table = $('#kt_table_1').DataTable({
                    responsive: true,
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 10,
                    language: {
                        'lengthMenu': 'Display _MENU_',
                    },

                    searchDelay: 500,
                    //sorting: false,
                    processing: true,
                    ajax: {
                        url: '<?php echo $grid->url;?>',
                        type: 'GET',
                        dataSrc: "response.data"
                    },
                    /*initComplete: function () {
                        var thisTable = this;
                        var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

                        this.api().columns().every(function () {
                            var column = this;
                            var input;
                            console.log(column);
                        });

                        // hide search column for responsive table
                        var hideSearchColumnResponsive = function () {
                            thisTable.api().columns().every(function () {
                                var column = this
                                if (column.responsiveHidden()) {
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

                        //$('#kt_datepicker_1,#kt_datepicker_2').datepicker();
                    },*/
                    columnDefs: [
                        {
                            targets: -1,
                            title: 'Actions',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return '\
                                    <span class="dropdown">\
                                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">\
                                          <i class="la la-ellipsis-h"></i>\
                                        </a>\
                                        <div class="dropdown-menu dropdown-menu-right">\
                                            <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
                                            <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
                                            <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
                                        </div>\
                                    </span>\
                                    <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">\
                                      <i class="la la-edit"></i>\
                                    </a>';
                            },
                        },
                    ],
                });

            };

            return {

                //main function to initiate the module
                init: function () {
                    initTable1();
                }
            };
        }();
        jQuery(document).ready(function () {
            KTDatatablesSearchOptionsColumnSearch.init();
        });

    </script>--}}
@endsection
