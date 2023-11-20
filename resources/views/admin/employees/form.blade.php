@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('head')
    <link href="{{ asset_url('css/wizard/wizard-3.min.css', true) }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="users">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="padding: 0 10px;">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ $row->id }}">
            <!-- begin:: Content -->

            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="padding: 0 10px;">
                <div class="kt-portlet">
                    <div class="kt-portlet__body kt-portlet__body--fit">

                    <div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="kt_wizard_v3" data-ktwizard-state="step-first">
                        <div class="kt-grid__item">
                            <!--begin: Wizard Nav-->
                            <div class="kt-wizard-v3__nav">
                                <div class="kt-wizard-v3__nav-items" style="padding: 0 1rem;">
                                    @php
                                        $steps = [
                                            ['title' => 'Personal Information', 'desc' => '', 'icon' => '', 'file' => 'personal-info'],
                                            ['title' => 'Family Information', 'desc' => '', 'icon' => '', 'file' => 'family-info'],
                                            ['title' => 'Experience', 'desc' => '', 'icon' => '', 'file' => 'experience'],
                                            ['title' => 'Qualification', 'desc' => '', 'icon' => '', 'file' => 'qualification'],
                                            ['title' => 'On Boarding', 'desc' => '', 'icon' => '', 'file' => 'on-boarding'],
                                            ['title' => 'Skills', 'desc' => '', 'icon' => '', 'file' => 'skills'],
                                            ['title' => 'Reference', 'desc' => '', 'icon' => '', 'file' => 'reference'],
                                            ['title' => 'Emergency Contact', 'desc' => '', 'icon' => '', 'file' => 'emergency-contact'],
                                            ['title' => 'Banking & Finance', 'desc' => '', 'icon' => '', 'file' => 'banking-finance'],
                                        ];
                                    @endphp
                                    @foreach($steps as $k => $step)
                                        <a class="kt-wizard-v3__nav-item" style="flex: auto;" href="#" data-ktwizard-type="step" data-ktwizard-state="{{ ($k == 0 ? 'current' : '') }}">
                                            <div class="kt-wizard-v3__nav-body">
                                                <div class="kt-wizard-v3__nav-label">
                                                    <span>{{ $k + 1 }}.</span>{{ $step['title'] }}
                                                    {{--<div class="wizard-desc">{{ $step['desc'] }}</div>--}}
                                                </div>
                                                <div class="kt-wizard-v3__nav-bar"></div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <!--end: Wizard Nav-->
                        </div>
                        <!--begin: Wizard Body-->
                        <div class="kt-grid__item kt-grid__item--fluid -kt-wizard-v3__wrapper p-5">
                            <!--begin: Form Wizard Form-->
                            @foreach($steps as $k => $step)
                                <!--begin: Wizard Step {{ $k + 1 }}-->
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content" data-ktwizard-state="{{ ($k == 0 ? 'current' : '') }}">
                                    <h4 class="mb-10 font-weight-bold text-dark">{{ $step['title'] }}</h4>
                                    <div class="kt-form__section kt-form__section--first">
                                        <div class="kt-wizard-v3__form">
                                            @include("admin.employees." . ($step['file'] ?? "step-" . ($k + 1)))
                                        </div>
                                    </div>
                                </div>
                                <!--end: Wizard Step {{ $k + 1 }}-->
                            @endforeach

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <!--begin: Form Actions -->
                            <div class="kt-form__actions d-flex justify-content-center">
                                <div class="btn btn-secondary btn-md btn-tall btn-wide m-3 kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                                    Previous
                                </div>
                                <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold  m-3 kt-font-transform-u" data-ktwizard-type="action-submit">
                                    Submit
                                </div>
                                <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold  m-3 kt-font-transform-u" data-ktwizard-type="action-next" style="place-content: flex-end;">
                                    Next Step
                                </div>
                            </div>
                            <!--end: Form Actions -->

                        </div>
                        <!--end: Wizard Body-->
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
        "use strict";
        var KTWizard3 = function () {
            var _form, _validate, _wizard;
            return {
                init: function () {
                    var i;
                    KTUtil.get("kt_wizard_v3"), _form = $("#users"), (_wizard = new KTWizard("kt_wizard_v3", {startStep: 1})).on("beforeNext", function (e) {
                        !0 !== _validate.form() && e.stop()
                    }), _wizard.on("beforePrev", function (e) {
                        !0 !== _validate.form() && e.stop()
                    }), _wizard.on("change", function (e) {
                        KTUtil.scrollTop()
                    }), _validate = _form.validate({
                        ignore: ":hidden",
                        rules: {
                            address: {required: !0},
                            zip_code: {required: !0},
                            city: {required: !0},
                            state: {required: !0},
                            country: {required: !0},
                            'rel[CNIC]': {required: !0},
                        },
                        invalidHandler: function (e, r) {
                            KTUtil.scrollTop(), swal.fire({
                                title: "",
                                text: "There are some errors in your submission. Please correct them.",
                                type: "error",
                                confirmButtonClass: "btn btn-secondary"
                            })
                        },
                        submitHandler: function (e) {
                        }
                    }), (i = _form.find('[data-ktwizard-type="action-submit"]')).on("click", function (t) {
                        t.preventDefault(),
                        _validate.form() && (KTApp.progress(i),
                                _form.submit()
                            /*_form.ajaxSubmit({
                                    success: function () {
                                        KTApp.unprogress(i), swal.fire({
                                            title: "",
                                            text: "The application has been successfully submitted!",
                                            type: "success",
                                            confirmButtonClass: "btn btn-secondary"
                                        })
                                    }
                                })*/
                        )
                    })
                }
            }
        }();
        jQuery(document).ready(function () {
            KTWizard3.init()
        });
    </script>
    <script>
        $("form#users").validate({
            // define validation rules
            rules: {
                //'user_type_id': {required: true,},
                'first_name': {required: true,},
                'email': {required: true, email: true,},
                //'username': {required: true,},
                //'password': {required: true, minlength: 8, maxlength: 8,},
            },
            /*messages: {
            'user_type_id' : {required: 'User Type is required',},'first_name' : {required: 'First Name is required',},'email' : {required: 'Email is required',email: 'Email is not valid',},'username' : {required: 'Username is required',},'password' : {required: 'Password is required',minlength: 'Password must be at least 8 character\'s',maxlength: 'Password maximum 8 character\'s',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        @if($row->id > 0)
        $('#password').rules('remove');
        @endif
    </script>
@endsection
