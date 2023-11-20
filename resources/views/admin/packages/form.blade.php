@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="packages">
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
                                <div class="col-lg-6">
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}"/>
                                </div>
                                <div class="col-lg-2">
                                    <label for="user_type_id" class="col-form-label">{{ __('User type') }}:</label>
                                    <select name="user_type_id" id="user_type_id" class="form-control m-select2">
                                        <option value="">- Select -</option>
                                        {!! selectBox("SELECT id, user_type FROM user_types", old('user_type_id', $row->user_type_id)) !!}
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <label for="price" class="col-form-label required">{{ __('Price') }}:</label>
                                    <div class="input-group m-input-group">
                                        <input type="text" name="price" id="price" class="form-control" placeholder="{{ __('Price') }}" value="{{ old('price', $row->price) }}"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text p-0" style="border: none;">
                                                <select name="currency" id="currency" class="form-control">
                                                    <option value="">Select Currency</option>
                                                    {!! selectBox("SELECT code, code AS _code FROM currencies", old('currency', $row->currency)) !!}
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">
                                    <label for="ordering" class="col-form-label">{{ __('Ordering') }}:</label>
                                    <input type="text" name="ordering" id="ordering" class="form-control" placeholder="{{ __('Ordering') }}" value="{{ old('ordering', $row->ordering) }}"/>
                                </div>

                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="description" class="col-form-label">{{ __('Description') }}:</label>
                                    <textarea name="description" id="description" placeholder="{{ __('Description') }}" class="simple_editor form-control" cols="30" rows="5">{{ old('description', $row->description) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                            @php
                                $benefits = old('benefits', json_decode($row->benefits, true));
                                $benefits = $benefits ?? [null];
                            @endphp
                            <div class="clone-container">
                                <a href="#" class="btn btn-info pull-right -btn-icon add_more" clone-container=".clone-container"><i class="icon-plus-circle"></i>Add Benefit</a>
                                <div class="clearfix"></div>
                                @foreach($benefits as $key => $benefit)
                                <div class="clone">
                                    <div class="form-group row">
                                        <div class="col-lg-11">
                                            <label class="col-form-label">{{ __('Benefit') }}:</label>
                                            <input type="text" name="benefits[]" id="info_{{$key}}" class="form-control" placeholder="{{ __('Benefit') }}" value="{{ old("benefits.{$key}", $benefit) }}"/>
                                        </div>
                                        <div class="col-lg-1 text-center">
                                            <p style="margin-top: 2px;">&nbsp;</p>
                                            <a href="#" class="btn btn-danger btn-icon" remove-limit="1" remove-el="parent-.clone"><i class="la la-trash"></i></a>
                                        </div>
                                    </div>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                </div>
                                @endforeach
                            </div>

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

        $("form#packages").validate({
            // define validation rules
            rules: {
                'title': {
                    required: true,
                },
                'price': {
                    required: true,
                },
            },
            /*messages: {
            'title' : {required: 'Title is required',},'price' : {required: 'Price is required',},    },*/
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
