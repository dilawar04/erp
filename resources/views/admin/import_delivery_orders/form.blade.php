@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="import_delivery_orders">
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
                            <div class="form-group row">
                                <div class="col-lg-6">
                                   <label for="oem_id" class="col-form-label required">{{ __('Oems') }}:</label>
                                    <select name="oem_id" id="oem_id" value="{{old('oem_id', $row->oem_id)}}" class="form-control m-select2">
                                        <option value="">Select Oems</option>
                                        {!! selectBox("SELECT id,title FROM oems", old('oem_id', $row->oem_id)) !!}
                                    </select>                          
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="from" class="col-form-label required">{{ __('File Upload') }}:</label>
                                        <input class="form-control" type="file" id="formFile" name="file" value="{{ old('file',  $row->file) }}">
                                        <span class="form-text text-muted">"pdf, xls, xlsx, doc, docx" file extension's</span>
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
        $("form#import_delivery_orders").validate({
            // define validation rules
            rules: {
                file: {
                    required: true,
                },
                oem_id: {
                    required: true,
                },
            },
            /*messages: {
        'schedule' : {required: 'Schedule is required',},'oem_id' : {required: 'Oems is required',},    },*/
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
