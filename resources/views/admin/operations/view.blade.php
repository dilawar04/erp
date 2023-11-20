@php
    $status_column_data = DB_enumValues('operations', 'status');
    $bulk_update['status'] = ['title' => 'Status', 'data' => $status_column_data];
    $form_buttons = ['new', 'import', 'export', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <style>
        .operation-ul {
            list-style: none;
            display: contents;
        }

        .operation-li {
            float: left;
            background: #6969d0;
            padding: 4px;
            margin: 3px;
            color: white;
            border-radius: 5px;
        }
        .operation-li a{
            color: white;
        }

        th.operation-seprator {
            background: unset !important;
            padding: 20px;
        }

        .operation-margin {
            margin: 9px !important;
        }

    </style>
    <form action="{{ admin_url('', true) }}" method="get" enctype="multipart/form-data" id="operations-form">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_operations">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body kt-padding-0">
                            <table class="table m-table table-view grid-table kt-margin-0 ">
                                <tbody>
                                <tr id="id">
                                    <th width="" class="bg-light">ID</th>
                                    <td><input style="display:none;" type="checkbox" name="ids[]" value="ids" class="chk-operation" checked>{{ $row->id }}
                                    </td>
                                </tr>
                              
                                <tr id="operation_code">
                                    <th width="" class="bg-light">Operation Code</th>
                                    <td>
                                        <ul class="operation-ul">
                                            @foreach(json_decode($row->operation_code) as $item)
                                                <li class="operation-li">{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr id="operation_name">
                                    <th width="" class="bg-light">Operation Name</th>
                                    <td>
                                        <ul class="operation-ul">
                                            @foreach(json_decode($row->operation_name) as $item)
                                                <li class="operation-li">{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="">
                                    <th width="" class="company-profile-seprator">&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if($row->type == 'Operation')
                        <h1 style="text-align:center;">Operation</h1>
                        <div class="kt-portlet__body kt-padding-0">
                            @php
                                $operation = \App\Operation::where('id', $row->id)->get();
                                foreach ($operation as $item) {

                                    /*------------------ Show Record Like View Table ------------------*/
                                    $view = new Record_view();
                                    $view->row = $item;

                                    $config['hidden_fields'] = ['created_at', 'updated_at', 'deleted_at'];
                                    $config['image_fields'] = [];
                                    $config['attributes'] = [
                                        'id' => ['title' => 'ID'],
                                        'operation_code' => ['title' => 'Operation Code'],
                                        'operation_name' => ['title' => 'Operation Name'],
                                        'id' => ['title' => 'id', 'wrap' => function ($value, $_row) use($row){
                                            return "<a target='_blank' href='" . admin_url("view/{$value}", 1) . "'>{$row->name}</a>";
                                        }],
                                        'id' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="operation-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="operation-li"><a href="mailto:'.$item.'">'.$item.'</a></li>';
                                            }
                                            $HTML .= '</ul>';
                                            return $HTML;
                                        }],
                                        'operation_code' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="operation-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="operation-li"><a href="mailto:'.$item.'">'.$item.'</a></li>';
                                            }
                                            $HTML .= '</ul>';
                                            return $HTML;
                                        }],
                                        'operation_name' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="operation-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="operation-li"><a href="tel:'.$item.'">'.$item.'</a></li>';
                                            }
                                            $HTML .= '</ul>';
                                            return $HTML;
                                        }],
                                        'website' => ['wrap' => function ($value, $_row) {
                                            return "<a href='{$value}' target='_blank'>{$value}</a>";
                                        }],
                                        'status' => ['wrap' => function ($value, $_row) {
                                            return status_field($value, $row, null, null);
                                        }],
                                    ];
                                    if (count($config)) {
                                        foreach ($config as $conf_key => $conf) {
                                            $view->{$conf_key} = $conf;
                                        }
                                    }
                                    echo $view->showView();
                                    echo '<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>';
                                }
                            @endphp
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

{{-- Scripts --}}
@section('scripts')

@endsection