@php
    $form_buttons = ['save', 'view', 'delete', 'back'];

@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="blog_posts">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-9">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head') @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}" />
                                </div>
                                <div class="col-lg-4">
                                    <label for="author" class="col-form-label">{{ __('Author') }}:</label>
                                    <input type="text" name="author" id="author" class="form-control" placeholder="{{ __('Author') }}" value="{{ old('author', $row->author) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="slug" class="col-form-label">{{ __('Slug') }}:</label>
                                    <div class="input-group">
                                        <div class="input-group-append"><span class="input-group-text">{{ url('post') }}/</span></div>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="{{ __('Slug') }}" value="{{ old('slug', $row->slug) }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="content" class="col-form-label">{{ __('Content') }}:</label>
                                    <textarea name="content" id="content" placeholder="{{ __('Content') }}" class="editor form-control" cols="30" rows="5">{{ old('content', $row->content) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            {{--<div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="post_name" class="col-form-label">{{ __('Post Name') }}:</label>
                                    <input type="text" name="post_name" id="post_name" class="form-control" placeholder="{{ __('Post Name') }}" value="{{ old('post_name', $row->post_name) }}" />
                                </div>
                            </div>--}}

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
                                    <h3 class="kt-portlet__head-title"> {{ __('Post') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <label for="status" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Content Type') }}:</label>
                            <select name="content_type_id" id="content_type_id" class="form-control m-select2">
                                {!! selectBox("SELECT id, title FROM content_types", old('content_type_id', $row->content_type_id)) !!}
                            </select>
                            <br>

                            <label for="status" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Status') }}:</label>
                            <select name="status" id="status" class="form-control m-select2">
                                {!! selectBox(DB_enumValues($_this->table, 'status'), old('status', $row->status)) !!}
                            </select>
                            <br>

                            <label for="datetime" class="">{{ __('Datetime') }}:</label>
                            <input type="text" name="datetime" id="datetime" class="form-control datetimepicker" style="width: 100%;" placeholder="{{ __('Datetime') }}" value="{{ old('datetime', $row->datetime) }}" />
                            <br>

                            <label for="datetime" class="">{{ __('Views') }}:</label>
                            <input type="number" min="0" name="views" id="views" class="form-control" placeholder="{{ __('views') }}" value="{{ old('views', $row->views) }}" />
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
                                    $_M->query = "SELECT id,title,parent_id FROM blog_posts WHERE 1 ORDER BY id DESC";
                                    echo $_M->build();
                                @endphp
                            </select>

                        </div>
                    </div>

                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"><i class="flaticon-list"></i></span>
                                    <h3 class="kt-portlet__head-title"> {{ __('Featured Image') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="text-center">
                                <input disabled type="hidden" name="featured_image--rm" value="{{ $row->featured_image }}" />
                                @php
                                    $file_input = '<input type="file" accept="gif,jpg,jpeg,png" name="featured_image" id="featured_image" class="form-control custom-file-input" />';
                                    //$thumb_url = asset_url("{$_this->module}/{$row->featured_image}");
                                    $thumb_url = asset_url("{$row->featured_image}", 's3');
                                    $delete_img_url = admin_url("ajax/delete_img/{$row->id}/featured_image", true);
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


                        </div>
                    </div>

                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_menus-cats">
                        <div class="kt-portlet__head kt-padding-l-15">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"><i class="la la-calendar-times-o"></i></span>
                                    <h3 class="kt-portlet__head-title menu-label">Categories</h3>
                                </div>
                            </div>
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body bg-light kt-padding-10">
                            <div class="kt-input-icon  kt-input-icon--right">
                                <input id="search" class="form-control kt-input kt-input--air search-input" type="text" placeholder="Search Categories..." find-block=".s-m-block-cats" find-in="[class*=f-item-cats]" autocomplete="off">
                                <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                            <div class="kt-accordion__item-content s-m-block-cats">
                                @if ($categories['tree'])
                                    <ul class="tree-menu-level-1">
                                        @php
                                            if($row->id == 0)
{
    $selected_cats = ['8'];
}
                                            echo _tree_menu_list($categories['rows'], 1, 'cats', ['type' => 'checkbox', 'name' => 'category_ids[]'], $selected_cats);
                                        @endphp
                                    </ul>
                                @else
                                    @foreach($categories['rows'] as $category)
                                        <div class="-form-group kt-form__group menu-group-link f-item-{{ $category->id }}">
                                            <label class="kt-checkbox kt-checkbox--square fields-data">
                                                <input type="checkbox" name="category_ids[]" class="id-field range-checkboxes" {{ _checked($category->id, $selected_cats) }} value="{{ $category->id }}"> {{ $category->category }}
                                                <span></span>
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection {{-- Scripts --}} @section('scripts')
    <script>
         $(document).on('change', '.video_s3', function (e) {
             const _parent = $(this).closest('.form-group');
             $('.s3-link', _parent).attr('href', '{{ getStorageUrl() }}' + $(this).val());
         })

         $(document).on('change', '#video_s3_360', function (e) {
             const _val = $(this).val();

             $('#datetime').val(_val.split('/')[2]?.split(' ')[0] + ' 00:00');

             $('#video_s3_480').val(_val.replaceAll('360p', '480p')).trigger('change');
             $('#video_s3_720').val(_val.replaceAll('360p', '720p')).trigger('change');
             $('#video_s3_1080').val(_val.replaceAll('360p', '1080p')).trigger('change');

             $('#thumb_s3').val(_val.replaceAll('360p', 'thumb').replace('.mp4', '.jpg')).trigger('change');

             $('#video_s3_MP3').val(_val.replace('360p', 'mp3').replace('360p', 'MP3').replace('.mp4', '.mp3')).trigger('change');
             $('#art_thumbnails').val(_val.replace('360p', 'preview').replace('360p', '60-10').replace('.mp4', '.jpg')).trigger('change');
         })

        $( "form#blog_posts" ).validate({
            // define validation rules
            rules: {
                'title': {
                    required: true,
                },
                'slug': {
                    remote: '<?php echo admin_url('ajax/validate/' . $row->id, true)?>',
                },
            },
            /*messages: {
            'title' : {required: 'Title is required',},'slug' : {remote: 'This Slug is already exist',},    },*/
            //display error alert on form submit
            invalidHandler: function(event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function(form) {
                form.submit();
            }

        });
    </script>
@endsection
