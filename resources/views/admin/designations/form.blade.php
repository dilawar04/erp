@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="designations">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
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
                                <div class="col-lg-5">
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}" />
                                </div>
                                <div class="col-lg-5">
                                    <label for="department_id" class="col-form-label required">{{ __('Department') }}:</label>
                                    <select name="department_id" id="department_id" class="form-control m-select2">
                                        <option value="">Select Department</option>
                                        {!! selectBox("SELECT id,title FROM departments", old('department_id', $row->department_id)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <label for="job_description" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Job Description') }}:</label><br>
                                    <input disabled type="hidden" name="job_description--rm" value="{{ $row->job_description }}">
                                    @php
                                        $file_input = '<input type="file" accept="image/*"name="job_description" accept="pdf,doc,docx" name="job_description" id="job_description" class="form-control custom-file-input" value="'.old('job_description', $row->job_description).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->job_description);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"pdf, doc, docx" file extension's</span>
                                </div>

                                {{--<div class="col-lg-12">
                                    <label for="job_description" class="col-form-label">{{ __('Job Description') }}:</label>
                                    <input type="file" accept="image/*" name="job_description" id="job_description" class="form-control" placeholder="{{ __('Job Description') }}" value="{{ old('job_description', $row->job_description) }}" />
                                </div>--}}
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php $Form_btn = new Form_btn(); echo $Form_btn->buttons($form_buttons); @endphp
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
        $("form#designations").validate({
            // define validation rules
            rules: {
                title: {
                    required: true,
                },
                department_id: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'Title is required',},'department_id' : {required: 'Department is required',},    },*/
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
