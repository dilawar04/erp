@php
    $status_column_data = DB_enumValues('company_profiles', 'status');
    $bulk_update['status'] = ['title' => 'Status', 'data' => $status_column_data];
    $form_buttons = ['new', 'import', 'export', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <style>
        .work_station-ul {
            list-style: none;
            display: contents;
        }

        .work_station-li {
            float: left;
            background: #6969d0;
            padding: 4px;
            margin: 3px;
            color: white;
            border-radius: 5px;
        }
        .work_station-li a{
            color: white;
        }

        th.work_station-seprator {
            background: unset !important;
            padding: 20px;
        }

        .work_station-margin {
            margin: 9px !important;
        }

    </style>
    <form action="{{ admin_url('', true) }}" method="get" enctype="multipart/form-data" id="work_stations-form">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_work_stations">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body kt-padding-0">
                            <table class="table m-table table-view grid-table kt-margin-0 ">
                                <tbody>
                                <tr id="id">
                                    <th width="25%" class="bg-light">ID</th>
                                    <td><input style="display:none;" type="checkbox" name="ids[]" value="37" class="chk-id" checked>{{ $row->id }}
                                    </td>
                                </tr>
                               
                               
                                
                                <tr id="code">
                                    <th width="" class="bg-light">Code</th>
                                    <td>
                                        <ul class="work_station-ul">
                                            @foreach(json_decode($row->code) as $item)
                                                <li class="work_station-li">{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr id="name">
                                    <th width="" class="bg-light">Name</th>
                                    <td>
                                        <ul class="work_station-ul">
                                            @foreach(json_decode($row->name) as $item)
                                                <li class="work_station-li">{{ $item }}</li>
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
                        @if($row->type == 'work_station')
                        <h1 style="text-align:center;">work_station details</h1>
                        <div class="kt-portlet__body kt-padding-0">
                            @php
                                $work_stations = \App\WorkStation::where('id', $row->id)->get();
                                foreach ($work_stations as $item) {

                                    /*------------------ Show Record Like View Table ------------------*/
                                    $view = new Record_view();
                                    $view->row = $item;

                                    $config['hidden_fields'] = ['created_at', 'updated_at', 'deleted_at'];
                                    $config['image_fields'] = [];
                                    $config['attributes'] = [
                                        'id' => ['title' => 'ID'],
                                        'code' => ['title' => 'Code'],
                                        'name' => ['title' => 'Name'],
                                        'id' => ['title' => 'WorkStation', 'wrap' => function ($value, $_row) use($row){
                                            return "<a target='_blank' href='" . admin_url("view/{$value}", 1) . "'>{$row->name}</a>";
                                        }],
                                        'code' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="work_station-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="work_station-li"><a href="mailto:'.$item.'">'.$item.'</a></li>';
                                            }
                                            $HTML .= '</ul>';
                                            return $HTML;
                                        }],
                                        'name' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="work_station-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="work_station-li"><a href="tel:'.$item.'">'.$item.'</a></li>';
                                            }
                                            $HTML .= '</ul>';
                                            return $HTML;
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