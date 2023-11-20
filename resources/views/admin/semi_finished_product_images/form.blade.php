@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="semi_finished_product_images">
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
                            <div class="form-group row mb-3 clone">
                                 <div class="col-lg-6">
                                    <label for="upload_date" class="col-form-label required">Upload Date:</label>
                                    <input type="datetime-local" name="upload_date" id="upload_date" class="form-control" placeholder="Upload Date" value="{{'uploade_date', $row->uploade_date }}" />
                                </div>
                                     <div class="col-lg-2 text-center">
                                    <label for="schedule" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Upload_file') }}:</label><br>
                                    <input disabled type="hidden" name="schedule--rm" value="{{ $row->schedule }}">
                                    @php
                                        $file_input = '<input type="file" accept="image/*"name="schedule" accept="pdf,doc,docx" name="schedule" id="schedule" class="form-control custom-file-input" value="'.old('schedule', $row->schedule).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->schedule);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"pdf, doc, docx" file extension's</span>
                                </div>

                                {{--<div class="col-lg-12">
                                    <label for="schedule" class="col-form-label">{{ __('Upload File') }}:</label>
                                    <input type="file" accept="image/*" name="schedule" id="schedule" class="form-control" placeholder="{{ __('Schedule') }}" value="{{ old('schedule', $row->schedule) }}" />
                                </div>--}}
                                <div class="col-lg-6" style="margin-top: 10px;">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
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
      $("#month").datepicker( {
    format: "yyyy",
    viewMode: "months", 
    minViewMode: "months"
}).on('changeMonth', function(e){
    $(this).datepicker('hide');
});
     $("#year").datepicker( {
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
}).on('changeYear', function(e){
    $(this).datepicker('hide');
});
        $("form#import_oem_schedules").validate({
            // define validation rules
            rules: {
                upload_file: {
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
