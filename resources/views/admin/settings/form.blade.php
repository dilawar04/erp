@php

    $form_buttons = ['save', 'view', 'delete', 'back'];
    $user_level = \Auth::user()->usertype->level;
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="directories">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" value="{{ $row->id }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body lg-p-0">

                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="nav flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" aria-controls="general"><i class="flaticon-settings"></i> General Setting</a>
                                        <a class="nav-link" id="website-tab" data-toggle="pill" href="#website" aria-controls="header_footer"><i class="flaticon2-cube-1"></i> Website Setting</a>
                                        {{--<a class="nav-link" id="theme-tab" data-toggle="pill" href="#theme-setting" aria-controls="theme-setting"><i class="flaticon2-cube-1"></i> {{ opt('site_title') }} Setting</a>--}}
                                        <a class="nav-link" id="contact-tab" data-toggle="pill" href="#contact" aria-controls="contact"><i class="flaticon2-open-text-book"></i> Contact Detail</a>
                                        @if ($user_level >= env('SUPER_LEVEL'))
                                            <a class="nav-link" id="admin-tab" data-toggle="pill" href="#admin" aria-controls="admin"><i class="flaticon2-help"></i> Admin Setting</a>
                                        @endif
                                        <a class="nav-link" id="social-tab" data-toggle="pill" href="#social" aria-controls="social"><i class="flaticon2-link"></i> Social Networks</a>
                                        <a class="nav-link" id="smtp-tab" data-toggle="pill" href="#smtp" aria-controls="smtp"><i class="flaticon2-mail"></i> SMTP Setting</a>

                                        {{--<a class="nav-link" id="sitemap-tab" data-toggle="pill" href="#sitemap" aria-controls="smtp"><i class="flaticon2-list"></i> Sitemap/Cache</a>--}}
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <div class="tab-content mb-5 mr-5" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="general">@include('admin.settings.general')</div>
                                        <div class="tab-pane fade" id="website">@include('admin.settings.website')</div>
                                        {{--<div class="tab-pane fade" id="theme-setting">@include('admin.settings.theme')</div>--}}
                                        <div class="tab-pane fade" id="contact">@include('admin.settings.contact')</div>
                                        @if ($user_level >= env('SUPER_LEVEL'))
                                            <div class="tab-pane fade" id="admin">@include('admin.settings.admin')</div>
                                        @endif
                                        <div class="tab-pane fade" id="social">@include('admin.settings.social')</div>
                                        <div class="tab-pane fade" id="smtp">@include('admin.settings.smtp')</div>

                                        {{--<div class="tab-pane fade" id="sitemap">@include('admin.settings.smtp')</div>--}}
                                        {{--<div class="tab-pane fade" id="widgets">@include('admin.settings.footer') </div>--}}
                                    </div>
                                </div>
                            </div>
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

        $("form#directories").validate({
            // define validation rules
            rules: {
                'association_id': {
                    required: true,
                },
                'name': {
                    required: true,
                },
                'designation': {
                    required: true,
                },
            },
            /*messages: {
            'name' : {required: 'Name is required',},'designation' : {required: 'Designation is required',},    },*/
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
