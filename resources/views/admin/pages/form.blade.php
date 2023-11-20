@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
    if($row->id > 0){
        $row->params = json_decode($row->params);
    }
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="pages">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-9">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">


                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="title" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Title') }}:</label>
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="padding: 0px 28px 15px 10px;">
                                                <label class="kt-checkbox ">
                                                    <input type="checkbox" value="1" name="show_title" id="show_title" {{ _checked(old('show_title', $row->show_title), 1) }}">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-reorder"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="slug" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('URL slug') }}:</label>
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ url('') }}/</span>
                                        </div>
                                        <input type="text" name="slug" id="slug" class="form-control input-lg" placeholder="{{ __('Slug...') }}" value="{{ old('slug', $row->slug) }}"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-laptop"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="tagline" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Tagline') }}:</label>
                                    <input type="text" name="tagline" id="tagline" class="form-control" placeholder="{{ __('Tagline') }}" value="{{ old('tagline', $row->tagline) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    {{--{{ $_COOKIE['fm_access_key'] }}--}}
                                    <label for="content" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Content') }}:</label>
                                    <textarea name="content" id="content" placeholder="{{ __('Content') }}" class="editor form-control" cols="30" rows="30">{{ old('content', $row->content) }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"><i class="flaticon-list"></i></span>
                                    <h3 class="kt-portlet__head-title"> SEO </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="meta_title" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Meta Title') }}:</label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="{{ __('Meta Title') }}" value="{{ old('meta_title', $row->meta_title) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="meta_keywords" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Meta Keywords') }}:</label>
                                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" placeholder="{{ __('Meta Keywords') }}" cols="30" rows="4">{{ old('meta_keywords', $row->meta_keywords) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="meta_description" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Meta Description') }}:</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" placeholder="{{ __('Meta Description') }}" cols="30" rows="4">{{ old('meta_description', $row->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"><i class="flaticon-list"></i></span>
                                    <h3 class="kt-portlet__head-title"> {{ __('Page status') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <label for="status" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Status') }}:</label>
                            <select name="status" id="status" class="form-control m-select2">
                                {!! selectBox(DB_enumValues($_this->table, 'status'), old('status', $row->status)) !!}
                            </select>
                            <br>

                            <label for="parent_id" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Parent') }}:</label>
                            <select name="parent_id" id="parent_id" class="form-control m-select2" style="width: 100%;">
                                <option value="0" {{ _selected(old('parent_id', $row->parent_id), 0) }}> /</option>
                                @php
                                    $_M = new Multilevel();
                                    $_M->type = 'select';
                                    $_M->id_Column = 'id';
                                    $_M->title_Column = 'title';
                                    $_M->link_Column = 'title';
                                    $_M->level_spacing = 6;
                                    $_M->selected =  old('parent_id', $row->parent_id);
                                    $_M->query = "SELECT id,title,parent_id FROM pages WHERE 1 ORDER BY id DESC";
                                    echo $_M->build();
                                @endphp
                            </select>

                            <br>
                            <label for="user_only" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('User Only') }}:</label>
                            <div>
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <input type="checkbox" value="1" name="user_only" id="user_only" {{ _checked(old('user_only', $row->user_only), 1) }}/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"><i class="flaticon-list"></i></span>
                                    <h3 class="kt-portlet__head-title"> {{ __('Thumbnail') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="text-center">
                                <input disabled type="hidden" name="thumbnail--rm" value="{{ $row->thumbnail }}">
                                @php
                                    $file_input = '<input type="file" accept="gif,jpg,jpeg,png" name="thumbnail" id="thumbnail" class="form-control custom-file-input" />';
                                    $thumb_url = asset_url("{$_this->module}/" . $row->thumbnail);
                                    $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/thumbnail', true);
                                    echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                @endphp

                                <span class="form-text text-muted">"jpg, png, bmp, gif" file extension's</span>
                            </div>
                        </div>
                    </div>


                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"><i class="flaticon-list"></i></span>
                                    <h3 class="kt-portlet__head-title"> Extra </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <label for="template" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Template') }}:</label>
                            <select name="template" id="template" class="form-control m-select2">
                                @php
                                    $template['default'] = 'Default';
                                    if(function_exists('get_theme_templates')){
                                        $template += get_theme_templates();
                                    }
                                    echo selectBox($template, old('template', $row->template));
                                @endphp
                            </select>
                            <br>
                            <label for="template" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('More Links') }}:</label>
                            <textarea name="params[more_links]" id="more_links" class="form-control" placeholder="{{ __('More links') }}" cols="30" rows="4">{{ old('params.more_links', $row->params->more_links) }}</textarea>

                            <br>
                            <label for="template" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Sorting Links') }}:</label>
                            <textarea name="params[sorting_links]" id="sorting_links" class="form-control" placeholder="{{ __('Sorting links') }}" cols="30" rows="4">{{ old('params.sorting_links', $row->params->sorting_links) }}</textarea>

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

        $("form#pages").validate({
            // define validation rules
            rules: {
                //'slug': {},
                'title': {
                    required: true,
                },
            },
            /*messages: {
            'url' : {},'title' : {required: 'Title is required',},    },*/
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
