@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="content_types">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
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
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}" />
                                </div>

                                {{--<div class="col-lg-6">
                                    <label for="identifier" class="col-form-label required">{{ __('Identifier') }} :</label>
                                    <input type="text" name="identifier" id="identifier" class="form-control" placeholder="{{ __('Identifier') }}" value="{{ old('identifier', $row->identifier) }}" />
                                </div>--}}
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="meta_title" class="col-form-label">{{ __('Meta Title') }}:</label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="{{ __('Meta Title') }}" value="{{ old('meta_title', $row->meta_title) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="meta_description" class="col-form-label">{{ __('Meta Description') }} :</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" placeholder="{{ __('Meta Description') }}" cols="30" rows="5">{{ old('meta_description', $row->meta_description) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="meta_keywords" class="col-form-label">{{ __('Meta Keywords') }}:</label>
                                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" placeholder="{{ __('Meta Keywords') }}" cols="30" rows="5">{{ old('meta_keywords', $row->meta_keywords) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="fileds" class="col-form-label">{{ __('Fileds') }}:</label>
                                    <input type="text" name="fileds" id="fileds" class="form-control" placeholder="{{ __('Fileds') }}" value="{{ old('fileds', $row->fileds) }}" />
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php $Form_btn = new Form_btn(); echo $Form_btn->buttons($form_buttons); @endphp
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
                                    <h3 class="kt-portlet__head-title"> {{ __('Type Config') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="form-group ">
                                <label for="robots" class="col-form-label">{{ __('Robots') }}:</label>
                                <select name="robots" id="robots" class="form-control m_selectpicker">
                                    {{--<option value="">Select Robots</option>--}}
                                    {!! selectBox(DB_enumValues('content_types', 'robots'), old('robots', $row->robots)) !!}
                                </select>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group">
                                <label for="sitemap" class="col-form-label">{{ __('Sitemap') }}:</label>
                                <select name="sitemap" id="sitemap" class="form-control m_selectpicker">
                                    {{--<option value="">Select Sitemap</option>--}}
                                    {!! selectBox(DB_enumValues('content_types', 'sitemap'), old('sitemap', $row->sitemap)) !!}
                                </select>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group">
                                <label for="search" class="col-form-label">{{ __('Search') }}:</label>
                                <select name="search" id="search" class="form-control m_selectpicker">
                                    {{--<option value="">Select Search</option>--}}
                                    {!! selectBox(DB_enumValues('content_types', 'search'), old('search', $row->search)) !!}
                                </select>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group">
                                <label for="layout" class="col-form-label">{{ __('Layout') }}:</label>
                                <input type="text" name="layout" id="layout" class="form-control" placeholder="{{ __('Layout') }}" value="{{ old('layout', $row->layout) }}" />
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            {{--<div class="form-group ">
                                <label for="status" class="col-form-label">{{ __('Status') }}:</label>
                                <select name="status" id="status" class="form-control m_selectpicker">
                                    <option value="">Select Status</option>
                                    {!! selectBox(DB_enumValues('content_types', 'status'), old('status', $row->status)) !!}
                                </select>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection {{-- Scripts --}}
@section('scripts')
    <script>
        $("form#content_types").validate({
            // define validation rules
            rules: {
                title: {
                    required: true,
                },
                //identifier: {required: true,},
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
            },
        });
    </script>
@endsection
