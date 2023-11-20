@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="oem_model">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head') @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="clone_container">
                             @php
                                $model_names = json_decode($row->model_name ?? "[{}]" );
                                $model_codes = json_decode($row->model_code);
                                $model_nos = json_decode($row->model_no);
                            @endphp
                            @foreach($model_names as $index => $model_name)
                                <div class="form-group row clone">
                                    <div class="col-lg-3">
                                        <label for="model_name" class="col-form-label required">{{ __('Model Name') }}:</label>
                                        <input type="text" name="model_name[]" id="model_name" class="sub-dep form-control" placeholder="{{ __('Model Name') }}" value="{{ old('model_name.' . $index, $model_name) }}" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="model_code" class="col-form-label required">{{ __('Model Code') }}:</label>
                                        <input type="text" name="model_code[]" id="model_code" class="form-control" placeholder="{{ __('Model Code') }}" value="{{ old('model_code.' . $index, $model_codes[$index]) }}" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="model_no" class="col-form-label required">{{ __('Model No') }}:</label>
                                        <input type="text" name="model_no[]" id="model_no" class="form-control" placeholder="{{ __('Model No') }}" value="{{ old('model_no.' . $index, $model_nos[$index]) }}" />
                                    </div>
                                    <div class="col-lg-3" style="margin-top: 39px;">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            </div>
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
        $("form#oem_model").validate({
            // define validation rules
            rules: {
                week_starts_form: {
                    required: true,
                },
            },
            /*messages: {
        'week_starts_form' : {required: 'Week Starts Form is required',},    },*/
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
     <script>
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop('name', 'model_name[]');
        }

        $("form#oem_model").validate({
            // define validation rules
            rules: {
                model_name: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'Title is required',},    },*/
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
