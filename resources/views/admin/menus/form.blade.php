@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="menus">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">


                            <div class="form-group row">
                                <label for="parent_id" class="col-lg-2 col-sm-12 col-form-label">{{ __('Parent') }}:</label>
                                <div class="col-lg-6">
                                    <select name="parent_id" id="parent_id" class="form-control m-select2">
                                        <option value="">Select Parent</option>
                                        {!! selectBox("SELECT id, menu_title FROM menus", old('parent_id', $row->parent_id)) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="menu_title" class="col-lg-2 col-sm-12 col-form-label required">{{ __('Menu Title') }}:</label>
                                <div class="col-lg-6">
                                    <input type="text" name="menu_title" id="menu_title" class="form-control" placeholder="{{ __('Menu Title') }}" value="{{ old('menu_title', $row->menu_title) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="menu_link" class="col-lg-2 col-sm-12 col-form-label">{{ __('Menu Link') }}:</label>
                                <div class="col-lg-6">
                                    <input type="text" name="menu_link" id="menu_link" class="form-control" placeholder="{{ __('Menu Link') }}" value="{{ old('menu_link', $row->menu_link) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="menu_type" class="col-lg-2 col-sm-12 col-form-label">{{ __('Menu Type') }}:</label>
                                <div class="col-lg-6">
                                    <input type="text" name="menu_type" id="menu_type" class="form-control" placeholder="{{ __('Menu Type') }}" value="{{ old('menu_type', $row->menu_type) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="menu_type_id" class="col-lg-2 col-sm-12 col-form-label">{{ __('Menu Type ID') }}:</label>
                                <div class="col-lg-6">
                                    <select name="menu_type_id" id="menu_type_id" class="form-control m-select2">
                                        <option value="">Select Menu Type ID</option>
                                        {!! selectBox("SELECT * FROM menu_types", old('menu_type_id', $row->menu_type_id)) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="status" class="col-lg-2 col-sm-12 col-form-label">{{ __('Status') }}:</label>
                                <div class="col-lg-6">
                                    <select name="status" id="status" class="form-control m_selectpicker">
                                        <option value="">Select Status</option>
                                        {!! selectBox(DB_enumValues('menus', 'status'), old('status', $row->status)) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php
                                    $Form_btn = new Form_btn();
                                    echo $Form_btn->buttons($form_buttons);
                                @endphp
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection

{{-- Scripts --}}
@section('scripts')
    <script>

        $("form#menus").validate({
            // define validation rules
            rules: {
                'menu_title': {
                    required: true,
                },
            },
            /*messages: {
            'menu_title' : {required: 'Menu Title is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    </script>@endsection
