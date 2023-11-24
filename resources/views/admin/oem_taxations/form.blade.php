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
                            <div class="form-group row clone">
                                <div class="col-lg-6">
                                    <label for="ntn" class="col-form-label required">{{ __('NTN') }}:</label>
                                    <input type="text" name="ntn" id="ntn" class="form-control" placeholder="{{ __('NTN') }}" value="{{ old('ntn', $row->ntn) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="sales_tax" class="col-form-label required">{{ __('Sales Tax') }}:</label>
                                    <input type="text" name="sales_tax" id="sales_tax" class="form-control" placeholder="{{ __('Sales Tax') }}" value="{{ old('sales_tax', $row->sales_tax) }}" />
                                </div>
                            </div>
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
