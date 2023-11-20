@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="static_blocks">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __(ID) }}" value="{{ old('id', $row->id) }}">
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
                                <div class="col-lg-8">
                                    <label for="title" class="required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}"/>
                                </div>
                                <div class="col-lg-4">
                                    <label for="identifier" class="required">{{ __('Identifier') }}:</label>
                                    <input type="text" name="identifier" id="identifier" class="form-control" placeholder="{{ __('Identifier') }}" value="{{ old('identifier', $row->identifier) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="content" class="">{{ __('Content') }}:</label>
                                    <textarea name="content" id="content" placeholder="{{ __('Content') }}" class="editor form-control" cols="50" rows="30">{{ old('content', $row->content) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                        </div>

                        {{--<div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php
                                    $Form_btn = new Form_btn();
                                    echo $Form_btn->buttons($form_buttons);
                                @endphp
                            </div>
                        </div>--}}

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

        $("form#static_blocks").validate({
            // define validation rules
            rules: {
                'title': {
                    required: true,
                },
                'identifier': {
                    required: true,
                },
            },
            /*messages: {
            'title' : {required: 'Title is required',},'identifier' : {required: 'Identifier is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    </script>
@endsection
