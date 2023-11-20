@php
    $status_column_data = DB_enumValues('company_profiles', 'status');
    $bulk_update['status'] = ['title' => 'Status', 'data' => $status_column_data];
    $form_buttons = ['new', 'import', 'export', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <style>
        .company-profile-ul {
            list-style: none;
            display: contents;
        }

        .company-profile-li {
            float: left;
            background: #6969d0;
            padding: 4px;
            margin: 3px;
            color: white;
            border-radius: 5px;
        }
        .company-profile-li a{
            color: white;
        }

        th.company-profile-seprator {
            background: unset !important;
            padding: 20px;
        }

        .company-profile-margin {
            margin: 9px !important;
        }

    </style>
    <form action="{{ admin_url('', true) }}" method="get" enctype="multipart/form-data" id="company_profiles-form">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_company_profiles">
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
                                <tr id="name">
                                    <th width="" class="bg-light">Name</th>
                                    <td>{{ $row->name }}</td>
                                </tr>
                                <tr id="type">
                                    <th width="" class="bg-light">Type</th>
                                    <td>{{ $row->type }}</td>
                                </tr>
                                @if($row->company_id > 0)
                                    <tr id="company_id">
                                        <th width="" class="bg-light">Company</th>
                                        <td>
                                            <a href='{{ admin_url("view/{$row->company_id}", 1) }}'>
                                            @php
                                                $company = \App\CompanyProfile::find($row->company_id);
                                                echo $company->name;
                                            @endphp
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                <tr id="address">
                                    <th width="" class="bg-light">Address</th>
                                    <td>{{ $row->address }}</td>
                                </tr>
                                <tr id="country">
                                    <th width="" class="bg-light">Country</th>
                                    <td>{{ $row->country }}</td>
                                </tr>
                                <tr id="city">
                                    <th width="" class="bg-light">City</th>
                                    <td>{{ $row->city }}</td>
                                </tr>
                                <tr id="state">
                                    <th width="" class="bg-light">State</th>
                                    <td>{{ $row->state }}</td>
                                </tr>
                                <tr id="postal_code">
                                    <th width="" class="bg-light">Postal Code</th>
                                    <td>{{ $row->postal_code }}</td>
                                </tr>
                                <tr id="email">
                                    <th width="" class="bg-light">Email</th>
                                    <td>
                                        <ul class="company-profile-ul">
                                            @foreach(json_decode($row->email) as $item)
                                                <li class="company-profile-li">{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr id="contact_number">
                                    <th width="" class="bg-light">Contact Number</th>
                                    <td>
                                        <ul class="company-profile-ul">
                                            @foreach(json_decode($row->contact_number) as $item)
                                                <li class="company-profile-li">{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr id="website">
                                    <th width="" class="bg-light">Website</th>
                                    <td><a href="{{ $row->website }}" target="_blank">{{ $row->website }}</a></td>
                                </tr>
                                <tr id="map_location">
                                    <th width="" class="bg-light">Map Location</th>
                                    <td>{{ $row->map_location }}</td>
                                </tr>
                                <tr id="ntn">
                                    <th width="" class="bg-light">NTN</th>
                                    <td>{{ $row->NTN }}</td>
                                </tr>
                                <tr id="sales_tax_number">
                                    <th width="" class="bg-light">Sales Tax Number</th>
                                    <td>{{ $row->sales_tax_number }}</td>
                                </tr>
                                <tr class="">
                                    <th width="" class="company-profile-seprator">&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if($row->type == 'Company')
                        <h1 style="text-align:center;">Office details</h1>
                        <div class="kt-portlet__body kt-padding-0">
                            @php
                                $offices = \App\CompanyProfile::where('company_id', $row->id)->get();
                                foreach ($offices as $item) {

                                    /*------------------ Show Record Like View Table ------------------*/
                                    $view = new Record_view();
                                    $view->row = $item;

                                    $config['hidden_fields'] = ['created_at', 'updated_at', 'deleted_at'];
                                    $config['image_fields'] = [];
                                    $config['attributes'] = [
                                        'id' => ['title' => 'ID'],
                                        'ntn' => ['title' => 'NTN'],
                                        'company_id' => ['title' => 'Company', 'wrap' => function ($value, $_row) use($row){
                                            return "<a target='_blank' href='" . admin_url("view/{$value}", 1) . "'>{$row->name}</a>";
                                        }],
                                        'email' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="company-profile-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="company-profile-li"><a href="mailto:'.$item.'">'.$item.'</a></li>';
                                            }
                                            $HTML .= '</ul>';
                                            return $HTML;
                                        }],
                                        'contact_number' => ['wrap' => function ($value, $_row) {
                                            $HTML = '<ul class="company-profile-ul">';
                                            foreach(json_decode($value) as $item){
                                                $HTML .= '<li class="company-profile-li"><a href="tel:'.$item.'">'.$item.'</a></li>';
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
