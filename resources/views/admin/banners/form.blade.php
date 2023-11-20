@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="banners">
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
                                <div class="col-lg-7">
                                    <label for="title" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}"/>

                                    <br>
                                    <div class="">
                                        <label for="link" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Link') }}:</label>
                                        <input type="text" name="link" id="link" class="form-control" placeholder="{{ __('Link') }}" value="{{ old('link', $row->link) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="type" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Type') }}:</label>
                                    <select name="type" id="type" class="form-control m_selectpicker">
                                        <option value="">Select Type</option>
                                        {!! selectBox(DB_enumValues('banners', 'type'), old('type', $row->type)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <label for="image" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Image') }}:</label><br>
                                    <input disabled type="hidden" name="image--rm" value="{{ $row->image }}">
                                    @php
                                        $file_input = '<input type="file" name="image" accept="gif,jpg,jpeg,png" name="image" id="image" class="form-control custom-file-input" value="'.old('image', $row->image).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->image);
                                        $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/image', true);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"jpg, png, bmp, gif" file extension's</span>
                                </div>

                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="description" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Description') }}:</label>
                                    <textarea name="description" id="description" placeholder="{{ __('Description') }}" class="editor form-control" cols="30" rows="8">{{ old('description', $row->description) }}</textarea>
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

        $("form#banners").validate({
            // define validation rules
            rules: {
                //'image': {required: true,},
                'title': {
                    required: true,
                },
            },
            /*messages: {
            'image' : {required: 'Image is required',},'title' : {required: 'Title is required',},    },*/
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
