@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="blog_categories">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}"
                   value="{{ old('id', $row->id) }}">
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
                                    <label for="category" class="col-form-label required">{{ __('Category') }}:</label>
                                    <input type="text" name="category" id="category" class="form-control" placeholder="{{ __('Category') }}" value="{{ old('category', $row->category) }}"/>
                                </div>
                                <div class="col-lg-5">
                                    <label for="parent_id" class="col-form-label">{{ __('Parent') }}:</label>
                                    <select name="parent_id" id="parent_id" class="form-control m-select2">
                                        <option value="0" {{ _selected(old('parent_id', $row->parent_id), 0) }}> /
                                        </option>
                                        @php
                                            $_M = new Multilevel();
                                            $_M->type = 'select';
                                            $_M->id_Column = 'id';
                                            $_M->title_Column = 'category';
                                            $_M->link_Column = 'category';
                                            $_M->level_spacing = 6;
                                            $_M->selected =  old('parent_id', $row->parent_id);
                                            $_M->query = "SELECT id,category,parent_id FROM blog_categories WHERE 1 ORDER BY id DESC";
                                            echo $_M->build();
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-7">
                                    <label for="slug" class="col-form-label required">{{ __('Slug') }}:</label>
                                    <div class="input-group">
                                        <div class="input-group-append"><span class="input-group-text">{{ url('blog/category') }}/</span></div>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="{{ __('Slug') }}" value="{{ old('slug', $row->slug) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="text-center">
                                        <input disabled type="hidden" name="image--rm" value="{{ $row->image }}">
                                        @php
                                            $file_input = '<input type="file" accept="gif,jpg,jpeg,png" name="image" id="image" class="form-control custom-file-input" />';
                                            $thumb_url = asset_url("{$_this->module}/" . $row->image);
                                            $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/image', true);
                                            echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                        @endphp

                                        <span class="form-text text-muted">"jpg, png, bmp, gif" file extension's</span>
                                    </div>
                                </div>

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

        $("form#blog_categories").validate({
            // define validation rules
            rules: {
                'category': {required: true},
                'slug': {
                    required: true,
                    remote: '<?php echo admin_url('ajax/validate/' . $row->id, true)?>',
                },
            },
            /*messages: {
            'slug' : {remote: 'This Slug is already exist',},    },*/
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
