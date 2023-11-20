@php
    $status_column_data = DB_enumValues('banners', 'status');
    $bulk_update['status'] = ['title' => 'Status', 'data' => $status_column_data];
    $form_buttons = ['new', 'delete', 'import', 'export'];
    ob_start();
@endphp
<div class="kt-subheader__toolbar form-btns">
    <div class="input-group">
        <input type="number" class="form-control" name="views" id="update-views" placeholder="Views">
        <div class="input-group-append">
            <button data-toggle="kt-tooltip" data-skin="dark" data-original-title="Update" class="btn btn-brand btn-icon update-views" type="button">
                <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</div>
@php
$html = ob_get_clean();
@endphp
@extends('admin.layouts.admin')

@section('content')

    <form action="{{ admin_url('', true) }}" method="get" enctype="multipart/form-data" id="blog_posts-form">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons', 'html'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_blog_posts">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body kt-padding-0">
                            @php
                                $grid = new Grid();
                                $grid->status_column_data = $status_column_data;
                                //$grid->filterable = false;
                                                        $grid->show_paging_bar = false;
                                $grid->grid_buttons = ['edit', 'delete', 'status' => ['status' => 'status'], 'view', 'duplicate'];

                                $grid->init($paginate_OBJ, $query);

                                $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
                                $grid->dt_column(['author' => [
                                    'wrap' => function($value, $field, $_row) use($_this) {
                                        if(user_do_action('edit')){
                                            return "<a href='".admin_url("form/{$_row['id']}", 1)."'>{$value}</a>";
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
                                $grid->dt_column(['views' => ['width' => '90', 'align' => 'center', 'th_align' => 'center',
                                    'wrap' => function($value, $field, $_row, $grid) {
                                        return ordering_input($value, $_row, $field, $grid);
                                    }
                                ]]);

                                $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);
                                $grid->dt_column(['featured_image' => ['align' => 'center',
                                    'wrap' => function($value, $field, $_row) use($_this) {
                                        //return grid_img(asset_url("{$_this->module}/{$value}"), 48, 48);
                                        return grid_img(asset_url($value, 's3'), 48, 48);
                                    }
                                ]]);
                                $grid->dt_column(['grid_actions' => ['width' => '150',
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
    <script>
        $(document).ready(function () {
             $(document).on('click', '.update-views', function (e) {
                 const views = $('#update-views').val();
                 $.ajax({
                     method: "GET",
                     url: "{{ admin_url("ajax/views", true) }}",
                     data: {
                         views: views
                     }
                 }).done(function(json) {
                     $('#update-views').val('')
                     $.notify(json.message, {
                         type: (json.status ? 'success' : 'error'),
                         newest_on_top: true,
                         allow_dismiss: true,
                     })
                     window.location.reload()
                     //swal.fire(json.message);
                 });
             })
        })
    </script>
@endsection
