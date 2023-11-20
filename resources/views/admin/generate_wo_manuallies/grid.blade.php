@php
    $status_column_data = DB_enumValues('generate_wo_manuallies', 'status');
    $bulk_update['status'] = ['title' => 'Status', 'data' => $status_column_data];

    $params = [
        'title' => 'Refresh',
        'class' => 'btn btn-label-danger btn-md btn-sm',
        'href' => admin_url('{_module}'),
        'icon_cls' => 'la la-refresh',
    ];
    //Form_btn::add_button('refresh', $params, true);
    $form_buttons = ['new', 'delete', 'import', 'export', 'refresh'];
@endphp
@extends('admin.layouts.admin')

@section('content')

    <form action="{{ admin_url('', true) }}" method="get" enctype="multipart/form-data" id="generate_wo_manuallies-form">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_generate_wo_manuallys">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body kt-padding-0">
                            @php
                                $params = [
                                    'title' => 'Add Operations',
                                    'href' => admin_url('generate_wo_manuallies_operations/form/?generate_wo_manuallies_id={_id}'),
                                    //'href' => admin_url('generate_wo_manuallies_operations?gid={_id}'),
                                    //'href' => '#modal',
                                    'attr' => 'target="_blank"',
                                    'icon_cls' => 'la la-plus',
                                ];
                                Grid_btn::add_button('add_work_operation', $params, true);

                                $params = [
                                    'title' => 'Logs',
                                    'href' => admin_url('generate_wo_manually_logs/{_id}', 1),
                                    'icon_cls' => 'la la-crosshairs',
                                ];
                                Grid_btn::add_button('generate_wo_manually_log', $params, true);

                                $grid = new Grid();
                                $grid->status_column_data = $status_column_data;
                                //$grid->filterable = false;
                                $grid->show_paging_bar = false;
                                $grid->grid_buttons = ['edit', 'delete', 'status' => ['status' => 'status'], 'view', 'duplicate', 'add_work_operation', 'generate_wo_manually_log'];

                                $grid->init($paginate_OBJ, $query);

                                $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
                                $grid->dt_column(['product_id' => ['hide' => true]]);
                                $grid->dt_column(['product' => [
                                    'wrap' => function($value, $field, $_row) use($_this) {
                                        if(user_do_action('view', 'generate_wo_manually_products')){
                                            return "<a target='_blank' href='".admin_url("finished_product_profiles/view/{$_row['product_id']}")."'>{$value}</a>";
                                        }
                                        return $value;
                                    }
                                ]]);

                                $grid->dt_column(['status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true],
                                    'wrap' => function($value, $field, $_row, $grid) {
                                        if(user_do_action('status')){
                                            return status_options($value, $_row, $field, $grid);
                                        }
                                        return status_field($value, $_row, $field, $grid);
                                    }
                                ]]);
                                $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center',
                                    'wrap' => function($value, $field, $_row, $grid) {
                                        return ordering_input($value, $_row, $field, $grid);
                                    }
                                ]]);

                                $grid->dt_column(['created_at' => ['width' => '150', 'align' => 'center', 'input_options' => ['class' => 'm_datepicker'],
                                    'wrap' => function($value, $field, $_row, $grid) {
                                        return _date_format($value, $_row, $field, $grid);
                                    }
                                ]]);
                                $grid->dt_column(['grid_actions' => ['width' => '180',
                                    'check_action' => function($_row, $html, $button){
                                        //if($button != 'delete')
                                        {
                                            return $html;
                                        }
                                    }
                                ]]);

                                echo $grid->showGrid();
                            @endphp
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-pagination kt-pagination--sm kt-pagination--danger">
                                @php
                                    echo $grid->getTFoot();
                                @endphp
                            </div>&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

{{-- Scripts --}}
@section('scripts')

@endsection
